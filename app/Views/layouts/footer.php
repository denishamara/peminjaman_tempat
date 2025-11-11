  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
  // ✅ Toggle Sidebar Mobile
  const sidebar = document.getElementById('sidebar');
  const openBtn = document.getElementById('openSidebar');
  const closeBtn = document.getElementById('toggleSidebar');

  openBtn?.addEventListener('click', () => sidebar.classList.add('active'));
  closeBtn?.addEventListener('click', () => sidebar.classList.remove('active'));
  </script>
</body>
</html>
