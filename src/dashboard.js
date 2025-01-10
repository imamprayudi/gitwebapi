
const $ = require('jquery');
const axios = require('axios');
const select2 = require('select2');
import Swal from 'sweetalert2';


import DataTable from 'datatables.net-dt';
import jszip from 'jszip';
import 'datatables.net-buttons-dt';
import 'datatables.net-buttons/js/buttons.html5.mjs';
import 'datatables.net-select-dt';

window.Swal = Swal;
// // CommonJS
// const Swal = require('sweetalert2');

$(function (){
  let authSession = JSON.parse(localStorage.getItem('poc_auth'));
  if (!localStorage.getItem('poc_auth')) {
    window.location.href = "../contents/login.html";
  }
  $(".load-holder").hide();
  $(".placeholder-glow").show();

  $("#select_po").select2({
    theme: "bootstrap-5",
    width: $(this).data("width")
      ? $(this).data("width")
      : $(this).hasClass("w-120")
      ? "100%"
      : "style",
    placeholder: $(this).data("placeholder"),
    closeOnSelect: false
  });

  axios
    .get("https://svr1.jkei.jvckenwood.com/api_gitweb/api/dashboard.php", {
      params: {
        method: "getMonthlyPoc",
        usr: authSession.usr,
        monthly: $('[name="monthly_poc"]').val()
      }
    })
    .then((res) => res.data)
    .then((res) => {
      $(".placeholder-glow").hide();
      $(".load-holder").show();
      // console.log({ localStorage });
      // console.log(res, "dashboard getMonthlyPoc =====================>");

      $('[name="monthly"]').text(res.monthly);

      const total_po = res.total_po;
      const total_poc = res.total_poc;
      const total_po_unread = res.total_po_unread;
      const total_poc_unread = res.total_poc_unread;
      const total_po_unconfirm = res.total_po_unconfirm;
      const total_poc_unconfirm = res.total_poc_unconfirm;
      const total_po_confirm = res.total_po_confirm;
      const total_poc_confirm = res.total_poc_confirm;
      const total_po_reject = res.total_po_reject;
      const total_poc_reject = res.total_poc_reject;

      $("#total_po").text(total_po);
      $("#total_poc").text(total_poc);
      $("#total_po_unread").text(total_po_unread);
      $("#total_poc_unread").text(total_poc_unread);
      $("#total_po_unconfirm").text(total_po_unconfirm);
      $("#total_poc_unconfirm").text(total_poc_unconfirm);
      $("#total_po_confirm").text(total_po_confirm);
      $("#total_poc_confirm").text(total_poc_confirm);
      $("#total_po_reject").text(total_po_reject);
      $("#total_poc_reject").text(total_poc_reject);

      let percent_po = (total_po_unread / total_po) * 100;
      let percent_po_unconfirm = (total_po_unconfirm / total_po) * 100;
      let percent_po_confirm = (total_po_confirm / total_po) * 100;
      let percent_po_reject = (total_po_reject / total_po) * 100;

      let percent_poc = (total_poc_unread / total_poc) * 100;
      let percent_poc_unconfirm = (total_poc_unconfirm / total_poc) * 100;
      let percent_poc_confirm = (total_poc_confirm / total_poc) * 100;
      let percent_poc_reject = (total_poc_reject / total_poc) * 100;

      $("#percentpo_unread").text(percent_po.toFixed(2));
      $("#percentpo_unconfirm").text(percent_po_unconfirm.toFixed(2));
      $("#percentpo_confirm").text(percent_po_confirm.toFixed(2));
      $("#percentpo_reject").text(percent_po_reject.toFixed(2));

      $("#percentpoc_unread").text(percent_poc.toFixed(2));
      $("#percentpoc_unconfirm").text(percent_poc_unconfirm.toFixed(2));
      $("#percentpoc_confirm").text(percent_poc_confirm.toFixed(2));
      $("#percentpoc_reject").text(percent_poc_reject.toFixed(2));

      $("#po").text(res.po);
    });
  // getSupplierGroup
  
  // console.log("authSession", authSession);
  // return;
  axios
    .get("https://svr1.jkei.jvckenwood.com/api_gitweb/api/jpo.php", {
      params: {
        method: "getSupplierGroup",
        usr: authSession.usr
      }
    })
    .then((res) => res.data.data)
    .then((res) => {
      // console.log("datasupplier", res);
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
  fetchSummarySupplier(authSession);

  $("form[name=filter-all]").submit((e) => {
    e.preventDefault();

    axios
      .get("https://svr1.jkei.jvckenwood.com/api_gitweb/api/dashboard.php", {
        params: {
          method: "getDataFilter",
          supplier: $("[name=supplier]").val(),
          from_date: $("[name=from_date]").val(),
          end_date: $("[name=end_date]").val(),
          select_po: $("[name=select_po]").val(),
          filter_by: $("[name=filter_by]").val(),
          usr: authSession.usr
        }
      })
      .then(function (response) {
        // console.log(response.message);

        // console.log("data_filter_all =>", response);
        let tablerepeat = new DataTable("#repeat-po", {
          data: response.data.repeated,
          fixedHeader: true,
          retrieve: true,
          responsive: true,
          order: [1, "desc"],
          dom: "Bfrtip",
          buttons: ["excelHtml5", "csvHtml5"],

          columns: [
            { data: "pono" },
            { data: "repeated" },
            {
              data: "pono",
              render: (data, type, row) => {
                return (
                  '<button id="btn-detail" class="btn btn-sm btn-primary ml-1" onclick="detail_click(' +
                  data +
                  ')" >Detail</button>'
                );
              }
            }
          ]
        });
        tablerepeat.clear().draw();
        tablerepeat.rows.add(response.data.repeated); // Add new data
        tablerepeat.columns.adjust().draw();
        // var table = $('#myTable').DataTable();
        var dummy = "";
        let tablechange = $("#po-change").DataTable({
          data: response.data.pochange,
          order: [1, "desc"],
          fixedHeader: true,
          retrieve: true,
          responsive: true,
          dom: "Bfrtip",
          buttons: ["excelHtml5", "csvHtml5"],

          columns: [
            { data: "idno" },
            { data: "rdate" },
            {
              data: dummy,
              render: function (data, type, row) {
                if (row.newdate > row.olddate) {
                  return "<p style=color:red;font-weight:bold> PO DOWN</p>";
                } else if (row.newdate < row.olddate) {
                  return "<p style=color:green;font-weight:bold> PO UP</p>";
                } else if (row.newqty == 0) {
                  return "<span style=color:red> PO CANCEL</span>";
                } else if (row.newqty < row.oldqty) {
                  return "<span style=color:orange> PO REDUCE</span>";
                }
              }
            },
            { data: "actioncode" },
            { data: "pono" },
            { data: "partno" },
            { data: "partname" },
            { data: "newqty" },
            { data: "newdate" },
            { data: "oldqty" },
            { data: "olddate" },
            { data: "potype" }
          ]
        });
        tablechange.clear().draw();
        tablechange.rows.add(response.data.pochange); // Add new data
        tablechange.columns.adjust().draw();

        //   if (response.data.failed){
        //     alert('data not found');

        //         Swal.fire({
        //             icon: 'warning',
        //             showConfirmButton :false,
        //         })
        //         tablerepeat.clear().draw();
        //         tablechange.clear().draw();
        //     }
      })
      .catch(function (error) {
        // console.log(error);
      });
  });
});

function fetchSummarySupplier(authSession) {
    axios
      .get("https://svr1.jkei.jvckenwood.com/api_gitweb/api/dashboard.php", {
        params: {
          method: "getSummarySupplier",
          usr: authSession.usr
        }
      })
      .then((res) => res.data)
      .then((res) => {
        // console.log("SUMMARY DATA =>", res);
        let tableSumSuppPo = new DataTable("#table-summary-supplier-po", {
          data: res.data_po,
          fixedHeader: false,
          retrieve: true,
          responsive: false,
          dom: "Bfrtip",
          order: [2, "desc"],
          buttons: ["excelHtml5", "csvHtml5"],
          lengthMenu: [
            [10, 25, 50, -1],
            [25, 50, 75, "All"]
          ],
          /* 
          SuppName :  "ASAHI BEST BASE INDONESIA PT                                                                        "
          po_number :  1867163
          read_at :  null
          status :  null
          supplier_code :  10693
          supplier_confirmed_at :  "2024-01-31 03:50:51.000"
          supplier_confirmed_by :  "jein                "
          supplier_confirmed_reason :  ""
          supplier_confirmed_status :  "REJECT"
          transmission_date :  "2024-01-25 00:00:00"
          transmission_no :  2024012500540
          */
          columns: [
            {
              title: "Action",
              data: "idno",
              render: (data, type, row) => {
                return (
                  '<a target="_blank" class="btn btn-sm btn-info ml-1" href="../contents/jgetpodtl.php?sid=' +
                  row.supplier_code +
                  "&tglid=" +
                  row.transmission_date +
                  "&sts=" +
                  "READ" +
                  "&pono=" +
                  row.po_number +
                  '">' +
                  "View Detail" +
                  "</a>"
                );
                return (
                  '<button id="btn-detail" class="btn btn-sm btn-info ml-1" onclick="po_detail(' +
                  data +
                  ')" >Detail</button>'
                );
              }
            }, // action
            {
              title: "SUPPLIER CONFIRM",
              data: "supplier_confirmed_reason",
              render: function (data, type, row) {
                let confirmed = "";
                if (row.supplier_confirmed_status == "CONFIRM")
                  confirmed =
                    "<span class='text-success'>" +
                    row.supplier_confirmed_status +
                    "</span>";
                if (row.supplier_confirmed_status == "REJECT")
                  confirmed =
                    "<span class='text-danger'>" +
                    row.supplier_confirmed_status +
                    "</span>";
                if (row.supplier_confirmed_status == null)
                  confirmed = "<span class='text-danger'>NOT YET</span>";
                if (row.supplier_confirmed_by)
                  confirmed +=
                    "<br><span class='text-secondary'> by " +
                    row.supplier_confirmed_by.toUpperCase() +
                    "</span>";
                if (row.supplier_confirmed_reason)
                  confirmed +=
                    "<br><span class='text-secondary text-wrap'>with reason is " +
                    row.supplier_confirmed_reason +
                    "</span> ";

                return confirmed;
              }
            },
            {
              title: "PURCH CONFIRM",
              data: "purch_confirmed_reason",
              render: function (data, type, row) {
                let confirmed = "";
                if (row.purch_confirmed_status == "CONFIRM FOR ACCEPT")
                  confirmed =
                    "<span class='text-success'>" +
                    row.purch_confirmed_status +
                    "</span>";

                if (row.purch_confirmed_status == "CONFIRM FOR REJECTION")
                  confirmed =
                    "<span class='text-danger'>" +
                    row.purch_confirmed_status +
                    "</span>";

                if (row.purch_confirmed_status == null)
                  confirmed = "<span class='text-info'>NOT YET</span>";
                if (row.purch_confirmed_by)
                  confirmed +=
                    "<br><span class='text-secondary'> by " +
                    row.purch_confirmed_by.toUpperCase() +
                    "</span>";
                if (row.purch_confirmed_reason)
                  confirmed +=
                    "<br><span class='text-secondary text-wrap'>with reason is " +
                    row.purch_confirmed_reason +
                    "</span> ";

                return confirmed;
              }
            },
            {
              title: "MC CONFIRM",
              data: "mc_confirmed_reason",
              render: function (data, type, row) {
                let confirmed = "NOT YET";
                if (row.mc_confirmed_status == "CONFIRM PUT BACK")
                  confirmed =
                    "<span class='text-success'>" +
                    row.mc_confirmed_status +
                    "</span>";

                if (row.mc_confirmed_status == "REJECT PUT BACK")
                  confirmed =
                    "<span class='text-danger'>" +
                    row.mc_confirmed_status +
                    "</span>";

                if (row.mc_confirmed_status == null)
                  confirmed = "<span class='text-info'>NOT YET</span>";
                if (row.mc_confirmed_by)
                  confirmed +=
                    "<br><span class='text-secondary'> by " +
                    row.mc_confirmed_by.toUpperCase() +
                    "</span>";
                if (row.mc_confirmed_reason)
                  confirmed +=
                    "<br><span class='text-secondary text-wrap'>with reason is " +
                    row.mc_confirmed_reason +
                    "</span> ";

                return confirmed;
              }
            },
            { title: "Trans Date", data: "transmission_date" },
            { title: "Trans NO", data: "transmission_no" },
            { title: "Supplier Code", data: "supplier_code" },
            { title: "Supplier Name", data: "SuppName" },
            { title: "PO NO", data: "po_number" }
          ]
        });
        tableSumSuppPo.clear().draw();
        tableSumSuppPo.rows.add(res.data_po); // Add new data
        tableSumSuppPo.columns.adjust().draw();

        let tableSumSuppPoc = new DataTable("#table-summary-supplier-poc", {
          data: res.data_poc,
          fixedHeader: false,
          retrieve: true,
          responsive: false,
          dom: "Bfrtip",
          order: [2, "desc"],
          buttons: ["excelHtml5", "csvHtml5"],
          lengthMenu: [
            [10, 25, 50, -1],
            [25, 50, 75, "All"]
          ],
          /* 
          SuppName :  "ASAHI BEST BASE INDONESIA PT                                                                        "
          po_number :  1867163
          read_at :  null
          status :  null
          supplier_code :  10693
          supplier_confirmed_at :  "2024-01-31 03:50:51.000"
          supplier_confirmed_by :  "jein                "
          supplier_confirmed_reason :  ""
          supplier_confirmed_status :  "REJECT"
          transmission_date :  "2024-01-25 00:00:00"
          transmission_no :  2024012500540
          */
          columns: [
            {
              title: "Action",
              data: "idno",
              render: (data, type, row) => {
                return (
                  '<a target="_blank" class="btn btn-sm btn-info ml-1" href="../contents/jgetpocdtl.php?sid=' +
                  row.supplier_code +
                  "&tglid=" +
                  row.transmission_date +
                  "&sts=" +
                  "READ" +
                  "&pono=" +
                  row.po_number +
                  '">' +
                  "View Detail" +
                  "</a>"
                );
                return (
                  '<button id="btn-detail" class="btn btn-sm btn-info ml-1" onclick="po_detail(' +
                  data +
                  ')" >Detail</button>'
                );
              }
            }, // action
            {
              title: "SUPPLIER CONFIRM",
              data: "supplier_confirmed_reason",
              render: function (data, type, row) {
                let confirmed = "";
                if (row.supplier_confirmed_status == "CONFIRM")
                  confirmed =
                    "<span class='text-success'>" +
                    row.supplier_confirmed_status +
                    "</span>";
                if (row.supplier_confirmed_status == "REJECT")
                  confirmed =
                    "<span class='text-danger'>" +
                    row.supplier_confirmed_status +
                    "</span>";
                if (row.supplier_confirmed_status == null)
                  confirmed = "<span class='text-danger'>NOT YET</span>";
                if (row.supplier_confirmed_by)
                  confirmed +=
                    "<br><span class='text-secondary'> by " +
                    row.supplier_confirmed_by.toUpperCase() +
                    "</span>";
                if (row.supplier_confirmed_reason)
                  confirmed +=
                    "<br><span class='text-secondary text-wrap'>with reason is " +
                    row.supplier_confirmed_reason +
                    "</span> ";

                return confirmed;
              }
            },
            {
              title: "PURCH CONFIRM",
              data: "purch_confirmed_reason",
              render: function (data, type, row) {
                let confirmed = "";
                if (row.purch_confirmed_status == "CONFIRM FOR ACCEPT")
                  confirmed =
                    "<span class='text-success'>" +
                    row.purch_confirmed_status +
                    "</span>";

                if (row.purch_confirmed_status == "CONFIRM FOR REJECTION")
                  confirmed =
                    "<span class='text-danger'>" +
                    row.purch_confirmed_status +
                    "</span>";

                if (row.purch_confirmed_status == null)
                  confirmed = "<span class='text-info'>NOT YET</span>";
                if (row.purch_confirmed_by)
                  confirmed +=
                    "<br><span class='text-secondary'> by " +
                    row.purch_confirmed_by.toUpperCase() +
                    "</span>";
                if (row.purch_confirmed_reason)
                  confirmed +=
                    "<br><span class='text-secondary text-wrap'>with reason is " +
                    row.purch_confirmed_reason +
                    "</span> ";

                return confirmed;
              }
            },
            {
              title: "MC CONFIRM",
              data: "mc_confirmed_reason",
              render: function (data, type, row) {
                let confirmed = "NOT YET";
                if (row.mc_confirmed_status == "CONFIRM PUT BACK")
                  confirmed =
                    "<span class='text-success'>" +
                    row.mc_confirmed_status +
                    "</span>";

                if (row.mc_confirmed_status == "REJECT PUT BACK")
                  confirmed =
                    "<span class='text-danger'>" +
                    row.mc_confirmed_status +
                    "</span>";

                if (row.mc_confirmed_status == null)
                  confirmed = "<span class='text-info'>NOT YET</span>";
                if (row.mc_confirmed_by)
                  confirmed +=
                    "<br><span class='text-secondary'> by " +
                    row.mc_confirmed_by.toUpperCase() +
                    "</span>";
                if (row.mc_confirmed_reason)
                  confirmed +=
                    "<br><span class='text-secondary text-wrap'>with reason is " +
                    row.mc_confirmed_reason +
                    "</span> ";

                return confirmed;
              }
            },
            { title: "Trans Date", data: "transmission_date" },
            { title: "Trans NO", data: "transmission_no" },
            { title: "Supplier Code", data: "supplier_code" },
            { title: "Supplier Name", data: "SuppName" },
            { title: "PO NO", data: "po_number" }
          ]
        });
        tableSumSuppPoc.clear().draw();
        tableSumSuppPoc.rows.add(res.data_poc); // Add new data
        tableSumSuppPoc.columns.adjust().draw();
      })
      .catch((error) => {
        // console.log({ error });
        let res = error.response;
        let data = res.data;
        let msg = data.message;

        msg = msg || "Something went wrong";

        renderMessage({
          html: msg,
          classes: "alert-danger",
          icons: "fa-solid fa-ban"
        });

        if ($("div.loading").hasClass("d-none") == false)
          $("div.loading").addClass("d-none");
      })
      .finally(() => {
        if ($("div.loading").hasClass("d-none") == false)
          $("div.loading").addClass("d-none");
      });
}


function getFilter(param) {
  // console.log("change " + param);
  axios
    .get("https://svr1.jkei.jvckenwood.com/api_gitweb/api/jpo.php", {
      params: {
        method: "getFilterBy",
        supplier: $("[name=supplier]").val(),
        from_date: $("[name=from_date]").val(),
        end_date: $("[name=end_date]").val(),
        filter_by: $("[name=filter_by]").val(),
        select_po: $("[name=select_po]").val(),
        usr: authSession.usr
      }
    })
    .then((res) => res.data.data)
    .then((res) => {
      // console.log(res);
      var toAppend = "";
      $.each(res, function (i, o) {
        toAppend += "<option>" + o + "</option>";
      });
      $("#select_poc").find("option").remove().end().append(toAppend);
    });
}

//FILTER PARTNO

$("[name=supplier]").on('change',()=>{
    getFilter('supplier')
});
$("[name=from_date]").on('change',()=>{
    getFilter("from_date");
});
$("[name=end_date]").on('change',()=>{
    getFilter("end_date");
});
$("[name=filter_by]").on('change',()=>{
    getFilter("filter_by");
});

// $("[name=supplier]").on('change',getFilter('supplier'));
// $("[name=from_date]").on('change',getFilter("from_date"));
// $("[name=end_date]").on('change',getFilter("end_date"));
// $("[name=filter_by]").on('change',getFilter("filter_by"));

