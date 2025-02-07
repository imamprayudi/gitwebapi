const QRCode = require('qrcode');

// const generateQRCode = async (text) => {
//     try {
//         const dataUrl = await QRCode.toDataURL(text);
//         console.log(dataUrl);
//         // Anda dapat menggunakan dataUrl ini dalam elemen <img> di frontend
//     } catch (err) {
//         console.error(err);
//     }
// };

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