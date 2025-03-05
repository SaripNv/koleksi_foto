<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Add New Photo<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="section-header">
    <h1>Add New Photo</h1>
</div>
<div class="section-body">
    <div class="card shadow">
        <div class="card-body">
            <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <form action="<?= base_url('admin/galleries/store') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="nama_foto">Photo Name</label>
                    <input type="text" name="nama_foto" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Description</label>
                    <textarea name="deskripsi" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="tanggal_diambil">Date Taken</label>
                    <input type="date" name="tanggal_diambil" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="kategori_id">Category</label>
                    <select name="kategori_id" class="form-control" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category['id'] ?>"><?= esc($category['nama_kategori']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="foto">Photo</label>
                    <input type="file" name="foto" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="<?= base_url('admin/galleries') ?>" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>