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
      console.log("datasupplier ================>", res);
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

  $("form[name=submit_tds]").submit((e) => {
    e.preventDefault();
    $("#submit_btn").attr("disabled", true);
    $("div.loading").toggleClass("d-none");
    $("div.message").html(null);

    axios
      .get("https://svr1.jkei.jvckenwood.com/api_gitweb/api/jtds.php", {
        params: {
          method: "getDataTds",
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

        console.log("data Time Delivery :::: ", res);
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
          let tableTimeDelivery = new DataTable("#table-timeDelivery", {
            data: res.data,
            fixedHeader: false,
            retrieve: true,
            responsive: false,
            // dom: "Bfrltip",
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
            columns: [
              { title: "NO", data: "partnumber" },
              { title: "PART NUMBER", data: "partnumber" },
              { title: "PART NAME", data: "partname" },
              { title: "ORDER QTY", data: "orderqty" },
              { title: "REQUIRED DATE", data: "reqdate" },
              { title: "PO NUMBER", data: "ponumber" },
              { title: "SQ", data: "posq" },
              { title: "ORDER BALANCE", data: "timeDelivery" },
              { title: "SUPP REST", data: "supprest" },
              { title: "MODEL", data: "model" },
              { title: "ISSUE DATE", data: "issuedate" },
              { title: "PO TYPE", data: "potype" },
            ]
          });
          tableTimeDelivery.clear().draw();

          tableTimeDelivery.rows.add(res.data); // Add new data
          tableTimeDelivery.on('order.dt search.dt', function () {
            let i = 1;

            tableTimeDelivery
              .cells(null, 0, { search: 'applied', order: 'applied' })
              .every(function (cell) {
                this.data(i++);
              });
          })
            .draw();
          tableTimeDelivery.columns.adjust().draw();

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

});
