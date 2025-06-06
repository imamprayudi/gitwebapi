import $ from "jquery";
import axios from "axios";
import Swal from "sweetalert2";
import DataTable from "datatables.net-dt";
import "datatables.net-buttons-dt";
import "datatables.net-buttons/js/buttons.html5.mjs";
import "datatables.net-select-dt";


window.Swal = Swal;

$(function () {
    let authSession = JSON.parse(localStorage.getItem('poc_auth'));
    if (!localStorage.getItem('poc_auth')) {
        window.location.href = "../contents/login.html";
    }
    $("div.message").html(null);
    if ($("div.loading").hasClass("d-none") == false)
        $("div.loading").addClass("d-none");
    $("#submit_summary").attr("disabled", false);

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

    axios
        .get("https://svr1.jkei.jvckenwood.com/api_gitweb/api/controller.php", {
            params: {
                method: "period",
                usr: authSession.usr,
                usrsecure: authSession.usrsecure
            }
        })
        .then((res) => res.data.data)
        .then((res) => {
            // console.log("periode summary ================>", res);
            var toAppend = "";
            $.each(res, function (i, o) {
                // console.log("data periode summary", o)
                toAppend +=
                    '<option value="' +
                    o.Period +
                    '">' +
                    o.Period +
                    "</option>";
            });
            $("#periode").find("option").remove().end().append(toAppend);
        });

    $("form[name=submit_summary]").submit((e) => {
        e.preventDefault();
        $("#submit_summary").attr("disabled", true);
        $("div.loading").toggleClass("d-none");
        $("div.message").html(null);

        if ($.fn.DataTable.isDataTable('#table-summary')) {
            $('#table-summary').DataTable().clear().destroy();
        }
        $('#table-summary').empty();

        axios.get("https://svr1.jkei.jvckenwood.com/api_gitweb/api/controller.php", {
            params: {
                method: "getDataMatsum",
                supplier: $("[name=supplier]").val(),
                periode: $("[name=periode]").val(),
                usr: authSession.usr,
                usrsecure: authSession.usrsecure
            }
        })
            .then((res) => res.data)
            .then((res) => {
                // console.log(res)
                // return;

                if (res.success) {

                    // initializeDataTable(res.header.header[0], res.data);
                    let header = res.header[0];
                    let dataSummary = res.data;
                    // console.log(header);
                    // return;
                    const columns = Object.keys(header).map((key, index) => {
                        return {
                            title: header[key], // Judul kolom dari header
                            data: key.toLowerCase() // Properti data sesuai dengan kunci
                        };
                    });

                    // Inisialisasi DataTable
                    let tablesummary = new DataTable("#table-summary", {
                        data: dataSummary,
                        fixedHeader: false,
                        retrieve: true,
                        responsive: false,
                        linebreaks: true,
                        dom: "Bfrl",
                        order: [2, "desc"],
                        select: {
                            style: "multi",
                            selector: "tr"
                        },
                        buttons: ["excelHtml5", "csvHtml5", "selectAll", "selectNone"],
                        lengthMenu: [
                            [25, 50, 75, -1],
                            [25, 50, 75, "All"]
                        ],
                        columns: columns
                    });

                    // Atur ulang nomor urut pada kolom pertama
                    tablesummary.on('order.dt search.dt', function () {
                        let i = 1;
                        tablesummary
                            .cells(null, 0, { search: 'applied', order: 'applied' })
                            .every(function (cell) {
                                this.data(i++);
                            });
                    }).draw();

                    tablesummary.columns.adjust().draw();
                } else {
                    renderMessage({
                        html: res.message,
                        classes: "alert-warning",
                        icons: "fa-solid fa-triangle-exclamation"
                    });
                }
            })
            .catch((error) => {
                console.error("Terjadi kesalahan:", error);
                renderMessage({
                    html: "Something went wrong",
                    classes: "alert-danger",
                    icons: "fa-solid fa-ban"
                });
            })
            .finally(() => {
                $("div.loading").addClass("d-none");
                $("#submit_summary").attr("disabled", false);
            });



    });
})
