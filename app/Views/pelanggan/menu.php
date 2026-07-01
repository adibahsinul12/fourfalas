<?= $this->extend('layout/customer_template'); ?>

<?= $this->section('content'); ?>

<div style="padding: 24px;">

    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
        <span onclick="location.href='<?= base_url('pelanggan'); ?>'" style="cursor: pointer; font-size: 22px; color: #6B3A1E;">&#8592;</span>
        <h1 style="margin: 0; font-size: 22px; font-weight: 700; color: #6B3A1E;">Semua Menu</h1>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div style="background:#e8f5e9; color:#2e7d32; padding:12px 16px; border-radius:8px; margin-bottom:16px; font-size:14px; font-family:'Poppins', sans-serif;">
            <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>

    <h2 style="font-size: 16px; font-weight: 600; color: #333333; margin-bottom: 14px;">Kategori Menu</h2>
    <div class="category-container">
        <span class="category-tab <?= empty($_GET['category']) ? 'active' : '' ?>"
              onclick="location.href='<?= base_url('menu'); ?>'">
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

            $isActive = (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'active' : '';
        ?>
            <span class="category-tab <?= $isActive ?>"
                  onclick="location.href='<?= base_url('menu') . '?category=' . $cat['id']; ?>'">
                <?= $icon; ?>
                <?= esc($cat['category_name']); ?>
            </span>
        <?php endforeach; ?>
    </div>

    <div class="menu-grid" style="margin-top: 20px;">
        <?php if (!empty($all_menus)): ?>
            <?php 
            // Ambil data keranjang saat ini untuk memetakan tombol awal
            $sessionCart = session()->get('cart') ?? []; 
            ?>
            <?php foreach ($all_menus as $menu): 
                $filename = $menu['image_path'] ?? 'default.jpg';
                $path = 'uploads/menus/' . $filename;

                if (file_exists(FCPATH . $path) && !empty($menu['image_path'])) {
                    $imgUrl = base_url($path);
                } else {
                    $imgUrl = base_url('uploads/menus/default_menus.jpg');
                }

                // Cari kuantitas item ini di dalam session keranjang belanja
                $currentQty = isset($sessionCart[$menu['id']]) ? $sessionCart[$menu['id']]['quantity'] : 0;
            ?>
                <div class="menu-card">
                    <img class="menu-img" src="<?= $imgUrl; ?>" alt="<?= esc($menu['menu_name']); ?>">
                    <div class="menu-info">
                        <h3><?= esc($menu['menu_name']); ?></h3>
                        <div class="menu-footer">
                            <span class="price">Rp <?= number_format($menu['price'], 0, ',', '.'); ?></span>
                            
                            <div class="quantity-control-wrapper" id="wrapper-<?= $menu['id']; ?>">
                                <button type="button" class="btn-add" id="btn-initial-<?= $menu['id']; ?>" onclick="updateCartQuantity(<?= $menu['id']; ?>, 'add', this)" style="display: <?= $currentQty == 0 ? 'block' : 'none'; ?>;">+</button>
                                
                                <div class="counter-control" id="counter-<?= $menu['id']; ?>" style="display: <?= $currentQty > 0 ? 'flex' : 'none'; ?>; align-items: center; gap: 8px;">
                                    <button type="button" class="btn-add" style="background-color: #d33 !important;" onclick="updateCartQuantity(<?= $menu['id']; ?>, 'decrease', this)">-</button>
                                    <span id="qty-val-<?= $menu['id']; ?>" style="font-weight: 600; font-size: 14px; min-width: 16px; text-align: center; color: #333; font-family: 'Poppins', sans-serif;"><?= $currentQty; ?></span>
                                    <button type="button" class="btn-add" style="background-color: #4CAF50 !important;" onclick="updateCartQuantity(<?= $menu['id']; ?>, 'add', this)">+</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <h4>Belum Ada Menu</h4>
                <p>Tidak ada menu yang tersedia<br>untuk kategori ini.</p>
            </div>
        <?php endif; ?>
    </div>

</div>

<?php
    $cartData = session()->get('cart') ?? [];
    $cartCount = 0;
    $cartTotal = 0;
    foreach ($cartData as $ci) {
        $cartCount += $ci['quantity'];
        $cartTotal += $ci['price'] * $ci['quantity'];
    }
?>

<div id="floatingCartBar" onclick="location.href='<?= base_url('cart'); ?>'" style="<?= $cartCount > 0 ? '' : 'display:none;' ?> position: fixed; bottom: 78px; left: 16px; right: 16px; max-width: 1200px; margin: 0 auto; background: #4CAF50; color: #ffffff; border-radius: 14px; padding: 14px 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 6px 20px rgba(76,175,80,0.35); cursor: pointer; z-index: 998; font-family: 'Poppins', sans-serif;">
    <div style="display: flex; align-items: center; gap: 10px;">
        <div id="cartBarCount" style="background: rgba(255,255,255,0.25); width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px;">
            <?= $cartCount; ?>
        </div>
        <span style="font-size: 14px; font-weight: 600;">Lihat Keranjang</span>
    </div>
    <span id="cartBarTotal" style="font-size: 14px; font-weight: 700;">Rp <?= number_format($cartTotal, 0, ',', '.'); ?></span>
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
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// FUNGSI UTAMA UNTUK UPDATE KUANTITAS MIN/PLUS REALTIME VIA AJAX FETCH
function updateCartQuantity(menuId, action, btn) {
    btn.disabled = true;

    // Menentukan URL endpoint berdasarkan aksi (tambah atau kurang)
    let url = action === 'add' ? '<?= base_url('cart/add'); ?>' : '<?= base_url('cart/decrease_ajax'); ?>';

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: 'menu_id=' + menuId
    })
    .then(res => res.json())
    .then(data => {
        btn.disabled = false;
        if (data.success) {
            const bar = document.getElementById('floatingCartBar');
            const countEl = document.getElementById('cartBarCount');
            const totalEl = document.getElementById('cartBarTotal');

            // Update info data total belanjaan di bawah secara realtime
            if (data.cartCount > 0) {
                countEl.textContent = data.cartCount;
                totalEl.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.cartTotal);
                bar.style.display = 'flex';
            } else {
                bar.style.display = 'none';
            }

            // Manipulasi pergantian elemen tombol [- Qty +] secara realtime
            const btnInitial = document.getElementById('btn-initial-' + menuId);
            const counterDiv = document.getElementById('counter-' + menuId);
            const qtyVal = document.getElementById('qty-val-' + menuId);

            if (data.itemQty > 0) {
                btnInitial.style.display = 'none';
                counterDiv.style.display = 'flex';
                qtyVal.textContent = data.itemQty;
            } else {
                btnInitial.style.display = 'block';
                counterDiv.style.display = 'none';
                qtyVal.textContent = 0;
            }
        } else {
            alert(data.message || 'Gagal memperbarui keranjang');
        }
    })
    .catch(err => {
        btn.disabled = false;
        console.error(err);
        alert('Terjadi kesalahan, coba lagi.');
    });
}
</script>
<?= $this->endSection(); ?>