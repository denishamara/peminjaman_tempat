<?php namespace App\Controllers;

use App\Models\BookingModel;
use Dompdf\Dompdf;
use Dompdf\Options;

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

    // Generate laporan PDF - FIXED VERSION
    public function generate()
    {
        try {
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

            $bookings = $query->orderBy('booking.id_booking', 'DESC')->findAll();

            $session = session();
            $user = $session->get('user');

            // Setup Dompdf dengan options
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true); // Enable untuk load external resources
            $options->set('defaultFont', 'Arial');
            $options->set('isPhpEnabled', true);
            $options->set('chroot', FCPATH); // Set chroot ke public folder

            $dompdf = new Dompdf($options);

            $html = view('laporan/pdf', [
                'bookings'      => $bookings,
                'tanggalMulai'  => $tanggalMulai,
                'tanggalSelesai'=> $tanggalSelesai,
                'status'        => $status,
                'bulan'         => $bulan,
                'tahun'         => $tahun,
                'user'          => $user
            ]);

            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            
            // Render PDF dengan timeout lebih lama
            $dompdf->render();

            // Output PDF
            $filename = "laporan_peminjaman_" . date('Y-m-d_H-i-s') . ".pdf";
            $dompdf->stream($filename, [
                "Attachment" => true,
                "compress" => true
            ]);

            exit;

        } catch (\Exception $e) {
            // Log error
            log_message('error', 'PDF Generation Error: ' . $e->getMessage());
            
            // Fallback untuk mobile - return JSON response
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal generate PDF: ' . $e->getMessage()
                ]);
            }
            
            // Redirect back dengan error message
            session()->setFlashdata('error', 'Gagal generate PDF: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    // Alternative method untuk mobile
    public function generateMobile()
    {
        try {
            $tanggalMulai   = $this->request->getPost('tanggal_mulai');
            $tanggalSelesai = $this->request->getPost('tanggal_selesai');
            $status         = $this->request->getPost('status');
            $bulan          = $this->request->getPost('bulan');
            $tahun          = $this->request->getPost('tahun');

            $query = $this->bookingModel
                ->select('booking.*, user.username, room.nama_room')
                ->join('user', 'user.id_user = booking.id_user')
                ->join('room', 'room.id_room = booking.id_room');

            if (!empty($tanggalMulai) && !empty($tanggalSelesai)) {
                $query->where('tanggal_mulai >=', $tanggalMulai)
                      ->where('tanggal_selesai <=', $tanggalSelesai);
            }

            if (!empty($status)) {
                $query->where('booking.status', $status);
            }

            if (!empty($bulan)) {
                $query->where('MONTH(tanggal_mulai)', $bulan);
            }

            if (!empty($tahun)) {
                $query->where('YEAR(tanggal_mulai)', $tahun);
            }

            $bookings = $query->orderBy('booking.id_booking', 'DESC')->findAll();

            // Simple HTML untuk mobile
            $html = $this->generateSimplePDF($bookings, $tanggalMulai, $tanggalSelesai, $status, $bulan, $tahun);

            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', false); // Disable remote untuk stability
            $options->set('defaultFont', 'Arial');
            $options->set('isPhpEnabled', false); // Disable PHP untuk security

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();

            $filename = "laporan_peminjaman_mobile_" . date('Y-m-d_H-i-s') . ".pdf";
            $dompdf->stream($filename, ["Attachment" => true]);

            exit;

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal generate PDF: ' . $e->getMessage()
            ]);
        }
    }

    private function generateSimplePDF($bookings, $tanggalMulai, $tanggalSelesai, $status, $bulan, $tahun)
    {
        $user = session()->get('user');
        
        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Laporan Peminjaman Ruangan</title>
            <style>
                body { font-family: Arial, sans-serif; font-size: 10px; margin: 15px; }
                h1, h2, h4 { text-align: center; margin: 0; padding: 0; }
                h1 { font-size: 16px; margin-bottom: 3px; }
                h2 { font-size: 14px; margin-bottom: 3px; }
                h4 { font-size: 12px; margin-bottom: 10px; }
                .header-info { margin: 10px 0; padding: 8px; background: #f5f5f5; border-radius: 5px; }
                table { width: 100%; border-collapse: collapse; margin-top: 8px; font-size: 9px; }
                table, th, td { border: 1px solid #333; }
                th, td { padding: 4px 5px; text-align: left; }
                th { background-color: #e0e0e0; font-weight: bold; }
                .footer { margin-top: 20px; text-align: right; font-size: 9px; }
                .text-center { text-align: center; }
            </style>
        </head>
        <body>
            <h1>SMKN 1 Bantul</h1>
            <h2>Smart Room</h2>
            <h4>Laporan Peminjaman Ruangan</h4>

            <div class="header-info">
                <strong>Periode:</strong> ' . (!empty($tanggalMulai) && !empty($tanggalSelesai) ? $tanggalMulai . " s/d " . $tanggalSelesai : 'Semua') . '<br>
                <strong>Status:</strong> ' . (!empty($status) ? ucfirst($status) : 'Semua') . '<br>
                <strong>Dicetak oleh:</strong> ' . ($user['username'] ?? '-') . '<br>
                <strong>Tanggal Cetak:</strong> ' . date('d-m-Y H:i:s') . '
            </div>

            <table>
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Peminjam</th>
                        <th width="15%">Ruangan</th>
                        <th width="15%">Mulai</th>
                        <th width="15%">Selesai</th>
                        <th width="10%">Status</th>
                        <th width="25%">Keterangan</th>
                    </tr>
                </thead>
                <tbody>';

        if(!empty($bookings)) {
            $no = 1;
            foreach($bookings as $b) {
                $html .= '<tr>
                    <td class="text-center">' . $no++ . '</td>
                    <td>' . htmlspecialchars($b['username'] ?? '-') . '</td>
                    <td>' . htmlspecialchars($b['nama_room'] ?? '-') . '</td>
                    <td>' . (isset($b['tanggal_mulai']) ? date('d-m-Y H:i', strtotime($b['tanggal_mulai'])) : '-') . '</td>
                    <td>' . (isset($b['tanggal_selesai']) ? date('d-m-Y H:i', strtotime($b['tanggal_selesai'])) : '-') . '</td>
                    <td>' . (isset($b['status']) ? ucfirst($b['status']) : '-') . '</td>
                    <td>' . htmlspecialchars($b['keterangan'] ?? '-') . '</td>
                </tr>';
            }
        } else {
            $html .= '<tr><td colspan="7" class="text-center">Tidak ada data</td></tr>';
        }

        $html .= '</tbody>
            </table>

            <div class="footer">
                ' . date('d-m-Y H:i:s') . '<br>
                <strong>Admin SmartRoom</strong>
            </div>
        </body>
        </html>';

        return $html;
    }
}