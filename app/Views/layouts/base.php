<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?=$this->renderSection('title')?> &mdash; FOTO PERUM BULOG</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?=base_url('assets/vendor/bootstrap/package/dist/css/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/vendor/fontawesome-free/package/css/all.min.css')?>">

    <!-- CSS Libraries -->

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?=base_url('assets/css/style.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/css/components.css')?>">

    <link rel="stylesheet" href="<?=base_url('assets/css/custom.css')?>">
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <!-- Navbar Item -->
            <div class="navbar-bg shadow-sm"></div>
            <?=$this->include('layouts/includes/navbar')?>
            <!-- Akhir Navbar -->

            <!-- Sidebar -->
            <?=$this->include('layouts/includes/sidebar')?>
            <!-- Akhir Sidebar -->

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <?=$this->renderSection('content')?>
                </section>
            </div>
            <!-- Akhir Main Content -->

            <!-- Footer -->
            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; 2025
                    <div class="bullet"></div><a>PERUM BULOG</a>
                </div>
            </footer>
            <!-- Akhir Footer -->
        </div>
    </div>

    <!-- General JS Scripts -->

    <script src="<?=base_url('assets/vendor/jquery/package/dist/jquery.min.js')?>"></script>
    <script src="<?=base_url('assets/vendor/popperjs/package/dist/umd/popper.min.js')?>"></script>
    <script src="<?=base_url('assets/vendor/bootstrap/package/dist/js/bootstrap.bundle.min.js')?>"></script>

    <script src="<?=base_url('assets/vendor/jquery.nicescroll/package/dist/jquery.nicescroll.min.js')?>"></script>
    <script src="<?=base_url('assets/vendor/moment/dist/moment.js')?>"></script>
    <script src="<?=base_url('assets/vendor/moment/dist/locale/id.js')?>"></script>
    <script src="<?=base_url('assets/js/stisla.js')?>"></script>

    <!-- JS Libraies -->

    <!-- Template JS File -->
    <script src="<?=base_url('assets/js/scripts.js')?>"></script>
    <script src="<?=base_url('assets/js/custom.js')?>"></script>

    <!-- Page Specific JS File -->

    <?=$this->renderSection('script')?>
</body>

</html>