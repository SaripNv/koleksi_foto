<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Tambah Kategori<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="section-header">
    <h1>Tambah Kategori</h1>
</div>

<div class="section-body">
    <div class="card shadow">
        <div class="card-body">
            <?php if (session()->getFlashdata('errors')) : ?>
            <div class="alert alert-danger">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                <p><?= $error ?></p>
                <?php endforeach ?>
            </div>
            <?php endif ?>

            <form action="<?= base_url('dashboard/categories/store') ?>" method="post">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="nama_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" name="nama_kategori" id="nama_kategori"
                                class="form-control <?= session()->getFlashdata('error_nama_kategori') ? 'is-invalid' : '' ?>"
                                value="<?= old('nama_kategori') ?>" placeholder="Masukkan nama kategori" required>
                            <?php if (session()->getFlashdata('error_nama_kategori')) : ?>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('error_nama_kategori') ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Simpan Kategori
                    </button>
                    <a href="<?= base_url('dashboard/categories') ?>" class="btn btn-secondary btn-lg">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>