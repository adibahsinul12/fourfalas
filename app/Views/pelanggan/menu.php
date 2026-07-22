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

                $variants = $menu['variants'] ?? [];
                $hasMultipleVariants = count($variants) > 1;
                $singleVariantId = (count($variants) === 1) ? $variants[0]['id'] : null;

                // Total qty di keranjang untuk SEMUA varian milik menu ini
                $menuQty = 0;
                foreach ($sessionCart as $ci) {
                    if (($ci['menu_id'] ?? null) == $menu['id']) {
                        $menuQty += $ci['quantity'];
                    }
                }
            ?>
                <div class="menu-card">
                    <img class="menu-img" src="<?= $imgUrl; ?>" alt="<?= esc($menu['menu_name']); ?>">
                    <div class="menu-info">
                        <h3>
                            <?= esc($menu['menu_name']); ?>
                            <?php if ($hasMultipleVariants): ?>
                                <span style="display:inline-block; font-size:10px; font-weight:600; color:#A67C52; background:#F7EFE5; padding:2px 8px; border-radius:20px; margin-left:4px; vertical-align:middle;">
                                    <?= count($variants); ?> pilihan
                                </span>
                            <?php endif; ?>
                        </h3>
                        <div class="menu-footer">
                            <span class="price">
                                <?= $hasMultipleVariants ? 'Mulai ' : ''; ?>Rp <?= number_format($menu['price'], 0, ',', '.'); ?>
                            </span>
                            
                            <div class="quantity-control-wrapper" id="wrapper-<?= $menu['id']; ?>">
                                <button type="button" class="btn-add js-add-btn" id="btn-initial-<?= $menu['id']; ?>"
                                    data-menu-id="<?= esc($menu['id'], 'attr'); ?>"
                                    data-menu-name="<?= esc($menu['menu_name'], 'attr'); ?>"
                                    data-variants='<?= esc(json_encode($variants), 'attr'); ?>'
                                    data-single-variant-id="<?= esc($singleVariantId, 'attr'); ?>"
                                    style="display: <?= $menuQty == 0 ? 'block' : 'none'; ?>;">+</button>

                                <?php if (!$hasMultipleVariants): ?>
                                    <div class="counter-control" id="counter-<?= $menu['id']; ?>" style="display: <?= $menuQty > 0 ? 'flex' : 'none'; ?>; align-items: center; gap: 8px;">
                                        <button type="button" class="btn-add js-decrease-btn" style="background-color: #d33 !important;"
                                            data-variant-id="<?= esc($singleVariantId, 'attr'); ?>"
                                            data-menu-id="<?= esc($menu['id'], 'attr'); ?>">-</button>
                                        <span id="qty-val-<?= $menu['id']; ?>" style="font-weight: 600; font-size: 14px; min-width: 16px; text-align: center; color: #333; font-family: 'Poppins', sans-serif;"><?= $menuQty; ?></span>
                                        <button type="button" class="btn-add js-increase-btn" style="background-color: #4CAF50 !important;"
                                            data-variant-id="<?= esc($singleVariantId, 'attr'); ?>"
                                            data-menu-id="<?= esc($menu['id'], 'attr'); ?>">+</button>
                                    </div>
                                <?php else: ?>
                                    <div class="counter-control js-open-variant" id="counter-<?= $menu['id']; ?>" style="display: <?= $menuQty > 0 ? 'flex' : 'none'; ?>; align-items: center; gap: 8px; cursor:pointer;"
                                        data-menu-id="<?= esc($menu['id'], 'attr'); ?>"
                                        data-menu-name="<?= esc($menu['menu_name'], 'attr'); ?>"
                                        data-variants='<?= esc(json_encode($variants), 'attr'); ?>'>
                                        <span style="background-color:#4CAF50; color:#fff; border-radius:20px; padding:5px 12px; font-weight:600; font-size:12px;">
                                            <span id="qty-val-<?= $menu['id']; ?>"><?= $menuQty; ?></span> di keranjang
                                        </span>
                                    </div>
                                <?php endif; ?>
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

