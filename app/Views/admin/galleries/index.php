<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Data Gallery<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="section-header">
    <h1>Data Gallery</h1>
</div>

<div class="section-body">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Photo List</h6>
            <div>
                <a href="<?= base_url('admin/galleries/create') ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Photo
                </a>
            </div>
        </div>

        <div class="card-body">
            <!-- Filter -->
            <div class="mb-3">
                <form method="get" class="d-flex">
                    <select name="sort" class="form-control w-auto" onchange="this.form.submit()">
                        <option value="desc" <?= $sort == 'desc' ? 'selected' : '' ?>>Newest</option>
                        <option value="asc" <?= $sort == 'asc' ? 'selected' : '' ?>>Oldest</option>
                    </select>
                </form>
            </div>

            <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php elseif (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Photo</th>
                            <th>Date Taken</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($galleries)) : ?>
                        <?php foreach ($galleries as $key => $photo) : ?>
                        <tr>
                            <td><?= (($currentPage - 1) * 5) + $key + 1 ?></td>
                            <td><?= esc($photo['nama_foto']) ?></td>
                            <td><?= esc($photo['deskripsi']) ?></td>
                            <td><?= esc($photo['nama_kategori'] ?? 'Unknown Category') ?></td>
                            <td>
                                <img src="<?= base_url($photo['foto']) ?>" class="img-thumbnail" width="100"
                                    height="100" loading="lazy">
                            </td>
                            <td><?= date('d M Y', strtotime($photo['tanggal_diambil'])) ?></td>
                            <td>
                                <a href="<?= base_url('admin/galleries/edit/' . $photo['id']) ?>"
                                    class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?= base_url('admin/galleries/delete/' . $photo['id']) ?>" method="post"
                                    style="display:inline;"
                                    onsubmit="return confirm('Are you sure you want to delete this photo?')">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else : ?>
                        <tr>
                            <td colspan="7" class="text-center">No photos found</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav>
                <ul class="pagination justify-content-center">
                    <?php if ($currentPage > 1) : ?>
                    <li class="page-item">
                        <a class="page-link"
                            href="<?= base_url('admin/galleries') . '?sort=' . $sort . '&page=' . ($currentPage - 1) ?>">Previous</a>
                    </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                    <li class="page-item <?= $currentPage == $i ? 'active' : '' ?>">
                        <a class="page-link"
                            href="<?= base_url('admin/galleries') . '?sort=' . $sort . '&page=' . $i ?>"><?= $i ?></a>
                    </li>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages) : ?>
                    <li class="page-item">
                        <a class="page-link"
                            href="<?= base_url('admin/galleries') . '?sort=' . $sort . '&page=' . ($currentPage + 1) ?>">Next</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?= $this->endSection() ?>