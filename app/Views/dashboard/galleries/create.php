<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Add New Photo<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?= helper('form') ?>

<style>
.image-slot {
    width: 150px;
    height: 150px;
    background-color: #f8f9fa;
    border: 2px dashed #ccc;
    border-radius: 4px;
    background-size: cover;
    background-position: center;
    cursor: pointer;
    position: relative;
    margin-right: 1rem;
}

.image-slot input[type=file] {
    display: none;
}

.image-slot .placeholder {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #888;
    font-size: 0.9rem;
    text-align: center;
}
</style>

<div class="section-header">
    <h1>Add New Photo</h1>
</div>
<div class="section-body">
    <div class="card shadow">
        <div class="card-body">
            <?php if (session('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session('errors') as $e): ?>
                    <li><?= esc($e) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
            <?php endif ?>

            <form action="<?= base_url('dashboard/galleries/store') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <!-- Meta fields -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nama_foto">Photo Name</label>
                        <input type="text" name="nama_foto" id="nama_foto" class="form-control"
                            value="<?= set_value('nama_foto') ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="tanggal_diambil">Date Taken</label>
                        <input type="date" name="tanggal_diambil" id="tanggal_diambil" class="form-control"
                            value="<?= set_value('tanggal_diambil') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Description</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control"
                        rows="2"><?= set_value('deskripsi') ?></textarea>
                </div>

                <div class="form-group">
                    <label for="kategori_id">Category</label>
                    <select name="kategori_id" id="kategori_id" class="form-control">
                        <option value="">-- Select Category --</option>
                        <?php foreach($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= set_select('kategori_id',$cat['id']) ?>>
                            <?= esc($cat['nama_kategori']) ?>
                        </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <!-- Empat slot gambar -->
                <div class="form-group">
                    <label>Upload Photos (1–4)</label>
                    <div class="d-flex">
                        <?php for($i=0; $i<4; $i++): ?>
                        <div class="image-slot" data-index="<?= $i ?>">
                            <div class="placeholder">Click to select<br>photo <?= $i+1 ?></div>
                            <input type="file" name="foto[]" accept="image/*" data-index="<?= $i ?>">
                        </div>
                        <?php endfor ?>
                    </div>
                    <small class="form-text text-muted">
                        Klik pada kotak untuk pilih file.<br>
                        Anda bisa upload 1–4 gambar (max 5MB setiap).
                    </small>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save
                </button>
                <a href="<?= base_url('dashboard/galleries') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancel
                </a>
            </form>
        </div>
    </div>
</div>

<script>
// Ketika slot diklik, trigger file input di dalamnya
document.querySelectorAll('.image-slot').forEach(slot => {
    slot.addEventListener('click', () => {
        slot.querySelector('input[type=file]').click();
    });
    // Preview setelah file dipilih
    slot.querySelector('input[type=file]').addEventListener('change', e => {
        const file = e.target.files[0];
        if (!file) return;
        if (!file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.onload = function(evt) {
            slot.style.backgroundImage = `url('${evt.target.result}')`;
            slot.querySelector('.placeholder').style.display = 'none';
        };
        reader.readAsDataURL(file);
    });
});
</script>
<?= $this->endSection() ?>