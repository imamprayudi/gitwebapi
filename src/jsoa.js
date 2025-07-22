import $ from "jquery";
import axios from "axios";
import Swal from "sweetalert2";
import DataTable from "datatables.net-dt";
import "datatables.net-buttons-dt";
import "datatables.net-buttons/js/buttons.html5.mjs";
import "datatables.net-select-dt";

window.Swal = Swal;

// Helper function untuk render message
function renderMessage(options) {
    const { html, classes, icons } = options;
    const messageHtml = `
        <div class="alert ${classes} alert-dismissible fade show" role="alert">
            <i class="${icons} me-1"></i>
            ${html}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    $(".message").html(messageHtml);
}

$(function () {
    let authSession = JSON.parse(localStorage.getItem('poc_auth'));
    if (!localStorage.getItem('poc_auth')) {
        window.location.href = "../contents/login.html";
    }

    // Initialize UI
    $("div.message").html(null);
    if ($("div.loading").hasClass("d-none") == false)
        $("div.loading").addClass("d-none");

    // Enable submit buttons
    $("#submit_soa").attr("disabled", false);
    $("#submit_soamid").attr("disabled", false);
    $("#submit_soaend").attr("disabled", false);

    // Load suppliers
    axios
        .get("https://svr1.jkei.jvckenwood.com/api_gitweb/api/jordbal.php", {
            params: {
                method: "getSupplierGroup",
                usr: authSession.usr
            }
        })
        .then((res) => res.data.data)
        .then((res) => {
            var toAppend = "";
            $.each(res, function (i, o) {
                toAppend +=
                    '<option value="' +
                    o.SuppCode +
                    '">' +
                    o.SuppName +
                    " - " +
                    o.SuppCode +
                    "</option>";
            });
            $("#supplier").find("option").remove().end().append(toAppend);
        });

    // Load SOA dates
    axios
        .get("https://svr1.jkei.jvckenwood.com/api_gitweb/api/controller.php", {
            params: {
                method: "soadate",
                usr: authSession.usr,
                usrsecure: authSession.usrsecure
            }
        })
        .then((res) => res.data.data)
        .then((res) => {
            // Populate SOA date dropdown
            if (res && res.length > 0) {
                var toAppend = "<option value=''>Select SOA Date...</option>";
                $.each(res, function (i, o) {
                    // Convert TRANSDATE to readable format (e.g., "01 Juli 2025")
                    const date = new Date(o.TRANSDATE);
                    const monthNames = [
                        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                    ];
                    
                    // Format with day, month name, and year
                    const day = String(date.getDate()).padStart(2, '0');
                    const monthName = monthNames[date.getMonth()];
                    const year = date.getFullYear();
                    const displayText = day + " " + monthName + " " + year;
                    
                    // Format date as YYYYMMDD for value
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const dateValue = year + month + day;
                    
                    toAppend += '<option value="' + dateValue + '">' + displayText + '</option>';
                });
                $("#soa_date").html(toAppend);
                
                // Set default to first option
                if (res.length > 0) {
                    const firstDate = new Date(res[0].TRANSDATE);
                    const year = firstDate.getFullYear();
                    const month = String(firstDate.getMonth() + 1).padStart(2, '0');
                    const day = String(firstDate.getDate()).padStart(2, '0');
                    const defaultValue = year + month + day;
                    $("#soa_date").val(defaultValue);
                }
            }
        });

    // SOA Form Submit Handler
    $("form[name=submit_soa]").submit((e) => {
        e.preventDefault();
        $("#submit_soa").attr("disabled", true);
        $("div.loading").toggleClass("d-none");
        $("div.message").html(null);

        if ($.fn.DataTable.isDataTable('#table-soa')) {
            $('#table-soa').DataTable().clear().destroy();
        }
        $('#table-soa').empty();

        // First axios call - Get Last Payment and Comment
        axios.get("https://svr1.jkei.jvckenwood.com/api_gitweb/api/controller.php", {
            params: {
                method: "getLastPayment",
                supplier: $("[name=supplier]").val(),
                soadate: $("[name=soa_date]").val(),
                usr: authSession.usr,
                usrsecure: authSession.usrsecure
            }
        })
        .then((res) => res.data)
        .then((lastPaymentRes) => {
            if (lastPaymentRes.success) {
                // Render Last Payment table
                renderLastPaymentTable(lastPaymentRes.header, lastPaymentRes.data);
                
                // Render Comment section
                renderCommentSection(lastPaymentRes.soa_comment);
            }
        })
        .catch((error) => {
            console.log('Last Payment fetch error:', error);
        });

        // Second axios call - Get main SOA data
        axios.get("https://svr1.jkei.jvckenwood.com/api_gitweb/api/controller.php", {
            params: {
                method: "getDataSoa",                
                supplier: $("[name=supplier]").val(),
                soadate: $("[name=soa_date]").val(), // Remove .replace(/-/g, '')
                usr: authSession.usr,
                usrsecure: authSession.usrsecure
            }
        })
        .then((res) => res.data)
        .then((res) => {
            if (res.success == true) {
                let tableSoa = new DataTable("#table-soa", {
                    data: res.data,
                    fixedHeader: false,
                    retrieve: true,
                    responsive: false,
                    dom: "Bfrl",
                    order: [1, "asc"],
                    select: {
                        style: "multi",
                        selector: "tr"
                    },
                    buttons: ["excelHtml5", "csvHtml5", "selectAll", "selectNone"],
                    lengthMenu: [
                        [25, 50, 75, -1],
                        [25, 50, 75, "All"]
                    ],
                    columns: [
                        { title: "NO", data: "no" },
                        { title: "DATE", data: "transdate", 
                          render: function(data) {
                            if (data) {
                              const date = new Date(data);
                              return date.toLocaleDateString('id-ID');
                            }
                            return '';
                          }
                        },
                        { title: "PO NUMBER\nSO NUMBER", data: "po" },
                        { title: "SQ", data: "posq" },
                        { title: "INVOICE NUMBER\nROG SLIP NO.", data: "invoice" },
                        { title: "PARTS NUMBER", data: "partno" },
                        { title: "DESCRIPTION", data: "partname" },
                        { title: "QTY", data: "qty", className: "text-end" },
                        { 
                          title: "UNIT PRICE", 
                          data: "price", 
                          className: "text-end",
                          render: function (data) {
                            if (data && data !== null) {
                              return new Intl.NumberFormat('id-ID', {
                                minimumFractionDigits: 5,
                                maximumFractionDigits: 5
                              }).format(parseFloat(data));
                            }
                            return '';
                          }
                        },
                        { 
                          title: "AMOUNT", 
                          data: "amount", 
                          className: "text-end",
                          render: function (data) {
                            if (data && data !== null) {
                              return new Intl.NumberFormat('id-ID', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                              }).format(parseFloat(data));
                            }
                            return '';
                          }
                        },
                        { 
                          title: "OUR DN CN", 
                          data: "dncnd", 
                          className: "text-end",
                          render: function (data) {
                            if (data && data !== null) {
                              return new Intl.NumberFormat('id-ID', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                              }).format(parseFloat(data));
                            }
                            return '';
                          }
                        }
                    ]
                });

                tableSoa.clear().draw();
                tableSoa.rows.add(res.data);
                tableSoa.on('order.dt search.dt', function () {
                    let i = 1;
                    tableSoa
                        .cells(null, 0, { search: 'applied', order: 'applied' })
                        .every(function (cell) {
                            this.data(i++);
                        });
                }).draw();
                tableSoa.columns.adjust().draw();
            } else {
                renderMessage({
                    html: res.message,
                    classes: "alert-warning",
                    icons: "fa-solid fa-triangle-exclamation"
                });
            }
        })
        .catch((error) => {
            console.log({ error });
            let msg = "Something went wrong";
            if (error.response && error.response.data && error.response.data.message) {
                msg = error.response.data.message;
            }
            renderMessage({
                html: msg,
                classes: "alert-danger",
                icons: "fa-solid fa-ban"
            });
        })
        .finally(() => {
            $("div.loading").addClass("d-none");
            $("#submit_soa").attr("disabled", false);
        });
    });

    // SOA Mid Form Submit Handler:
    $("form[name=submit_soamid]").submit((e) => {
        e.preventDefault();
        $("#submit_soamid").attr("disabled", true);
        $("div.loading").toggleClass("d-none");
        $("div.message").html(null);

        if ($.fn.DataTable.isDataTable('#table-soamid')) {
            $('#table-soamid').DataTable().clear().destroy();
        }
        $('#table-soamid').empty();

        // First axios call - Get Last Payment and Comment
        axios.get("https://svr1.jkei.jvckenwood.com/api_gitweb/api/controller.php", {
            params: {
                method: "getSoamidLastPayment",
                supplier: $("[name=supplier]").val(),
                soadate: $("[name=soa_date]").val(),
                usr: authSession.usr,
                usrsecure: authSession.usrsecure
            }
        })
        .then((res) => res.data)
        .then((lastPaymentRes) => {
            if (lastPaymentRes.success) {
                // Render Last Payment table
                renderLastPaymentTable(lastPaymentRes.header, lastPaymentRes.data);
                
                // Render Comment section
                renderCommentSection(lastPaymentRes.soa_comment);
            }
        })
        .catch((error) => {
            console.log('SOA Mid Last Payment fetch error:', error);
        });

        // Second axios call - Get main SOA Mid data
        axios.get("https://svr1.jkei.jvckenwood.com/api_gitweb/api/controller.php", {
            params: {
                method: "getSoamidData",
                supplier: $("[name=supplier]").val(),
                soadate: $("[name=soa_date]").val(),
                usr: authSession.usr,
                usrsecure: authSession.usrsecure
            }
        })
        .then((res) => res.data)
        .then((res) => {
            if (res.success == true) {
                let tableSoamid = new DataTable("#table-soamid", {
                    data: res.data,
                    fixedHeader: true,
                    retrieve: true,
                    responsive: true,
                    autoWidth: false,
                    scrollX: true,
                    scrollY: "60vh",
                    dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                         "<'row'<'col-sm-12'tr>>" +
                         "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
                         "<'row'<'col-sm-12'B>>",
                    order: [1, "asc"],
                    select: {
                        style: "multi",
                        selector: "tr",
                        className: "selected"
                    },
                    buttons: [
                        {
                            extend: "excelHtml5",
                            text: '<i class="fas fa-file-excel"></i> Excel',
                            className: "btn btn-success btn-sm"
                        },
                        {
                            extend: "csvHtml5",
                            text: '<i class="fas fa-file-csv"></i> CSV',
                            className: "btn btn-info btn-sm"
                        },
                        {
                            extend: "selectAll",
                            text: '<i class="fas fa-check-square"></i> Select All',
                            className: "btn btn-primary btn-sm"
                        },
                        {
                            extend: "selectNone",
                            text: '<i class="fas fa-square"></i> Select None',
                            className: "btn btn-secondary btn-sm"
                        }
                    ],
                    lengthMenu: [
                        [10, 25, 50, 75, 100, -1],
                        [10, 25, 50, 75, 100, "All"]
                    ],
                    pageLength: 25,
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data per halaman",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                        infoFiltered: "(difilter dari _MAX_ total data)",
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir",
                            next: "Selanjutnya",
                            previous: "Sebelumnya"
                        },
                        emptyTable: "Tidak ada data yang tersedia",
                        zeroRecords: "Tidak ditemukan data yang sesuai"
                    },
                    columnDefs: [
                        // Header styling untuk semua kolom dengan width yang konsisten
                        {
                            targets: "_all",
                            createdCell: function (td, cellData, rowData, row, col) {
                                $(td).css({
                                    'border': '1px solid #dee2e6',
                                    'padding': '8px 12px',
                                    'vertical-align': 'middle',
                                    'box-sizing': 'border-box'
                                });
                            }
                        },
                        // Kolom NO - width tetap
                        { 
                            targets: 0, 
                            width: "60px", 
                            className: "text-center fw-bold",
                            createdCell: function (td, cellData, rowData, row, col) {
                                $(td).css({
                                    'background-color': '#f8f9fa',
                                    'font-weight': 'bold',
                                    'min-width': '60px',
                                    'max-width': '60px',
                                    'width': '60px'
                                });
                            }
                        },
                        // Kolom DATE - width tetap
                        { 
                            targets: 1, 
                            width: "100px", 
                            className: "text-center",
                            createdCell: function (td, cellData, rowData, row, col) {
                                $(td).css({
                                    'background-color': '#fff3cd',
                                    'min-width': '100px',
                                    'max-width': '100px',
                                    'width': '100px'
                                });
                            }
                        },
                        // Kolom PO NUMBER SO NUMBER - width tetap
                        { 
                            targets: 2, 
                            width: "120px", 
                            className: "text-left",
                            createdCell: function (td, cellData, rowData, row, col) {
                                $(td).css({
                                    'min-width': '120px',
                                    'max-width': '120px',
                                    'width': '120px',
                                    'word-wrap': 'break-word'
                                });
                            }
                        },
                        // Kolom SQ - width tetap
                        { 
                            targets: 3, 
                            width: "80px", 
                            className: "text-left",
                            createdCell: function (td, cellData, rowData, row, col) {
                                $(td).css({
                                    'min-width': '80px',
                                    'max-width': '80px',
                                    'width': '80px'
                                });
                            }
                        },
                        // Kolom INVOICE NUMBER - width tetap
                        { 
                            targets: 4, 
                            width: "140px", 
                            className: "text-left",
                            createdCell: function (td, cellData, rowData, row, col) {
                                $(td).css({
                                    'min-width': '140px',
                                    'max-width': '140px',
                                    'width': '140px',
                                    'word-wrap': 'break-word'
                                });
                            }
                        },
                        // Kolom PARTS NUMBER - width tetap
                        { 
                            targets: 5, 
                            width: "120px", 
                            className: "text-left",
                            createdCell: function (td, cellData, rowData, row, col) {
                                $(td).css({
                                    'min-width': '120px',
                                    'max-width': '120px',
                                    'width': '120px',
                                    'word-wrap': 'break-word'
                                });
                            }
                        },
                        // Kolom DESCRIPTION - width fleksibel tapi terkontrol
                        { 
                            targets: 6, 
                            width: "200px", 
                            className: "text-left",
                            createdCell: function (td, cellData, rowData, row, col) {
                                $(td).css({
                                    'min-width': '200px',
                                    'word-wrap': 'break-word',
                                    'white-space': 'normal'
                                });
                            }
                        },
                        // Kolom QTY - width tetap
                        { 
                            targets: 7, 
                            width: "80px", 
                            className: "text-end fw-semibold",
                            createdCell: function (td, cellData, rowData, row, col) {
                                $(td).css({
                                    'background-color': '#e7f3ff',
                                    'min-width': '80px',
                                    'max-width': '80px',
                                    'width': '80px'
                                });
                            }
                        },
                        // Kolom UNIT PRICE - width tetap
                        { 
                            targets: 8, 
                            width: "100px", 
                            className: "text-end fw-semibold",
                            createdCell: function (td, cellData, rowData, row, col) {
                                $(td).css({
                                    'background-color': '#e7f3ff',
                                    'min-width': '100px',
                                    'max-width': '100px',
                                    'width': '100px'
                                });
                            }
                        },
                        // Kolom AMOUNT - width tetap
                        { 
                            targets: 9, 
                            width: "100px", 
                            className: "text-end fw-semibold",
                            createdCell: function (td, cellData, rowData, row, col) {
                                $(td).css({
                                    'background-color': '#d4edda',
                                    'min-width': '100px',
                                    'max-width': '100px',
                                    'width': '100px'
                                });
                            }
                        },
                        // Kolom OUR DN CN - width tetap
                        { 
                            targets: 10, 
                            width: "100px", 
                            className: "text-end fw-semibold",
                            createdCell: function (td, cellData, rowData, row, col) {
                                $(td).css({
                                    'background-color': '#f8d7da',
                                    'min-width': '100px',
                                    'max-width': '100px',
                                    'width': '100px'
                                });
                            }
                        }
                    ],
                    columns: [
                        { 
                            title: "NO", 
                            data: "no",
                            render: function (data, type, row, meta) {
                                return '<span class="badge bg-primary">' + (meta.row + 1) + '</span>';
                            }
                        },
                        { 
                            title: "DATE", 
                            data: "transdate",
                            render: function(data) {
                                if (data) {
                                    const date = new Date(data);
                                    const formatted = date.toLocaleDateString('id-ID', {
                                        day: '2-digit',
                                        month: '2-digit',
                                        year: 'numeric'
                                    });
                                    return '<span class="text-primary fw-semibold">' + formatted + '</span>';
                                }
                                return '';
                            }
                        },
                        { 
                            title: "PO NUMBER<br>SO NUMBER", 
                            data: "po",
                            render: function(data) {
                                return data ? '<span class="text-dark">' + data + '</span>' : '';
                            }
                        },
                        { 
                            title: "SQ", 
                            data: "posq",
                            render: function(data) {
                                return data ? '<span class="text-muted">' + data + '</span>' : '';
                            }
                        },
                        { 
                            title: "INVOICE NUMBER<br>ROG SLIP NO.", 
                            data: "invoice",
                            render: function(data) {
                                return data ? '<span class="text-info fw-semibold">' + data + '</span>' : '';
                            }
                        },
                        { 
                            title: "PARTS NUMBER", 
                            data: "partno",
                            render: function(data) {
                                return data ? '<code class="text-dark" style="font-size: 16px; font-weight: 500;">' + data + '</code>' : '';
                            }
                        },
                        { 
                            title: "DESCRIPTION", 
                            data: "partname",
                            render: function(data) {
                                return data ? '<span class="text-dark">' + data + '</span>' : '';
                            }
                        },
                        { 
                            title: "QTY", 
                            data: "qty", 
                            render: function (data) {
                                if (data && data !== null) {
                                    const formatted = new Intl.NumberFormat('id-ID').format(data);
                                    return '<span class="text-primary fw-bold">' + formatted + '</span>';
                                }
                                return '';
                            }
                        },
                        { 
                            title: "UNIT PRICE", 
                            data: "price", 
                            render: function (data) {
                                if (data && data !== null) {
                                    const formatted = new Intl.NumberFormat('id-ID', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    }).format(parseFloat(data));
                                    return '<span class="text-success fw-bold">' + formatted + '</span>';
                                }
                                return '';
                            }
                        },
                        { 
                            title: "AMOUNT", 
                            data: "amount", 
                            render: function (data) {
                                if (data && data !== null) {
                                    const formatted = new Intl.NumberFormat('id-ID', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    }).format(parseFloat(data));
                                    return '<span class="text-success fw-bold">' + formatted + '</span>';
                                }
                                return '';
                            }
                        },
                        { 
                            title: "OUR<br>DN CN", 
                            data: "dncnd", 
                            render: function (data) {
                                if (data && data !== null) {
                                    const formatted = new Intl.NumberFormat('id-ID', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    }).format(parseFloat(data));
                                    const isPositive = parseFloat(data) >= 0;
                                    const colorClass = isPositive ? 'text-success' : 'text-danger';
                                    return '<span class="' + colorClass + ' fw-bold">' + formatted + '</span>';
                                }
                                return '';
                            }
                        }
                    ],
                    initComplete: function () {
                        // Styling untuk header tabel dengan width yang konsisten
                        $('#table-soamid thead th').css({
                            'background': 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                            'color': 'white',
                            'font-weight': 'bold',
                            'text-align': 'center',
                            'vertical-align': 'middle',
                            'border': '1px solid #dee2e6',
                            'padding': '12px 8px',
                            'font-size': '13px',
                            'white-space': 'normal',
                            'word-wrap': 'break-word',
                            'box-sizing': 'border-box'
                        });
                        
                        // Set width spesifik untuk setiap header kolom
                        $('#table-soamid thead th:nth-child(1)').css({'width': '60px', 'min-width': '60px', 'max-width': '60px'});
                        $('#table-soamid thead th:nth-child(2)').css({'width': '100px', 'min-width': '100px', 'max-width': '100px'});
                        $('#table-soamid thead th:nth-child(3)').css({'width': '120px', 'min-width': '120px', 'max-width': '120px'});
                        $('#table-soamid thead th:nth-child(4)').css({'width': '80px', 'min-width': '80px', 'max-width': '80px'});
                        $('#table-soamid thead th:nth-child(5)').css({'width': '140px', 'min-width': '140px', 'max-width': '140px'});
                        $('#table-soamid thead th:nth-child(6)').css({'width': '120px', 'min-width': '120px', 'max-width': '120px'});
                        $('#table-soamid thead th:nth-child(7)').css({'width': '200px', 'min-width': '200px'});
                        $('#table-soamid thead th:nth-child(8)').css({'width': '80px', 'min-width': '80px', 'max-width': '80px'});
                        $('#table-soamid thead th:nth-child(9)').css({'width': '100px', 'min-width': '100px', 'max-width': '100px'});
                        $('#table-soamid thead th:nth-child(10)').css({'width': '100px', 'min-width': '100px', 'max-width': '100px'});
                        $('#table-soamid thead th:nth-child(11)').css({'width': '100px', 'min-width': '100px', 'max-width': '100px'});
                        
                        // Styling untuk container tabel
                        $('#table-soamid_wrapper').css({
                            'width': '100%',
                            'margin': '0 auto',
                            'overflow-x': 'auto'
                        });
                        
                        // Styling untuk tabel utama
                        $('#table-soamid').css({
                            'width': '100%',
                            'border-collapse': 'collapse',
                            'font-size': '13px',
                            'table-layout': 'fixed' // Penting untuk mempertahankan width yang konsisten
                        });
                        
                        // Hover effect untuk baris
                        $('#table-soamid tbody tr').hover(
                            function() {
                                $(this).css('background-color', '#f5f5f5');
                            },
                            function() {
                                $(this).css('background-color', '');
                            }
                        );
                    },
                    drawCallback: function() {
                        // Styling untuk baris yang dipilih
                        $('#table-soamid tbody tr.selected').css({
                            'background-color': '#b3d7ff !important',
                            'color': '#000'
                        });
                    }
                });

                tableSoamid.clear().draw();
                tableSoamid.rows.add(res.data);
                tableSoamid.on('order.dt search.dt', function () {
                    let i = 1;
                    tableSoamid
                        .cells(null, 0, { search: 'applied', order: 'applied' })
                        .every(function (cell) {
                            this.data(i++);
                        });
                }).draw();
                tableSoamid.columns.adjust().draw();
            } else {
                renderMessage({
                    html: res.message,
                    classes: "alert-warning",
                    icons: "fa-solid fa-triangle-exclamation"
                });
            }
        })
        .catch((error) => {
            console.log({ error });
            let msg = "Something went wrong";
            if (error.response && error.response.data && error.response.data.message) {
                msg = error.response.data.message;
            }
            renderMessage({
                html: msg,
                classes: "alert-danger",
                icons: "fa-solid fa-ban"
            });
        })
        .finally(() => {
            $("div.loading").addClass("d-none");
            $("#submit_soamid").attr("disabled", false);
        });
    });

    // SOA End Form Submit Handler:
    $("form[name=submit_soaend]").submit((e) => {
        e.preventDefault();
        $("#submit_soaend").attr("disabled", true);
        $("div.loading").toggleClass("d-none");
        $("div.message").html(null);

        if ($.fn.DataTable.isDataTable('#table-soaend')) {
            $('#table-soaend').DataTable().clear().destroy();
        }
        $('#table-soaend').empty();

        // First axios call - Get Last Payment and Comment
        axios.get("https://svr1.jkei.jvckenwood.com/api_gitweb/api/controller.php", {
            params: {
                method: "getSoaendLastPayment",
                supplier: $("[name=supplier]").val(),
                soadate: $("[name=soa_date]").val(),
                usr: authSession.usr,
                usrsecure: authSession.usrsecure
            }
        })
        .then((res) => res.data)
        .then((lastPaymentRes) => {
            if (lastPaymentRes.success) {
                // Render Last Payment table
                renderLastPaymentTable(lastPaymentRes.header, lastPaymentRes.data);
                
                // Render Comment section
                renderCommentSection(lastPaymentRes.soa_comment);
            }
        })
        .catch((error) => {
            console.log('SOA End Last Payment fetch error:', error);
        });

        // Second axios call - Get main SOA End data
        axios.get("https://svr1.jkei.jvckenwood.com/api_gitweb/api/controller.php", {
            params: {
                method: "getSoaendData",
                supplier: $("[name=supplier]").val(),
                soadate: $("[name=soa_date]").val(),
                usr: authSession.usr,
                usrsecure: authSession.usrsecure
            }
        })
        .then((res) => res.data)
        .then((res) => {
            if (res.success == true) {
                let tableSoaend = new DataTable("#table-soaend", {
                    data: res.data,
                    fixedHeader: true,
                    retrieve: true,
                    responsive: true,
                    autoWidth: false,
                    scrollX: true,
                    scrollY: "60vh",
                    dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                         "<'row'<'col-sm-12'tr>>" +
                         "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
                         "<'row'<'col-sm-12'B>>",
                    order: [1, "asc"],
                    select: {
                        style: "multi",
                        selector: "tr",
                        className: "selected"
                    },
                    buttons: [
                        {
                            extend: "excelHtml5",
                            text: '<i class="fas fa-file-excel"></i> Excel',
                            className: "btn btn-success btn-sm"
                        },
                        {
                            extend: "csvHtml5",
                            text: '<i class="fas fa-file-csv"></i> CSV',
                            className: "btn btn-info btn-sm"
                        },
                        {
                            extend: "selectAll",
                            text: '<i class="fas fa-check-square"></i> Select All',
                            className: "btn btn-primary btn-sm"
                        },
                        {
                            extend: "selectNone",
                            text: '<i class="fas fa-square"></i> Select None',
                            className: "btn btn-secondary btn-sm"
                        }
                    ],
                    lengthMenu: [
                        [10, 25, 50, 75, 100, -1],
                        [10, 25, 50, 75, 100, "All"]
                    ],
                    pageLength: 25,
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data per halaman",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                        infoFiltered: "(difilter dari _MAX_ total data)",
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir",
                            next: "Selanjutnya",
                            previous: "Sebelumnya"
                        },
                        emptyTable: "Tidak ada data yang tersedia",
                        zeroRecords: "Tidak ditemukan data yang sesuai"
                    },
                    columnDefs: [
                        {
                            targets: "_all",
                            createdCell: function (td, cellData, rowData, row, col) {
                                $(td).css({
                                    'border': '1px solid #dee2e6',
                                    'padding': '8px 12px',
                                    'vertical-align': 'middle',
                                    'box-sizing': 'border-box',
                                    'white-space': 'normal',
                                    'word-wrap': 'break-word'
                                });
                            }
                        },
                        { 
                            targets: 0, 
                            width: "60px", 
                            className: "text-center fw-bold",
                            createdCell: function (td, cellData, rowData, row, col) {
                                $(td).css({
                                    'background-color': '#f8f9fa',
                                    'font-weight': 'bold',
                                    'width': '60px',
                                    'min-width': '60px',
                                    'max-width': '60px'
                                });
                            }
                        },
                        { 
                            targets: 1, 
                            width: "100px", 
                            className: "text-center",
                            createdCell: function (td, cellData, rowData, row, col) {
                                $(td).css({
                                    'background-color': '#fff3cd',
                                    'width': '100px',
                                    'min-width': '100px',
                                    'max-width': '100px'
                                });
                            }
                        },
                        { 
                            targets: 2, 
                            width: "120px", 
                            className: "text-left",
                            createdCell: function (td, cellData, rowData, row, col) {
                                $(td).css({
                                    'width': '120px',
                                    'min-width': '120px',
                                    'max-width': '120px'
                                });
                            }
                        },
                        { 
                            targets: 3, 
                            width: "80px", 
                            className: "text-left",
                            createdCell: function (td, cellData, rowData, row, col) {
                                $(td).css({
                                    'width': '80px',
                                    'min-width': '80px',
                                    'max-width': '80px'
                                });
                            }
                        },
                        { 
                            targets: 4, 
                            width: "140px", 
                            className: "text-left",
                            createdCell: function (td, cellData, rowData, row, col) {
                                $(td).css({
                                    'width': '140px',
                                    'min-width': '140px',
                                    'max-width': '140px'
                                });
                            }
                        },
                        { 
                            targets: 5, 
                            width: "120px", 
                            className: "text-left",
                            createdCell: function (td, cellData, rowData, row, col) {
                                $(td).css({
                                    'width': '120px',
                                    'min-width': '120px',
                                    'max-width': '120px'
                                });
                            }
                        },
                        { 
                            targets: 6, 
                            width: "200px", 
                            className: "text-left",
                            createdCell: function (td, cellData, rowData, row, col) {
                                $(td).css({
                                    'width': '200px',
                                    'min-width': '200px'
                                });
                            }
                        },
                        { 
                            targets: 7, 
                            width: "80px", 
                            className: "text-end",
                            createdCell: function (td, cellData, rowData, row, col) {
                                $(td).css({
                                    'width': '80px',
                                    'min-width': '80px',
                                    'max-width': '80px'
                                });
                            }
                        },
                        { 
                            targets: 8, 
                            width: "100px", 
                            className: "text-end",
                            createdCell: function (td, cellData, rowData, row, col) {
                                $(td).css({
                                    'width': '100px',
                                    'min-width': '100px',
                                    'max-width': '100px'
                                });
                            }
                        },
                        { 
                            targets: 9, 
                            width: "100px", 
                            className: "text-end",
                            createdCell: function (td, cellData, rowData, row, col) {
                                $(td).css({
                                    'width': '100px',
                                    'min-width': '100px',
                                    'max-width': '100px'
                                });
                            }
                        },
                        { 
                            targets: 10, 
                            width: "100px", 
                            className: "text-end",
                            createdCell: function (td, cellData, rowData, row, col) {
                                $(td).css({
                                    'width': '100px',
                                    'min-width': '100px',
                                    'max-width': '100px'
                                });
                            }
                        }
                    ],
                    columns: [
                        { title: res.header.no || "NO", data: "no" },
                        { 
                            title: res.header.transdate || "DATE", 
                            data: "transdate", 
                            render: function(data) {
                                if (data) {
                                    const date = new Date(data);
                                    return '<span class="badge bg-info text-dark">' + date.toLocaleDateString('id-ID') + '</span>';
                                }
                                return '';
                            }
                        },
                        { 
                            title: "PO NUMBER<br>SO NUMBER", 
                            data: "po",
                            render: function(data) {
                                return data ? '<code class="text-dark" style="font-size: 14px; font-weight: 500;">' + data + '</code>' : '';
                            }
                        },
                        { title: res.header.posq || "SQ", data: "posq" },
                        { 
                            title: "INVOICE NUMBER<br>ROG SLIP NO", 
                            data: "invoice",
                            render: function(data) {
                                return data ? '<code class="text-primary" style="font-size: 14px; font-weight: 500;">' + data + '</code>' : '';
                            }
                        },
                        { 
                            title: res.header.partno || "PARTS NUMBER", 
                            data: "partno",
                            render: function(data) {
                                return data ? '<code class="text-dark" style="font-size: 14px; font-weight: 500;">' + data + '</code>' : '';
                            }
                        },
                        { title: res.header.partname || "DESCRIPTION", data: "partname" },
                        { 
                            title: res.header.qty || "QTY", 
                            data: "qty",
                            render: function (data) {
                                if (data && data !== null) {
                                    const formatted = new Intl.NumberFormat('id-ID').format(parseFloat(data));
                                    return '<span class="text-primary fw-bold">' + formatted + '</span>';
                                }
                                return '';
                            }
                        },
                        { 
                            title: res.header.price || "UNIT PRICE", 
                            data: "price", 
                            render: function (data) {
                                if (data && data !== null) {
                                    const formatted = new Intl.NumberFormat('id-ID', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    }).format(parseFloat(data));
                                    return '<span class="text-success fw-bold">' + formatted + '</span>';
                                }
                                return '';
                            }
                        },
                        { 
                            title: res.header.amount || "AMOUNT", 
                            data: "amount", 
                            render: function (data) {
                                if (data && data !== null) {
                                    const formatted = new Intl.NumberFormat('id-ID', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    }).format(parseFloat(data));
                                    return '<span class="text-success fw-bold">' + formatted + '</span>';
                                }
                                return '';
                            }
                        },
                        { 
                            title: "OUR<br>DN CN", 
                            data: "dncnd", 
                            render: function (data) {
                                if (data && data !== null) {
                                    const formatted = new Intl.NumberFormat('id-ID', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    }).format(parseFloat(data));
                                    const isPositive = parseFloat(data) >= 0;
                                    const colorClass = isPositive ? 'text-success' : 'text-danger';
                                    return '<span class="' + colorClass + ' fw-bold">' + formatted + '</span>';
                                }
                                return '';
                            }
                        }
                    ],
                    initComplete: function () {
                        // Styling untuk header tabel
                        $('#table-soaend thead th').css({
                            'background': 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                            'color': 'white',
                            'font-weight': 'bold',
                            'text-align': 'center',
                            'vertical-align': 'middle',
                            'border': '1px solid #dee2e6',
                            'padding': '12px 8px',
                            'font-size': '13px',
                            'white-space': 'normal',
                            'word-wrap': 'break-word',
                            'box-sizing': 'border-box'
                        });
                        
                        // Set width spesifik untuk setiap header kolom agar simetris dengan konten
                        $('#table-soaend thead th:nth-child(1)').css({'width': '60px', 'min-width': '60px', 'max-width': '60px'});
                        $('#table-soaend thead th:nth-child(2)').css({'width': '100px', 'min-width': '100px', 'max-width': '100px'});
                        $('#table-soaend thead th:nth-child(3)').css({'width': '120px', 'min-width': '120px', 'max-width': '120px'});
                        $('#table-soaend thead th:nth-child(4)').css({'width': '80px', 'min-width': '80px', 'max-width': '80px'});
                        $('#table-soaend thead th:nth-child(5)').css({'width': '140px', 'min-width': '140px', 'max-width': '140px'});
                        $('#table-soaend thead th:nth-child(6)').css({'width': '120px', 'min-width': '120px', 'max-width': '120px'});
                        $('#table-soaend thead th:nth-child(7)').css({'width': '200px', 'min-width': '200px'});
                        $('#table-soaend thead th:nth-child(8)').css({'width': '80px', 'min-width': '80px', 'max-width': '80px'});
                        $('#table-soaend thead th:nth-child(9)').css({'width': '100px', 'min-width': '100px', 'max-width': '100px'});
                        $('#table-soaend thead th:nth-child(10)').css({'width': '100px', 'min-width': '100px', 'max-width': '100px'});
                        $('#table-soaend thead th:nth-child(11)').css({'width': '100px', 'min-width': '100px', 'max-width': '100px'});
                        
                        // Styling untuk container dan tabel
                        $('#table-soaend_wrapper').css({
                            'width': '100%',
                            'margin': '0 auto',
                            'overflow-x': 'auto'
                        });
                        
                        $('#table-soaend').css({
                            'width': '100%',
                            'border-collapse': 'collapse',
                            'font-size': '13px',
                            'table-layout': 'fixed'
                        });
                        
                        // Hover effect
                        $('#table-soaend tbody tr').hover(
                            function() {
                                $(this).css('background-color', '#f5f5f5');
                            },
                            function() {
                                $(this).css('background-color', '');
                            }
                        );
                    },
                    drawCallback: function() {
                        $('#table-soaend tbody tr.selected').css({
                            'background-color': '#b3d7ff !important',
                            'color': '#000'
                        });
                    }
                });

                tableSoaend.clear().draw();
                tableSoaend.rows.add(res.data);
                tableSoaend.on('order.dt search.dt', function () {
                    let i = 1;
                    tableSoaend
                        .cells(null, 0, { search: 'applied', order: 'applied' })
                        .every(function (cell) {
                            this.data(i++);
                        });
                }).draw();
                tableSoaend.columns.adjust().draw();
            } else {
                renderMessage({
                    html: res.message,
                    classes: "alert-warning",
                    icons: "fa-solid fa-triangle-exclamation"
                });
            }
        })
        .catch((error) => {
            console.log({ error });
            let msg = "Something went wrong";
            if (error.response && error.response.data && error.response.data.message) {
                msg = error.response.data.message;
            }
            renderMessage({
                html: msg,
                classes: "alert-danger",
                icons: "fa-solid fa-ban"
            });
        })
        .finally(() => {
            $("div.loading").addClass("d-none");
            $("#submit_soaend").attr("disabled", false);
        });
    });
});

// Helper function untuk render Last Payment table
function renderLastPaymentTable(header, data) {
    if ($.fn.DataTable.isDataTable('#table-last-payment')) {
        $('#table-last-payment').DataTable().clear().destroy();
    }
    $('#table-last-payment').empty();
    
    if (data) {
        // Convert data object to array format for DataTable
        const tableData = [{
            lastpay: data.lastpay || '',
            purchase: data.purchase || '',
            dncns: data.dncns || '',
            netpur: data.netpur || '',
            vat: data.vat || '',
            payment: data.payment || '',
            balance: data.balance || ''
        }];
        
        let tableLastPayment = new DataTable("#table-last-payment", {
            data: tableData,
            paging: false,
            searching: false,
            info: false,
            columns: [
                { title: header.lastpay || "LAST PAYMENT", data: "lastpay" },
                { title: header.purchase || "PURCHASE", data: "purchase", className: "text-end" },
                { title: header.dncns || "DN CN (PUR)", data: "dncns", className: "text-end" },
                { title: header.netpur || "NET PURCHASE", data: "netpur", className: "text-end" },
                { title: header.vat || "VAT", data: "vat", className: "text-end" },
                { title: header.payment || "PAYMENT", data: "payment", className: "text-end" },
                { title: header.balance || "THIS BALANCE", data: "balance", className: "text-end" }
            ]
        });
        
        $('#last-payment-section').show();
    } else {
        $('#last-payment-section').hide();
    }
}

// Helper function untuk render Comment section
function renderCommentSection(soaComment) {
    if (soaComment) {
        $('#supplier_comment').val(soaComment.suppcom || '');
        $('#jkei_comment').val(soaComment.jeincom || '');
        $('#comment-section').show();
    } else {
        $('#comment-section').hide();
    }
}
