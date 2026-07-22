<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fo'Orders - Café Fourfalas</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">

    <style>
        html, body { overflow-x: hidden; }

        /* PENTING: animasi TIDAK boleh ditaruh di <body> atau elemen yang membungkus
           bottom-nav, karena transform/filter/will-change:transform pada ancestor
           akan merusak position:fixed pada elemen di dalamnya (bottom-nav jadi
           "ikut" ke-transform dan terdorong jauh ke bawah dokumen).
           Makanya animasi ditaruh di #page-anim, dan bottom-nav dipindah keluar
           dari situ lewat JS supaya tetap fixed relatif ke viewport. */
        #page-anim {
            will-change: transform, opacity, filter;
        }

        /* ===== Masuk (entrance) ===== */
        #page-anim.enter-forward {
            animation: slideInRight 0.22s cubic-bezier(0.22, 1, 0.36, 1) both;
        }
        #page-anim.enter-backward {
            animation: slideInLeft 0.22s cubic-bezier(0.22, 1, 0.36, 1) both;
        }
        #page-anim.enter-fade {
            animation: fadeIn 0.2s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        /* ===== Keluar (leaving), dipicu JS sebelum pindah halaman ===== */
        #page-anim.leaving-forward {
            animation: slideOutLeft 0.15s cubic-bezier(0.55, 0, 1, 0.45) forwards;
        }
        #page-anim.leaving-backward {
            animation: slideOutRight 0.15s cubic-bezier(0.55, 0, 1, 0.45) forwards;
        }
        #page-anim.leaving-fade {
            animation: fadeOut 0.13s cubic-bezier(0.55, 0, 1, 0.45) forwards;
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(32px) scale(0.99); filter: blur(4px); }
            60%  { filter: blur(0.5px); }
            to   { opacity: 1; transform: translateX(0) scale(1); filter: blur(0); }
        }
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-32px) scale(0.99); filter: blur(4px); }
            60%  { filter: blur(0.5px); }
            to   { opacity: 1; transform: translateX(0) scale(1); filter: blur(0); }
        }
        @keyframes slideOutLeft {
            from { opacity: 1; transform: translateX(0) scale(1); filter: blur(0); }
            to   { opacity: 0; transform: translateX(-32px) scale(0.99); filter: blur(4px); }
        }
        @keyframes slideOutRight {
            from { opacity: 1; transform: translateX(0) scale(1); filter: blur(0); }
            to   { opacity: 0; transform: translateX(32px) scale(0.99); filter: blur(4px); }
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(6px); filter: blur(3px); }
            to   { opacity: 1; transform: translateY(0); filter: blur(0); }
        }
        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); filter: blur(0); }
            to   { opacity: 0; transform: translateY(-6px); filter: blur(3px); }
        }
    </style>
</head>
<?php
    // pageKey = identitas halaman ini di urutan tab (dikirim dari view lewat section 'pageKey')
    // pageAnimation = 'fade' khusus untuk halaman yang selalu ingin fade (mis. riwayat)
    $pageKey       = trim($this->renderSection('pageKey'));
    $pageAnimation = trim($this->renderSection('pageAnimation'));
?>
<body data-page="<?= esc($pageKey); ?>" data-anim="<?= esc($pageAnimation); ?>" style="background-color: #FAF6EB; margin: 0; padding: 0;">

    <div id="page-anim">
        <div class="app-container">

            <?= $this->renderSection('content'); ?>

        </div>
    </div>

    <script>
        // Urutan tab di bottom-nav. Sesuaikan urutan ini kalau urutan tab kamu beda.
        // Index lebih besar = "lebih maju" -> slide dari kanan.
        // Index lebih kecil = "mundur"     -> slide dari kiri.
        window.PAGE_ORDER = ['beranda', 'pesanan', 'keranjang', 'checkout', 'menu', 'semua_menu', 'riwayat', 'rating'];

        (function () {
            // Pindahkan SEMUA elemen position:fixed (bottom-nav, summary bar checkout,
            // dll -- apapun strukturnya) keluar dari #page-anim, supaya fixed-nya
            // tidak rusak akibat transform/filter animasi. Dicek pakai computed style,
            // bukan cuma class tertentu, karena tiap halaman strukturnya bisa beda
            // (mis. di keranjang, bottom-nav dibungkus div fixed lain).
            var pageAnim = document.getElementById('page-anim');
            if (pageAnim) {
                var all = pageAnim.querySelectorAll('*');
                var toMove = [];
                for (var i = 0; i < all.length; i++) {
                    if (window.getComputedStyle(all[i]).position === 'fixed') {
                        toMove.push(all[i]);
                    }
                }
                for (var j = 0; j < toMove.length; j++) {
                    document.body.appendChild(toMove[j]);
                }
            }

            var myAnim = document.body.getAttribute('data-anim');
            var direction = sessionStorage.getItem('navDirection');
            sessionStorage.removeItem('navDirection');

            if (pageAnim) {
                if (myAnim === 'fade') {
                    pageAnim.classList.add('enter-fade');
                } else if (direction === 'backward') {
                    pageAnim.classList.add('enter-backward');
                } else {
                    pageAnim.classList.add('enter-forward');
                }
            }
        })();

        // Panggil dari onclick nav-item.
        // targetKey WAJIB diisi salah satu nilai di PAGE_ORDER di atas, contoh:
        // onclick="navigateSmooth('<?= base_url('pesanan'); ?>', 'pesanan')"
        function navigateSmooth(url, targetKey) {
            var pageAnim = document.getElementById('page-anim');
            var myKey = document.body.getAttribute('data-page');
            var myAnim = document.body.getAttribute('data-anim');

            var curIndex = window.PAGE_ORDER.indexOf(myKey);
            var targetIndex = window.PAGE_ORDER.indexOf(targetKey);
            var direction = (targetIndex !== -1 && curIndex !== -1 && targetIndex < curIndex) ? 'backward' : 'forward';

            sessionStorage.setItem('navDirection', direction);

            if (pageAnim) {
                if (myAnim === 'fade') {
                    pageAnim.classList.add('leaving-fade');
                } else if (direction === 'backward') {
                    pageAnim.classList.add('leaving-backward');
                } else {
                    pageAnim.classList.add('leaving-forward');
                }
            }

            setTimeout(function () {
                location.href = url;
            }, 140);
        }
    </script>

    <?= $this->renderSection('scripts'); ?>

</body>
</html>