    </div> <!-- End main-wrapper -->
    
    <!-- Modern Footer -->
    <footer class="glass-card mx-3 mb-3 p-4" style="position: relative; z-index: 1;">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <h5 class="gradient-text fw-bold mb-2">
                        <i class="fas fa-building me-2"></i>
                        Sistem Peminjaman Tempat
                    </h5>
                    <p class="text-muted small mb-0">
                        <i class="fas fa-heart text-danger me-1"></i>
                        Dibuat dengan penuh dedikasi untuk kemudahan Anda
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="d-flex justify-content-center justify-content-md-end gap-3 mb-2">
                        <a href="#" class="text-decoration-none" title="Facebook">
                            <i class="fab fa-facebook-f text-primary fs-5"></i>
                        </a>
                        <a href="#" class="text-decoration-none" title="Instagram">
                            <i class="fab fa-instagram text-danger fs-5"></i>
                        </a>
                        <a href="#" class="text-decoration-none" title="Twitter">
                            <i class="fab fa-twitter text-info fs-5"></i>
                        </a>
                        <a href="#" class="text-decoration-none" title="Email">
                            <i class="fas fa-envelope text-warning fs-5"></i>
                        </a>
                    </div>
                    <p class="text-muted small mb-0">
                        <i class="fas fa-copyright me-1"></i>
                        <?= date('Y') ?> All Rights Reserved
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Scripts -->
    <script>
        // Smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.glass-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.6s ease';
            observer.observe(card);
        });

        // Auto dismiss alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    </script>
</body>
</html>
