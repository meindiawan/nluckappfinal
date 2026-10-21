/* NLUCK — render QR di browser (tanpa API eksternal) + unduh PNG / ZIP.
   Membutuhkan qrcode-generator.js (dan jszip.min.js untuk ZIP). */
(function () {
  'use strict';

  function makeQr(text) {
    var qr = qrcode(0, 'Q'); // koreksi error Q: tahan lecet/kotor di kemasan
    qr.addData(text);
    qr.make();
    return qr;
  }

  // Gambar QR ke canvas dengan quiet zone 4 modul; ukuran dibulatkan ke kelipatan modul agar tajam.
  function drawQr(canvas, text, targetPx) {
    var qr = makeQr(text);
    var n = qr.getModuleCount(), quiet = 4, total = n + quiet * 2;
    var scale = Math.max(1, Math.ceil(targetPx / total));
    canvas.width = canvas.height = total * scale;
    var ctx = canvas.getContext('2d');
    ctx.fillStyle = '#fff';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = '#000';
    for (var r = 0; r < n; r++) {
      for (var c = 0; c < n; c++) {
        if (qr.isDark(r, c)) ctx.fillRect((c + quiet) * scale, (r + quiet) * scale, scale, scale);
      }
    }
    return canvas;
  }

  function toBlob(canvas) {
    return new Promise(function (resolve) { canvas.toBlob(resolve, 'image/png'); });
  }

  function saveBlob(blob, filename) {
    var a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    setTimeout(function () { URL.revokeObjectURL(a.href); a.remove(); }, 1500);
  }

  async function pngFor(url, px) {
    return toBlob(drawQr(document.createElement('canvas'), url, px || 1200));
  }

  function init() {
    // Thumbnail / kartu cetak
    document.querySelectorAll('canvas[data-qr]').forEach(function (cv) {
      try { drawQr(cv, cv.getAttribute('data-qr'), parseInt(cv.getAttribute('data-size') || '240', 10)); }
      catch (e) { cv.replaceWith(document.createTextNode('QR gagal dibuat')); }
    });

    // Unduh PNG satu kode
    document.querySelectorAll('[data-download-png]').forEach(function (btn) {
      btn.addEventListener('click', async function () {
        var blob = await pngFor(btn.getAttribute('data-url'));
        saveBlob(blob, (btn.getAttribute('data-prefix') || 'qr') + '-' + btn.getAttribute('data-code') + '.png');
      });
    });

    // Unduh ZIP semua QR pada filter aktif
    var zipBtn = document.getElementById('qr-zip');
    if (zipBtn) {
      zipBtn.addEventListener('click', async function () {
        var data = window.NLUCK_QR || { items: [] };
        if (!data.items.length) { alert('Tidak ada QR pada filter ini.'); return; }
        if (typeof JSZip === 'undefined') { alert('Library ZIP tidak termuat.'); return; }
        var label = zipBtn.textContent;
        zipBtn.disabled = true;
        try {
          var zip = new JSZip();
          for (var i = 0; i < data.items.length; i++) {
            zipBtn.textContent = 'Membuat ' + (i + 1) + '/' + data.items.length + '…';
            zip.file(data.prefix + '-' + data.items[i].code + '.png', await pngFor(data.items[i].url), { binary: true });
            if (i % 10 === 9) await new Promise(function (r) { setTimeout(r, 0); }); // beri napas ke UI
          }
          zipBtn.textContent = 'Mengemas ZIP…';
          saveBlob(await zip.generateAsync({ type: 'blob' }), data.prefix + '-qr.zip');
        } finally {
          zipBtn.disabled = false;
          zipBtn.textContent = label;
        }
      });
    }

    // Peringatan bila QR berisi alamat lokal
    var warn = document.getElementById('qr-local-warning');
    if (warn && window.NLUCK_QR && /^https?:\/\/(localhost|127\.|0\.0\.0\.0|192\.168\.|10\.|172\.(1[6-9]|2\d|3[01])\.)/i.test(window.NLUCK_QR.sampleUrl || '')) {
      warn.hidden = false;
    }
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init); else init();
})();
