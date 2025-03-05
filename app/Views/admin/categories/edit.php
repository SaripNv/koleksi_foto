<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Edit Kategori<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="section-header">
    <h1>Edit Kategori</h1>
</div>

<div class="section-body">
    <div class="card shadow">
        <div class="card-body">
            <form action="<?= base_url('admin/categories/update/' . $category['id']) ?>" method="post">
                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" name="nama_kategori" value="<?= $category['nama_kategori'] ?>"
                        class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Update</button>
                <a href="<?= base_url('categories') ?>" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>