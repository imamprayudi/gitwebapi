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
                        { title: "NO", data: null },
                        { title: "INVOICE NO", data: "INVNO" },
                        { title: "INVOICE DATE", data: "INVDATE" },
                        {
                            title: "INVOICE AMOUNT",
                            data: "INVAMOUNT",
                            className: "text-end",
                            render: function (data) {
                                return new Intl.NumberFormat('id-ID').format(data);
                            }
                        },
                        { title: "CURRENCY", data: "CURRENCY" },
                        { title: "STATUS", data: "STATUS" }
                    ]
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
                method: "getDataSoaend",
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
