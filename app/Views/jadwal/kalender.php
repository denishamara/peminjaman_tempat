<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>📅 Kalender Peminjaman Ruangan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
  <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
  <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
  <style>
    body { background-color: #f8f9fa; }
    .main-content { margin-left: 260px; padding: 30px; }
    @media (max-width: 991.98px) { .main-content { margin-left: 0; padding: 15px; } }
    .form-check-label { white-space: normal; }

    /* FIX DROPDOWN CHOICES */
    .choices__list.choices__list--dropdown {
        z-index: 999999 !important;
        position: absolute !important;
        max-height: 250px !important;
        overflow-y: auto !important; /* scroll utama */
        background: #fff !important;
        border: 1px solid #ccc !important;
        width: 100% !important;
        max-width: 300px !important;
        left: 0 !important;
    }

    /* Hilangkan scroll kedua */
    .choices__list--dropdown .choices__list {
        max-height: none !important;
        overflow-y: visible !important;
    }

    .choices {
        max-width: 300px !important;
        width: 100% !important;
    }

    @media (max-width: 576px) {
      .choices,
      .choices__list--dropdown {
        max-width: 260px !important;
      }
    }

    .choices__inner {
      padding: 6px 10px !important;
      min-height: 42px !important;
      border-radius: 8px !important;
    }
</style>
</head>

<body class="modern-dashboard">
<?= view('layouts/sidebar') ?>

<main class="main-content p-4">
  <div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="fw-bold text-primary">📆 Kalender Peminjaman Ruang</h3>
      <a href="<?= base_url('jadwal/index') ?>" class="btn btn-secondary">⬅ Kembali</a>
    </div>

    <!-- Keterangan Warna -->
    <div class="legend mb-3">
      <div class="legend-item">
        <span class="legend-color" style="background-color:#007bff;"></span> 
        Jadwal Reguler
      </div>
      <div class="legend-item">
        <span class="legend-color" style="background-color:#f0ad4e;"></span> 
        Peminjaman Proses
      </div>
      <div class="legend-item">
        <span class="legend-color" style="background-color:#28a745;"></span> 
        Peminjaman Disetujui
      </div>
    </div>

    <!-- Dropdown Pilih Ruang -->
    <div class="mb-4">
      <label for="ruangSelect" class="form-label fw-semibold">Pilih Ruangan:</label>
      <select id="ruangSelect" class="form-select" style="max-width: 300px;">
        <option value="">— Semua Ruang —</option>
        <?php foreach ($ruangs as $r): ?>
          <option value="<?= $r['id_room'] ?>" <?= ($selectedRoom == $r['id_room']) ? 'selected' : '' ?>>
            <?= esc($r['nama_room']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Kalender -->
    <div id="calendar" class="bg-white p-3 rounded shadow-sm"></div>

  </div>
</main>

<!-- 🔹 MODAL DETAIL EVENT -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="eventModalLabel">Detail Jadwal</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p><strong>Nama Jadwal:</strong> <span id="modalNama"></span></p>
        <p><strong>Ruangan:</strong> <span id="modalRuang"></span></p>
        <p><strong>Peminjam:</strong> <span id="modalUser"></span></p>
        <p><strong>Mulai:</strong> <span id="modalMulai"></span></p>
        <p><strong>Selesai:</strong> <span id="modalSelesai"></span></p>
        <p><strong>Status:</strong> <span id="modalStatus" class="badge"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const calendarEl = document.getElementById('calendar');
  const ruangSelect = document.getElementById('ruangSelect');

  let calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    locale: 'id',
    height: 'auto',
    events: '<?= base_url("jadwal/getKalenderData") ?>',
    eventDisplay: 'block', // 🟩 biar muncul kotak warna
    eventTextColor: '#fff', // teks putih di dalam kotak

    eventDidMount: function(info) {
      // Tooltip cepat (judul aja)
      new bootstrap.Tooltip(info.el, {
        title: info.event.title,
        placement: 'top',
        trigger: 'hover',
        container: 'body'
      });
    },

    // 📋 klik event -> tampilkan modal detail
    eventClick: function(info) {
      const e = info.event.extendedProps;
      const start = new Date(info.event.start).toLocaleString('id-ID');
      const end = new Date(info.event.end).toLocaleString('id-ID');

      const html = `
        <div class="modal fade" id="detailModal" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">
              <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold">Detail Jadwal</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <p><strong>Nama Jadwal:</strong> ${info.event.title}</p>
                <p><strong>Ruangan:</strong> ${e.nama_ruang ?? '-'}</p>
                <p><strong>Peminjam:</strong> ${e.peminjam ?? '-'}</p>
                <p><strong>Mulai:</strong> ${start}</p>
                <p><strong>Selesai:</strong> ${end}</p>
                <p><strong>Status:</strong> <span class="badge bg-secondary">${e.status ?? '-'}</span></p>
              </div>
              <div class="modal-footer">
                <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
              </div>
            </div>
          </div>
        </div>
      `;
      document.body.insertAdjacentHTML('beforeend', html);
      const modal = new bootstrap.Modal(document.getElementById('detailModal'));
      modal.show();
      document.getElementById('detailModal').addEventListener('hidden.bs.modal', function() {
        this.remove();
      });
    }
  });

  calendar.render();

  // 🔄 ganti ruangan
  ruangSelect.addEventListener('change', function() {
    const ruangId = this.value;
    let url = '<?= base_url("jadwal/getKalenderData") ?>';
    if (ruangId) url += '?id_room=' + ruangId;
    calendar.removeAllEvents();
    calendar.addEventSource(url);
  });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    new Choices('#ruangSelect', {
        searchEnabled: true,
        itemSelectText: '',
        removeItemButton: false,
        shouldSort: false,
    });
});
</script>
</body>
</html>
