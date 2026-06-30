<?= $this->extend('layout/customer_template'); ?>

<?= $this->section('content'); ?>

<div style="padding: 24px;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
            <p style="margin: 0; font-size: 14px; color: #A67C52; font-weight: 500;">Halo, Selamat datang di</p>
            <h1 style="margin: 0; font-size: 26px; font-weight: 700; color: #6B3A1E; letter-spacing: -0.5px;">FO'Orders</h1>
        </div>
        
        <div style="width: 48px; height: 48px; background-color: #FFFFFF; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(107, 58, 30, 0.18); border: 1px solid #E5E5E5; overflow: hidden;">
            <img src="<?= base_url('assets/img/FourFalasLogo_HD.png'); ?>" alt="Logo" style="height: 100%; width: 100%; object-fit: cover;">
        </div>
    </div>

    <div class="promo-banner">
        <div class="banner-content">
            <p style="margin: 0; font-size: 12px; opacity: 0.9;">Pesan dengan mudah</p>
            <h3>Nikmati Hidangan Terbaik<br>dari Fourfalas Café</h3>
            <button class="btn-promo">Pesan Sekarang</button>
        </div>
        <div class="banner-icon">
            <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="45" fill="#A67C52" fill-opacity="0.3"/>
                <circle cx="50" cy="50" r="30" fill="#FFFFFF" fill-opacity="0.2"/>
                
                <path d="M65 50 C85 50, 85 75, 65 75" stroke="#FFFFFF" stroke-width="6" stroke-linecap="round"/>
                
                <rect x="25" y="40" width="50" height="45" rx="10" fill="#FFFFFF" stroke="#FFFFFF" stroke-width="2"/>
                
                <line x1="32" y1="50" x2="68" y2="50" stroke="#6B3A1E" stroke-width="3" stroke-linecap="round"/>
                
                <path d="M40 32 C40 20, 45 20, 45 10" stroke="#FFFFFF" stroke-width="3" stroke-linecap="round" opacity="0.9"/>
                <path d="M50 35 C50 23, 55 23, 55 13" stroke="#FFFFFF" stroke-width="3" stroke-linecap="round" opacity="0.9"/>
                <path d="M60 32 C60 20, 65 20, 65 10" stroke="#FFFFFF" stroke-width="3" stroke-linecap="round" opacity="0.9"/>
            </svg>
        </div>
    </div>

    <h2 style="font-size: 16px; font-weight: 600; color: #333333; margin-bottom: 14px;">Kategori Menu</h2>
    <div class="category-container">
        <span class="category-tab active">
            <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
            Semua
        </span>
        
        <?php foreach ($categories as $cat): 
            $catName = strtolower($cat['category_name']);
            $icon = '<svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect></svg>'; 
            
            if (strpos($catName, 'kopi') !== false && strpos($catName, 'non') === false) {
                $icon = '<svg viewBox="0 0 24 24"><path d="M17 8h1a4 4 0 1 1 0 8h-1"></path><path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"></path><line x1="6" y1="2" x2="6" y2="4"></line><line x1="10" y1="2" x2="10" y2="4"></line><line x1="14" y1="2" x2="14" y2="4"></line></svg>';
            } elseif (strpos($catName, 'minuman') !== false || strpos($catName, 'non') !== false) {
                $icon = '<svg viewBox="0 0 24 24"><path d="M8 22h8"></path><path d="M12 18v4"></path><path d="M6 5l2 13h8l2-13"></path><line x1="10" y1="2" x2="16" y2="8"></line></svg>';
            } elseif (strpos($catName, 'snack') !== false || strpos($catName, 'dessert') !== false) {
                $icon = '<svg viewBox="0 0 24 24"><path d="M12 2l3 3h4v4l3 3-3 3v4h-4l-3 3-3-3H6v-4L3 12l3-3V6h4z"></path></svg>';
            }
        ?>
            <span class="category-tab" onclick="location.href='<?= base_url('menu') . '?category=' . $cat['id']; ?>'">
                <?= $icon; ?>
                <?= esc($cat['category_name']); ?>
            </span>
        <?php endforeach; ?>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <h2 style="font-size: 16px; font-weight: 600; color: #333333; margin: 0;">Rekomendasi Menu</h2>
        <span style="font-size: 12px; color: #4CAF50; font-weight: 600; cursor: pointer;" onclick="location.href='<?= base_url('menu'); ?>'">Lihat semua</span>
    </div>
    
    <div class="menu-grid">
        <?php if (!empty($recommended_menus)): ?>
            <?php foreach ($recommended_menus as $menu): 
                $filename = $menu['image_path'] ?? 'default.jpg';
                $path = 'uploads/menus/' . $filename;
                
                if (file_exists(FCPATH . $path) && !empty($menu['image_path'])) {
                    $imgUrl = base_url($path);
                } else {
                    $imgUrl = base_url('uploads/menus/default_menus.jpg');
                }
            ?>
                <div class="menu-card">
                    <img class="menu-img" src="<?= $imgUrl; ?>" alt="<?= esc($menu['menu_name']); ?>">
                    <div class="menu-info">
                        <h3><?= esc($menu['menu_name']); ?></h3>
                        <div class="menu-footer">
                            <span class="price">Rp <?= number_format($menu['price'], 0, ',', '.'); ?></span>
                            
                            <form action="<?= base_url('cart/add'); ?>" method="post" style="margin: 0; padding: 0; display: inline;">
                                <input type="hidden" name="menu_id" value="<?= $menu['id']; ?>">
                                <button type="submit" class="btn-add">+</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <svg viewBox="0 0 150 150" xmlns="http://www.w3.org/2000/svg">
                    <path d="M30 40 L35 25 L40 40 L55 45 L40 50 L35 65 L30 50 L15 45 Z" fill="#F4A261" opacity="0.6"/>
                    <path d="M110 30 L113 20 L116 30 L126 33 L116 36 L113 46 L110 36 L100 33 Z" fill="#F4A261" opacity="0.4"/>
                    <path d="M60 45 Q50 35, 60 25 T60 5" stroke="#A67C52" stroke-width="4" stroke-linecap="round" fill="none" opacity="0.5"/>
                    <path d="M85 50 Q95 40, 85 30 T85 10" stroke="#A67C52" stroke-width="4" stroke-linecap="round" fill="none" opacity="0.5"/>
                    <rect x="45" y="60" width="60" height="55" rx="12" fill="#FFFFFF" stroke="#E5E5E5" stroke-width="3"/>
                    <path d="M105 75 C120 75, 120 95, 105 100" fill="none" stroke="#FFFFFF" stroke-width="6"/>
                    <path d="M105 75 C120 75, 120 95, 105 100" fill="none" stroke="#E5E5E5" stroke-width="3"/>
                    <circle cx="65" cy="85" r="4" fill="#6B3A1E"/>
                    <circle cx="85" cy="85" r="4" fill="#6B3A1E"/>
                    <path d="M70 95 Q75 102, 80 95" fill="none" stroke="#6B3A1E" stroke-width="3" stroke-linecap="round"/>
                    <circle cx="58" cy="90" r="3" fill="#FF8FA3" opacity="0.6"/>
                    <circle cx="92" cy="90" r="3" fill="#FF8FA3" opacity="0.6"/>
                </svg>
                <h4>Belum Ada Rekomendasi</h4>
                <p>Menu spesial dari Fourfalas sedang<br>disiapkan untukmu!</p>
            </div>
        <?php endif; ?>
    </div>

</div>

<div class="bottom-nav">
    <div class="nav-item active" onclick="location.href='<?= base_url('pelanggan'); ?>'">
        <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
        <span>Beranda</span>
    </div>
    <div class="nav-item">
        <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
        <span>Pesanan</span>
    </div>
    <div class="nav-item" onclick="location.href='<?= base_url('cart'); ?>'">
        <svg viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
        <span>Keranjang</span>
    </div>
</div>

<?= $this->endSection(); ?>