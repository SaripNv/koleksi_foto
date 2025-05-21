<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Data Kategori<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="section-header">
    <h1>Data Kategori</h1>
</div>

<div class="section-body">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Category List</h6>
            <a href="<?= base_url('dashboard/categories/create') ?>" class="btn btn-primary">Add New Category</a>
        </div>
        <div class="card-body">
            <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $key => $category) : ?>
                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= $category['nama_kategori'] ?></td>
                        <td>
                            <a href="<?= base_url('dashboard/categories/edit/' . $category['id']) ?>"
                                class="btn btn-warning btn-sm">Edit</a>
                            <form action="<?= base_url('dashboard/categories/delete/' . $category['id']) ?>"
                                method="post" style="display:inline;"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>

                    </tr>

                    <?php endforeach; ?>
                    <?php if (empty($categories)) : ?>
                    <tr>
                        <td colspan="3" class="text-center">Tidak ada kategori ditemukan</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>