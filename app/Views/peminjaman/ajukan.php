<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Peminjaman Ruang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
            min-height: 100vh;
        }

        .peminjaman-body.has-sidebar {
            min-height: 100vh;
            padding: 40px 40px 40px 280px;
        }

        /* Page Container */
        .peminjaman-container {
            max-width: 800px;
            margin: 0 auto;
        }

        /* Card Header */
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px 20px 0 0;
            padding: 2rem;
            color: #fff;
            text-align: center;
            margin-bottom: 0;
        }

        .page-header h2 {
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .page-header p {
            margin-bottom: 0;
            opacity: 0.95;
            font-size: 1rem;
        }

        /* Form Card */
        .peminjaman-card {
            background-color: #fff;
            padding: 0;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .form-content {
            padding: 2rem;
        }

        /* Alert */
        .alert {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
        }

        .alert ul {
            text-align: left;
            margin: 0;
            padding-left: 1.5rem;
        }

        .alert li {
            margin: 0.3rem 0;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
        }

        .form-label i {
            color: #667eea;
            font-size: 1.1rem;
        }

        .form-control,
        .form-select,
        textarea {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .form-control:focus,
        .form-select:focus,
        textarea:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15);
            background: #fff;
            outline: none;
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        /* Choices.js Custom Styling */
        .choices__inner {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.5rem 1rem;
            min-height: 48px;
        }

        .choices__inner:focus,
        .choices.is-focused .choices__inner {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15);
            background: #fff;
        }

        .choices__list--dropdown {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .choices__item--selectable {
            padding: 0.75rem 1rem;
        }

        .choices__item--selectable.is-highlighted {
            background-color: #667eea;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1.5rem;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Info Box */
        .info-box {
            background: linear-gradient(135deg, #f3f4f6 0%, #e9d5ff 100%);
            border-left: 4px solid #667eea;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
        }

        .info-box p {
            margin: 0;
            color: #5b21b6;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-box i {
            font-size: 1.2rem;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .peminjaman-body.has-sidebar {
                padding: 80px 20px 40px 20px;
            }
        }

        @media (max-width: 768px) {
            .peminjaman-body.has-sidebar {
                padding: 80px 15px 30px 15px;
            }

            .page-header {
                padding: 1.5rem;
            }

            .page-header h2 {
                font-size: 1.5rem;
                flex-direction: column;
                gap: 0.5rem;
            }

            .page-header p {
                font-size: 0.9rem;
            }

            .form-content {
                padding: 1.5rem;
            }

            .form-group {
                margin-bottom: 1.25rem;
            }

            .btn-submit {
                padding: 0.9rem;
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .peminjaman-body.has-sidebar {
                padding: 70px 10px 20px 10px;
            }

            .page-header {
                padding: 1.25rem;
                border-radius: 16px 16px 0 0;
            }

            .page-header h2 {
                font-size: 1.3rem;
            }

            .form-content {
                padding: 1.25rem;
            }

            .form-control,
            .form-select,
            textarea {
                font-size: 0.95rem;
                padding: 0.65rem 0.9rem;
            }

            .form-label {
                font-size: 0.9rem;
            }

            .info-box {
                padding: 0.85rem 1rem;
            }

            .info-box p {
                font-size: 0.85rem;
            }

            .btn-submit {
                font-size: 0.95rem;
                padding: 0.85rem;
            }
        }
    </style>
</head>
<body class="peminjaman-page peminjaman-body has-sidebar">

<?= view('layouts/sidebar') ?>

<div class="peminjaman-container">
    <div class="peminjaman-card">
        <!-- Header -->
        <div class="page-header">
            <h2>
                <i class="bi bi-file-earmark-plus"></i>
                Ajukan Peminjaman Ruang
            </h2>
            <p>Isi formulir di bawah untuk mengajukan peminjaman ruangan</p>
        </div>

        <!-- Form Content -->
        <div class="form-content">
            <!-- Info Box -->
            <div class="info-box">
                <p>
                    <i class="bi bi-info-circle-fill"></i>
                    Pastikan semua data terisi dengan benar. Pengajuan akan diproses oleh petugas.
                </p>
            </div>

            <!-- Alert -->
            <?php if(session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="bi bi-exclamation-triangle me-2"></i>Terjadi Kesalahan:</strong>
                    <ul>
                        <?php foreach(session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Form -->
            <form action="<?= base_url('peminjaman/submit') ?>" method="post">
                <?= csrf_field() ?>

                <?php 
                $now = date('Y-m-d\TH:i');
                // Ambil ruang_id dari URL parameter
                $ruangIdFromUrl = $_GET['ruang_id'] ?? '';
                ?>

                <!-- Dropdown Ruang -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-door-open"></i>
                        Pilih Ruang
                    </label>
                    <select id="ruangSelect" name="id_room" class="form-select" required>
                        <option value="">-- Pilih Ruang --</option>
                        <?php foreach($rooms as $room): ?>
                            <option value="<?= esc($room['id_room']) ?>" 
                                <?= (old('id_room') == $room['id_room'] || $ruangIdFromUrl == $room['id_room']) ? 'selected' : '' ?>>
                                <?= esc($room['nama_room']) ?> - <?= esc($room['lokasi']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Tanggal Mulai -->
                <div class="form-group">
                    <label for="tanggal_mulai" class="form-label">
                        <i class="bi bi-calendar-check"></i>
                        Tanggal & Jam Mulai
                    </label>
                    <input 
                        type="datetime-local" 
                        name="tanggal_mulai" 
                        id="tanggal_mulai" 
                        class="form-control"
                        required
                        min="<?= $now ?>"
                        value="<?= old('tanggal_mulai') ? date('Y-m-d\TH:i', strtotime(old('tanggal_mulai'))) : '' ?>"
                    >
                </div>

                <!-- Tanggal Selesai -->
                <div class="form-group">
                    <label for="tanggal_selesai" class="form-label">
                        <i class="bi bi-calendar-x"></i>
                        Tanggal & Jam Selesai
                    </label>
                    <input 
                        type="datetime-local" 
                        name="tanggal_selesai" 
                        id="tanggal_selesai" 
                        class="form-control"
                        required
                        value="<?= old('tanggal_selesai') ? date('Y-m-d\TH:i', strtotime(old('tanggal_selesai'))) : '' ?>"
                    >
                </div>

                <!-- Keterangan -->
                <div class="form-group">
                    <label for="keterangan" class="form-label">
                        <i class="bi bi-pencil-square"></i>
                        Keterangan / Keperluan
                    </label>
                    <textarea 
                        name="keterangan" 
                        id="keterangan" 
                        class="form-control"
                        rows="4" 
                        placeholder="Tuliskan keperluan peminjaman ruangan Anda di sini..." 
                        required><?= old('keterangan') ?></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit">
                    <i class="bi bi-send-fill"></i>
                    Ajukan Peminjaman Sekarang
                </button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Fungsi untuk mendapatkan parameter dari URL
    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        const regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        const results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }

    // Ambil ruang_id dari URL
    const ruangIdFromUrl = getUrlParameter('ruang_id');
    
    // Jika ada ruang_id di URL, set dropdown secara otomatis
    document.addEventListener('DOMContentLoaded', function() {
        if (ruangIdFromUrl) {
            const ruangSelect = document.getElementById('ruangSelect');
            ruangSelect.value = ruangIdFromUrl;
            
            // Jika menggunakan Choices.js, update juga
            if (typeof ruangChoices !== 'undefined') {
                ruangChoices.setChoiceByValue(ruangIdFromUrl);
            }
            
            // Tampilkan pesan bahwa ruangan sudah dipilih
            console.log('Ruangan dengan ID', ruangIdFromUrl, 'telah dipilih secara otomatis');
        }

        // Validasi tanggal dinamis
        const mulaiInput = document.getElementById('tanggal_mulai');
        const selesaiInput = document.getElementById('tanggal_selesai');
        
        mulaiInput.addEventListener('change', () => {
            selesaiInput.min = mulaiInput.value;
            if (selesaiInput.value && selesaiInput.value < mulaiInput.value) {
                selesaiInput.value = '';
            }
        });

        // Inisialisasi Choices.js untuk dropdown (jika digunakan)
        if (typeof Choices !== 'undefined') {
            const ruangChoices = new Choices('#ruangSelect', {
                searchEnabled: true,
                itemSelectText: '',
                shouldSort: false
            });

            // Set pilihan lama (old value) atau dari URL
            const oldValue = '<?= old('id_room') ?>' || ruangIdFromUrl;
            if(oldValue) {
                ruangChoices.setChoiceByValue(oldValue);
            }
        }
    });
</script>

</body>
</html>
