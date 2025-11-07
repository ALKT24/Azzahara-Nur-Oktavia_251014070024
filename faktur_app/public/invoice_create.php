<?php
require_once __DIR__ . '/../app/Models/Company.php';
require_once __DIR__ . '/../app/Models/Customer.php';
require_once __DIR__ . '/../app/Models/Product.php';
require_once __DIR__ . '/../app/Helpers/auth.php';
checkAuth();

$companyModel = new Company();
$customerModel = new Customer();
$productModel = new Product();

$companies = $companyModel->all();
$customers = $customerModel->all();
$products  = $productModel->all();
?>

<div class="container">
  <h4>Buat Faktur</h4>
  <form id="formFaktur">
    <div class="row mb-3">
      <div class="col-md-3">
        <label>Tanggal</label>
        <input type="date" name="tgl_faktur" class="form-control" required>
      </div>
      <div class="col-md-3">
        <label>Due Date</label>
        <input type="date" name="due_date" class="form-control" required>
      </div>
      <div class="col-md-3">
        <label>Metode Bayar</label>
        <select name="metode_bayar" class="form-select" required>
          <option value="Cash" selected>Cash</option>
          <option value="Transfer">Transfer</option>
        </select>
      </div>

    </div>

    <div class="row mb-3">
      <div class="col-md-6">
        <label>Perusahaan</label>
        <select name="id_perusahaan" class="form-select" required>
          <option value="">-- Pilih Perusahaan --</option>
          <?php foreach ($companies as $c): ?>
            <option value="<?= $c['id_perusahaan'] ?>"><?= htmlspecialchars($c['nama_perusahaan']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-6">
        <label>Customer</label>
        <select name="id_customer" class="form-select" required>
          <option value="">-- Pilih Customer --</option>
          <?php foreach ($customers as $cu): ?>
            <option value="<?= $cu['id_customer'] ?>"><?= htmlspecialchars($cu['nama_customer']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <hr>
    <h6>Produk</h6>
    <table class="table table-bordered" id="tblProduk">
      <thead>
        <tr>
          <th>Produk</th>
          <th>Harga</th>
          <th>Qty</th>
          <th>Subtotal</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>

    <button type="button" id="btnAddRow" class="btn btn-secondary btn-sm mb-3">Tambah Baris</button>

    <div class="mb-2">
      <p>Subtotal: <span id="subtotal">0</span></p>
      <p>PPN (11%): <span id="ppn">0</span></p>
      <p>DP (50% dari subtotal): <span id="dp">0</span></p>
      <p><b>Grand Total: <span id="grand_total">0</span></b></p>
    </div>

    <button type="submit" class="btn btn-primary">Simpan & Cetak</button>
  </form>
</div>

<script>
const products = <?= json_encode($products) ?>;

function formatNumber(num){ return new Intl.NumberFormat('id-ID').format(num); }

// Tambah baris produk
$('#btnAddRow').on('click', function() {
  let row = `
    <tr>
      <td>
        <select class="form-select product-select" name="produk[]">
          <option value="">-- Pilih Produk --</option>
          ${products.map(p => `<option value="${p.id_produk}" data-price="${p.price}" data-stock="${p.stock}">${p.nama_produk}</option>`).join('')}
        </select>
      </td>
      <td><input type="text" class="form-control price" name="price[]" readonly></td>
      <td><input type="number" class="form-control qty" name="qty[]" min="1" value="1"></td>
      <td><input type="text" class="form-control subtotal" name="subtotal[]" readonly></td>
      <td><button type="button" class="btn btn-danger btn-sm btnRemove">X</button></td>
    </tr>`;
  $('#tblProduk tbody').append(row);
});

// Hapus baris
$(document).on('click', '.btnRemove', function() {
  $(this).closest('tr').remove();
  hitungTotal();
});

// Saat pilih produk, isi harga
$(document).on('change', '.product-select', function() {
  const price = $(this).find(':selected').data('price') || 0;
  $(this).closest('tr').find('.price').val(price);
  hitungTotal();
});

// Saat ubah qty
$(document).on('input', '.qty', function() {
  hitungTotal();
});

// Hitung total otomatis
function hitungTotal(){
  let subtotal = 0;
  $('#tblProduk tbody tr').each(function(){
    const qty = parseFloat($(this).find('.qty').val()) || 0;
    const price = parseFloat($(this).find('.price').val()) || 0;
    const sub = qty * price;
    $(this).find('.subtotal').val(sub);
    subtotal += sub;
  });

  const ppn = subtotal * 0.11;
  const dp = subtotal * 0.5;
  const grand = subtotal + ppn;

  $('#subtotal').text(formatNumber(subtotal));
  $('#ppn').text(formatNumber(ppn));
  $('#dp').text(formatNumber(dp));
  $('#grand_total').text(formatNumber(grand));
}

// Simpan Faktur (langsung update stok produk)
$('#formFaktur').on('submit', function(e){
  e.preventDefault();
  $.post('invoice_save.php', $(this).serialize(), function(res){
    $('#mainContent').html(res);
  });
});
</script>
