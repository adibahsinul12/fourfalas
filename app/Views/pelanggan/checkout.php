<?= $this->extend('layout/customer_template'); ?>

<?= $this->section('content'); ?>

<div class="app-container" style="min-height: 100vh; display: flex; flex-direction: column; box-sizing: border-box;">

    <header class="cart-header" style="flex-shrink: 0; padding: 15px 16px;">
        <a href="<?= base_url('cart'); ?>" class="btn-back" style="text-decoration: none;">←</a>
        <h1 style="display: inline-block; margin: 0 0 0 10px; vertical-align: middle; font-family: 'Poppins', sans-serif;">Checkout</h1>
    </header>

    <div style="flex: 1; padding: 10px 16px 140px 16px; box-sizing: border-box;">

        <?php if (session()->getFlashdata('error')): ?>
            <div style="background:#ffe5e5; color:#c0392b; padding:12px 16px; border-radius:8px; margin-bottom:16px; font-size:14px; font-family:'Poppins', sans-serif;">
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('checkout/process'); ?>" method="post" id="checkoutForm">

            <div style="background: #ffffff; padding: 20px; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 16px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #333333; font-size: 14px; font-family: 'Poppins', sans-serif;">Nama Pemesan <span style="color: red;">*</span></label>
                <input type="text" name="customer_name" required placeholder="Masukkan nama kamu" style="width: 100%; padding: 12px 16px; border: 1px solid #E5E5E5; border-radius: 8px; font-family: inherit; font-size: 14px; box-sizing: border-box; outline: none;">
            </div>

            <div style="background: #ffffff; padding: 20px; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 16px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #333333; font-size: 14px; font-family: 'Poppins', sans-serif;">Pilih Meja <span style="color: red;">*</span></label>
                <select name="table_id" required style="width: 100%; padding: 12px 16px; border: 1px solid #E5E5E5; border-radius: 8px; font-family: inherit; font-size: 14px; box-sizing: border-box; outline: none; background-color: #ffffff; cursor: pointer;">
                    <option value="" disabled selected>-- Pilih Meja --</option>
                    <?php if(!empty($tables)): ?>
                        <?php foreach($tables as $meja): ?>
                            <option value="<?= $meja['id']; ?>">
                                Meja <?= $meja['table_number']; ?> (<?= $meja['type']; ?> - Kapasitas <?= $meja['capacity']; ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="" disabled>Data meja belum tersedia</option>
                    <?php endif; ?>
                </select>
            </div>

            <div style="background: #ffffff; padding: 20px; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #333333; font-size: 14px; font-family: 'Poppins', sans-serif;">Catatan Tambahan (Opsional)</label>
                <textarea name="notes" rows="3" placeholder="Misal: Es dipisah, pedas level 2..." style="width: 100%; padding: 12px 16px; border: 1px solid #E5E5E5; border-radius: 8px; font-family: inherit; font-size: 14px; box-sizing: border-box; outline: none; resize: none;"></textarea>
            </div>

            <div style="background: #ffffff; padding: 20px; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 20px;">
                <h3 style="margin: 0 0 16px 0; font-size: 15px; color: #333333; font-family: 'Poppins', sans-serif;">Rincian Pesanan</h3>
                
                <?php if(!empty($cart)): ?>
                    <?php foreach($cart as $item): ?>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; color: #555555; font-family: 'Poppins', sans-serif;">
                            <div style="flex: 1; padding-right: 15px;">
                                <span style="font-weight: 600; color: #4CAF50; margin-right: 6px;"><?= $item['quantity']; ?>x</span> 
                                <?= esc($item['menu_name']); ?>
                            </div>
                            <div style="font-weight: 500; color: #333333;">
                                Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <hr style="border: 0; border-top: 1px dashed #E5E5E5; margin: 16px 0;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px; color: #666666; font-family: 'Poppins', sans-serif;">
                    <span>Subtotal Menu</span>
                    <span>Rp <?= number_format($subtotal ?? 0, 0, ',', '.'); ?></span>
                </div>
                <hr style="border: 0; border-top: 1px dashed #E5E5E5; margin: 12px 0;">
                <div style="display: flex; justify-content: space-between; font-weight: 700; font-size: 16px; color: #6B3A1E; font-family: 'Poppins', sans-serif;">
                    <span>Total Estimasi</span>
                    <span>Rp <?= number_format($subtotal ?? 0, 0, ',', '.'); ?></span>
                </div>
            </div>
        </form>
    </div>

    <div style="position: fixed; bottom: 0; left: 0; right: 0; width: 100%; background: #ffffff; box-shadow: 0 -8px 24px rgba(0,0,0,0.08); border-radius: 16px 16px 0 0; z-index: 999; box-sizing: border-box; padding: 16px 16px 12px 16px; margin: 0 auto; max-width: inherit;">
        
        <button type="button" onclick="document.getElementById('checkoutForm').requestSubmit();" style="display: block; text-align: center; padding: 14px 0; font-size: 15px; font-weight: 600; border-radius: 12px; background-color: #4CAF50; color: white; width: 100%; box-sizing: border-box; font-family: 'Poppins', sans-serif; border: none; cursor: pointer; transition: 0.2s; margin-bottom: 14px;">Pesan Sekarang</button>
        
        <hr style="border: 0; border-top: 1px solid #eeeeee; margin: 0 0 12px 0;">

        <div class="bottom-nav" style="position: static !important; display: flex; justify-content: space-around; align-items: center; background: transparent !important; box-shadow: none !important; padding: 0 !important; margin: 0 !important; width: 100% !important; transform: none !important;">
            
            <div class="nav-item" onclick="location.href='<?= base_url('pelanggan'); ?>'" style="cursor: pointer; flex: 1; text-align: center;">
                <svg viewBox="0 0 24 24" style="margin: 0 auto 4px auto; width: 24px; height: 24px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; color: #888888;"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                <span style="font-size: 12px; color: #888888; font-family: 'Poppins', sans-serif;">Beranda</span>
            </div>
            
            <div class="nav-item" onclick="location.href='<?= base_url('pesanan'); ?>'" style="cursor: pointer; flex: 1; text-align: center;">
                <svg viewBox="0 0 24 24" style="margin: 0 auto 4px auto; width: 24px; height: 24px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; color: #888888;"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                <span style="font-size: 12px; color: #888888; font-family: 'Poppins', sans-serif;">Pesanan</span>
            </div>
            
            <div class="nav-item" onclick="location.href='<?= base_url('cart'); ?>'" style="cursor: pointer; flex: 1; text-align: center;">
                <svg viewBox="0 0 24 24" style="margin: 0 auto 4px auto; width: 24px; height: 24px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; color: #4CAF50;"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                <span style="font-size: 12px; color: #4CAF50; font-weight: 600; font-family: 'Poppins', sans-serif;">Keranjang</span>
            </div>
            
        </div>
    </div>
</div>

<?= $this->endSection(); ?>