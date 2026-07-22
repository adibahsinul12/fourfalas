<?= $this->extend('layout/customer_template'); ?>

<?= $this->section('content'); ?>

<div style="padding: 24px; padding-bottom: 100px;">

    <h1 style="margin: 0 0 4px 0; font-size: 22px; font-weight: 700; color: #6B3A1E; font-family: 'Poppins', sans-serif;">Riwayat Pesanan</h1>
    <a href="<?= base_url('pesanan'); ?>" style="display:inline-block; margin-bottom:20px; font-size:13px; color:#6B3A1E; text-decoration:underline; font-family: 'Poppins', sans-serif;">&larr; Kembali ke Pesanan Aktif</a>

    <?php if (session()->getFlashdata('success')): ?>
        <div style="background:#E8F5E9; color:#2E7D32; padding:12px 16px; border-radius:10px; margin-bottom:16px; font-size:13px; font-family:'Poppins',sans-serif;">
            <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div style="background:#FFEBEE; color:#C62828; padding:12px 16px; border-radius:10px; margin-bottom:16px; font-size:13px; font-family:'Poppins',sans-serif;">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <?php if (empty($orders)): ?>
        <div class="empty-state" style="margin-top: 40px; text-align: center;">
            <svg viewBox="0 0 100 100" style="width: 100px; height: 100px; margin: 0 auto;">
                <rect x="20" y="35" width="60" height="45" rx="8" fill="none" stroke="#A67C52" stroke-width="4"/>
                <path d="M30,35 L30,25 Q30,15 40,15 L60,15 Q70,15 70,25 L70,35" fill="none" stroke="#A67C52" stroke-width="4"/>
                <line x1="35" y1="50" x2="65" y2="50" stroke="#A67C52" stroke-width="3" stroke-linecap="round"/>
                <line x1="35" y1="60" x2="55" y2="60" stroke="#A67C52" stroke-width="3" stroke-linecap="round"/>
            </svg>
            <h4 style="margin-top: 16px; color: #333333; font-family: 'Poppins', sans-serif;">Belum Ada Riwayat</h4>
            <p style="color: #888888; font-family: 'Poppins', sans-serif;">Pesanan yang sudah selesai akan muncul di sini.</p>
            <a href="<?= base_url('menu'); ?>" class="btn-promo" style="display:inline-block; margin-top:16px; text-decoration:none;">Lihat Menu</a>
        </div>
    <?php else: ?>

        <?php foreach ($orders as $order): 
            // Tentukan warna badge sesuai status
            switch ($order['order_status']) {
                case 'Menunggu':
                    $badgeColor = '#FFA726'; $badgeBg = '#FFF3E0'; break;
                case 'Diproses':
                    $badgeColor = '#42A5F5'; $badgeBg = '#E3F2FD'; break;
                case 'Siap Diantar':
                    $badgeColor = '#AB47BC'; $badgeBg = '#F3E5F5'; break;
                case 'Selesai':
                    $badgeColor = '#4CAF50'; $badgeBg = '#E8F5E9'; break;
                case 'Dibatalkan':
                    $badgeColor = '#E53935'; $badgeBg = '#FFEBEE'; break;
                default:
                    $badgeColor = '#888888'; $badgeBg = '#F5F5F5';
            }
        ?>
            <div style="background: #ffffff; border-radius: 16px; padding: 18px 20px; margin-bottom: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.04); font-family: 'Poppins', sans-serif;">

                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                    <div>
                        <p style="margin: 0; font-size: 12px; color: #888888;">No. Pesanan</p>
                        <h3 style="margin: 2px 0 0 0; font-size: 15px; color: #333333;">#<?= esc($order['order_number']); ?></h3>
                    </div>
                    <span style="background: <?= $badgeBg; ?>; color: <?= $badgeColor; ?>; font-size: 12px; font-weight: 600; padding: 6px 12px; border-radius: 20px; white-space: nowrap;">
                        <?= esc($order['order_status']); ?>
                    </span>
                </div>

                <div style="font-size: 13px; color: #666666; margin-bottom: 10px;">
                    <span>Meja <?= esc($order['table_number']); ?></span>
                    <span style="margin: 0 6px;">•</span>
                    <span><?= date('d M Y, H:i', strtotime($order['created_at'])); ?></span>
                </div>

                <hr style="border: 0; border-top: 1px dashed #EEEEEE; margin: 12px 0;">

                <?php if (!empty($order['items'])): ?>
                    <?php foreach ($order['items'] as $item): ?>
                        <div style="display: flex; justify-content: space-between; font-size: 13px; color: #555555; margin-bottom: 6px;">
                            <span><span style="font-weight: 600; color: #4CAF50;"><?= $item['quantity']; ?>x</span> <?= esc($item['menu_name'] ?? 'Menu'); ?></span>
                            <span>Rp <?= number_format($item['subtotal'], 0, ',', '.'); ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <hr style="border: 0; border-top: 1px dashed #EEEEEE; margin: 12px 0;">

                <div style="display: flex; justify-content: space-between; font-weight: 700; font-size: 15px; color: #6B3A1E;">
                    <span>Total</span>
                    <span>Rp <?= number_format($order['total_payment'], 0, ',', '.'); ?></span>
                </div>

                <?php if (!empty($order['notes'])): ?>
                    <p style="margin: 10px 0 0 0; font-size: 12px; color: #999999; font-style: italic;">Catatan: <?= esc($order['notes']); ?></p>
                <?php endif; ?>

                <?php if ($order['order_status'] === 'Selesai'): ?>

                    <?php if (!empty($order['rating'])): ?>
                        <div style="margin-top: 14px; padding-top: 14px; border-top: 1px dashed #EEEEEE;">
                            <p style="margin: 0 0 4px 0; font-size: 12px; color: #888888;">Penilaian Anda</p>
                            <div style="font-size: 16px; color: #FFB300; letter-spacing: 2px;">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <?= $i <= $order['rating']['rating'] ? '★' : '☆'; ?>
                                <?php endfor; ?>
                            </div>
                            <?php if (!empty($order['rating']['komentar'])): ?>
                                <p style="margin: 6px 0 0 0; font-size: 13px; color: #555555; font-style: italic;">
                                    "<?= esc($order['rating']['komentar']); ?>"
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div style="margin-top: 14px; padding-top: 14px; border-top: 1px dashed #EEEEEE;">
                            <button type="button" onclick="bukaModalRating(<?= $order['id']; ?>)"
                                style="width: 100%; background: #4CAF50; color: #fff; border: none; padding: 10px; border-radius: 10px; font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 600; cursor: pointer;">
                                ⭐ Beri Rating
                            </button>
                        </div>
                    <?php endif; ?>

                <?php endif; ?>

            </div>
        <?php endforeach; ?>

    <?php endif; ?>

