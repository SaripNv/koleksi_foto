<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Edit Photo<?= $this->endSection() ?>

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
    <h1>Edit Photo</h1>
</div>

<div class="section-body">
    <div class="card shadow">
        <div class="card-body">
            <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <form action="<?= base_url('dashboard/galleries/update/' . $gallery['id']) ?>" method="POST"
                enctype="multipart/form-data">
                <?= csrf_field() ?>

                <!-- Meta fields -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nama_foto">Photo Name</label>
                        <input type="text" name="nama_foto" id="nama_foto" class="form-control"
                            value="<?= set_value('nama_foto', esc($gallery['nama_foto'] ?? '')) ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="tanggal_diambil">Date Taken</label>
                        <input type="date" name="tanggal_diambil" id="tanggal_diambil" class="form-control"
                            value="<?= set_value('tanggal_diambil', esc($gallery['tanggal_diambil'] ?? '')) ?>"
                            required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Description</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"
                        required><?= set_value('deskripsi', esc($gallery['deskripsi'] ?? '')) ?></textarea>
                </div>

                <div class="form-group">
                    <label for="kategori_id">Category</label>
                    <select name="kategori_id" id="kategori_id" class="form-control" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category): ?>
                        <option value="<?= esc($category['id']) ?>"
                            <?= set_select('kategori_id', $category['id'], $category['id'] == ($gallery['kategori_id'] ?? null)) ?>>
                            <?= esc($category['nama_kategori']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Current Photos (preview existing images) -->
                <div class="form-group">
                    <label>Current Photos</label><br>
                    <div class="d-flex">
                        <?php 
                            // Split the photos into an array using comma as the delimiter
                            $existingPhotos = explode(',', $gallery['foto']);
                            $maxImages = 4; // Set a limit for images displayed
                        ?>
                        <?php for ($i = 0; $i < 4; $i++): ?>
                        <div class="image-slot" data-index="<?= $i ?>"
                            style="background-image: url('<?= base_url($existingPhotos[$i] ?? '') ?>')">
                            <div class="placeholder" <?= isset($existingPhotos[$i]) ? 'style="display:none"' : '' ?>>
                                Click to select<br>photo <?= $i+1 ?>
                            </div>
                            <input type="file" name="foto[<?= $i ?>]" accept="image/*" data-index="<?= $i ?>">
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Photo</button>
                <a href="<?= base_url('dashboard/galleries') ?>" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<script>
// Update image preview on selection
document.querySelectorAll('.image-slot').forEach(slot => {
    slot.addEventListener('click', () => {
        slot.querySelector('input[type=file]').click();
    });

    // Preview the selected image
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