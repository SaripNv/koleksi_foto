<?= $this->extend('template/home') ?>
<?= $this->section('content') ?>
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="display-4 fw-bold text-primary mb-3">Foto Kegiatan Ferum Bulog</h2>
        <p class="lead text-muted">Koleksi momen berharga dari berbagai kegiatan Ferum Bulog</p>
    </div>

    <!-- Filter Categories -->
    <div class="text-center mb-5">
        <div class="btn-group btn-group-lg" role="group" aria-label="Gallery filter">
            <button type="button" class="btn btn-primary px-4 rounded-pill filter-btn" data-category="all">
                <i class="fas fa-images me-2"></i>All
            </button>
            <?php foreach ($categories as $category) : ?>
            <button type="button" class="btn btn-outline-primary px-4 rounded-pill filter-btn"
                data-category="<?= $category['id'] ?>">
                <?= esc($category['nama_kategori']) ?>
            </button>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Gallery Masonry -->
    <div class="row gallery g-4" id="gallery-container" data-masonry='{"percentPosition": true}'>
        <?php foreach ($galleries as $photo) : 
            // Handle multiple photos if stored as comma-separated
            $photos = explode(',', $photo['foto']);
            foreach ($photos as $img) :
        ?>
        <div class="col-sm-6 col-md-4 col-lg-3 gallery-item" data-category="<?= $photo['kategori_id'] ?>">
            <div class="card h-100 border-0 shadow-sm overflow-hidden hover-effect">
                <a href="<?= base_url($img) ?>" data-lightbox="gallery-<?= $photo['id'] ?>"
                    data-title="<?= esc($photo['nama_foto']) ?> - <?= esc($photo['deskripsi']) ?>">
                    <div class="gallery-image-container">
                        <img src="<?= base_url($img) ?>" class="card-img-top img-fluid"
                            alt="<?= esc($photo['nama_foto']) ?>" loading="lazy">
                        <div class="image-overlay">
                            <i class="fas fa-search-plus overlay-icon"></i>
                        </div>
                    </div>
                </a>
                <div class="card-body">
                    <h5 class="card-title fw-bold text-primary"><?= esc($photo['nama_foto']) ?></h5>
                    <p class="card-text"><?= esc($photo['deskripsi']) ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="far fa-calendar-alt me-1"></i>
                            <?= date('d M Y', strtotime($photo['tanggal_diambil'])) ?>
                        </small>

                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1) : ?>
    <nav aria-label="Gallery pagination" class="mt-5">
        <ul class="pagination justify-content-center">
            <li class="page-item <?= ($currentPage == 1) ? 'disabled' : '' ?>">
                <a class="page-link rounded-pill mx-1" href="?page=<?= $currentPage - 1 ?>" aria-label="Previous">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </li>

            <?php 
            // Show limited page numbers
            $start = max(1, $currentPage - 2);
            $end = min($totalPages, $currentPage + 2);
            
            if ($start > 1) echo '<li class="page-item disabled"><span class="page-link rounded-pill mx-1">...</span></li>';
            
            for ($i = $start; $i <= $end; $i++) : ?>
            <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                <a class="page-link rounded-pill mx-1" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
            <?php endfor; 
            
            if ($end < $totalPages) echo '<li class="page-item disabled"><span class="page-link rounded-pill mx-1">...</span></li>';
            ?>

            <li class="page-item <?= ($currentPage == $totalPages) ? 'disabled' : '' ?>">
                <a class="page-link rounded-pill mx-1" href="?page=<?= $currentPage + 1 ?>" aria-label="Next">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>

</div>

<style>
/* Gallery Enhancements */
.gallery-image-container {
    position: relative;
    overflow: hidden;
    height: 250px;
}

.gallery-image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(42, 92, 130, 0.7);
    opacity: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: opacity 0.3s ease;
}

.overlay-icon {
    color: white;
    font-size: 2rem;
    transform: scale(0.8);
    transition: transform 0.3s ease;
}

.hover-effect:hover .gallery-image-container img {
    transform: scale(1.05);
}

.hover-effect:hover .image-overlay {
    opacity: 1;
}

.hover-effect:hover .overlay-icon {
    transform: scale(1);
}

.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 12px !important;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
}

/* Pagination Enhancements */
.page-item.active .page-link {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.page-link {
    color: var(--primary-color);
    border: 1px solid #dee2e6;
    min-width: 40px;
    text-align: center;
}

.page-link:hover {
    color: var(--secondary-color);
    background-color: #f8f9fa;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .gallery-image-container {
        height: 200px;
    }

    .btn-group {
        flex-wrap: wrap;
        gap: 8px;
    }

    .btn-group .btn {
        flex: 1 0 auto;
    }
}
</style>

<script>
// Initialize Masonry with better performance
document.addEventListener('DOMContentLoaded', function() {
    var gallery = document.querySelector('.gallery');

    // Use imagesLoaded for better loading handling
    if (typeof imagesLoaded !== 'undefined') {
        imagesLoaded(gallery, function() {
            var msnry = new Masonry(gallery, {
                itemSelector: '.gallery-item',
                percentPosition: true,
                transitionDuration: '0.3s'
            });

            // Refresh after filter
            window.msnry = msnry;
        });
    } else {
        var msnry = new Masonry(gallery, {
            itemSelector: '.gallery-item',
            percentPosition: true,
            transitionDuration: '0.3s'
        });
        window.msnry = msnry;
    }
});

// Enhanced Filter Functionality
document.querySelectorAll('.filter-btn').forEach(button => {
    button.addEventListener('click', function() {
        // Update active button with animation
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active', 'btn-primary');
            btn.classList.add('btn-outline-primary');
        });

        this.classList.remove('btn-outline-primary');
        this.classList.add('btn-primary', 'active');

        // Add slight animation
        this.style.transform = 'scale(0.95)';
        setTimeout(() => {
            this.style.transform = 'scale(1)';
        }, 150);

        // Filter items with fade effect
        let category = this.getAttribute('data-category');
        document.querySelectorAll('.gallery-item').forEach(item => {
            if (category === 'all' || item.getAttribute('data-category') === category) {
                item.style.opacity = '0';
                item.style.display = 'block';
                setTimeout(() => {
                    item.style.opacity = '1';
                }, 50);
            } else {
                item.style.opacity = '0';
                setTimeout(() => {
                    item.style.display = 'none';
                }, 300);
            }
        });

        // Refresh Masonry layout after animation
        setTimeout(() => {
            if (window.msnry) {
                window.msnry.layout();
            }
        }, 350);
    });
});

// Enhanced Lightbox configuration
lightbox.option({
    'resizeDuration': 200,
    'wrapAround': true,
    'albumLabel': 'Gambar %1 dari %2',
    'fadeDuration': 300,
    'imageFadeDuration': 300,
    'disableScrolling': true,
    'fitImagesInViewport': true
});

// Smooth scroll to top when filtering
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        window.scrollTo({
            top: document.getElementById('gallery-container').offsetTop - 100,
            behavior: 'smooth'
        });
    });
});
</script>

<?= $this->endSection() ?>