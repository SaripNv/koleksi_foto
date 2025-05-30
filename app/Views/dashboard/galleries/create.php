<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Add New Photo<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?= helper('form') ?>

<style>
.image-slot-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 15px;
    margin-bottom: 20px;
}

.image-slot {
    width: 100%;
    aspect-ratio: 1/1;
    background-color: #f8f9fa;
    border: 2px dashed #ccc;
    border-radius: 8px;
    background-size: cover;
    background-position: center;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.image-slot:hover {
    border-color: #4e73df;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
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

.remove-photo {
    position: absolute;
    top: 5px;
    right: 5px;
    width: 24px;
    height: 24px;
    background: rgba(255, 0, 0, 0.7);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    cursor: pointer;
    border: none;
    opacity: 0;
    transition: opacity 0.3s;
}

.image-slot:hover .remove-photo {
    opacity: 1;
}

.photo-counter {
    position: absolute;
    bottom: 5px;
    right: 5px;
    background: rgba(0, 0, 0, 0.6);
    color: white;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 11px;
}
</style>

<div class="section-header">
    <h1>Add New Photo</h1>
</div>
<div class="section-body">
    <div class="card shadow">
        <div class="card-body">
            <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
            <?php endif; ?>

            <?php if (isset($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                    <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
            <?php endif; ?>

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

                <!-- 10 slot gambar dengan grid layout -->
                <div class="form-group">
                    <label>Upload Photos (1-10)</label>
                    <div class="image-slot-container">
                        <?php for($i=0; $i<10; $i++): ?>
                        <div class="image-slot" data-index="<?= $i ?>">
                            <div class="placeholder">Click to select<br>photo <?= $i+1 ?></div>
                            <input type="file" name="foto[<?= $i ?>]" accept="image/*" data-index="<?= $i ?>">
                            <div class="photo-counter"><?= $i+1 ?></div>
                        </div>
                        <?php endfor ?>
                    </div>
                    <small class="form-text text-muted">
                        Klik pada kotak untuk pilih file.<br>
                        Anda bisa upload 1-10 gambar (max 2MB setiap).
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
document.querySelectorAll('.image-slot').forEach(slot => {
    const input = slot.querySelector('input[type="file"]');
    const counter = slot.querySelector('.photo-counter');

    slot.addEventListener('click', () => input.click());

    input.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        if (file.size > 2 * 1024 * 1024) {
            alert('File size exceeds 2MB limit');
            this.value = '';
            return;
        }

        if (!file.type.startsWith('image/')) {
            alert('Please select an image file');
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(evt) {
            slot.style.backgroundImage = `url('${evt.target.result}')`;
            slot.querySelector('.placeholder').style.display = 'none';

            if (!slot.querySelector('.remove-photo')) {
                const removeBtn = document.createElement('button');
                removeBtn.className = 'remove-photo';
                removeBtn.innerHTML = '×';
                removeBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    slot.style.backgroundImage = '';
                    slot.querySelector('.placeholder').style.display = '';
                    input.value = '';
                    this.remove();
                });
                slot.appendChild(removeBtn);
            }
        };
        reader.readAsDataURL(file);
    });
});

document.querySelector('form').addEventListener('submit', function(e) {
    const fileInputs = document.querySelectorAll('input[type="file"]');
    let hasFile = false;

    fileInputs.forEach(input => {
        if (input.files.length > 0) {
            hasFile = true;
        }
    });

    if (!hasFile) {
        e.preventDefault();
        alert('Minimal unggah satu foto');
    }
});
</script>
<?= $this->endSection() ?>