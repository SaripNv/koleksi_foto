<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Data Gallery<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?= helper('form') ?>

<div class="section-header">
    <h1>Data Gallery</h1>
</div>
<div class="section-body">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Photo List</h6>
            <a href="<?= base_url('dashboard/galleries/create') ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Photo
            </a>
        </div>
        <div class="card-body">

            <!-- FILTER: Kategori | Tanggal | Sort -->
            <form method="get" class="form-row align-items-end mb-4">
                <!-- Category -->
                <div class="form-group col-6 col-md-3">
                    <label for="filter_kategori" class="small mb-1">Category</label>
                    <select name="filter_kategori" id="filter_kategori" class="form-control form-control-sm"
                        onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"
                            <?= set_select('filter_kategori', $cat['id'], $filterKategori == $cat['id']) ?>>
                            <?= esc($cat['nama_kategori']) ?>
                        </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <!-- Date -->
                <div class="form-group col-6 col-md-3">
                    <label for="filter_tanggal" class="small mb-1">Date</label>
                    <input type="date" name="filter_tanggal" id="filter_tanggal" class="form-control form-control-sm"
                        value="<?= esc($filterTanggal) ?>" onchange="this.form.submit()">
                </div>

                <!-- Sort -->
                <div class="form-group col-6 col-md-2">
                    <label for="sort" class="small mb-1">Sort</label>
                    <select name="sort" id="sort" class="form-control form-control-sm" onchange="this.form.submit()">
                        <option value="desc" <?= set_select('sort','desc',$sort==='desc') ?>>Newest</option>
                        <option value="asc" <?= set_select('sort','asc',$sort==='asc') ?>>Oldest</option>
                    </select>
                </div>

                <!-- Reset Filter -->
                <div class="form-group col-6 col-md-2">
                    <a href="<?= base_url('dashboard/galleries') ?>" class="btn btn-sm btn-secondary btn-block">
                        Reset Filter
                    </a>
                </div>
            </form>

            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php elseif (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif ?>

            <!-- Tabel -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Photos</th>
                            <th>Date Taken</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($galleries): ?>
                        <?php foreach ($galleries as $i => $photo): ?>
                        <tr>
                            <td><?= ($currentPage-1)*$perPage + $i +1 ?></td>
                            <td><?= esc($photo['nama_foto']) ?></td>
                            <td><?= esc($photo['deskripsi']) ?></td>
                            <td><?= esc($photo['nama_kategori'] ?? '—') ?></td>
                            <td>
                                <?php 
                                $photos = explode(',', $photo['foto']);
                                foreach (array_slice($photos, 0, 4) as $img): 
                                ?>
                                <img src="<?= base_url($img) ?>" class="img-thumbnail mr-1 mb-1"
                                    style="width:60px;height:60px;object-fit:cover;" loading="lazy">
                                <?php endforeach ?>
                                <?php if (count($photos) > 4): ?>
                                <span class="badge badge-info">+<?= count($photos) - 4 ?> more</span>
                                <?php endif ?>
                            </td>
                            <td><?= date('d M Y', strtotime($photo['tanggal_diambil'])) ?></td>
                            <td>
                                <a href="<?= base_url("dashboard/galleries/edit/{$photo['id']}") ?>"
                                    class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                <!-- Di view dashboard/galleries/index.php -->
                                <form action="<?= base_url("dashboard/galleries/delete/{$photo['id']}") ?>"
                                    method="POST" class="d-inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin hapus foto?')">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No photos found.</td>
                        </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
            <nav>
                <ul class="pagination justify-content-center">
                    <?php
                    $queryParams = [
                        'sort' => $sort,
                        'filter_kategori' => $filterKategori,
                        'filter_tanggal' => $filterTanggal
                    ];
                    $baseUrl = base_url('dashboard/galleries') . '?' . http_build_query($queryParams);
                    ?>
                    <?php if ($currentPage > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= $baseUrl.'&page='.($currentPage-1) ?>">&laquo; Prev</a>
                    </li>
                    <?php endif ?>
                    <?php for ($p=1; $p<=$totalPages; $p++): ?>
                    <li class="page-item <?= $p==$currentPage?'active':'' ?>">
                        <a class="page-link" href="<?= $baseUrl.'&page='.$p ?>"><?= $p ?></a>
                    </li>
                    <?php endfor ?>
                    <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= $baseUrl.'&page='.($currentPage+1) ?>">Next &raquo;</a>
                    </li>
                    <?php endif ?>
                </ul>
            </nav>
            <?php endif ?>

        </div>
    </div>
</div>
<?= $this->endSection() ?>