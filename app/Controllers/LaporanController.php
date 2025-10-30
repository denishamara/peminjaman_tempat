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

        // Ambil filter tanggal dari GET (jika ada)
        $tanggalMulai = $this->request->getGet('tanggal_mulai') ?? '';
        $tanggalSelesai = $this->request->getGet('tanggal_selesai') ?? '';

        // Ambil semua data dulu
        $query = $this->bookingModel
            ->select('booking.*, user.username, room.nama_room')
            ->join('user', 'user.id_user = booking.id_user')
            ->join('room', 'room.id_room = booking.id_room')
            ->orderBy('booking.id_booking', 'DESC');

        // Kalau ada filter tanggal, baru disaring
        if (!empty($tanggalMulai) && !empty($tanggalSelesai)) {
            $query->where('tanggal_mulai >=', $tanggalMulai)
                  ->where('tanggal_selesai <=', $tanggalSelesai);
        }

        $bookings = $query->findAll();

        return view('laporan/filter', [
            'user' => $user,
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
            'bookings' => $bookings
        ]);
    }

    // Generate laporan PDF
    public function generate()
    {
        $tanggalMulai   = $this->request->getPost('tanggal_mulai');
        $tanggalSelesai = $this->request->getPost('tanggal_selesai');

        $query = $this->bookingModel
            ->select('booking.*, user.username, room.nama_room')
            ->join('user', 'user.id_user = booking.id_user')
            ->join('room', 'room.id_room = booking.id_room');

        if (!empty($tanggalMulai) && !empty($tanggalSelesai)) {
            $query->where('tanggal_mulai >=', $tanggalMulai)
                  ->where('tanggal_selesai <=', $tanggalSelesai);
        }

        $bookings = $query->orderBy('booking.id_booking', 'DESC')->findAll();

        $session = session();
        $user = $session->get('user');

        $html = view('laporan/pdf', [
            'bookings' => $bookings,
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
            'user' => $user
        ]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("laporan_peminjaman.pdf", ["Attachment" => true]);
    }
}
