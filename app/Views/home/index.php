<?= $this->extend('template/home') ?>
<?= $this->section('content') ?>
<div class="container py-5">
    <h2 class="text-center mb-4">Gallery Photos</h2>

    <!-- Filter Categories -->
    <div class="text-center mb-4">
        <button class="btn btn-primary filter-btn" data-category="all">All</button>
        <?php foreach ($categories as $category) : ?>
        <button class="btn btn-secondary filter-btn" data-category="<?= $category['id'] ?>">
            <?= esc($category['nama_kategori']) ?>
        </button>
        <?php endforeach; ?>
    </div>

    <!-- Gallery Masonry -->
    <div class="row" id="gallery-container">
        <?php foreach ($galleries as $photo) : ?>
        <div class="col-md-4 gallery-item" data-category="<?= $photo['kategori_id'] ?>">
            <a href="<?= base_url($photo['foto']) ?>" data-lightbox="gallery"
                data-title="<?= esc($photo['nama_foto']) ?>">
                <img src="<?= base_url($photo['foto']) ?>" class="img-fluid rounded shadow-sm">
            </a>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <nav>
        <ul class="pagination justify-content-center mt-4">
            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
            <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"> <?= $i ?> </a>
            </li>
            <?php endfor; ?>
        </ul>
    </nav>

</div>

<script>
// Filter Gallery by Category
document.querySelectorAll('.filter-btn').forEach(button => {
    button.addEventListener('click', function() {
        let category = this.getAttribute('data-category');
        document.querySelectorAll('.gallery-item').forEach(item => {
            item.style.display = (category === 'all' || item.getAttribute('data-category') ===
                category) ? 'block' : 'none';
        });
    });
});
</script>

<?= $this->endSection() ?>