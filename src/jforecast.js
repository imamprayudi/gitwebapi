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
  $("#submit_forecast").attr("disabled", false);

  axios
    .get("https://svr1.jkei.jvckenwood.com/api_gitweb/api/jordbal.php", {
      params: {
        method: "getSupplierGroup",
        usr: authSession.usr
      }
    })
    // .then((res) => {
    //   console.log(res.data, "DATA supplier")
    //   return
    // })
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

  axios
    .get("https://svr1.jkei.jvckenwood.com/api_gitweb/api/controller.php", {
      params: {
        method: "getTransdateArchive",
        usr: authSession.usr,
        usrsecure: authSession.usrsecure
      }
    })
    // .then((res) => {
    //   console.log(res.data, "DATA TRANSDATE")
    //   return
    // })
    .then((res) => res.data.data)
    .then((res) => {
      // console.log("transdate archived ================>", res);
      var toAppend = "";
      $.each(res, function (i, o) {
        // console.log("data transdate archive", o)
        toAppend +=
          '<option value="' +
          o.transdate +
          '">' +
          o.transdate +
          "</option>";
      });
      $("#tgl").find("option").remove().end().append(toAppend);
    });

  axios
    .get("https://svr1.jkei.jvckenwood.com/api_gitweb/api/controller.php", {
      params: {
        method: "getTransdateArchiveOneYear",
        usr: authSession.usr,
        usrsecure: authSession.usrsecure
      }
    })
    // .then((res) => {
    //   console.log(res.data, "DATA TRANSDATE")
    //   return
    // })
    .then((res) => res.data.data)
    .then((res) => {
      // console.log("transdate archived ================>", res);
      var toAppend = "";
      $.each(res, function (i, o) {
        // console.log("data transdate archive", o)
        toAppend +=
          '<option value="' +
          o.transdate +
          '">' +
          o.transdate +
          "</option>";
      });
      $("#tgl").find("option").remove().end().append(toAppend);
    });

  // END Of getSupplierGroup
  // ------------------------


  $("form[name=submit_fcy]").submit((e) => {
    e.preventDefault();
    $("#submit_fcy").attr("disabled", true);
    $("div.loading").toggleClass("d-none");
    $("div.message").html(null);

    if ($.fn.DataTable.isDataTable('#table-forecast')) {
      $('#table-forecast').DataTable().clear().destroy();
    }
    $('#table-forecast').empty();

    /* function initializeDataTable(header, data) {
      // Buat array kolom untuk DataTable
      const columns = Object.keys(header).map((key, index) => {
        return {
          title: header[key], // Judul kolom dari header
          data: key.toLowerCase() // Properti data sesuai dengan kunci
        };
      });

      // Inisialisasi DataTable
      let tableForecast = new DataTable("#table-forecast", {
        data: data,
        fixedHeader: false,
        retrieve: true,
        responsive: false,
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
      tableForecast.on('order.dt search.dt', function () {
        let i = 1;
        tableForecast
          .cells(null, 0, { search: 'applied', order: 'applied' })
          .every(function (cell) {
            this.data(i++);
          });
      }).draw();

      tableForecast.columns.adjust().draw();
    } */
    axios.get("https://svr1.jkei.jvckenwood.com/api_gitweb/api/controller.php", {
      params: {
        method: "getDataForecast2y",
        supplier: $("[name=supplier]").val(),
        tipe: $("[name=tipe]").val(),
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
          let data = res.data;
          // console.log(header);
          // return;
          const columns = Object.keys(header).map((key, index) => {
            return {
              title: header[key], // Judul kolom dari header
              data: key.toLowerCase() // Properti data sesuai dengan kunci
            };
          });

          // Inisialisasi DataTable
          let tableForecast = new DataTable("#table-forecast", {
            data: data,
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
          tableForecast.on('order.dt search.dt', function () {
            let i = 1;
            tableForecast
              .cells(null, 0, { search: 'applied', order: 'applied' })
              .every(function (cell) {
                this.data(i++);
              });
          }).draw();

          tableForecast.columns.adjust().draw();
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
        $("#submit_fcy").attr("disabled", false);
      });



  });
  $("form[name=submit_fcyArc]").submit((e) => {
    e.preventDefault();
    $("#submit_fcyArc").attr("disabled", true);
    $("div.loading").toggleClass("d-none");
    $("div.message").html(null);

    if ($.fn.DataTable.isDataTable('#table-forecastArc')) {
      $('#table-forecastArc').DataTable().clear().destroy();
    }
    $('#table-forecastArc').empty();

    /* function initializeDataTable(header, data) {
      // Buat array kolom untuk DataTable
      const columns = Object.keys(header).map((key, index) => {
        return {
          title: header[key], // Judul kolom dari header
          dataArc: key.toLowerCase() // Properti data sesuai dengan kunci
        };
      });

      // Inisialisasi DataTable
      let tableForecastArc = new DataTable("#table-forecastArc", {
        data: dataArc,
        fixedHeader: false,
        retrieve: true,
        responsive: false,
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
      tableForecastArc.on('order.dt search.dt', function () {
        let i = 1;
        tableForecastArc
          .cells(null, 0, { search: 'applied', order: 'applied' })
          .every(function (cell) {
            this.data(i++);
          });
      }).draw();

      tableForecastArc.columns.adjust().draw();
    } */
    axios.get("https://svr1.jkei.jvckenwood.com/api_gitweb/api/controller.php", {
      params: {
        method: "getDataForecast2yArc",
        supplier: $("[name=supplier]").val(),
        tgl: $("[name=tgl]").val(),
        tipe: $("[name=tipe]").val(),
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
          let dataArc = res.data;
          // console.log(header);
          // return;
          const columns = Object.keys(header).map((key, index) => {
            return {
              title: header[key], // Judul kolom dari header
              data: key.toLowerCase() // Properti data sesuai dengan kunci
            };
          });

          // Inisialisasi DataTable
          let tableForecastArc = new DataTable("#table-forecastArc", {
            data: dataArc,
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
          tableForecastArc.on('order.dt search.dt', function () {
            let i = 1;
            tableForecastArc
              .cells(null, 0, { search: 'applied', order: 'applied' })
              .every(function (cell) {
                this.data(i++);
              });
          }).draw();

          tableForecastArc.columns.adjust().draw();
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
        $("#submit_fcyArc").attr("disabled", false);
      });



  });
  $("form[name=submit_fcyArcOld]").submit((e) => {
    e.preventDefault();
    $("#submit_fcyArcOld").attr("disabled", true);
    $("div.loading").toggleClass("d-none");
    $("div.message").html(null);

    if ($.fn.DataTable.isDataTable('#table-forecastArcOld')) {
      $('#table-forecastArcOld').DataTable().clear().destroy();
    }
    $('#table-forecastArcOld').empty();


    axios.get("https://svr1.jkei.jvckenwood.com/api_gitweb/api/controller.php", {
      params: {
        method: "getDataForecasty",
        supplier: $("[name=supplier]").val(),
        tgl: $("[name=tgl]").val(),
        tipe: $("[name=tipe]").val(),
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
          let dataArc = res.data;
          // console.log(header);
          // return;
          const columns = Object.keys(header).map((key, index) => {
            return {
              title: header[key], // Judul kolom dari header
              data: key.toLowerCase() // Properti data sesuai dengan kunci
            };
          });

          // Inisialisasi DataTable
          let tableForecastArcOld = new DataTable("#table-forecastArcOld", {
            data: dataArc,
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
          tableForecastArcOld.on('order.dt search.dt', function () {
            let i = 1;
            tableForecastArcOld
              .cells(null, 0, { search: 'applied', order: 'applied' })
              .every(function (cell) {
                this.data(i++);
              });
          }).draw();

          tableForecastArcOld.columns.adjust().draw();
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
        $("#submit_fcyArcOld").attr("disabled", false);
      });



  });

});
