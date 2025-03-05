<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Tambah Kategori<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="section-header">
    <h1>Tambah Kategori</h1>
</div>

<div class="section-body">
    <div class="card shadow">
        <div class="card-body">
            <form action="<?= base_url('admin/categories/store') ?>" method="post">
                <label for="nama_kategori">Nama Kategori:</label>
                <input type="text" name="nama_kategori" id="nama_kategori" required>
                <button type="submit">Simpan</button>
            </form>

        </div>
    </div>
</div>
<?= $this->endSection() ?>