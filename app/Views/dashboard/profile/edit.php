<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>Edit Profile<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4>Edit Profile</h4>
                </div>
                <div class="card-body">
                    <!-- Form Edit Profil -->
                    <form action="<?= route_to('profile.update') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text"
                                class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>"
                                name="username" value="<?= old('username', $user['username']) ?>">
                            <?php if (session('errors.username')): ?>
                            <div class="invalid-feedback">
                                <?= session('errors.username') ?>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>"
                                name="email" value="<?= old('email', $user['email']) ?>">
                            <?php if (session('errors.email')): ?>
                            <div class="invalid-feedback">
                                <?= session('errors.email') ?>
                            </div>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Profile
                        </button>
                    </form>

                    <hr>

                    <!-- Form Upload Foto Profil -->
                    <div class="mt-4">
                        <h5>Update Profile Picture</h5>
                        <form action="<?= route_to('profile.upload-photo') ?>" method="post"
                            enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <div class="row align-items-center">
                                <div class="col-md-4 mb-3">
                                    <img src="<?= base_url('uploads/profile/' . $user['profile_picture']) ?>"
                                        class="img-thumbnail w-100" alt="Current Profile Picture">
                                </div>
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="profile_picture" class="form-label">Choose New Image</label>
                                        <input type="file"
                                            class="form-control <?= session('errors.profile_picture') ? 'is-invalid' : '' ?>"
                                            name="profile_picture" accept="image/jpeg,image/png">
                                        <?php if (session('errors.profile_picture')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.profile_picture') ?>
                                        </div>
                                        <?php endif; ?>
                                        <div class="form-text">Max size 2MB (JPEG/PNG)</div>
                                    </div>
                                    <button type="submit" class="btn btn-info">
                                        <i class="fas fa-upload"></i> Upload Photo
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <hr>

                    <!-- Form Ganti Password -->
                    <div class="mt-4">
                        <h5>Change Password</h5>
                        <form action="<?= route_to('profile.change-password') ?>" method="post">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password"
                                    class="form-control <?= session('errors.current_password') ? 'is-invalid' : '' ?>"
                                    name="current_password">
                                <?php if (session('errors.current_password')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.current_password') ?>
                                </div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password"
                                    class="form-control <?= session('errors.new_password') ? 'is-invalid' : '' ?>"
                                    name="new_password">
                                <?php if (session('errors.new_password')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.new_password') ?>
                                </div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm New Password</label>
                                <input type="password"
                                    class="form-control <?= session('errors.confirm_password') ? 'is-invalid' : '' ?>"
                                    name="confirm_password">
                                <?php if (session('errors.confirm_password')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.confirm_password') ?>
                                </div>
                                <?php endif; ?>
                            </div>

                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-key"></i> Change Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>