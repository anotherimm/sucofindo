<?php

namespace App\Controllers;

use App\Models\TambahDataModel;
use App\Models\TambahTorModel;
use App\Models\TambahBudgetModel;
use App\Models\TambahPpbjModel;
use App\Models\BidangModel;
use App\Models\TambahSuratpesananModel;
use App\Models\TambahSpphModel;
use App\Models\TambahKontrakModel;
use App\Models\TambahUmkModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RekapController extends BaseController
{
    // Method untuk menampilkan rekap bulanan
    public function bulanan()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $model = new TambahDataModel();
        $sortOrder = $this->request->getGet('sort_order') ?? 'desc';
        $selectedMonth = $this->request->getGet('month') ?? date('Y-m');

        // Pastikan urutkan data sebelum mengambil hasil
        $model->orderBy('created_at', $sortOrder);
        $data['documents'] = $model->where("DATE_FORMAT(tanggal, '%Y-%m')", $selectedMonth)->findAll();
        $data['selectedMonth'] = $selectedMonth;

        return view('rekap_bulanan', $data);
    }

    // Method untuk menampilkan rekap tahunan
    public function tahunan()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $model = new TambahDataModel();
        $sortOrder = $this->request->getGet('sort_order') ?? 'desc';
        $selectedYear = $this->request->getGet('year') ?? date('Y');

        // Pastikan urutkan data sebelum mengambil hasil
        $model->orderBy('created_at', $sortOrder);
        $data['documents'] = $model->where("DATE_FORMAT(tanggal, '%Y')", $selectedYear)->findAll();
        $data['selectedYear'] = $selectedYear;

        return view('rekap_tahunan', $data);
    }

    // Method untuk mendapatkan detail dokumen
    public function getDocumentDetails()
    {
        $id = $this->request->getVar('id');
        $dataModel = new TambahDataModel();
        $torModel = new TambahTorModel();
        $budgetModel = new TambahBudgetModel();
        $ppbjModel = new TambahPpbjModel();
        $bidangModel = new BidangModel();
        $suratpesananModel = new TambahSuratpesananModel();
        $umkModel = new TambahUmkModel();
        $spphModel = new TambahSpphModel();
        $kontrakModel = new TambahKontrakModel();

        // Ambil data dokumen berdasarkan ID
        $document = $dataModel->find($id);

        if (!$document) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Document not found']);
        }

        // Ambil data TOR, Budgeting, dan PPBJ yang terkait
        $torDetails = $torModel->where('tambahdata_id', $id)->first();
        $budgetDetails = $budgetModel->where('tambahdata_id', $id)->first();
        $ppbjDetails = $ppbjModel->where('tambahdata_id', $id)->first();
        $suratpesananDetails = $suratpesananModel->where('tambahdata_id', $id)->first();
        $umkDetails = $umkModel->where('tambahdata_id', $id)->first();
        $spphDetails = $spphModel->where('tambahdata_id', $id)->first();
        $kontrakDetails = $kontrakModel->where('tambahdata_id', $id)->first();

        // Ambil nama_kepala dari kepala_bidang berdasarkan ID KABID
        $kabidId = $document['KABID'];
        $bidangData = $bidangModel->find($kabidId);
        $namaKepala = $bidangData['nama_kepala'] ?? '';

        // Format harga satuan, total harga, dan nilai-nilai lainnya
        function formatRupiah($angka)
        {
            return 'Rp ' . number_format($angka, 0, ',', '.');
        }

        $document['harga_satuan'] = formatRupiah($document['harga_satuan']);
        $document['total_harga'] = formatRupiah($document['total_harga']);
        $ppbjDetails['nilai_ppbj'] = formatRupiah($ppbjDetails['nilai_ppbj'] ?? 0);
        $suratpesananDetails['harga_pesanan'] = formatRupiah($suratpesananDetails['harga_pesanan'] ?? 0);
        $umkDetails['harga_umk'] = formatRupiah($umkDetails['harga_umk'] ?? 0);
        $kontrakDetails['harga_kontrak'] = formatRupiah($kontrakDetails['harga_kontrak'] ?? 0);

        // Gabungkan data dokumen dengan data lainnya
        $data = array_merge(
            $document,
            $torDetails ?? [],
            $budgetDetails ?? [],
            $ppbjDetails ?? [],
            $suratpesananDetails ?? [],
            $umkDetails ?? [],
            $spphDetails ?? [],
            $kontrakDetails ?? [],
            ['nama_kepala' => $namaKepala]
        );

        // Kembalikan data dalam format JSON
        return $this->response->setJSON($data);
    }

    // Method untuk mengekspor data ke Excel
    public function exportToExcel()
{
    $month = $this->request->getGet('month');
    $model = new TambahDataModel();
    $documents = $model->where("DATE_FORMAT(tanggal, '%Y-%m')", $month)->findAll();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set header
    $headers = [
        'No', 'Nama Barang/Jasa', 'Jenis Dokumen', 'Nama Bidang/Portofolio',
        'Jumlah', 'Harga Satuan', 'Total Harga', 'Tanggal Dikirim TOR', 
        'Tanggal Diterima TOR', 'Penerima Dokumen TOR', 'Tanggal Masuk Budget', 
        'Tanggal Diterima Setelah Budgeting', 'Penerima Dokumen Budget', 'Nomor PPBJ',
        'Tanggal PPBJ', 'Nilai PPBJ', 'Tanggal Pelimpahan', 'Penerima Dokumen PPBJ',
        'Nomor Pesanan', 'Tanggal Pesanan', 'Harga Pesanan', 'Nama Vendor',
        'Tanggal UMK', 'Harga UMK', 'Vendor UMK', 'Nomor SPPH', 'Tanggal SPPH',
        'Nama Vendor 1', 'Nama Vendor 2', 'Nama Vendor 3', 'Nomor Kontrak',
        'Tanggal Kontrak', 'Vendor Pemenang', 'Harga Kontrak'
    ];

    $column = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($column . '1', $header);
        $column++;
    }

    // Populate data
    $row = 2;
    foreach ($documents as $index => $document) {
        $sheet->setCellValue('A' . $row, $index + 1);
        $sheet->setCellValue('B' . $row, $document['nama_dokumen']);
        $sheet->setCellValue('C' . $row, $document['jenis_dokumen']);
        $sheet->setCellValue('D' . $row, $document['nama_bidang']);
        $sheet->setCellValue('E' . $row, $document['jumlah']);
        $sheet->setCellValue('F' . $row, $document['harga_satuan']);
        $sheet->setCellValue('G' . $row, $document['total_harga']);

        // Ambil detail dokumen
        $documentId = $document['id'];
        $detailData = $this->getDocumentDetail($documentId);

        // Menulis detail dokumen ke kolom terpisah
        $sheet->setCellValue('H' . $row, $detailData['tor']['tanggal_dikirim'] ?? '');
        $sheet->setCellValue('I' . $row, $detailData['tor']['tanggal_diterima'] ?? '');
        $sheet->setCellValue('J' . $row, $detailData['tor']['penerima_dokumen'] ?? '');
        $sheet->setCellValue('K' . $row, $detailData['budget']['tanggal_masuk_budget'] ?? '');
        $sheet->setCellValue('L' . $row, $detailData['budget']['tanggal_diterima_setelah_budgeting'] ?? '');
        $sheet->setCellValue('M' . $row, $detailData['budget']['penerima_dokumen_budget'] ?? '');
        $sheet->setCellValue('N' . $row, $detailData['ppbj']['nomor_ppbj'] ?? '');
        $sheet->setCellValue('O' . $row, $detailData['ppbj']['tanggal_ppbj'] ?? '');
        $sheet->setCellValue('P' . $row, $detailData['ppbj']['nilai_ppbj'] ?? '');
        $sheet->setCellValue('Q' . $row, $detailData['ppbj']['tanggal_pelimpahan'] ?? '');
        $sheet->setCellValue('R' . $row, $detailData['ppbj']['penerima_dokumenppbj'] ?? '');
        $sheet->setCellValue('S' . $row, $detailData['suratpesanan']['nomor_pesanan'] ?? '');
        $sheet->setCellValue('T' . $row, $detailData['suratpesanan']['tanggal_pesanan'] ?? '');
        $sheet->setCellValue('U' . $row, $detailData['suratpesanan']['harga_pesanan'] ?? '');
        $sheet->setCellValue('V' . $row, $detailData['suratpesanan']['nama_vendor'] ?? '');
        $sheet->setCellValue('W' . $row, $detailData['umk']['tanggal_umk'] ?? '');
        $sheet->setCellValue('X' . $row, $detailData['umk']['harga_umk'] ?? '');
        $sheet->setCellValue('Y' . $row, $detailData['umk']['vendor_umk'] ?? '');
        $sheet->setCellValue('Z' . $row, $detailData['spph']['nomor_spph'] ?? '');
        $sheet->setCellValue('AA' . $row, $detailData['spph']['tanggal_spph'] ?? '');
        $sheet->setCellValue('AB' . $row, $detailData['spph']['nama_vendor1'] ?? '');
        $sheet->setCellValue('AC' . $row, $detailData['spph']['nama_vendor2'] ?? '');
        $sheet->setCellValue('AD' . $row, $detailData['spph']['nama_vendor3'] ?? '');
        $sheet->setCellValue('AE' . $row, $detailData['kontrak']['nomor_kontrak'] ?? '');
        $sheet->setCellValue('AF' . $row, $detailData['kontrak']['tanggal_kontrak'] ?? '');
        $sheet->setCellValue('AG' . $row, $detailData['kontrak']['vendor_pemenang'] ?? '');
        $sheet->setCellValue('AH' . $row, $detailData['kontrak']['harga_kontrak'] ?? '');

        $row++;
    }

    // Auto size columns
    foreach (range('A', 'AH') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // Add borders
    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ],
        ],
    ];
    $sheet->getStyle('A1:AH' . ($row - 1))->applyFromArray($styleArray);

    // Create a writer and output the file
    $writer = new Xlsx($spreadsheet);
    $filename = 'Rekap_Bulanan_' . date('Y-m', strtotime($month)) . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit();
}
public function exportToExcelTahunan()
{
    $year = $this->request->getGet('year');
    $model = new TambahDataModel();
    $documents = $model->where("DATE_FORMAT(tanggal, '%Y')", $year)->findAll();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set header
    $headers = [
        'No', 'Nama Barang/Jasa', 'Jenis Dokumen', 'Nama Bidang/Portofolio',
        'Jumlah', 'Harga Satuan', 'Total Harga', 'Tanggal Dikirim TOR', 
        'Tanggal Diterima TOR', 'Penerima Dokumen TOR', 'Tanggal Masuk Budget', 
        'Tanggal Diterima Setelah Budgeting', 'Penerima Dokumen Budget', 'Nomor PPBJ',
        'Tanggal PPBJ', 'Nilai PPBJ', 'Tanggal Pelimpahan', 'Penerima Dokumen PPBJ',
        'Nomor Pesanan', 'Tanggal Pesanan', 'Harga Pesanan', 'Nama Vendor',
        'Tanggal UMK', 'Harga UMK', 'Vendor UMK', 'Nomor SPPH', 'Tanggal SPPH',
        'Nama Vendor 1', 'Nama Vendor 2', 'Nama Vendor 3', 'Nomor Kontrak',
        'Tanggal Kontrak', 'Vendor Pemenang', 'Harga Kontrak'
    ];

    $column = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($column . '1', $header);
        $column++;
    }

    // Populate data
    $row = 2;
    foreach ($documents as $index => $document) {
        $sheet->setCellValue('A' . $row, $index + 1);
        $sheet->setCellValue('B' . $row, $document['nama_dokumen']);
        $sheet->setCellValue('C' . $row, $document['jenis_dokumen']);
        $sheet->setCellValue('D' . $row, $document['nama_bidang']);
        $sheet->setCellValue('E' . $row, $document['jumlah']);
        $sheet->setCellValue('F' . $row, $document['harga_satuan']);
        $sheet->setCellValue('G' . $row, $document['total_harga']);

        // Ambil detail dokumen
        $documentId = $document['id'];
        $detailData = $this->getDocumentDetail($documentId);

        // Menulis detail dokumen ke kolom terpisah
        $sheet->setCellValue('H' . $row, $detailData['tor']['tanggal_dikirim'] ?? '');
        $sheet->setCellValue('I' . $row, $detailData['tor']['tanggal_diterima'] ?? '');
        $sheet->setCellValue('J' . $row, $detailData['tor']['penerima_dokumen'] ?? '');
        $sheet->setCellValue('K' . $row, $detailData['budget']['tanggal_masuk_budget'] ?? '');
        $sheet->setCellValue('L' . $row, $detailData['budget']['tanggal_diterima_setelah_budgeting'] ?? '');
        $sheet->setCellValue('M' . $row, $detailData['budget']['penerima_dokumen_budget'] ?? '');
        $sheet->setCellValue('N' . $row, $detailData['ppbj']['nomor_ppbj'] ?? '');
        $sheet->setCellValue('O' . $row, $detailData['ppbj']['tanggal_ppbj'] ?? '');
        $sheet->setCellValue('P' . $row, $detailData['ppbj']['nilai_ppbj'] ?? '');
        $sheet->setCellValue('Q' . $row, $detailData['ppbj']['tanggal_pelimpahan'] ?? '');
        $sheet->setCellValue('R' . $row, $detailData['ppbj']['penerima_dokumenppbj'] ?? '');
        $sheet->setCellValue('S' . $row, $detailData['suratpesanan']['nomor_pesanan'] ?? '');
        $sheet->setCellValue('T' . $row, $detailData['suratpesanan']['tanggal_pesanan'] ?? '');
        $sheet->setCellValue('U' . $row, $detailData['suratpesanan']['harga_pesanan'] ?? '');
        $sheet->setCellValue('V' . $row, $detailData['suratpesanan']['nama_vendor'] ?? '');
        $sheet->setCellValue('W' . $row, $detailData['umk']['tanggal_umk'] ?? '');
        $sheet->setCellValue('X' . $row, $detailData['umk']['harga_umk'] ?? '');
        $sheet->setCellValue('Y' . $row, $detailData['umk']['vendor_umk'] ?? '');
        $sheet->setCellValue('Z' . $row, $detailData['spph']['nomor_spph'] ?? '');
        $sheet->setCellValue('AA' . $row, $detailData['spph']['tanggal_spph'] ?? '');
        $sheet->setCellValue('AB' . $row, $detailData['spph']['nama_vendor1'] ?? '');
        $sheet->setCellValue('AC' . $row, $detailData['spph']['nama_vendor2'] ?? '');
        $sheet->setCellValue('AD' . $row, $detailData['spph']['nama_vendor3'] ?? '');
        $sheet->setCellValue('AE' . $row, $detailData['kontrak']['nomor_kontrak'] ?? '');
        $sheet->setCellValue('AF' . $row, $detailData['kontrak']['tanggal_kontrak'] ?? '');
        $sheet->setCellValue('AG' . $row, $detailData['kontrak']['vendor_pemenang'] ?? '');
        $sheet->setCellValue('AH' . $row, $detailData['kontrak']['harga_kontrak'] ?? '');

        $row++;
    }

    // Auto size columns
    foreach (range('A', 'AH') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // Add borders
    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ],
        ],
    ];
    $sheet->getStyle('A1:AH' . ($row - 1))->applyFromArray($styleArray);

    // Create a writer and output the file
    $writer = new Xlsx($spreadsheet);
    $filename = 'Rekap_Tahunan_' . $year . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit();
}


    // Method untuk mengambil detail dokumen
    private function getDocumentDetail($documentId)
    {
        $torModel = new TambahTorModel();
        $budgetModel = new TambahBudgetModel();
        $ppbjModel = new TambahPpbjModel();
        $suratpesananModel = new TambahSuratpesananModel();
        $umkModel = new TambahUmkModel();
        $spphModel = new TambahSpphModel();
        $kontrakModel = new TambahKontrakModel();

        // Ambil data detail dokumen
        $torDetails = $torModel->where('tambahdata_id', $documentId)->first();
        $budgetDetails = $budgetModel->where('tambahdata_id', $documentId)->first();
        $ppbjDetails = $ppbjModel->where('tambahdata_id', $documentId)->first();
        $suratpesananDetails = $suratpesananModel->where('tambahdata_id', $documentId)->first();
        $umkDetails = $umkModel->where('tambahdata_id', $documentId)->first();
        $spphDetails = $spphModel->where('tambahdata_id', $documentId)->first();
        $kontrakDetails = $kontrakModel->where('tambahdata_id', $documentId)->first();

        return [
            'tor' => $torDetails ?? [],
            'budget' => $budgetDetails ?? [],
            'ppbj' => $ppbjDetails ?? [],
            'suratpesanan' => $suratpesananDetails ?? [],
            'umk' => $umkDetails ?? [],
            'spph' => $spphDetails ?? [],
            'kontrak' => $kontrakDetails ?? [],
        ];
    }

}
