import $ from "jquery";
import axios from "axios";
import select2 from "select2";

import Swal from "sweetalert2";

import jszip from "jszip";
import DataTable from "datatables.net-dt";
import "datatables.net-buttons-dt";
import "datatables.net-buttons/js/buttons.html5.mjs";
import "datatables.net-select-dt";

// import 'dotenv/config';
// const apiExternal = process.env.EXTERNAL_API_URL;

window.Swal = Swal;
// // CommonJS
// const Swal = require('sweetalert2');

$(function () {
  let authSession = JSON.parse(localStorage.getItem('poc_auth'));
  if (!localStorage.getItem('poc_auth')) {
    window.location.href = "../contents/login.html";
  }
  $("div.message").html(null);
  if ($("div.loading").hasClass("d-none") == false)
    $("div.loading").addClass("d-none");
  $("#submit_btn").attr("disabled", false);

  axios
    .get("https://svr1.jkei.jvckenwood.com/api_gitweb/api/jordbal.php", {
      params: {
        method: "getSupplierGroup",
        usr: authSession.usr
      }
    })
    .then((res) => res.data.data)
    .then((res) => {
      // console.log("datasupplier ================>", res);
      var toAppend = "";
      $.each(res, function (i, o) {
        // console.log("data supplier",o)
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
  // END Of getSupplierGroup
  // ------------------------

  $("form[name=submit_ordbal]").submit((e) => {
    e.preventDefault();
    $("#submit_btn").attr("disabled", true);
    $("div.loading").toggleClass("d-none");
    $("div.message").html(null);

    axios
      .get("https://svr1.jkei.jvckenwood.com/api_gitweb/api/jordbal.php", {
        params: {
          method: "getDataOrdBal",
          supplier: $("[name=supplier]").val(),
          // from_date: $("[name=from_date]").val(),
          // end_date: $("[name=end_date]").val(),
          // select_po: $("[name=select_po]").val(),
          // filter_by: $("[name=filter_by]").val(),
          usr: authSession.usr,
          usrsecure: authSession.usrsecure
        }
      })
      .then((res) => res.data)
      .then((res) => {

        console.log("data Order Balance :::: ", res);
        // console.log("dataaaaaaaaaaaaa", $("[name=filter_by]").val());
        if (res.success == false) {
          renderMessage({
            html: res.message,
            classes: "alert-warning",
            icons: "fa-solid fa-triangle-exclamation"
          });
          return;
        }

        if (res.success == true) {
          let tableOrdBal = new DataTable("#table-orderBalance", {
            data: res.data,
            fixedHeader: false,
            retrieve: true,
            responsive: false,
            dom: "Bfrltip",
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
            columns: [
              { title: "PART NUMBER", data: "partnumber" },
              { title: "PART NAME", data: "partname" },
              { title: "ORDER QTY", data: "orderqty" },
              { title: "REQUIRED DATE", data: "reqdate" },
              { title: "PO NUMBER", data: "ponumber" },
              { title: "SQ", data: "posq" },
              { title: "ORDER BALANCE", data: "orderbalance" },
              { title: "SUPP REST", data: "supprest" },
              { title: "MODEL", data: "model" },
              { title: "ISSUE DATE", data: "issuedate" },
              { title: "PO TYPE", data: "potype" },
            ]
          });
          tableOrdBal.clear().draw();
          tableOrdBal.rows.add(res.data); // Add new data
          tableOrdBal.columns.adjust().draw();
        }
      })
      .catch((error) => {
        console.log({ error });
        let res = error.response;
        let data = res.data;
        let msg = data.message;

        msg = msg || "Something went wrong";

        renderMessage({
          html: msg,
          classes: "alert-danger",
          icons: "fa-solid fa-ban"
        });

        $("#userid").focus();
        $("div.loading").addClass("d-none");
        $("#btn_login").attr("disabled", false);
      })
      .finally(() => {
        $("div.loading").addClass("d-none");
        $("#submit_btn").attr("disabled", false);
      });
  });









  // getData Input PO/Partnumber/TransmissionDate based on filter by
  // function getFilter() {
  //   axios
  //     .get("https://svr1.jkei.jvckenwood.com/api_gitweb/api/jordbal.php", {
  //       params: {
  //         method: "getFilterBy",
  //         supplier: $("[name=supplier]").val(),
  //         from_date: $("[name=from_date]").val(),
  //         end_date: $("[name=end_date]").val(),
  //         filter_by: $("[name=filter_by]").val(),
  //         select_po: $("[name=select_po]").val(),
  //         usr: authSession.usr
  //       }
  //     })
  //     .then((res) => res.data.data)
  //     .then((res) => {
  //       console.log(res);
  //       if ($.fn.dataTable.isDataTable("#table-purchase-order-st")) {
  //         $("#table-purchase-order-st").DataTable().destroy();
  //         $("#table-purchase-order-st").empty();
  //       }
  //       var toAppend = "";
  //       $.each(res, function (i, o) {
  //         toAppend += "<option>" + o + "</option>";
  //       });
  //       $("#select_po").find("option").remove().end().append(toAppend);
  //     });
  // }
  // $("[name=supplier]").on("change", () => {
  //   getFilter("supplier");
  // });
  // $("[name=from_date]").on("change", () => {
  //   getFilter("from_date");
  // });
  // $("[name=end_date]").on("change", () => {
  //   getFilter("end_date");
  // });
  // $("[name=filter_by]").on("change", () => {
  //   getFilter("filter_by");
  // });
  // End Of getData Input PO/Partnumber/TransmissionDate based on filter by
  // ----------------------------------------------------------------------

  // getData SubmitPo
  // $("form[name=submit_po]").submit((e) => {
  //   e.preventDefault();
  //   $("#submit_btn").attr("disabled", true);
  //   $("div.loading").toggleClass("d-none");
  //   $("div.message").html(null);

  //   axios
  //     .get("https://svr1.jkei.jvckenwood.com/api_gitweb/api/jordbal.php", {
  //       params: {
  //         method: "getDataPoST",
  //         supplier: $("[name=supplier]").val(),
  //         from_date: $("[name=from_date]").val(),
  //         end_date: $("[name=end_date]").val(),
  //         select_po: $("[name=select_po]").val(),
  //         filter_by: $("[name=filter_by]").val(),
  //         usr: authSession.usr
  //       }
  //     })
  //     .then((res) => res.data)
  //     .then((res) => {

  //     // console.log("dataaaaaaaaaaaaa", res);
  //     // console.log("dataaaaaaaaaaaaa", $("[name=filter_by]").val());
  //       if (res.success == false) {
  //         renderMessage({
  //           html: res.message,
  //           classes: "alert-warning",
  //           icons: "fa-solid fa-triangle-exclamation"
  //         });
  //         return;
  //       }

  //       if (res.success == true) {
  //         if ($("[name=filter_by]").val() == "rdate") {
  //           // console.log("get data post => ", res.data);
  //           let tablePOST = new DataTable("#table-purchase-order-st", {
  //             data: res.data,
  //             fixedHeader: false,
  //             retrieve: true,
  //             responsive: false,
  //             dom: "frltip",
  //             order: [2, "desc"],
  //             buttons: ["excelHtml5", "csvHtml5", "selectAll", "selectNone"],
  //             lengthMenu: [
  //               [10, 25, 50, -1],
  //               [25, 50, 75, "All"]
  //             ],
  //             columns: [
  //               {
  //                 title: "Action",
  //                 data: "idno",
  //                 render: (data, type, row) => {
  //                   return (
  //                     '<a target="_blank" class="btn btn-sm btn-info ml-1" href="jgetpodtl.php?sid=' +
  //                     row.supplier +
  //                     "&tglid=" +
  //                     row.transdate +
  //                     "&sts=" +
  //                     row.status +
  //                     '">' +
  //                     "View Detail" +
  //                     "</a>"
  //                   );
  //                   return (
  //                     '<button id="btn-detail" class="btn btn-sm btn-info ml-1" onclick="po_detail(' +
  //                     data +
  //                     ')" >Detail</button>'
  //                   );
  //                 }
  //               },
  //               { title: "Transmission Date", data: "transdate" },
  //               {
  //                 title: "Status",
  //                 data: "status",
  //                 render: (data, type, row) => {
  //                   // console.log("response data", data);
  //                   // console.log("response type", type);
  //                   // console.log("response row", row);
  //                   let rendering = '<p class="text-center fw-bold">';
  //                   let status = row.status.toUpperCase();
  //                   if (status == "UNREAD") {
  //                     rendering = '<p class="text-center text-danger fw-bold">';
  //                   }
  //                   if (status == "READ") {
  //                     rendering =
  //                       '<p class="text-center text-success fw-bold">';
  //                   }
  //                   rendering = rendering + status + "</p>";
  //                   return rendering;
  //                 }
  //               },
  //               { title: "Read At", data: "updated" },
  //               {
  //                 title: "Progress",
  //                 data: "extn",
  //                 render: function (data, type, row, meta) {
  //                   // console.log("render dtatable", [data, type, row, meta]);
  //                   return type === "display"
  //                     ? '<div class="progress">' +
  //                     '<div class="progress-bar bg-success" role="progressbar" aria-valuenow="' +
  //                     row.total_confirmed +
  //                     '" aria-valuemin="0" aria-valuemax="' +
  //                     row.total_po +
  //                     '">' +
  //                     row.total_confirmed +
  //                     " PO</div>" +
  //                     '<div class="progress-bar bg-danger" role="progressbar" aria-valuenow="' +
  //                     row.total_rejected +
  //                     '" aria-valuemin="0" aria-valuemax="' +
  //                     row.total_po +
  //                     '">' +
  //                     row.total_rejected +
  //                     " PO</div>" +
  //                     "</div>"
  //                     : // '<progress value="' + data.total_confirmed + '" max="'+data.total_po+'"></progress>'
  //                     0;
  //                 }
  //               },
  //               {
  //                 title: "Total PO",
  //                 data: "total_po",
  //                 render: function (data, type, row, meta) {
  //                   return (
  //                     '<p class="text-success text-center">' +
  //                     row.total_confirmed +
  //                     "</p>"
  //                   );
  //                 }
  //               },
  //               {
  //                 title: "Confirmed",
  //                 data: "total_confirmed",
  //                 render: function (data, type, row, meta) {
  //                   return (
  //                     '<p class="text-success text-center">' +
  //                     row.total_confirmed +
  //                     "</p>"
  //                   );
  //                 }
  //               },
  //               {
  //                 title: "Rejected",
  //                 data: "total_rejected",
  //                 render: function (data, type, row, meta) {
  //                   return (
  //                     '<p class="text-danger text-center">' +
  //                     row.total_rejected +
  //                     "</p>"
  //                   );
  //                 }
  //               },
  //               {
  //                 title: "Balance",
  //                 data: null,
  //                 render: function (data, type, row, meta) {
  //                   let balance_po =
  //                     row.total_po - row.total_confirmed - row.total_rejected;
  //                   return '<p class="text-center">' + balance_po + "</p>";
  //                 }
  //               }
  //             ]
  //           });
  //           tablePOST.clear().draw();
  //           tablePOST.rows.add(res.data); // Add new data
  //           tablePOST.columns.adjust().draw();
  //         } else {
  //           let tablePOST = new DataTable("#table-purchase-order-st", {
  //             data: res.data,
  //             fixedHeader: false,
  //             retrieve: true,
  //             responsive: false,
  //             dom: "Bfrltip",
  //             order: [2, "desc"],
  //             select: {
  //               style: "multi",
  //               selector: "tr"
  //             },
  //             buttons: ["excelHtml5", "csvHtml5", "selectAll", "selectNone"],
  //             lengthMenu: [
  //               [10, 25, 50, -1],
  //               [25, 50, 75, "All"]
  //             ],
  //             columns: [
  //               // <th scope="col">#</th>
  //               //   <th scope="col">CONFIRMATION STATUS</th>
  //               //   <th scope="col">TRANSMISSION DATE</th>
  //               //   <th scope="col">TRANSMISSION NO</th>
  //               //   <th scope="col">PO STATUS</th>
  //               //   <th scope="col">PO NUMBER</th>
  //               //   <th scope="col">PART NUMBER</th>
  //               //   <th scope="col">PART NAME</th>
  //               //   <th scope="col">PO QTY</th>
  //               //   <th scope="col">PO DATE</th>
  //               //   <th scope="col">PRICE</th>
  //               //   <th scope="col">MODEL</th>
  //               //   <th scope="col">PO TYPE</th>
  //               //   <th scope="col">REASON</th>
  //               //   <th scope="col">CONFIRMED BY</th>
  //               // {
  //               //   data: null,
  //               //   name: "cb_podtl",
  //               //   defaultContent: '<input type="checkbox" name="cb_podtl">'
  //               // },
  //               {
  //                 title: "SUPPLIER CONFIRM",
  //                 data: "supplier_confirmed_reason",
  //                 render: function (data, type, row) {
  //                   let confirmed = "";
  //                   if (row.supplier_confirmed_status == "CONFIRM")
  //                     confirmed =
  //                       "<span class='text-success'>" +
  //                       row.supplier_confirmed_status +
  //                       "</span>";
  //                   if (row.supplier_confirmed_status == "REJECT")
  //                     confirmed =
  //                       "<span class='text-danger'>" +
  //                       row.supplier_confirmed_status +
  //                       "</span>";
  //                   if (row.supplier_confirmed_status == null)
  //                     confirmed = "<span class='text-danger'>NOT YET</span>";
  //                   if (row.supplier_confirmed_by)
  //                     confirmed +=
  //                       "<br><span class='text-secondary'> by " +
  //                       row.supplier_confirmed_by.toUpperCase() +
  //                       "</span>";
  //                   if (row.supplier_confirmed_reason)
  //                     confirmed +=
  //                       "<br><span class='text-secondary text-wrap'>with reason is " +
  //                       row.supplier_confirmed_reason +
  //                       "</span> ";

  //                   return confirmed;
  //                 }
  //               },
  //               {
  //                 title: "PURCH CONFIRM",
  //                 data: "purch_confirmed_reason",
  //                 render: function (data, type, row) {
  //                   let confirmed = "";
  //                   if (row.purch_confirmed_status == "CONFIRM FOR ACCEPT")
  //                     confirmed =
  //                       "<span class='text-success'>" +
  //                       row.purch_confirmed_status +
  //                       "</span>";

  //                   if (row.purch_confirmed_status == "CONFIRM FOR REJECTION")
  //                     confirmed =
  //                       "<span class='text-danger'>" +
  //                       row.purch_confirmed_status +
  //                       "</span>";

  //                   if (row.purch_confirmed_status == null)
  //                     confirmed = "<span class='text-info'>NOT YET</span>";
  //                   if (row.purch_confirmed_by)
  //                     confirmed +=
  //                       "<br><span class='text-secondary'> by " +
  //                       row.purch_confirmed_by.toUpperCase() +
  //                       "</span>";
  //                   if (row.purch_confirmed_reason)
  //                     confirmed +=
  //                       "<br><span class='text-secondary text-wrap'>with reason is " +
  //                       row.purch_confirmed_reason +
  //                       "</span> ";

  //                   return confirmed;
  //                 }
  //               },
  //               {
  //                 title: "MC CONFIRM",
  //                 data: "mc_confirmed_reason",
  //                 render: function (data, type, row) {
  //                   let confirmed = "NOT YET";
  //                   if (row.mc_confirmed_status == "CONFIRM PUT BACK")
  //                     confirmed =
  //                       "<span class='text-success'>" +
  //                       row.mc_confirmed_status +
  //                       "</span>";

  //                   if (row.mc_confirmed_status == "REJECT PUT BACK")
  //                     confirmed =
  //                       "<span class='text-danger'>" +
  //                       row.mc_confirmed_status +
  //                       "</span>";

  //                   if (row.mc_confirmed_status == null)
  //                     confirmed = "<span class='text-info'>NOT YET</span>";
  //                   if (row.mc_confirmed_by)
  //                     confirmed +=
  //                       "<br><span class='text-secondary'> by " +
  //                       row.mc_confirmed_by.toUpperCase() +
  //                       "</span>";
  //                   if (row.mc_confirmed_reason)
  //                     confirmed +=
  //                       "<br><span class='text-secondary text-wrap'>with reason is " +
  //                       row.mc_confirmed_reason +
  //                       "</span> ";

  //                   return confirmed;
  //                 }
  //               },
  //               { title: "TRANSMISSION DATE", data: "rdate" },
  //               { title: "TRANSMISSION NO", data: "idno" },
  //               {
  //                 title: "PO STATUS",
  //                 data: "",
  //                 render: function (data, type, row) {
  //                   if (row.newdate > row.olddate) {
  //                     return "<p class='text-danger fw-bold'> PO DOWN</p>";
  //                   } else if (row.newdate < row.olddate) {
  //                     return "<p class='text-success fw-bold'> PO UP</p>";
  //                   } else if (row.newqty == 0) {
  //                     return "<span class='text-secondary fw-bold'> PO CANCEL</span>";
  //                   } else if (row.newqty < row.oldqty) {
  //                     return "<span class='text-warning fw-bold'> PO REDUCE</span>";
  //                   }
  //                 }
  //               },
  //               { title: "PO NUMBER", data: "pono" },
  //               { title: "PART NUMBER", data: "partno" },
  //               { title: "PART NAME", data: "partname" },
  //               { title: "PO QTY", data: "newqty" },
  //               { title: "PO DATE", data: "newdate" },
  //               { title: "PRICE", data: "price" },
  //               { title: "MODEL", data: "model" },
  //               { title: "PO TYPE", data: "potype" }
  //             ]
  //           });
  //           tablePOST.clear().draw();
  //           tablePOST.rows.add(res.data); // Add new data
  //           tablePOST.columns.adjust().draw();
  //         }
  //       }
  //     })
  //     .catch((error) => {
  //       console.log({ error });
  //       let res = error.response;
  //       let data = res.data;
  //       let msg = data.message;

  //       msg = msg || "Something went wrong";

  //       renderMessage({
  //         html: msg,
  //         classes: "alert-danger",
  //         icons: "fa-solid fa-ban"
  //       });

  //       $("#userid").focus();
  //       $("div.loading").addClass("d-none");
  //       $("#btn_login").attr("disabled", false);
  //     })
  //     .finally(() => {
  //       $("div.loading").addClass("d-none");
  //       $("#submit_btn").attr("disabled", false);
  //     });
  // });
  // END of getData SubmitPo
  // -----------------------
});