</div>

<!-- Modal Rating -->
<div id="modalRating" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:16px; padding:24px; width:85%; max-width:340px; font-family:'Poppins',sans-serif;">
        <h3 style="margin:0 0 16px 0; color:#6B3A1E; font-size:17px;">Beri Rating</h3>
        <form id="formRating" method="post">
            <div id="starPicker" style="font-size:32px; color:#DDDDDD; text-align:center; margin-bottom:16px; letter-spacing:6px;">
                <span data-val="1" style="cursor:pointer;">★</span><span data-val="2" style="cursor:pointer;">★</span><span data-val="3" style="cursor:pointer;">★</span><span data-val="4" style="cursor:pointer;">★</span><span data-val="5" style="cursor:pointer;">★</span>
            </div>
            <input type="hidden" name="rating" id="ratingValue" value="0">
            <textarea name="komentar" placeholder="Tulis komentar (opsional)"
                style="width:100%; border:1px solid #EEEEEE; border-radius:10px; padding:10px; font-family:'Poppins',sans-serif; font-size:13px; resize:none; height:70px; box-sizing:border-box;"></textarea>
            <div style="display:flex; gap:10px; margin-top:16px;">
                <button type="button" onclick="tutupModalRating()"
                    style="flex:1; background:#F5F5F5; color:#666; border:none; padding:10px; border-radius:10px; font-weight:600; cursor:pointer;">Batal</button>
                <button type="submit"
                    style="flex:1; background:#4CAF50; color:#fff; border:none; padding:10px; border-radius:10px; font-weight:600; cursor:pointer;">Kirim</button>
            </div>
        </form>
    </div>
</div>

<div class="bottom-nav">
    <div class="nav-item" onclick="location.href='<?= base_url('pelanggan'); ?>'">
        <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
        <span>Beranda</span>
    </div>
    <div class="nav-item active" onclick="location.href='<?= base_url('pesanan'); ?>'">
        <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
        <span>Pesanan</span>
    </div>
    <div class="nav-item" onclick="location.href='<?= base_url('cart'); ?>'">
        <svg viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
        <span>Keranjang</span>
    </div>
    <div class="nav-item" onclick="location.href='<?= base_url('rating'); ?>'">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
        </svg>
        <span>Rating</span>
    </div>
</div>

<script>
function bukaModalRating(orderId) {
    document.getElementById('formRating').action = '<?= base_url('pesanan/rating/simpan') ?>/' + orderId;
    document.getElementById('ratingValue').value = 0;
    document.querySelectorAll('#starPicker span').forEach(s => s.style.color = '#DDDDDD');
    document.getElementById('modalRating').style.display = 'flex';
}
function tutupModalRating() {
    document.getElementById('modalRating').style.display = 'none';
}
document.querySelectorAll('#starPicker span').forEach(span => {
    span.addEventListener('click', function () {
        const val = parseInt(this.dataset.val);
        document.getElementById('ratingValue').value = val;
        document.querySelectorAll('#starPicker span').forEach(s => {
            s.style.color = parseInt(s.dataset.val) <= val ? '#FFB300' : '#DDDDDD';
        });
    });
});
</script>

<?= $this->endSection(); ?>