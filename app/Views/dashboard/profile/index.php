<?= $this->extend('layouts/base') ?>

<?= $this->section('title') ?>My Profile<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4>My Profile</h4>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                    <?php endif; ?>

                    <div class="row mb-4">
                        <div class="col-md-3">
                            <img src="<?= base_url('uploads/profile/' . $user['profile_picture']) ?>"
                                class="img-thumbnail" alt="Profile Picture">
                        </div>
                        <div class="col-md-9">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Username</th>
                                    <td><?= esc($user['username']) ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?= esc($user['email']) ?></td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td><?= ucfirst($user['role']) ?></td>
                                </tr>
                                <tr>
                                    <th>Member Since</th>
                                    <td><?= date('d F Y', strtotime($user['created_at'])) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="<?= route_to('profile.edit') ?>" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Profile
                        </a>
                        <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>