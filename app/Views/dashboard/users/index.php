<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Kelola User<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="section-header">
    <h1>Kelola User</h1>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar User</h4>
                    <div class="card-header-action">
                        <a href="<?= route_to('users.create') ?>" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah User
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Last Login</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $user['username'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <td><?= ucfirst($user['role']) ?></td>
                                    <td>
                                        <?php if ($user['status_aktif']): ?>
                                        <span class="badge badge-success">Aktif</span>
                                        <?php else: ?>
                                        <span class="badge badge-danger">Tidak Aktif</span>
                                        <?php endif ?>
                                    </td>
                                    <td><?= $user['last_login'] ? date('d/m/Y H:i', strtotime($user['last_login'])) : '-' ?>
                                    </td>
                                    <td>
                                        <a href="<?= route_to('users.edit', $user['id']) ?>"
                                            class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?= route_to('users.toggle-status', $user['id']) ?>" method="POST"
                                            class="d-inline">
                                            <?= csrf_field() ?>
                                            <button type="submit"
                                                class="btn btn-sm <?= $user['status_aktif'] ? 'btn-danger' : 'btn-success' ?>">
                                                <i
                                                    class="fas <?= $user['status_aktif'] ? 'fa-times' : 'fa-check' ?>"></i>
                                            </button>
                                        </form>
                                        <form action="<?= route_to('users.delete', $user['id']) ?>" method="POST"
                                            class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin hapus user ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>