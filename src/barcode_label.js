import $ from "jquery";
import axios from "axios";
const QRCode = require('qrcode');
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


function generateQRCode() {
    const qrText = 'Teks atau URL yang ingin dienkode';
    const qrContainer = document.getElementById('qrcode');
    qrContainer.innerHTML = ''; // Kosongkan kontainer sebelum menambahkan kode QR baru

    QRCode.toCanvas(qrText, { errorCorrectionLevel: 'H' }, function (err, canvas) {
        if (err) {
            console.error(err);
            return;
        }
        qrContainer.appendChild(canvas);
    });
}
generateQRCode('Contoh teks untuk kode QR');

axios
    .get("https://svr1.jkei.jvckenwood.com/api_gitweb/api/controller.php", {
        params: {
            method: "getPartnumberBySupplier",
            supplier: $("#supplier").val(),
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