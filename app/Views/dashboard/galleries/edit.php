<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Edit Photo<?= $this->endSection() ?>

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

/* Animasi untuk preview */
@keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

.preview-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 6px;
    animation: fadeIn 0.3s ease-in-out;
}

/* Efek loading */
.image-loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 30px;
    height: 30px;
    margin: -15px 0 0 -15px;
    border: 3px solid rgba(78, 115, 223, 0.3);
    border-radius: 50%;
    border-top-color: #4e73df;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
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

                <!-- 10 slot gambar -->
                <div class="form-group">
                    <label>Current Photos</label>
                    <div class="image-slot-container">
                        <?php 
                            $existingPhotos = explode(',', $gallery['foto']);
                            // Tambahkan elemen kosong hingga 10
                            $existingPhotos = array_pad($existingPhotos, 10, '');
                        ?>
                        <?php for ($i = 0; $i < 10; $i++): ?>
                        <?php if (!empty($existingPhotos[$i])): ?>
                        <div class="image-slot" data-index="<?= $i ?>">
                            <img src="<?= base_url($existingPhotos[$i]) ?>" class="preview-image"
                                alt="Preview <?= $i+1 ?>">
                            <input type="hidden" name="existing_foto[]" value="<?= $existingPhotos[$i] ?>">
                            <button type="button" class="remove-photo"
                                data-photo="<?= $existingPhotos[$i] ?>">×</button>
                            <div class="photo-counter"><?= $i+1 ?></div>
                        </div>
                        <?php else: ?>
                        <div class="image-slot" data-index="<?= $i ?>">
                            <div class="placeholder">Click to select<br>photo <?= $i+1 ?></div>
                            <input type="file" name="foto[<?= $i ?>]" accept="image/*" data-index="<?= $i ?>">
                            <div class="photo-counter"><?= $i+1 ?></div>
                        </div>
                        <?php endif; ?>
                        <?php endfor; ?>
                    </div>

                    <!-- Tambahkan input hidden untuk menyimpan foto yang dihapus -->
                    <input type="hidden" name="deleted_foto[]" id="deletedPhotos" value="">
                </div>

                <button type="submit" class="btn btn-primary">Update Photo</button>
                <a href="<?= base_url('dashboard/galleries') ?>" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<script>
// Event delegation untuk menangani semua slot gambar
document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.image-slot-container');

    // Gunakan event delegation untuk menangani klik pada slot gambar
    container.addEventListener('click', function(e) {
        const slot = e.target.closest('.image-slot');
        if (!slot) return;

        // Jika mengklik tombol remove
        if (e.target.classList.contains('remove-photo')) {
            handleRemovePhoto(e.target, slot);
            return;
        }

        // Jika mengklik slot untuk memilih file
        const fileInput = slot.querySelector('input[type="file"]');
        if (fileInput) {
            fileInput.click();
        }
    });

    // Event delegation untuk perubahan input file
    container.addEventListener('change', function(e) {
        if (e.target.tagName === 'INPUT' && e.target.type === 'file') {
            handleFileSelect(e.target);
        }
    });
});

// Fungsi untuk menangani pemilihan file
function handleFileSelect(input) {
    const file = input.files[0];
    if (!file) return;

    const slot = input.closest('.image-slot');

    // Tampilkan efek loading
    slot.classList.add('image-loading');

    // Validasi ukuran file
    if (file.size > 2 * 1024 * 1024) {
        alert('File size exceeds 2MB limit');
        input.value = '';
        slot.classList.remove('image-loading');
        return;
    }

    // Validasi tipe file
    if (!file.type.startsWith('image/')) {
        alert('Please select an image file');
        input.value = '';
        slot.classList.remove('image-loading');
        return;
    }

    // Gunakan FileReader untuk preview tanpa upload
    const reader = new FileReader();
    reader.onload = function(e) {
        // Hapus placeholder jika ada
        const placeholder = slot.querySelector('.placeholder');
        if (placeholder) placeholder.remove();

        // Hapus gambar sebelumnya jika ada
        const oldImg = slot.querySelector('img.preview-image');
        if (oldImg) oldImg.remove();

        // Buat elemen gambar baru
        const img = document.createElement('img');
        img.src = e.target.result;
        img.className = 'preview-image';
        slot.insertBefore(img, slot.firstChild);

        // Hapus efek loading
        slot.classList.remove('image-loading');
    };

    // Baca file sebagai data URL
    reader.readAsDataURL(file);
}

// Fungsi untuk menghapus foto
function handleRemovePhoto(btn, slot) {
    const photoPath = btn.getAttribute('data-photo');

    // Tambahkan ke daftar foto yang dihapus
    const deletedInput = document.getElementById('deletedPhotos');
    let deletedPhotos = deletedInput.value ? deletedInput.value.split(',') : [];
    if (photoPath && !deletedPhotos.includes(photoPath)) {
        deletedPhotos.push(photoPath);
        deletedInput.value = deletedPhotos.join(',');
    }

    // Reset slot
    const img = slot.querySelector('img.preview-image');
    if (img) img.remove();

    // Tambahkan kembali placeholder
    const index = slot.getAttribute('data-index');
    const placeholder = document.createElement('div');
    placeholder.className = 'placeholder';
    placeholder.innerHTML = `Click to select<br>photo ${parseInt(index)+1}`;
    slot.appendChild(placeholder);

    // Tambahkan input file baru
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.name = `foto[${index}]`;
    fileInput.accept = 'image/*';
    fileInput.dataset.index = index;
    fileInput.style.display = 'none';
    slot.appendChild(fileInput);

    // Hapus tombol remove
    btn.remove();

    // Hapus input existing_foto jika ada
    const existingInput = slot.querySelector('input[name="existing_foto[]"]');
    if (existingInput) existingInput.remove();
}
</script>

<?= $this->endSection() ?>