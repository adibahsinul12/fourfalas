<?= $this->extend('layout/customer_template'); ?>

<?= $this->section('content'); ?>

<div class="app-container" style="min-height: 100vh; display: flex; flex-direction: column; box-sizing: border-box;"> 
    
    <header class="cart-header" style="position: sticky; top: 0; z-index: 1000; background-color: #FAF6EB; padding-top: 15px; padding-bottom: 10px;">
        <a href="<?= base_url('pelanggan'); ?>" class="btn-back" style="text-decoration: none;">←</a>
        <h1 style="display: inline-block; margin: 0 0 0 10px; vertical-align: middle;">Keranjang Belanja</h1>
    </header>

    <div class="cart-list" style="flex: 1; padding-bottom: 220px; box-sizing: border-box;">
        <?php if (empty($cart)): ?>
            <div class="empty-state" style="margin-top: 40px;">
                <svg viewBox="0 0 100 100">
                    <path d="M30,40 C30,25 70,25 70,40 L65,75 C65,80 35,80 35,75 Z" fill="none" stroke="#6B3A1E" stroke-width="4"/>
                    <path d="M70,45 C78,45 78,55 70,55" fill="none" stroke="#6B3A1E" stroke-width="4"/>
                    <path d="M25,82 L75,82" stroke="#6B3A1E" stroke-width="4" stroke-linecap="round"/>
                    <path d="M45,20 Q48,15 45,10 M55,22 Q58,17 55,12" fill="none" stroke="#888888" stroke-width="3" stroke-linecap="round"/>
                </svg>
                <h4>Keranjangmu Kosong</h4>
                <p>Yuk, pilih menu kopi atau cemilan favoritmu dulu!</p>
                <a href="<?= base_url('menu'); ?>" class="btn-promo" style="display:inline-block; margin-top:20px; text-decoration:none;">Lihat Menu</a>
            </div>
        <?php else: ?>
            <?php foreach ($cart as $id => $item): ?>
                <div class="cart-item">
                    
                    <?php 
                    // BENERIN DI SINI: Ambil nama kolom 'image' dari database
                    $namaFileGambar = isset($item['image']) ? trim($item['image']) : '';

                    // Amankan jalur ke folder uploads/menus/ jika filenya banya ada fisik
                    if (!empty($namaFileGambar) && file_exists(FCPATH . 'uploads/menus/' . $namaFileGambar)) {
                        $imageSrc = base_url('uploads/menus/' . $namaFileGambar);
                    } else {
                        // Jika data kosong atau file tidak ditemukan, panggil default_menus.jpg lokal
                        $imageSrc = base_url('uploads/menus/default_menus.jpg');
                    }
                    ?>
                    
                    <!-- Tag IMG baru yang diarahkan ke variabel imageSrc -->
                    <img src="<?= $imageSrc; ?>" class="item-img" alt="<?= $item['menu_name']; ?>">
                    
                    <div class="item-info">
                        <h3><?= $item['menu_name']; ?></h3>
                        <p class="item-price">Rp <?= number_format($item['price'], 0, ',', '.'); ?></p>
                    </div>
                    <div class="item-actions">
                        <a href="<?= base_url('cart/remove/'.$id); ?>" class="btn-delete" style="text-decoration: none;" onclick="return confirm('Hapus menu ini?')">Hapus</a>
                        <div class="qty-counter">
                            <a href="<?= base_url('cart/decrease/'.$id); ?>" class="qty-btn" style="text-decoration: none;">-</a>
                            <span class="qty-num"><?= $item['quantity']; ?></span>
                            
                            <form action="<?= base_url('cart/add'); ?>" method="post" style="display:inline; margin:0; padding:0;">
                                <input type="hidden" name="menu_id" value="<?= $id; ?>">
                                <input type="hidden" name="return_url" value="<?= base_url('cart') ?>">
                                <button type="submit" class="qty-btn" style="border:none; cursor:pointer;">+</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div style="position: fixed; bottom: 0; left: 50%; transform: translateX(-50%); width: 100%; max-width: 1200px; background-color: #ffffff; box-shadow: 0 -8px 24px rgba(0,0,0,0.06); border-radius: 20px 20px 0 0; z-index: 999; box-sizing: border-box; padding: 16px 16px env(safe-area-inset-bottom, 16px) 16px;">
        
        <?php if (!empty($cart)): ?>
            <div class="summary-line" style="margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 14px; font-weight: 600; color: #555555; font-family: 'Poppins', sans-serif;">Total Sementara</span>
                <span class="total-price" style="font-size: 18px; font-weight: 700; color: #6B3A1E; font-family: 'Poppins', sans-serif;">Rp <?= number_format($subtotal, 0, ',', '.'); ?></span>
            </div>
            
            <a href="<?= base_url('checkout'); ?>" class="btn-checkout" style="text-decoration: none; display: block; text-align: center; padding: 14px 0; font-size: 14px; font-weight: 600; border-radius: 12px; background-color: #4CAF50; color: white; margin-bottom: 16px; width: 100%; box-sizing: border-box; font-family: 'Poppins', sans-serif; transition: background-color 0.2s; border: none; cursor: pointer;">Lanjut Pilih Meja</a>
            
            <hr style="border: 0; border-top: 1px solid #F5F5F5; margin: 0 0 12px 0;">
        <?php endif; ?>

        <div class="bottom-nav" style="position: static !important; display: flex; justify-content: space-around; align-items: center; background: transparent !important; box-shadow: none !important; padding: 0 !important; margin: 0 !important; width: 100% !important; transform: none !important;">
            <div class="nav-item" onclick="location.href='<?= base_url('pelanggan'); ?>'" style="cursor: pointer; flex: 1; text-align: center;">
                <svg viewBox="0 0 24 24" style="margin: 0 auto 4px auto;"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                <span style="font-family: 'Poppins', sans-serif;">Beranda</span>
            </div>
            <div class="nav-item" onclick="location.href='<?= base_url('pesanan'); ?>'" style="cursor: pointer; flex: 1; text-align: center;">
                <svg viewBox="0 0 24 24" style="margin: 0 auto 4px auto;"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                <span style="font-family: 'Poppins', sans-serif;">Pesanan</span>
            </div>
            <div class="nav-item active" onclick="location.href='<?= base_url('cart'); ?>'" style="cursor: pointer; flex: 1; text-align: center;">
                <svg viewBox="0 0 24 24" style="margin: 0 auto 4px auto;"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                <span style="font-family: 'Poppins', sans-serif;">Keranjang</span>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>