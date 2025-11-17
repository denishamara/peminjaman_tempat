<?php namespace App\Controllers;

use App\Models\BookingModel;
use Dompdf\Dompdf;

class LaporanController extends BaseController
{
    protected $bookingModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
    }

    // Halaman filter laporan
    public function index()
{
    $session = session();
    $user = $session->get('user');

    // Ambil filter dari GET
    $tanggalMulai   = $this->request->getGet('tanggal_mulai') ?? '';
    $tanggalSelesai = $this->request->getGet('tanggal_selesai') ?? '';
    $status         = $this->request->getGet('status') ?? '';
    $hari           = $this->request->getGet('hari') ?? '';
    $bulan          = $this->request->getGet('bulan') ?? '';
    $tahun          = $this->request->getGet('tahun') ?? '';

    // Query dasar
    $query = $this->bookingModel
        ->select('booking.*, user.username, room.nama_room')
        ->join('user', 'user.id_user = booking.id_user')
        ->join('room', 'room.id_room = booking.id_room')
        ->orderBy('booking.id_booking', 'DESC');

    // Filter tanggal
    if (!empty($tanggalMulai) && !empty($tanggalSelesai)) {
        $query->where('tanggal_mulai >=', $tanggalMulai)
              ->where('tanggal_selesai <=', $tanggalSelesai);
    }

    // Filter status
    if (!empty($status)) {
        $query->where('booking.status', $status);
    }

    // Filter bulan
    if (!empty($bulan)) {
        $query->where('MONTH(tanggal_mulai)', $bulan);
    }

    // Filter tahun
    if (!empty($tahun)) {
        $query->where('YEAR(tanggal_mulai)', $tahun);
    }

    $bookings = $query->findAll();

    return view('laporan/filter', [
        'user' => $user,
        'tanggalMulai' => $tanggalMulai,
        'tanggalSelesai' => $tanggalSelesai,
        'status' => $status,
        'bulan' => $bulan,
        'tahun' => $tahun,
        'bookings' => $bookings
    ]);
}

    // Generate laporan PDF
    public function generate()
{
    $tanggalMulai   = $this->request->getPost('tanggal_mulai');
    $tanggalSelesai = $this->request->getPost('tanggal_selesai');
    $status         = $this->request->getPost('status');
    $bulan          = $this->request->getPost('bulan');
    $tahun          = $this->request->getPost('tahun');

    $query = $this->bookingModel
        ->select('booking.*, user.username, room.nama_room')
        ->join('user', 'user.id_user = booking.id_user')
        ->join('room', 'room.id_room = booking.id_room');

    // Filter tanggal
    if (!empty($tanggalMulai) && !empty($tanggalSelesai)) {
        $query->where('tanggal_mulai >=', $tanggalMulai)
              ->where('tanggal_selesai <=', $tanggalSelesai);
    }

    // Filter status (PERBAIKAN DARI FILTER HARI)
    if (!empty($status)) {
        $query->where('booking.status', $status);
    }

    // Filter bulan
    if (!empty($bulan)) {
        $query->where('MONTH(tanggal_mulai)', $bulan);
    }

    // Filter tahun
    if (!empty($tahun)) {
        $query->where('YEAR(tanggal_mulai)', $tahun);
    }

    $bookings = $query->orderBy('booking.id_booking', 'DESC')->findAll();

    $session = session();
    $user = $session->get('user');

    $html = view('laporan/pdf', [
        'bookings'      => $bookings,
        'tanggalMulai'  => $tanggalMulai,
        'tanggalSelesai'=> $tanggalSelesai,
        'status'        => $status,  // PERBAIKAN: mengirim status ke view
        'bulan'         => $bulan,
        'tahun'         => $tahun,
        'user'          => $user
    ]);

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream("laporan_peminjaman.pdf", ["Attachment" => true]);
}


}
