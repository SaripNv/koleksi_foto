<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Edit Photo<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="section-header">
    <h1>Edit Photo</h1>
</div>

<div class="section-body">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Update Photo</h6>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form action="<?= base_url('admin/galleries/update/' . $gallery['id']) ?>" method="post"
                enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="nama_foto">Photo Name</label>
                    <input type="text" name="nama_foto" id="nama_foto" class="form-control"
                        value="<?= esc($gallery['nama_foto']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Description</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"
                        required><?= esc($gallery['deskripsi']) ?></textarea>
                </div>

                <div class="form-group">
                    <label for="kategori_id">Category</label>
                    <select name="kategori_id" id="kategori_id" class="form-control" required>
                        <option value="">-- Select Category --</option>
                        <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category['id'] ?>"
                            <?= ($category['id'] == $gallery['kategori_id']) ? 'selected' : '' ?>>
                            <?= esc($category['nama_kategori']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tanggal_diambil">Date Taken</label>
                    <input type="date" name="tanggal_diambil" id="tanggal_diambil" class="form-control"
                        value="<?= $gallery['tanggal_diambil'] ?>" required>
                </div>

                <div class="form-group">
                    <label>Current Photo</label>
                    <br>
                    <img src="<?= base_url($gallery['foto']) ?>" class="img-thumbnail" width="150" height="150">
                </div>

                <div class="form-group">
                    <label for="foto">Change Photo (optional)</label>
                    <input type="file" name="foto" id="foto" class="form-control-file" accept="image/*">
                    <small class="text-muted">Max size: 2MB | Formats: JPG, PNG</small>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Update Photo
                </button>
                <a href="<?= base_url('admin/galleries') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>