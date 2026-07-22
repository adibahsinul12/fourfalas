<?= $this->extend('layout/customer_template'); ?>

<?= $this->section('content'); ?>

<style>
    .rating-card {
        background: #FFFFFF;
        border-radius: 16px;
        padding: 24px 20px;
        box-shadow: 0 4px 16px rgba(107, 58, 30, 0.08);
        border: 1px solid #F0EAE2;
    }

    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
        gap: 6px;
        margin: 10px 0 4px;
    }
    .star-rating input { display: none; }
    .star-rating label {
        font-size: 40px;
        line-height: 1;
        color: #E0DCD5;
        cursor: pointer;
        transition: color 0.15s ease;
        user-select: none;
    }
    .star-rating input:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #F4A261;
    }

    .rating-textarea {
        width: 100%;
        border: 1px solid #E5E5E5;
        border-radius: 10px;
        padding: 12px 14px;
        font-family: 'Poppins', sans-serif;
        font-size: 13px;
        resize: none;
        min-height: 90px;
        outline: none;
        transition: border-color 0.2s;
        box-sizing: border-box;
    }
    .rating-textarea:focus { border-color: #6B3A1E; }

    .rating-input-nama {
        width: 100%;
        border: 1px solid #E5E5E5;
        border-radius: 10px;
        padding: 12px 14px;
        font-family: 'Poppins', sans-serif;
        font-size: 13px;
        outline: none;
        transition: border-color 0.2s;
        box-sizing: border-box;
    }
    .rating-input-nama:focus { border-color: #6B3A1E; }

    .btn-kirim-rating {
        width: 100%;
        background-color: #6B3A1E;
        color: #FFFFFF;
        border: none;
        border-radius: 10px;
        padding: 13px;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 14px;
        margin-top: 16px;
        transition: background-color 0.2s;
    }
    .btn-kirim-rating:hover { background-color: #55290F; }
</style>

<div style="padding: 24px; padding-bottom: 100px;">

    <div style="margin-bottom: 22px;">
        <p style="margin: 0; font-size: 14px; color: #A67C52; font-weight: 500;">Bagikan pengalamanmu di</p>
        <h1 style="margin: 0; font-size: 24px; font-weight: 700; color: #6B3A1E; letter-spacing: -0.5px;">FO'Orders</h1>
    </div>

    <div class="rating-card">
        <div style="text-align: center; margin-bottom: 6px;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">Beri Rating & Ulasan</h3>
            <p style="margin: 4px 0 0; font-size: 12px; color: #888;">Pendapatmu membantu kami jadi lebih baik</p>
        </div>

        <form action="<?= base_url('rating/store'); ?>" method="POST">

            <div class="star-rating">
                <input type="radio" id="star5" name="rating" value="5">
                <label for="star5">★</label>
                <input type="radio" id="star4" name="rating" value="4">
                <label for="star4">★</label>
                <input type="radio" id="star3" name="rating" value="3">
                <label for="star3">★</label>
                <input type="radio" id="star2" name="rating" value="2">
                <label for="star2">★</label>
                <input type="radio" id="star1" name="rating" value="1">
                <label for="star1">★</label>
            </div>

            <div style="margin-top: 18px;">
                <label style="font-size: 12px; font-weight: 600; color: #333; display: block; margin-bottom: 6px;">
                    Nama Kamu
                </label>
                <input type="text" name="nama_pelanggan" class="rating-input-nama"
                       placeholder="Masukkan nama kamu" required>
            </div>

            <div style="margin-top: 14px;">
                <label style="font-size: 12px; font-weight: 600; color: #333; display: block; margin-bottom: 6px;">
                    Ulasan (opsional)
                </label>
                <textarea name="komentar" class="rating-textarea"
                          placeholder="Ceritakan pengalamanmu di FO'Orders..."></textarea>
            </div>

            <button type="submit" class="btn-kirim-rating">Kirim Rating</button>
        </form>
    </div>

</div>

<div class="bottom-nav">
    <div class="nav-item" onclick="location.href='<?= base_url('pelanggan'); ?>'">
        <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
        <span>Beranda</span>
    </div>
    <div class="nav-item" onclick="location.href='<?= base_url('pesanan'); ?>'">
        <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
        <span>Pesanan</span>
    </div>
    <div class="nav-item" onclick="location.href='<?= base_url('cart'); ?>'">
        <svg viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
        <span>Keranjang</span>
    </div>
    <div class="nav-item active" onclick="location.href='<?= base_url('rating'); ?>'">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
        </svg>
        <span>Rating</span>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    <?php if (session()->getFlashdata('pesan_sukses')) : ?>
        Swal.fire({
            target: document.body,
            title: 'Berhasil!',
            text: '<?= session()->getFlashdata("pesan_sukses"); ?>',
            icon: 'success',
            confirmButtonColor: '#4CAF50',
            background: '#FAF6EB'
        });
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        Swal.fire({
            target: document.body,
            title: 'Oops!',
            text: '<?= session()->getFlashdata("error"); ?>',
            icon: 'warning',
            confirmButtonColor: '#6B3A1E',
            background: '#FAF6EB'
        });
    <?php endif; ?>
});
</script>
<?= $this->endSection(); ?>