<div id="floatingCartBar"
    onclick="location.href='<?= base_url('cart'); ?>'"
    style="
        display: <?= $cartCount > 0 ? 'flex' : 'none'; ?>;
        position: fixed;
        bottom: 78px;
        left: 50%;
        transform: translateX(-50%);
        width: calc(100% - 24px);
        max-width: 1190px;
        justify-content: space-between;
        align-items: center;
        background: #4CAF50;
        color: #ffffff;
        padding: 14px 20px;
        border-radius: 14px;
        box-shadow: 0 6px 20px rgba(76,175,80,.35);
        cursor: pointer;
        z-index: 999;
        font-family: 'Poppins', sans-serif;
        box-sizing: border-box;
    ">
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
    <div class="nav-item" onclick="location.href='<?= base_url('rating'); ?>'">
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
// Event delegation: menangkap semua klik tombol +/- dan buka-varian di dalam menu-grid
document.addEventListener('click', function(e) {
    const addBtn = e.target.closest('.js-add-btn');
    if (addBtn) {
        const menuId = addBtn.dataset.menuId;
        const menuName = addBtn.dataset.menuName;
        const variants = JSON.parse(addBtn.dataset.variants || '[]');
        const singleVariantId = addBtn.dataset.singleVariantId;
        handleAddClick(menuId, menuName, variants, singleVariantId, addBtn);
        return;
    }

    const decBtn = e.target.closest('.js-decrease-btn');
    if (decBtn) {
        updateCartQuantity(decBtn.dataset.variantId, 'decrease', decBtn, decBtn.dataset.menuId);
        return;
    }

    const incBtn = e.target.closest('.js-increase-btn');
    if (incBtn) {
        updateCartQuantity(incBtn.dataset.variantId, 'add', incBtn, incBtn.dataset.menuId);
        return;
    }

    const openVariantEl = e.target.closest('.js-open-variant');
    if (openVariantEl) {
        const menuId = openVariantEl.dataset.menuId;
        const menuName = openVariantEl.dataset.menuName;
        const variants = JSON.parse(openVariantEl.dataset.variants || '[]');
        openVariantPicker(menuId, menuName, variants);
        return;
    }
});

// Diklik saat tombol "+" pertama kali ditekan di sebuah kartu menu.
function handleAddClick(menuId, menuName, variants, singleVariantId, btn) {
    if (variants.length <= 1) {
        updateCartQuantity(singleVariantId, 'add', btn, menuId);
    } else {
        openVariantPicker(menuId, menuName, variants);
    }
}

// Popup SweetAlert2 untuk memilih varian mana yang mau ditambahkan
function openVariantPicker(menuId, menuName, variants) {
    let optionsHtml = variants.map(v => {
        const priceFmt = new Intl.NumberFormat('id-ID').format(v.price);
        return `
            <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 4px; border-bottom:1px solid #F0EAE2;">
                <div style="text-align:left;">
                    <div style="font-weight:600; font-size:14px; color:#333;">${v.variant_name}</div>
                    <div style="font-size:12px; color:#888;">Rp ${priceFmt}</div>
                </div>
                <button type="button" class="variant-pick-btn" data-variant-id="${v.id}"
                    style="background:#4CAF50; color:#fff; border:none; border-radius:8px; padding:6px 14px; font-size:12px; font-weight:600; cursor:pointer;">
                    + Tambah
                </button>
            </div>
        `;
    }).join('');

    Swal.fire({
        title: menuName,
        html: `<div style="text-align:left; max-height:320px; overflow-y:auto;">${optionsHtml}</div>`,
        showConfirmButton: false,
        showCloseButton: true,
        background: '#FAF6EB',
        width: 380,
        didOpen: () => {
            document.querySelectorAll('.variant-pick-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const variantId = this.getAttribute('data-variant-id');
                    this.textContent = '...';
                    this.disabled = true;
                    updateCartQuantity(variantId, 'add', this, menuId, function() {
                        this.textContent = '✓ Ditambahkan';
                        setTimeout(() => { this.textContent = '+ Tambah'; this.disabled = false; }, 800);
                    });
                });
            });
        }
    });
}

// FUNGSI UTAMA UNTUK UPDATE KUANTITAS PER VARIAN SECARA REALTIME VIA AJAX FETCH
function updateCartQuantity(variantId, action, btn, menuId, afterCallback) {
    if (btn) btn.disabled = true;

    let url = action === 'add' ? '<?= base_url('cart/add'); ?>' : '<?= base_url('cart/decrease_ajax'); ?>';

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: 'variant_id=' + variantId
    })
    .then(res => res.json())
    .then(data => {
        if (btn) btn.disabled = false;
        if (data.success) {
            const bar = document.getElementById('floatingCartBar');
            const countEl = document.getElementById('cartBarCount');
            const totalEl = document.getElementById('cartBarTotal');

           if (data.cartCount <= 0) {
                bar.style.display = 'none';
            } else {
                countEl.textContent = data.cartCount;
                totalEl.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.cartTotal);
                bar.style.display = 'flex';
            }

            const mId = data.menuId || menuId;
            const btnInitial = document.getElementById('btn-initial-' + mId);
            const counterDiv = document.getElementById('counter-' + mId);
            const qtyVal = document.getElementById('qty-val-' + mId);

            if (data.menuQty > 0) {
                if (btnInitial) btnInitial.style.display = 'none';
                if (counterDiv) counterDiv.style.display = 'flex';
                if (qtyVal) qtyVal.textContent = data.menuQty;
            } else {
                if (btnInitial) btnInitial.style.display = 'block';
                if (counterDiv) counterDiv.style.display = 'none';
                if (qtyVal) qtyVal.textContent = 0;
            }

            if (typeof afterCallback === 'function' && btn) {
                afterCallback.call(btn);
            }
        } else {
            alert(data.message || 'Gagal memperbarui keranjang');
        }
    })
    .catch(err => {
        if (btn) btn.disabled = false;
        console.error(err);
        alert('Terjadi kesalahan, coba lagi.');
    });
}
</script>
<?= $this->endSection(); ?>