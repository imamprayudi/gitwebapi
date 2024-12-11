const $ = require("jquery");
const axios = require("axios");
const select2 = require("select2");
import Swal from "sweetalert2";

import jszip from "jszip";
import DataTable from "datatables.net-dt";
import "datatables.net-buttons-dt";
import "datatables.net-buttons/js/buttons.html5.mjs";
import "datatables.net-select-dt";

window.Swal = Swal;
// // CommonJS
// const Swal = require('sweetalert2');

$(function () {
  $("div.message").html(null);
  if ($("div.loading").hasClass("d-none") == false)
    $("div.loading").addClass("d-none");
  $("#submit_btn").attr("disabled", false);

  $("#select_po").select2({
    theme: "bootstrap-5",
    // width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-120' ) ? '100%' : 'style',
    placeholder: $(this).data("placeholder"),
    closeOnSelect: false
  });

  // getSupplierGroup
  axios
    .get("../api/jpo.php", {
      params: {
        method: "getSupplierGroup"
      }
    })
    .then((res) => res.data.data)
    .then((res) => {
      // console.log("datasupplier",res);
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

  // getData Input PO/Partnumber/TransmissionDate based on filter by
  function getFilter() {
    axios
      .get("../api/jpoc.php", {
        params: {
          method: "getFilterBy",
          supplier: $("[name=supplier]").val(),
          from_date: $("[name=from_date]").val(),
          end_date: $("[name=end_date]").val(),
          filter_by: $("[name=filter_by]").val(),
          select_po: $("[name=select_po]").val()
        }
      })
      .then((res) => res.data.data)
      .then((res) => {
        console.log(res);
        if ($.fn.dataTable.isDataTable("#table-purchase-order-change")) {
          $("#table-purchase-order-change").DataTable().destroy();
          $("#table-purchase-order-change").empty();
        }
        var toAppend = "";
        $.each(res, function (i, o) {
          toAppend += "<option>" + o + "</option>";
        });
        $("#select_po").find("option").remove().end().append(toAppend);
      });
  }
  $("[name=supplier]").on("change", () => {
    getFilter("supplier");
  });
  $("[name=from_date]").on("change", () => {
    getFilter("from_date");
  });
  $("[name=end_date]").on("change", () => {
    getFilter("end_date");
  });
  $("[name=filter_by]").on("change", () => {
    getFilter("filter_by");
  });
  // End Of getData Input PO/Partnumber/TransmissionDate based on filter by
  // ----------------------------------------------------------------------

  // getData SubmitPo
  $("form[name=submit_poc]").submit((e) => {
    e.preventDefault();
    $("#submit_btn").attr("disabled", true);
    $("div.loading").toggleClass("d-none");
    $("div.message").html(null);

    axios
      .get("../api/jpoc.php", {
        params: {
          method: "getDataPoChangeST",
          supplier: $("[name=supplier]").val(),
          from_date: $("[name=from_date]").val(),
          end_date: $("[name=end_date]").val(),
          select_po: $("[name=select_po]").val(),
          filter_by: $("[name=filter_by]").val()
        }
      })
      .then((res) => res.data)
      .then((res) => {
        
        console.log("dataaaaaaaaaaaaa", res);
        console.log("dataaaaaaaaaaaaa", $("[name=filter_by]").val());
        if (res.success == false) {
          renderMessage({
            html: res.message,
            classes: "alert-warning",
            icons: "fa-solid fa-triangle-exclamation"
          });
          return;
        }

        if (res.success == true) {
          if ($("[name=filter_by]").val() == "rdate") {
            // console.log("get data post => ", res.data);
            let tablePOST = new DataTable("#table-purchase-order-change", {
              data: res.data,
              fixedHeader: false,
              retrieve: true,
              responsive: false,
              dom: "frltip",
              order: [2, "desc"],
              buttons: ["excelHtml5", "csvHtml5", "selectAll", "selectNone"],
              lengthMenu: [
                [10, 25, 50, -1],
                [25, 50, 75, "All"]
              ],
              columns: [
                {
                  title: "Action",
                  data: "idno",
                  render: (data, type, row) => {
                    return (
                      '<a target="_blank" class="btn btn-sm btn-info ml-1" href="jgetpocdtl.php?sid=' +
                      row.supplier +
                      "&tglid=" +
                      row.transdate +
                      "&sts=" +
                      row.status +
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
                },
                { title: "Transmission Date", data: "transdate" },
                {
                  title: "Status",
                  data: "status",
                  render: (data, type, row) => {
                    // console.log("response data", data);
                    // console.log("response type", type);
                    // console.log("response row", row);
                    let rendering = '<p class="text-center fw-bold">';
                    let status = row.status.toUpperCase();
                    if (status == "UNREAD") {
                      rendering = '<p class="text-center text-danger fw-bold">';
                    }
                    if (status == "READ") {
                      rendering =
                        '<p class="text-center text-success fw-bold">';
                    }
                    rendering = rendering + status + "</p>";
                    return rendering;
                  }
                },
                { title: "Read At", data: "updated" },
                {
                  title: "Progress",
                  data: "extn",
                  render: function (data, type, row, meta) {
                    // console.log("render dtatable", [data, type, row, meta]);
                    return type === "display"
                      ? '<div class="progress">' +
                          '<div class="progress-bar bg-success" role="progressbar" aria-valuenow="' +
                          row.total_confirmed +
                          '" aria-valuemin="0" aria-valuemax="' +
                          row.total_po +
                          '">' +
                          row.total_confirmed +
                          " PO</div>" +
                          '<div class="progress-bar bg-danger" role="progressbar" aria-valuenow="' +
                          row.total_rejected +
                          '" aria-valuemin="0" aria-valuemax="' +
                          row.total_po +
                          '">' +
                          row.total_rejected +
                          " PO</div>" +
                          "</div>"
                      : // '<progress value="' + data.total_confirmed + '" max="'+data.total_po+'"></progress>'
                        0;
                  }
                },
                {
                  title: "Total PO",
                  data: "total_po",
                  render: function (data, type, row, meta) {
                    return (
                      '<p class="text-success text-center">' +
                      row.total_confirmed +
                      "</p>"
                    );
                  }
                },
                {
                  title: "Confirmed",
                  data: "total_confirmed",
                  render: function (data, type, row, meta) {
                    return (
                      '<p class="text-success text-center">' +
                      row.total_confirmed +
                      "</p>"
                    );
                  }
                },
                {
                  title: "Rejected",
                  data: "total_rejected",
                  render: function (data, type, row, meta) {
                    return (
                      '<p class="text-danger text-center">' +
                      row.total_rejected +
                      "</p>"
                    );
                  }
                },
                {
                  title: "Balance",
                  data: null,
                  render: function (data, type, row, meta) {
                    let balance_po =
                      row.total_po - row.total_confirmed - row.total_rejected;
                    return '<p class="text-center">' + balance_po + "</p>";
                  }
                }
              ]
            });
            tablePOST.clear().draw();
            tablePOST.rows.add(res.data); // Add new data
            tablePOST.columns.adjust().draw();
          } else {
            let tablePOST = new DataTable("#table-purchase-order-change", {
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
                [10, 25, 50, -1],
                [25, 50, 75, "All"]
              ],
              columns: [
                // <th scope="col">#</th>
                //   <th scope="col">CONFIRMATION STATUS</th>
                //   <th scope="col">TRANSMISSION DATE</th>
                //   <th scope="col">TRANSMISSION NO</th>
                //   <th scope="col">PO STATUS</th>
                //   <th scope="col">PO NUMBER</th>
                //   <th scope="col">PART NUMBER</th>
                //   <th scope="col">PART NAME</th>
                //   <th scope="col">PO QTY</th>
                //   <th scope="col">PO DATE</th>
                //   <th scope="col">PRICE</th>
                //   <th scope="col">MODEL</th>
                //   <th scope="col">PO TYPE</th>
                //   <th scope="col">REASON</th>
                //   <th scope="col">CONFIRMED BY</th>
                // {
                //   data: null,
                //   name: "cb_podtl",
                //   defaultContent: '<input type="checkbox" name="cb_podtl">'
                // },
                {
                  title: "CONFIRMATION STATUS",
                  data: "supplier_confirmed_status",
                  render: function (data, type, row) {
                    if (row.supplier_confirmed_status == null) {
                      return "<p class='text-danger'>NOT YET CONFIRM</p>";
                    } else {
                      return (
                        "<p class='text-success'>" +
                        row.supplier_confirmed_status +
                        "</p>"
                      );
                    }
                  }
                },
                { title: "TRANSMISSION DATE", data: "rdate" },
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
                { title: "PO TYPE", data: "potype" },
                {
                  title: "REASON",
                  data: "supplier_confirmed_reason",
                  render: function (data, type, row) {
                    if (row.supplier_confirmed_status == "CONFIRM") {
                      return (
                        "<p class='text-success'>" +
                        row.supplier_confirmed_status +
                        "<br>" +
                        row.supplier_confirmed_reason +
                        "</p>"
                      );
                    }
                    if (row.supplier_confirmed_status == null) {
                      return "<p class='text-danger'>-</p>";
                    }
                  }
                },
                {
                  title: "CONFIRMED BY",
                  data: "confirmed_by",
                  render: function (data, type, row) {
                    if (row.supplier_confirmed_by == null) {
                      return "<p class='text-danger'>-</p>";
                    }
                    return (
                      "<p>" +
                      row.supplier_confirmed_by +
                      "<br>" +
                      row.supplier_confirmed_at +
                      "</p>"
                    );
                  }
                }
              ]
            });
            tablePOST.clear().draw();
            tablePOST.rows.add(res.data); // Add new data
            tablePOST.columns.adjust().draw();
          }
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
  // END of getData SubmitPo
  // -----------------------
});


function renderMessage(obj = { html: null, classes: "", icons: null }) {
  let htmo =
    '<div class="alert ' +
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
$(function () {
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

  // update read status from supplier
  params.method = "updateReadStatus";
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
          classes: "alert-info",
          icons: "fa-solid fa-circle-info"
        });
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
  // END of update read status from supplier
  // ---------------------------------------

  $("button#confirm_podtl").on("click", function (e) {
    e.preventDefault();
    var reason = $("#reason").val();
    var data = tablePODetail
      .rows(function (idx, data, node) {
        return $(node)
          .find('input[type="checkbox"][name="cb_podtl"]')
          .prop("checked");
        // return $(node).find('[className="cb_podtl"]').prop('checked');
      })
      .data()
      .toArray();
    console.log("confirm po detail data => ", data);

    if (data.length == 0) {
      renderMessage({
        html: "Select PO first !",
        classes: "alert-danger",
        icons: "fa-solid fa-ban"
      });
    } else {
      var query = getUrlVars();
      console.log("set query => ", query);
      // console.log("set param => ",data);
      $("div.loading").removeClass("d-none");
      let url = "../api/jpo.php";
      axios
        .get(url, {
          params: {
            method: "confirmBySupplier",
            data: data,
            additional: query,
            status: "CONFIRM",
            reason: reason
          }
        })
        .then((res) => {
          if ($.fn.dataTable.isDataTable("#table-purchase-order-detail")) {
            $("#table-purchase-order-detail").DataTable().destroy();
            $("#table-purchase-order-detail").empty();
          }
          console.log("confirm By Supplier => ", res);

          getDataPoDetail();
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
          // toggleLoadingLogin();
        })
        .finally(() => {
          // hide loading
          $("div.loading").addClass("d-none");
        });
    }
  });
  $("button#reject_podtl").on("click", function (e) {
    e.preventDefault();
    var reason = $("#reason").val();
    var data = tablePODetail
      .rows(function (idx, data, node) {
        return $(node)
          .find('input[type="checkbox"][name="cb_podtl"]')
          .prop("checked");
        // return $(node).find('[className="cb_podtl"]').prop('checked');
      })
      .data()
      .toArray();
    console.log("confirm po detail data => ", data);

    if (data.length == 0) {
      renderMessage({
        html: "Select PO first !",
        classes: "alert-danger",
        icons: "fa-solid fa-ban"
      });
    } else {
      var query = getUrlVars();
      console.log("set query => ", query);
      // console.log("set param => ",data);
      $("div.loading").removeClass("d-none");
      let url = "../api/jpo.php";
      axios
        .get(url, {
          params: {
            method: "rejectBySupplier",
            data: data,
            additional: query,
            status: "REJECT",
            reason: reason
          }
        })
        .then((res) => {
          if ($.fn.dataTable.isDataTable("#table-purchase-order-detail")) {
            $("#table-purchase-order-detail").DataTable().destroy();
            $("#table-purchase-order-detail").empty();
          }
          console.log("reject By Supplier => ", res);
          getDataPoDetail();
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
          $("div.loading").addClass("d-none");
        });
    }
  });

  getDataPoDetail(params);

  return;

});

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
        console.log("get data post => ", res);

        tablePODetail = new DataTable("#table-purchase-order-detail", {
          data: res,
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
            [10, 25, 50, -1],
            [25, 50, 75, "All"]
          ],
          columns: [
            {
              title: "#",
              data: null,
              name: "cb_podtl",
              defaultContent: '<input type="checkbox" name="cb_podtl">'
            },
            {
              title: "CONFIRMATION STATUS",
              data: "supplier_confirmed_status",
              render: function (data, type, row) {
                if (row.supplier_confirmed_status == "CONFIRM") {
                  return (
                    "<p class='text-success'>" +
                    row.supplier_confirmed_status +
                    "</p>"
                  );
                } else if (row.supplier_confirmed_status == "REJECT") {
                  return (
                    "<p class='text-danger'>" +
                    row.supplier_confirmed_status +
                    "</p>"
                  );
                } else {
                  return "<p class='text-warning'>NOT YET CONFIRM</p>";
                }
              }
            },
            { title: "TRANSMISSION DATE", data: "rdate" },
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
            { title: "PO TYPE", data: "potype" },
            {
              title: "REASON",
              data: "supplier_confirmed_reason",
              render: function (data, type, row) {
                if (row.supplier_confirmed_status == "CONFIRM") {
                  return (
                    "<p class='text-success'>" +
                    row.supplier_confirmed_status +
                    "<br>" +
                    row.supplier_confirmed_reason +
                    "</p>"
                  );
                }
                if (row.supplier_confirmed_status == "REJECT") {
                  return (
                    "<p class='text-danger'>" +
                    row.supplier_confirmed_status +
                    "<br>" +
                    row.supplier_confirmed_reason +
                    "</p>"
                  );
                }
                if (row.supplier_confirmed_status == null) {
                  return "<p class='text-info'>-</p>";
                }
              }
            },
            {
              title: "CONFIRMED BY",
              data: "confirmed_by",
              render: function (data, type, row) {
                if (row.supplier_confirmed_by == null) {
                  return "<p class='text-danger'>-</p>";
                }
                return (
                  "<p>" +
                  row.supplier_confirmed_by +
                  "<br>" +
                  row.supplier_confirmed_at +
                  "</p>"
                );
              }
            }
          ]
        });

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

      // if($('div.loading').hasClass('d-none') == false)
      // $('div.loading').addClass('d-none');
    })
    .finally(() => {
      // hide loading
      $("div.loading").addClass("d-none");
    });
  // END Of get data PO Detail
  // -------------------------
}
