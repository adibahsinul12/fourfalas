<?= $this->extend('layout/customer_template'); ?>

<?= $this->section('content'); ?>

<header class="cart-header" style="position: fixed !important; top: 0; left: 50%; transform: translateX(-50%); width: 100%; max-width: 1200px; z-index: 9999 !important; background-color: #FAF6EB; padding: 15px 16px; border-bottom: 1px solid rgba(0,0,0,0.05); box-sizing: border-box;">
    <a href="<?= base_url('pelanggan'); ?>" class="btn-back" style="text-decoration: none; font-size: 20px; color: #333;">←</a>
    <h1 style="display: inline-block; margin: 0 0 0 10px; vertical-align: middle; font-family: 'Poppins', sans-serif; font-size: 20px;">Semua Menu</h1>
</header>

<div class="menu-scroll-area" style="padding: 75px 16px 120px 16px; display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; box-sizing: border-box; background-color: #FAF6EB; min-height: 100vh;">
    <?php if(!empty($menus)): ?>
        <?php foreach($menus as $menu): ?>
            <div style="background: #ffffff; border-radius: 16px; padding: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between; height: 220px; box-sizing: border-box;">
                <div>
                    <?php 
                    $namaFileGambar = isset($menu['image']) ? trim($menu['image']) : '';
                    if (!empty($namaFileGambar) && file_exists(FCPATH . 'uploads/menus/' . $namaFileGambar)) {
                        $imageSrc = base_url('uploads/menus/' . $namaFileGambar);
                    } else {
                        $imageSrc = base_url('uploads/menus/default_menus.jpg');
                    }
                    ?>
                    
                    <img src="<?= $imageSrc; ?>" style="width: 100%; height: 110px; object-fit: cover; border-radius: 12px; margin-bottom: 8px;" alt="">
                    <h3 style="font-size: 13px; margin: 0 0 4px 0; color: #333; font-family: 'Poppins', sans-serif; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= esc($menu['menu_name']); ?></h3>
                </div>
                <div>
                    <p style="font-size: 13px; font-weight: 700; color: #6B3A1E; margin: 0 0 6px 0; font-family: 'Poppins', sans-serif;">Rp <?= number_format($menu['price'], 0, ',', '.'); ?></p>
                    
                    <form action="<?= base_url('cart/add'); ?>" method="post" style="margin: 0;">
                        <input type="hidden" name="menu_id" value="<?= $menu['id']; ?>">
                        <button type="submit" style="width: 100%; background: #6B3A1E; color: white; border: none; padding: 6px 0; border-radius: 8px; font-size: 11px; font-weight: 600; cursor: pointer; font-family: 'Poppins', sans-serif;">+ Tambah</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div style="grid-column: span 2; text-align: center; padding: 60px 20px;">
            <p style="color: #888888; font-size: 14px; font-family: 'Poppins', sans-serif; margin: 0;">Menu tidak ditemukan.</p>
        </div>
    <?php endif; ?>
</div>

<div style="position: fixed !important; bottom: 0; left: 50%; transform: translateX(-50%); width: 100%; max-width: 1200px; background-color: #ffffff; box-shadow: 0 -8px 24px rgba(0,0,0,0.06); border-radius: 20px 20px 0 0; z-index: 9999 !important; box-sizing: border-box; padding: 12px 16px env(safe-area-inset-bottom, 12px) 16px;">
    <div class="bottom-nav" style="display: flex; justify-content: space-around; align-items: center; font-family: 'Poppins', sans-serif;">
        
        <div class="nav-item" onclick="location.href='<?= base_url('pelanggan'); ?>'" style="cursor: pointer; text-align: center; font-size: 12px; color: #666666; display: flex; flex-direction: column; align-items: center; gap: 4px; flex: 1;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            <span style="font-weight: 500;">Beranda</span>
        </div>
        
        <div class="nav-item" style="cursor: pointer; text-align: center; font-size: 12px; color: #666666; display: flex; flex-direction: column; align-items: center; gap: 4px; flex: 1;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="8" y1="6" x2="21" y2="6"></line>
                <line x1="8" y1="12" x2="21" y2="12"></line>
                <line x1="8" y1="18" x2="21" y2="18"></line>
                <circle cx="3" cy="6" r="1"></circle>
                <circle cx="3" cy="12" r="1"></circle>
                <circle cx="3" cy="18" r="1"></circle>
            </svg>
            <span style="font-weight: 500;">Pesanan</span>
        </div>
        
        <div class="nav-item" onclick="location.href='<?= base_url('cart'); ?>'" style="cursor: pointer; text-align: center; font-size: 12px; color: #28a745; display: flex; flex-direction: column; align-items: center; gap: 4px; flex: 1;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#28a745" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <span style="font-weight: 600;">Keranjang</span>
        </div>

    </div>
</div>

<?= $this->endSection(); ?>