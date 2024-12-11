const $ = require("jquery");
const axios = require("axios");
const select2 = require("select2");
import Swal from "sweetalert2";

import jszip from "jszip";
import DataTable from "datatables.net-dt";
import "datatables.net-buttons-dt";
import "datatables.net-buttons/js/buttons.html5.mjs";
import "datatables.net-select-dt";

// window.Swal = Swal;
// // CommonJS
// const Swal = require('sweetalert2');
function renderMessage(obj = { html: null, classes: "", icons: null }) {
  let htmo =
    '<div id="infinite" class="alert ' +
    obj.classes +
    ' alert-dismissible fade show" role="alert">' +
    '<i class="' +
    obj.icons +
    '"></i> ' +
    obj.html +
    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
    "</div>";

  $("div.message").html(htmo);
  console.log("Message Rendering", obj.html);
  return;
}

function getUrlVars() {
  var search = location.search.substring(1);
  return JSON.parse(
    '{"' +
      decodeURI(search)
        .replace(/"/g, '\\"')
        .replace(/&/g, '","')
        .replace(/=/g, '":"') +
      '"}'
  );

  // var vars = [], hash;
  // var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
  // for(var i = 0; i < hashes.length; i++)
  // {
  //     hash = hashes[i].split('=');
  //     // vars.push(hash[0]);
  //     vars[hash[0]] = hash[1];
  // }
  // return vars;
}

var tablePODetail;

// if ($mysecure == '4') {
//   echo "PURCHASING CONFIRMATION";
// } else if ($mysecure == '6') {
//   echo "MATERIAL CONTROL CONFIRMATION";
// } else if ($mysecure == '3') {
//   echo "BUYER CONFIRMATION";
// } else {
//   echo "CONFIRMATION " . $mysecure;
// }
$(function () {
  var usrsecure = $("#usrsecure").val();
  $("div.message").html(null);
  var search = location.search.substring(1);
  var params = JSON.parse(
    '{"' +
      decodeURI(search)
        .replace(/"/g, '\\"')
        .replace(/&/g, '","')
        .replace(/=/g, '":"') +
      '"}'
  );

  renderPage(usrsecure);

  // update read status from supplier
  params.method = "updateReadStatus";
  updateReadStatus(params);
  // END of update read status from supplier
  // ---------------------------------------

  $("button#confirm_podtl").on("click", function (e) {
    console.log("confirm_podtl START");
    e.preventDefault();
    var reason = $("#reason").val();
    var data = tablePODetail.rows({ selected: true }).data().toArray();
    console.log("confirm_podtl DATA == ", data);
    
    if (data.length == 0) {
      renderMessage({
        html: "Select PO first !",
        classes: "alert-danger",
        icons: "fa-solid fa-ban"
      });
      console.log("Select PO First !");
    } else {
      var query = getUrlVars();
      console.log("confirm_podtl PARAM == ", query);
      // console.log("set query => ", query)
      // console.log("set param => ",data);
      $("div.loading").removeClass("d-none");
      let url = "../api/jpo.php";
      if (usrsecure == 0 || usrsecure == 1 || usrsecure == 2 || usrsecure == 5)
        renderMessage({
          html: "You can not confirm this PO / POC",
          classes: "alert-danger",
          icons: "fa-solid fa-ban"
        });

      console.log("confirm_podtl PROCESSING !");
      // confirmed based on user secure
      let status = "CONFIRM";
      if (usrsecure == 3) {
        status = status;
      }
      if (usrsecure == 4) {
        status = "CONFIRM FOR ACCEPT";
      }
      if (usrsecure == 6) {
        status = "CONFIRM PUT BACK";
      }

      console.log("confirm_podtl STATUS !", {
        status: status,
        reason: reason,
        usrsecure: usrsecure
      });

      axios
        .get(url, {
          params: {
            method: "confirm",
            data: data,
            additional: query,
            status: status,
            reason: reason,
            usrsecure: usrsecure
          }
        })
        .then((res) => {
          if ($.fn.dataTable.isDataTable("#table-purchase-order-detail")) {
            $("#table-purchase-order-detail").DataTable().destroy();
            $("#table-purchase-order-detail").empty();
          }
          // console.log("confirm By Supplier => ", res);
          console.log("confirm_podtl DONE !", res);
          $("div.message").html(null);
          $("#reason").val("");
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

          if ($("div.loading").hasClass("d-none") == false)
            $("div.loading").addClass("d-none");
        })
        .finally(() => {
          // hide loading
          getDataPoDetail();
          $("div.loading").addClass("d-none");
        });
    }
  });

  $("button#reject_podtl").on("click", function (e) {
    console.log("reject_podtl START");
    e.preventDefault();
    var reason = $("#reason").val();
    var data = tablePODetail.rows({ selected: true }).data().toArray();
    console.log("reject_podtl DATA => ", data);

    if (data.length == 0) {
      renderMessage({
        html: "Select PO first !",
        classes: "alert-danger",
        icons: "fa-solid fa-ban"
      });
      console.log("Select PO First !");
    } else {
      var query = getUrlVars();
      console.log("reject_podtl PARAM == ", query);
      // console.log("set query => ", query);
      // console.log("set param => ",data);
      $("div.loading").removeClass("d-none");
      let url = "../api/jpo.php";
      if (usrsecure == 0 || usrsecure == 1 || usrsecure == 2 || usrsecure == 5)
        renderMessage({
          html: "You can not reject this PO / POC",
          classes: "alert-danger",
          icons: "fa-solid fa-ban"
        });

      console.log("reject_podtl PROCESSING !");

      let status = "REJECT";
      if (usrsecure == 3) {
        status = status;
      }
      if (usrsecure == 4) {
        status = "CONFIRM FOR REJECTION";
      }
      if (usrsecure == 6) {
        status = "REJECT PUT BACK";
      }
      console.log("reject_podtl STATUS !", {
        status: status,
        reason: reason,
        usrsecure: usrsecure
      });
      axios
        .get(url, {
          params: {
            method: "confirm",
            data: data,
            additional: query,
            status: status,
            reason: reason,
            usrsecure: usrsecure
          }
        })
        .then((res) => {
          if ($.fn.dataTable.isDataTable("#table-purchase-order-detail")) {
            $("#table-purchase-order-detail").DataTable().destroy();
            $("#table-purchase-order-detail").empty();
          }
          console.log("reject_podtl DONE !", res);
          $("div.message").html(null);
          $("#reason").val("");
        })
        .catch((error) => {
          console.log("Error 230 jpo_detail", { error });
          let res = error.response;
          let msg = error.message;
          // let msg = data.message;

          msg = msg || "Something went wrong";

          renderMessage({
            html: msg,
            classes: "alert-danger",
            icons: "fa-solid fa-ban"
          });

          if ($("div.loading").hasClass("d-none") == false)
            $("div.loading").addClass("d-none");
          // toggleLoadingLogin();
        })
        .finally(() => {
          // hide loading
          getDataPoDetail();
          $("div.loading").addClass("d-none");
        });
    }
  });

  getDataPoDetail(params);

  return;
});

function renderPage(usrsecure) {
  if (usrsecure == 0 || usrsecure == 1 || usrsecure == 2 || usrsecure == 5)
    $("#confirmation").hide();
  $("#confirmation").show();
  if (usrsecure == "3") {
    $("#confirm_title").html("BUYER CONFIRMATION");
    $("#confirm_podtl").html("<i class='bi bi-check-circle'></i> CONFIRM");
    $("#reject_podtl").html("<i class='bi bi-x-circle'></i> REJECT");
  } else if (usrsecure == "4") {
    $("#confirm_title").html("PURCHASING CONFIRMATION");
    $("#confirm_podtl").html(
      "<i class='bi bi-check-circle'></i> CONFIRM FOR ACCEPT"
    );
    $("#reject_podtl").html(
      "<i class='bi bi-x-circle'></i> CONFIRM FOR REJECT"
    );
  } else if (usrsecure == "6") {
    $("#confirm_title").html("MATERIAL CONTROL CONFIRMATION");
    $("#confirm_podtl").html(
      "<i class='bi bi-check-circle'></i> CONFIRM PUT BACK"
    );
    $("#reject_podtl").html("<i class='bi bi-x-circle'></i> REJECT PUT BACK");
  } else {
    $("#confirm_title").html("CONFIRMATION " + usrsecure);
  }
}

function getDataPoDetail(params = null) {
  // get data PO Detail
  if (params == null) {
    var search = location.search.substring(1);
    var params = JSON.parse(
      '{"' +
        decodeURI(search)
          .replace(/"/g, '\\"')
          .replace(/&/g, '","')
          .replace(/=/g, '":"') +
        '"}'
    );
  }
  params.method = "getDataPoDetail";
  axios
    .get("../api/jpo.php", {
      params: params
    })
    // .then((res) => res.data)
    .then((res) => {
      console.log("get data PO Detail", res);
      res = res.data;
      if (res.success == false) {
        renderMessage({
          html: res.message,
          classes: "alert-warning",
          icons: "fa-solid fa-triangle-exclamation"
        });
        return;
      }
      if (res.success == true) {
        tablePODetail = new DataTable("#table-purchase-order-detail", {
          data: res,
          fixedHeader: false,
          retrieve: true,
          responsive: false,
          dom: "Bfrltip",
          columnDefs: [
            {
              orderable: false,
              className: "select-checkbox",
              targets: 0
            }
          ],
          select: {
            style: "multi",
            // selector: "td:first-child"
          },
          // order: [2, "desc"],
          // select: {
          //   style: "multi",
          //   selector: "tr"
          // },
          buttons: ["excelHtml5", "csvHtml5", "selectAll", "selectNone"],
          lengthMenu: [
            [10, 25, 50, -1],
            [25, 50, 75, "All"]
          ],
          columns: [
            {
              title: "#",
              data: null,
              name: "cb_podtl",
              defaultContent:""
              //   '<input type="checkbox" name="cb_podtl" class="dt-checkboxes" />'
            },
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
            { title: "TRANSMISSION NO", data: "idno" },
            {
              title: "PO STATUS",
              data: "",
              render: function (data, type, row) {
                if (row.newdate > row.olddate) {
                  return "<p class='text-danger fw-bold'> PO DOWN</p>";
                } else if (row.newdate < row.olddate) {
                  return "<p class='text-success fw-bold'> PO UP</p>";
                } else if (row.newqty == 0) {
                  return "<span class='text-secondary fw-bold'> PO CANCEL</span>";
                } else if (row.newqty < row.oldqty) {
                  return "<span class='text-warning fw-bold'> PO REDUCE</span>";
                }
              }
            },
            { title: "PO NUMBER", data: "pono" },
            { title: "PART NUMBER", data: "partno" },
            { title: "PART NAME", data: "partname" },
            { title: "PO QTY", data: "newqty" },
            { title: "PO DATE", data: "newdate" },
            { title: "PRICE", data: "price" },
            { title: "MODEL", data: "model" },
            { title: "PO TYPE", data: "potype" }
          ]
        });
        // Handle form submission event
        // $("#frm-example").on("submit", function (e) {
        //   var form = this;

        //   var rows_selected = tablePODetail.column(0).checkboxes.selected();

        //   // Iterate over all selected checkboxes
        //   $.each(rows_selected, function (index, rowId) {
        //     // Create a hidden element
        //     $(form).append(
        //       $("<input>")
        //         .attr("type", "hidden")
        //         .attr("name", "id[]")
        //         .val(rowId)
        //     );
        //   });
        // });

        tablePODetail.clear().draw();
        tablePODetail.rows.add(res.data); // Add new data
        tablePODetail.columns.adjust().draw();
      }
    })
    .catch((error) => {
      console.log("error get data po detail => ", { error });
      let msg = error.message;
      msg = msg || "Something went wrong";

      renderMessage({
        html: msg,
        classes: "alert-danger",
        icons: "fa-solid fa-ban"
      });

    })
    .finally(() => {
      // hide loading
      $("div.loading").addClass("d-none");
    });
  // END Of get data PO Detail
  // -------------------------
}

function updateReadStatus(params = null) {
  axios
    .get("../api/jpo.php", {
      params: params
    })
    .then((res) => res.data)
    .then((res) => {
      console.log("read status updating", res);
      $(".pagetitle>h1").html("Purchase Order Detail - " + res.supplier);

      if (res.message == "not supplier") {
        $("div.message").html(null);

        if ($("div.loading").hasClass("d-none") == false)
          $("div.loading").addClass("d-none");
        return;
      }
      if (res.success == false) {
        renderMessage({
          html: res.message,
          classes: "alert-warning",
          icons: "fa-solid fa-triangle-exclamation"
        });
        return;
      }
      if (res.success == true) {
        renderMessage({
          html: "Thank you for read the detail...", // res.message,
          classes: "alert-info ",
          icons: "fa-solid fa-circle-info"
        });
        setTimeout(() => {
          $("div.message").html(null);
        }, "5000");
        // setTimeout($("div.message").html(null), 5000);
        return;
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

      if ($("div.loading").hasClass("d-none") == false)
        $("div.loading").addClass("d-none");
    })
    .finally(() => {
      $("div.loading").addClass("d-none");
    });
}
