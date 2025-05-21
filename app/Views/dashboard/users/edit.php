<?= $this->extend('layouts/base') ?>
<?= $this->section('title') ?>Edit User<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="section-header">
    <h1>Edit User</h1>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Edit User</h4>
                </div>
                <div class="card-body">
                    <form action="<?= route_to('users.update', $user['id']) ?>" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?= $user['username'] ?>"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Password (kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <select name="role" class="form-control" required>
                                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status_aktif" class="form-control" required>
                                <option value="1" <?= $user['status_aktif'] == 1 ? 'selected' : '' ?>>Aktif</option>
                                <option value="0" <?= $user['status_aktif'] == 0 ? 'selected' : '' ?>>Tidak Aktif
                                </option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>