<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>📅 Kalender Peminjaman Ruangan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
  <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
  const calendarEl = document.getElementById('calendar');
  const ruangSelect = document.getElementById('ruangSelect');

  let calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    locale: 'id',
    height: 'auto',
    events: '<?= base_url("jadwal/getKalenderData") ?>',
    eventDisplay: 'block',
    eventTextColor: '#fff',
    eventDidMount: function(info) {
      // Tooltip keterangan tambahan
      new bootstrap.Tooltip(info.el, {
        title: info.event.title,
        placement: 'top',
        trigger: 'hover',
        container: 'body'
      });
    }
  });

  calendar.render();

  // Ketika dropdown ruang diganti
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
</body>
</html>
