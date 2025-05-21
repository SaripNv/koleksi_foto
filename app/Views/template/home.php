<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Gallery Bullog Subang' ?></title>

    <!-- Assets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
    :root {
        --primary-color: #2A5C82;
        --secondary-color: #E63946;
    }

    body {
        background-color: #f8f9fa;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .navbar {
        background: white;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        padding: 10px 0;
    }

    .nav-link {
        color: var(--primary-color) !important;
        font-weight: 500;
        position: relative;
        margin: 0 15px;
        transition: all 0.3s;
    }

    .nav-link:hover,
    .nav-link.active {
        color: var(--secondary-color) !important;
    }

    .nav-link:hover::after {
        width: 100%;
    }

    .footer {
        background: var(--primary-color);
        color: white;
        margin-top: auto;
        padding: 40px 0 20px;
    }

    .footer a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: all 0.3s;
    }

    .footer a:hover {
        color: white;
        text-decoration: underline;
    }

    .contact-info i {
        width: 25px;
        text-align: center;
        margin-right: 10px;
    }

    .gallery-item {
        margin-bottom: 15px;
        transition: transform 0.3s;
    }

    .gallery-item:hover {
        transform: translateY(-5px);
    }

    /* Back to Top Button Styles */
    .back-to-top {
        position: fixed;
        bottom: 20px;
        right: 20px;
        display: none;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--secondary-color);
        color: white;
        text-align: center;
        line-height: 50px;
        font-size: 20px;
        z-index: 999;
        transition: all 0.3s;
        border: none;
    }

    .back-to-top:hover {
        background: var(--primary-color);
        transform: translateY(-3px);
    }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('/') ?>">
                <img width="120" src="<?= base_url('/assets/gallery/bulog.png') ?>" alt="Bulog Logo">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= (current_url() == base_url('/')) ? 'active' : '' ?>"
                            href="<?= base_url('/') ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (uri_string() == 'about') ? 'active' : '' ?>" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (uri_string() == 'login') ? 'active' : '' ?>"
                            href="<?= base_url('login') ?>">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (uri_string() == 'contact') ? 'active' : '' ?>"
                            href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow-1">
        <div class="container py-5">
            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4 text-center text-md-start">
                    <img width="200" src="<?= base_url('/assets/gallery/bulog.png') ?>" alt="Company Logo" class="mb-3">
                </div>

                <div class="col-md-4" id="contact">
                    <h5 class="mb-3">Contact Us</h5>
                    <div class="contact-info">
                        <p><i class="fas fa-map-marker-alt"></i> Jl. R.A. Kartini KM. 3, Subang,
                            Pasirkareumbi, Kec. Subang, Kabupaten Subang,
                            Jawa Barat 41285, Indonesia</p>
                        <p><i class="fas fa-phone-alt"></i> +62 123 456 7890</p>
                        <p><i class="fas fa-envelope"></i> BulogSubang@gmail.com</p>
                    </div>
                </div>

                <div class="col-md-4 text-center text-md-end">
                    <h5 class="mb-3">Follow Us</h5>
                    <div class="social-links">
                        <a href="#" class="me-3"><i class="fab fa-facebook fa-2x"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-instagram fa-2x"></i></a>
                        <a href="#"><i class="fab fa-linkedin fa-2x"></i></a>
                    </div>
                </div>
            </div>

            <div class="border-top mt-4 pt-3 text-center">
                <p class="mb-0">&copy; 2025 Bulog Subang - Sarip Sistem Informasi</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop" title="Go to top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script>
    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Back to Top Button
    const backToTopButton = document.getElementById('backToTop');

    // Show button when scrolling down
    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            backToTopButton.style.display = 'block';
        } else {
            backToTopButton.style.display = 'none';
        }
    });

    // Scroll to top when clicked
    backToTopButton.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    </script>
</body>

</html>