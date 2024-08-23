<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Tahunan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .underline-effect {
            position: relative;
            display: inline-block;
            text-decoration: none;
        }

        .underline-effect::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0.2rem;
            background-color: #FFC630;
            transition: all 0.3s ease;
        }

        .underline-effect:hover::before {
            width: 100%;
        }

        .underline-effect.active::before {
            width: 100%;
        }

        /* Tambahkan ini di file CSS Anda */
        #documentDetailsModal .bg-white {
            max-height: 80vh;
            /* Sesuaikan tinggi maksimum sesuai kebutuhan */
            overflow-y: auto;
            /* Tambahkan scroll jika konten melebihi tinggi */
        }

        /* CSS untuk modal */
        #documentDetailsModal {
            overflow: hidden;
            /* Pastikan modal tidak scroll */
        }

        .table-fixed {
            table-layout: fixed;
        }

        .w-1 {
            width: 2%;
        }

        .w-2 {
            width: 37%;
        }

        .w-3 {
            width: 23%;
        }

        .w-4 {
            width: 23%;
        }

        .w-5 {
            width: 15%;
        }

        td {
            word-wrap: break-word;
            word-break: break-all;
        }


        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .no-print {
                display: none;
                /* Sembunyikan elemen dengan kelas no-print saat mencetak */
            }
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="bg-white py-4 px-6 shadow-md fixed top-0 left-0 right-0 z-50">
        <div class="container mx-auto flex justify-between items-center relative">
            <div class="flex items-center">
                <img src="/images/logosci.png" alt="Logo" class="h-12 mr-3">
                <h2 class="font-bold text-xl relative pb-2"> <!-- Menambahkan padding bottom pada judul -->
                    Monitoring Pengajuan TOR
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-yellow-400 to-transparent"></div>
                </h2>
            </div>
        </div>
    </div>


    <!-- Sidebar -->
    <div class="fixed top-20 left-0 h-full w-36 bg-blue-700 text-white py-6 pl-4 pr-6 font-medium shadow-md flex flex-col items-center">
        <div class="flex items-center justify-center w-full bg-blue-500 p-2 rounded-full mb-5 mt-4">
            <img src="/images/profile.png" alt="Profile" class="h-7 w-6 mr-2">
            <div class="font-bold"><?php echo session()->get('username'); ?></div>
        </div>
        <ul class="space-y-2 w-full flex flex-col items-center">
            <li><a href="<?= base_url('admin/dashboard') ?>" class="block py-1 px-2 rounded-md underline-effect active">Beranda</a></li>
        </ul>
        <ul class="space-y-2 w-full flex flex-col items-center mt-5">
            <li><a href="<?= base_url('adminDatakepala') ?>" class="block py-1 px-2 rounded-md underline-effect">Data Kepala</a></li>
        </ul>
        <ul class="space-y-2 w-full flex flex-col items-center text-center mt-5">
            <li><a href="<?= base_url('adminPenerima') ?>" class="block py-1 px-2 rounded-md underline-effect">Penerima</a></li>
        </ul>
        <!-- Menambahkan bagian baru untuk data pengguna -->
        <ul class="space-y-2 w-full flex flex-col items-center mt-5">
            <li><a href="<?= base_url('adminDatapengguna') ?>" class="block py-1 px-2 rounded-md underline-effect">Pengguna</a></li>
        </ul>


    </div>

    <!-- Logout Button -->
    <div class="fixed bottom-4 left-4 z-50">
        <a href="/auth/logout" class="flex items-center justify-center bg-gradient-to-r from-blue-500 to-blue-700 rounded-full py-2 px-4 font-bold text-white max-w-[8rem]">
            <img src="/images/logoLogout.png" alt="Logout" class="h-5 mr-2">
            Logout
        </a>
    </div>

    <div class="mt-24 ml-36 p-6">
        <div class="container mx-auto">
            <div class="flex justify-between items-center mb-4">
                <div class="flex space-x-2">
                    <a href="<?= base_url('admin/dashboard') ?>" class="bg-red-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-red-400 no-print">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <div class="relative group">
                        <button id="dropdownButton" class="bg-blue-600 text-white font-bold py-2 px-4 rounded-lg flex items-center space-x-2">
                            <span>Tahunan</span>
                            <i class="fas fa-caret-down ml-2"></i>
                        </button>
                        <div id="dropdownMenu" class="absolute right-0 mt-2 bg-white border border-gray-300 rounded-lg shadow-lg hidden">
                            <a href="/rekapBulanan" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition duration-300">Bulanan</a>
                        </div>
                    </div>
                    <a href="<?= base_url('rekap/tahunan/excel?year=' . $selectedYear) ?>" class="flex items-center text-green-600 font-semibold py-1 px-2 rounded-lg border border-green-600 hover:bg-green-600 hover:text-white transition duration-300">
                        <i class="fas fa-file-excel text-xl mr-2"></i> Unduh Excel
                    </a>

                </div>

                <form method="get" action="<?= base_url('rekap/tahunan') ?>" class="flex space-x-4 items-center">
                    <input type="number" id="year" name="year" class="border border-gray-300 rounded py-2 px-4 w-48" value="<?= $selectedYear ?>" placeholder="Tahun">
                    <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-500">Lihat</button>
                </form>
            </div>

            <h2 class="text-lg font-semibold mb-4">Rekap Dokumen untuk Tahun: <?= $selectedYear ?></h2>

            <!-- Tabel Data -->
            <table id="tableData" class="w-full table-auto bg-white shadow-md rounded-lg">
                <thead>
                    <tr class="bg-blue-600 text-white text-center">
                        <th class="w-1 border p-3">No</th>
                        <th class="w-2 border p-3">Nama Barang/Jasa</th>
                        <th class="w-3 border p-3">Jenis Dokumen</th>
                        <th class="w-4 border p-3">Nama Bidang/Portofolio</th>
                        <th class="w-5 border p-3">Proses</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($documents) && is_array($documents)) : ?>
                        <?php foreach ($documents as $index => $document) : ?>
                            <tr>
                                <td class="border p-3 text-center"><?= $index + 1 ?></td>
                                <td class="border p-3"><?= $document['nama_dokumen'] ?></td>
                                <td class="border p-3"><?= $document['jenis_dokumen'] ?></td>
                                <td class="border p-3"><?= $document['nama_bidang'] ?></td>
                                <td class="border p-3 flex justify-center items-center">
                                    <button class="bg-blue-600 text-white border-none py-1 px-3 rounded cursor-pointer" data-id="<?= $document['id'] ?>" onclick="fetchDocumentDetails(this)">
                                        ☰
                                    </button>
                                </td>

                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="7" class="border p-3 text-center">Tidak ada data</td>
                            </tr>
                        <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
    </div>

    </div>

    <!-- Link ke dokument detail -->
    <?php include 'rekapDokdetail.php'; ?>



    <script>
        document.getElementById('dropdownButton').addEventListener('click', function() {
            const dropdownMenu = document.getElementById('dropdownMenu');
            dropdownMenu.classList.toggle('hidden');
        });

        // Optional: Close the dropdown if clicking outside
        document.addEventListener('click', function(event) {
            const isClickInside = document.getElementById('dropdownButton').contains(event.target);
            const dropdownMenu = document.getElementById('dropdownMenu');
            if (!isClickInside && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });

        function printTable() {
            var printContent = document.getElementById('tableData').outerHTML;
            var win = window.open('', '', 'height=500, width=800');
            win.document.write('<html><head><title>Print Table</title>');
            win.document.write('<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">');
            win.document.write('</head><body>');
            win.document.write('<h2 class="text-lg font-semibold mb-4">Rekap Dokumen untuk Tahun: <?= $selectedYear ?></h2>');
            win.document.write(printContent);
            win.document.write('</body></html>');
            win.document.close();
            win.print();
        }


        // *** FUNGSI UNTUK PENGOLAHAN DATA ***

        // JavaScript untuk mengaktifkan tombol print
        document.addEventListener('DOMContentLoaded', function() {
            const printButton = document.getElementById('printButton');

            printButton.addEventListener('click', function() {
                // Membuka jendela cetak
                window.print();
            });
        });


        // Fungsi untuk memformat angka menjadi format Rupiah

        function removeFormat(angka) {
            return angka.replace(/[^,\d]/g, '');
        }

        // Fungsi untuk memformat nilai sebagai Rupiah
        function formatRupiah(angka) {
            if (angka === undefined || angka === null || angka === '') {
                return '';
            }
            let number_string = angka.toString().replace(/[^,\d]/g, ''),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return 'Rp ' + rupiah;
        }


        function fetchDocumentDetails(button) {
            var documentId = button.getAttribute('data-id');
            fetch(`/getDocumentDetails?id=${documentId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('namaDokumen').value = data.nama_dokumen;
                    document.getElementById('jenisDokumen').value = data.jenis_dokumen;
                    document.getElementById('namaBidang').value = data.nama_bidang;
                    document.getElementById('KABID').value = data.KABID; // Menampilkan nama KABID
                    document.getElementById('tanggal').value = data.tanggal;
                    document.getElementById('jumlah').value = data.jumlah;
                    document.getElementById('harga_satuan').value = formatRupiah(data.harga_satuan);
                    document.getElementById('total_harga').value = formatRupiah(data.total_harga);


                    // Populate TOR details if available
                    document.getElementById('tanggalDikirim').value = data.tanggal_dikirim || '';
                    document.getElementById('tanggalDiterima').value = data.tanggal_diterima || '';
                    document.getElementById('penerimaDokumen').value = data.penerima_dokumen || '';

                    document.getElementById('documentDetailsModal').classList.remove('hidden');


                    // Populate Budgeting details if available
                    document.getElementById('tanggalMasukBudget').value = data.tanggal_masuk_budget || '';
                    document.getElementById('tanggalDiterimaBudget').value = data.tanggal_diterima_setelah_budgeting || '';
                    document.getElementById('penerimaDokumenBudget').value = data.penerima_dokumen_budget || '';


                    document.getElementById('documentDetailsModal').classList.remove('hidden');


                    // Populate PPBJ details if available
                    document.getElementById('nomorPpbj').value = data.nomor_ppbj || '';
                    document.getElementById('tanggalPpbj').value = data.tanggal_ppbj || '';
                    document.getElementById('nilaiPpbj').value = formatRupiah(data.nilai_ppbj) || '';
                    document.getElementById('tanggalPelimpahan').value = data.tanggal_pelimpahan || '';
                    document.getElementById('penerimaDokumenppbj').value = data.penerima_dokumenppbj || '';


                    document.getElementById('documentDetailsModal').classList.remove('hidden');


                    // Populate Surat pesanan details if available
                    document.getElementById('nomorPesanan').value = data.nomor_pesanan || '';
                    document.getElementById('tanggalPesanan').value = data.tanggal_pesanan || '';
                    document.getElementById('nilaiPesanan').value = formatRupiah(data.harga_pesanan) || '';
                    document.getElementById('namaVendor').value = data.nama_vendor || '';


                    document.getElementById('documentDetailsModal').classList.remove('hidden');



                    // Populate Uang Muka details if available
                    document.getElementById('tanggalUmk').value = data.tanggal_umk || '';
                    document.getElementById('hargaUmk').value = formatRupiah(data.harga_umk) || '';
                    document.getElementById('vendorUmk').value = data.vendor_umk || '';


                    document.getElementById('documentDetailsModal').classList.remove('hidden');


                    // Populate SPPH details if available
                    document.getElementById('nomorSpph').value = data.nomor_spph || '';
                    document.getElementById('tanggalSpph').value = data.tanggal_spph || '';
                    document.getElementById('namaVendor1').value = data.nama_vendor1 || '';
                    document.getElementById('namaVendor2').value = data.nama_vendor2 || '';
                    document.getElementById('namaVendor3').value = data.nama_vendor3 || '';


                    document.getElementById('documentDetailsModal').classList.remove('hidden');



                    // Populate Kontrak details if available
                    document.getElementById('nomorKontrak').value = data.nomor_kontrak || '';
                    document.getElementById('tanggalKontrak').value = data.tanggal_kontrak || '';
                    document.getElementById('vendorPemenang').value = data.vendor_pemenang || '';
                    document.getElementById('hargaKontrak').value = formatRupiah(data.harga_kontrak) || '';


                    document.getElementById('documentDetailsModal').classList.remove('hidden');

                })
                .catch(error => console.error('Error fetching document details:', error));
        }

        function closeModal() {
            document.getElementById('documentDetailsModal').classList.add('hidden');
        }

        document.getElementById('hamburger-menu').addEventListener('click', function() {
            document.getElementById('mobile-sidebar').classList.toggle('hidden');
        });
    </script>

</body>

</html>