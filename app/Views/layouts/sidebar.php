<!-- Bootstrap & Custom Style -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="<?= base_url('css/style.css') ?>" rel="stylesheet">

<?php $user = session()->get('user'); ?>
<aside class="sidebar">
    <div class="sidebar-header">
        <h4 class="fw-bold text-primary mb-0">🏫 Sistem Peminjaman</h4>
    </div>

    <nav class="sidebar-menu mt-4">
        <a href="<?= base_url('/') ?>" 
           class="sidebar-link <?= service('uri')->getSegment(1) === '' ? 'active' : '' ?>">🏠 Home</a>

        <?php if($user && $user['role'] === 'administrator'): ?>
            <a href="<?= base_url('administrator/users/index') ?>" 
               class="sidebar-link <?= service('uri')->getSegment(2) === 'users' ? 'active' : '' ?>">👥 Manajemen User</a>
            <a href="<?= base_url('ruang/index') ?>" 
               class="sidebar-link <?= service('uri')->getSegment(1) === 'ruang' ? 'active' : '' ?>">🏫 Manajemen Ruang</a>
            <a href="<?= base_url('laporan') ?>" 
               class="sidebar-link <?= service('uri')->getSegment(1) === 'laporan' ? 'active' : '' ?>">📄 Generate Laporan</a>
            <a href="<?= base_url('peminjaman/history') ?>" class="sidebar-link">🕓 Riwayat Peminjaman</a>
            <a href="<?= base_url('petugas/peminjaman_daftar') ?>" class="sidebar-link">📋 Daftar Peminjaman</a>

        <?php elseif($user && $user['role'] === 'petugas'): ?>
            <a href="<?= base_url('petugas/peminjaman_daftar') ?>" 
               class="sidebar-link <?= service('uri')->getSegment(2) === 'peminjaman_daftar' ? 'active' : '' ?>">📋 Daftar Peminjaman</a>
            <a href="<?= base_url('peminjaman/history') ?>" class="sidebar-link">🕓 Riwayat Peminjaman</a>
            <a href="<?= base_url('laporan') ?>" 
               class="sidebar-link <?= service('uri')->getSegment(1) === 'laporan' ? 'active' : '' ?>">📄 Generate Laporan</a>

        <?php elseif($user && $user['role'] === 'peminjam'): ?>
            <a href="<?= base_url('peminjaman/ajukan') ?>" 
               class="sidebar-link <?= service('uri')->getSegment(2) === 'ajukan' ? 'active' : '' ?>">📝 Pengajuan Peminjaman</a>
        <?php endif; ?>

        <a href="<?= base_url('jadwal/index') ?>" 
           class="sidebar-link <?= service('uri')->getSegment(1) === 'jadwal' ? 'active' : '' ?>">📅 Jadwal Ruang</a>

        <a href="<?= base_url('profile') ?>" 
           class="sidebar-link <?= service('uri')->getSegment(1) === 'profile' ? 'active' : '' ?>">👤 Profile</a>

        <a href="<?= base_url('kontak') ?>" 
           class="sidebar-link text-danger fw-semibold <?= service('uri')->getSegment(1) === 'kontak' ? 'active' : '' ?>">📞 Kontak Petugas</a>
    </nav>

    <?php if($user): ?>
    <div class="sidebar-footer mt-auto pt-4 text-center">
        <!-- 🔹 Tambahkan Foto Profil di sini -->
        <div class="profile-img-container mb-2">
            <img src="<?= base_url('images/profile/' . ($user['foto'] ?? 'default.jpeg')) ?>" 
                 alt="Foto Profil" 
                 class="sidebar-profile-img"
                 onerror="this.src='<?= base_url('images/profile/default.jpeg') ?>'">
        </div>

        <div class="fw-semibold text-dark small mb-1"><?= esc($user['username']) ?></div>
        <div class="text-muted small mb-2">(<?= esc($user['role']) ?>)</div>
        <a href="<?= base_url('auth/logout') ?>" class="btn btn-outline-danger w-100 btn-sm">Logout</a>
    </div>
    <?php endif; ?>
</aside>
