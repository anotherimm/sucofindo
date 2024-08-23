<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Monitoring Pengajuan TOR</title>
    <meta name="csrf-token" content="<?= csrf_hash() ?>">

    <!-- Menggunakan Tailwind CSS dari CDN -->
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

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 10rem;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 0.5rem 1rem;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .modal-bg {
            display: none;
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 100%;
        }

        .table-fixed {
            table-layout: fixed;
        }

        .w-1 {
            width: 1%;
        }

        .w-2 {
            width: 30%;
        }

        .w-3 {
            width: 15%;
        }

        .w-4 {
            width: 20%;
        }

        .w-5 {
            width: 10%;
        }

        .w-6 {
            width: 15%;
        }

        .w-7 {
            width: 19%;
        }
        
         .shadow-blue {
            box-shadow: 0 0 10px rgba(0, 0, 255, 0.5);
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
        
    </style>
</head>

<!-- Header -->

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
            <!-- Bagian Navigasi -->
            <div class="flex justify-between items-center mb-6">
                <!-- Tombol Bulanan, Mingguan, Harian -->
                <div class="flex space-x-2">
                    <a href="/rekapBulanan" class="bg-blue-600 text-white font-bold border-none py-2 px-4 rounded-lg cursor-pointer">Lihat Rekap</a>


                </div>

                <!-- Bagian Filter -->
                <div class="flex space-x-4 items-center">

                    <select id="jenis_dokumen" name="jenis_dokumen" class="border border-gray-300 rounded py-1 px-2 w-48" onchange="FilterBydoc()">
                        <option value="">Jenis Dokumen</option>
                        <option value="TOR">TOR</option>
                        <option value="FORM KALIBRASI">FORM KALIBRASI</option>
                    </select>

                    <select id="nama_bidang" name="nama_bidang" class="border border-gray-300 rounded py-1 px-2 w-48" onchange="FilterBybidang()">
                        <option value="">Nama Bidang</option>
                        <option value="DUKBIS">DUKBIS</option>
                        <option value="BIU">BIU</option>
                        <option value="BIP">BIP</option>
                        <option value="BIT">BIT</option>
                        <option value="PDO">PDO</option>
                        <option value="KDS">KDS</option>
                        <option value="SRK">SRK</option>
                        <option value="MNGT">MNGT</option>
                    </select>
                    <input type="date" id="date-picker" class="border border-gray-300 rounded py-1 px-2 w-10" onchange="filterByDate()">
                    <input type="text" id="search" class="border border-gray-300 rounded py-1 px-2 w-60" placeholder="Cari dokumen" oninput="searchTable()">


                    <button onclick="clearAllFilter()" class="bg-blue-600 text-white py-1 px-2 rounded-lg hover:bg-blue-500">All</button>
                </div>
            </div>

            <!-- Tabel Data -->
            <table id="tableData" class="w-full table-auto bg-white shadow-md rounded-lg">
                <thead>
                    <tr class="bg-blue-600 text-white text-center">
                        <th class="w-1 border p-3">No</th>
                        <th class="w-2 border p-3">Nama Barang/Jasa</th>
                        <th class="w-3 border p-3">Jenis Dokumen</th>
                        <th class="w-4 border p-3">Nama Bidang/Portofolio</th>
                        <th class="w-5 border p-3">Proses</th>
                        <th class="w-6 border p-3">Tracking</th>
                        <th class="w-7 border p-3">Aksi</th>
                    </tr>
                </thead>
                
                <style>
                    .shadow-blue {
                        box-shadow: 0 0 10px rgba(0, 0, 255, 0.5);
                    }
                </style>
                <tbody>
                    <?php if (!empty($documents) && is_array($documents)) : ?>
                        <?php foreach ($documents as $index => $document) : ?>
                            <?php
                            // Tentukan apakah baris harus memiliki bayangan biru
                            $allPending = $document['status_tor'] === 'pending' &&
                                $document['status_budgeting'] === 'pending' &&
                                $document['status_ppbj'] === 'pending' &&
                                $document['status_pesan'] === 'pending' &&
                                $document['status_selesai'] === 'pending' &&
                                $document['status_spph'] === 'pending' &&
                                $document['status_pesan'] === 'pending' &&
                                $document['status_umk'] === 'pending' &&
                                $document['status_kontrak'] === 'pending';
                            $shadowClass = $allPending ? 'shadow-blue' : '';
                            ?>
                            <tr class="<?= $shadowClass ?>">
                                <td class="border p-3 text-center"><?= $index + 1 ?></td>
                                <td class="border p-3"><?= htmlspecialchars($document['nama_dokumen']) ?></td>
                                <td class="border p-3"><?= htmlspecialchars($document['jenis_dokumen']) ?></td>
                                <td class="border p-3"><?= htmlspecialchars($document['nama_bidang']) ?></td>
                                <td class="border p-3 relative">
                                    <div class="flex justify-between">
                                        <button class="bg-blue-600 text-white border-none py-1 px-3 rounded cursor-pointer" data-id="<?= htmlspecialchars($document['id']) ?>" onclick="fetchDocumentDetails(this)">
                                            ☰
                                        </button>
                                        <div class="relative inline-block text-left">
                                            <button class="bg-gray-200 border-none py-1 px-3 rounded cursor-pointer dropdown-btn">▼</button>
                                            <div class="dropdown-content absolute right-0 mt-2 py-2 w-48 bg-white rounded-md shadow-lg">
                                                <a href="/adminSuratpesanan?tambahdata_id=<?= htmlspecialchars($document['id']) ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Surat Pesanan</a>
                                                <a href="/adminUmk?tambahdata_id=<?= htmlspecialchars($document['id']) ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">UMK</a>
                                                <a href="/adminSpph?tambahdata_id=<?= htmlspecialchars($document['id']) ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">SPPH</a>
                                                <a href="/adminKontrak?tambahdata_id=<?= htmlspecialchars($document['id']) ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kontrak</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <?php if ($document['status_selesai'] === 'diterima') : ?>
                                    <td class="border p-3 text-center">
                                        <button id="update-status-btn-<?= htmlspecialchars($document['id']) ?>" class="bg-green-500 text-white py-1 px-3 rounded cursor-pointer open-modal-btn" data-id="<?= htmlspecialchars($document['id']) ?>">Selesai</button>
                                    </td>
                                <?php else : ?>
                                    <td class="border p-3 text-center">
                                        <button id="update-status-btn-<?= htmlspecialchars($document['id']) ?>" class="bg-yellow-500 text-white py-1 px-3 rounded cursor-pointer open-modal-btn" data-id="<?= htmlspecialchars($document['id']) ?>">Update Status</button>
                                    </td>
                                <?php endif; ?>
                                <td class="border p-3 text-center relative">
                                    <button class="bg-red-500 text-white border-none py-1 px-3 rounded cursor-pointer" data-id="<?= htmlspecialchars($document['id']) ?>" onclick="confirmDeleteDocument(this)">Hapus</button>
                                </td>
                            </tr>
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

    <!-- Link ke dokument detail -->
    <?php include 'adminDokdetail.php'; ?>


    <script>
        function printPopup() {
            var popupContent = document.getElementById('documentDetailsModal').innerHTML;
            var printWindow = window.open('', '', 'height=600,width=800');

            printWindow.document.open();
            printWindow.document.write(`
    <html>
    <head>
        <title>Cetak Detail Dokumen</title>
        <style>
            @media print {
                body {
                    font-size: 12pt;
                }
                .no-print {
                    display: none;
                }
            }
            /* Tambahkan CSS khusus jika diperlukan */
        </style>
    </head>
    <body>
        ${popupContent}
    </body>
    </html>
`);
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
        }

        // *** FUNGSI FILTER DAN PENCARIAN ***
        // Fungsi untuk memfilter data berdasarkan bidang
        function FilterBybidang() {
            const namaBidang = document.getElementById('nama_bidang').value;
            const search = document.getElementById('search').value.toLowerCase();
            const date = document.getElementById('date-picker').value;

            const url = new URL(window.location.href);
            url.searchParams.set('nama_bidang', namaBidang);
            url.searchParams.set('search', search);
            url.searchParams.set('date', date);
            window.location.href = url.toString();
        }

        document.getElementById('nama_bidang').addEventListener('change', FilterBybidang);



        // Fungsi untuk memfilter data berdasarkan jenis dokumen
        function FilterBydoc() {
            const jenisDokumen = document.getElementById('jenis_dokumen').value;
            const search = document.getElementById('search').value.toLowerCase();
            const date = document.getElementById('date-picker').value;

            const url = new URL(window.location.href);
            url.searchParams.set('jenis_dokumen', jenisDokumen);
            url.searchParams.set('search', search);
            url.searchParams.set('date', date);
            window.location.href = url.toString();
        }

        document.getElementById('jenis_dokumen').addEventListener('change', FilterBydoc);

        // Fungsi untuk memfilter data berdasarkan tanggal
        function filterByDate() {
            const date = document.getElementById('date-picker').value;
            const search = document.getElementById('search').value.toLowerCase();

            const url = new URL(window.location.href);
            url.searchParams.set('date', date);
            url.searchParams.set('search', search);
            window.location.href = url.toString();
        }

        document.getElementById('date-picker').addEventListener('change', filterByDate);

        // Fungsi untuk memuat nilai filter dari URL
        function loadFilters() {
            const urlParams = new URLSearchParams(window.location.search);

            const jenisDokumen = urlParams.get('jenis_dokumen') || '';
            const namaBidang = urlParams.get('nama_bidang') || '';
            const date = urlParams.get('date') || '';

            const jenisDokumenElement = document.getElementById('jenis_dokumen');
            const namaBidangElement = document.getElementById('nama_bidang');
            const datePickerElement = document.getElementById('date-picker');

            // Pastikan nilai yang diterapkan adalah salah satu dari opsi
            if ([...jenisDokumenElement.options].map(option => option.value).includes(jenisDokumen)) {
                jenisDokumenElement.value = jenisDokumen;
            } else {
                jenisDokumenElement.value = '';
            }

            if ([...namaBidangElement.options].map(option => option.value).includes(namaBidang)) {
                namaBidangElement.value = namaBidang;
            } else {
                namaBidangElement.value = '';
            }

            datePickerElement.value = date;
        }

        // Panggil fungsi saat halaman dimuat
        window.addEventListener('DOMContentLoaded', (event) => {
            loadFilters();
        });



        // Fungsi untuk menghapus semua filter
        function clearAllFilter() {
            // Reset nilai input filter
            document.getElementById('date-picker').value = '';
            document.getElementById('jenis_dokumen').value = '';
            document.getElementById('nama_bidang').value = '';
            const search = document.getElementById('search').value;

            // Update URL untuk menghapus parameter filter
            const url = new URL(window.location.href);
            url.searchParams.delete('date');
            url.searchParams.delete('jenis_dokumen');
            url.searchParams.delete('nama_bidang');
            url.searchParams.set('search', search);

            // Redirect ke URL yang sudah diperbarui
            window.location.href = url.toString();
        }



        // *** FUNGSI DROPDOWN ***

        // Menampilkan dan menyembunyikan konten dropdown
        document.addEventListener('click', function(e) {
            if (!e.target.matches('.dropdown-btn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.style.display === 'block') {
                        openDropdown.style.display = 'none';
                    }
                }
            } else {
                var dropdownContent = e.target.nextElementSibling;
                if (dropdownContent.style.display === 'block') {
                    dropdownContent.style.display = 'none';
                } else {
                    dropdownContent.style.display = 'block';
                }
            }
        });

        document.querySelectorAll('.dropdown-btn').forEach(button => {
            button.addEventListener('click', function() {
                this.nextElementSibling.classList.toggle('hidden');
            });
        });

        // Menyembunyikan dropdown saat klik di luar dropdown
        window.onclick = function(event) {
            if (!event.target.matches('.dropdown-btn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (!openDropdown.classList.contains('hidden')) {
                        openDropdown.classList.add('hidden');
                    }
                }
            }
        };

        // Fungsi pencarian di tabel
        function searchTable() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("search");
            filter = input.value.toUpperCase();
            table = document.getElementById("tableData");
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) {
                tr[i].style.display = "none";
                td = tr[i].getElementsByTagName("td");
                for (j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        }
                    }
                }
            }
        }



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


        // *** FUNGSI UNTUK PENGOLAHAN DATA ***

        // JavaScript untuk mengaktifkan tombol print
        document.addEventListener('DOMContentLoaded', function() {
            const printButton = document.getElementById('printButton');

            printButton.addEventListener('click', function() {
                // Membuka jendela cetak
                window.print();
            });
        });


        // Mengambil detail dokumen berdasarkan ID dan menampilkan di modal
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

            // Populate Budgeting details if available
            document.getElementById('tanggalMasukBudget').value = data.tanggal_masuk_budget || '';
            document.getElementById('tanggalDiterimaBudget').value = data.tanggal_diterima_setelah_budgeting || '';
            document.getElementById('penerimaDokumenBudget').value = data.penerima_dokumen_budget || '';

            // Populate PPBJ details if available
            document.getElementById('nomorPpbj').value = data.nomor_ppbj || '';
            document.getElementById('tanggalPpbj').value = data.tanggal_ppbj || '';
            document.getElementById('nilaiPpbj').value = formatRupiah(data.nilai_ppbj) || '';
            document.getElementById('tanggalPelimpahan').value = data.tanggal_pelimpahan || '';
            document.getElementById('penerimaDokumenppbj').value = data.penerima_dokumenppbj || '';

            // Populate Surat pesanan details if available
            document.getElementById('nomorPesanan').value = data.nomor_pesanan || '';
            document.getElementById('tanggalPesanan').value = data.tanggal_pesanan || '';
            document.getElementById('nilaiPesanan').value = formatRupiah(data.harga_pesanan) || '';
            document.getElementById('namaVendor').value = data.nama_vendor || '';

            // Populate Uang Muka details if available
            document.getElementById('tanggalUmk').value = data.tanggal_umk || '';
            document.getElementById('hargaUmk').value = formatRupiah(data.harga_umk) || '';
            document.getElementById('vendorUmk').value = data.vendor_umk || '';

            // Populate SPPH details if available
            document.getElementById('nomorSpph').value = data.nomor_spph || '';
            document.getElementById('tanggalSpph').value = data.tanggal_spph || '';
            document.getElementById('namaVendor1').value = data.nama_vendor1 || '';
            document.getElementById('namaVendor2').value = data.nama_vendor2 || '';
            document.getElementById('namaVendor3').value = data.nama_vendor3 || '';

            // Populate Kontrak details if available
            document.getElementById('nomorKontrak').value = data.nomor_kontrak || '';
            document.getElementById('tanggalKontrak').value = data.tanggal_kontrak || '';
            document.getElementById('vendorPemenang').value = data.vendor_pemenang || '';
            document.getElementById('hargaKontrak').value = formatRupiah(data.harga_kontrak) || '';

            document.getElementById('documentDetailsModal').classList.remove('hidden');
        })
        .catch(error => console.error('Error fetching document details:', error));
}

// Menutup modal detail dokumen
function closeDocumentDetailsModal() {
    document.getElementById('documentDetailsModal').classList.add('hidden');
}

// *** FUNGSI UNTUK UPDATE STATUS ***

// Fungsi untuk membuka modal dan mengisi data
function openModal(id) {
    document.getElementById('updateStatusModal').classList.remove('hidden');
    document.getElementById('documentId').value = id;

    // Fetch existing status values and set them in the form
    fetch(`/admin/getDocument/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('status_tor').value = data.status_tor;
            document.getElementById('status_budgeting').value = data.status_budgeting;
            document.getElementById('status_ppbj').value = data.status_ppbj;
            document.getElementById('status_umk').value = data.status_pesan;
            document.getElementById('status_pesanan').value = data.status_pesan;
            document.getElementById('status_spph').value = data.status_pesan;
            document.getElementById('status_kontrak').value = data.status_pesan;
            document.getElementById('status_selesai').value = data.status_selesai;
        });
}

// Menutup modal update status
function closeUpdateStatusModal() {
    document.getElementById('updateStatusModal').classList.add('hidden');
}


        // Fungsi untuk membuka popup sukses
        function openPopupStatus() {
            document.getElementById("statusPopup").classList.remove("hidden"); // Tampilkan popup sukses
            setTimeout(function() {
                closePopupStatus(); // Tutup popup sukses setelah 3 detik
            }, 500);
        }

        // Fungsi untuk menutup popup sukses
        function closePopupStatus() {
            document.getElementById("statusPopup").classList.add("hidden"); // Sembunyikan popup sukses
        }


        // Event listener untuk membuka modal saat tombol diklik
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.open-modal-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    openModal(id);
                });
            });
        });


        // *** FUNGSI UNTUK PENGHAPUSAN DOKUMEN ***

        let documentIdToDelete = null;

        // Fungsi untuk membuka modal konfirmasi penghapusan
        function confirmDeleteDocument(button) {
            documentIdToDelete = button.getAttribute('data-id'); // Ambil ID dokumen dari tombol yang diklik
            document.getElementById('confirmDeleteModal').style.display = 'flex'; // Tampilkan modal konfirmasi
        }

        // Fungsi untuk menghapus dokumen
        function deleteDocument() {
            if (documentIdToDelete !== null) {
                fetch("<?= base_url('admin/deleteDocument') ?>", { // Ganti URL dengan URL endpoint penghapusan dokumen Anda
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: "id=" + documentIdToDelete // Kirim ID dokumen sebagai data POST
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            openPopup(); // Tampilkan popup sukses
                            document.querySelector(`[data-id="${documentIdToDelete}"]`).closest('tr').remove(); // Hapus baris dokumen dari tabel
                        } else {
                            alert("Gagal menghapus data."); // Tampilkan pesan gagal jika penghapusan tidak berhasil
                        }
                        documentIdToDelete = null; // Reset ID dokumen yang akan dihapus
                        closeConfirmDeleteModal(); // Tutup modal konfirmasi
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert("Terjadi kesalahan saat menghapus data: " + error.message); // Tampilkan pesan kesalahan jika terjadi error
                        documentIdToDelete = null; // Reset ID dokumen yang akan dihapus
                        closeConfirmDeleteModal(); // Tutup modal konfirmasi
                    });
            }
        }

        // Fungsi untuk menutup modal konfirmasi penghapusan
        function closeConfirmDeleteModal() {
            document.getElementById('confirmDeleteModal').style.display = 'none'; // Sembunyikan modal konfirmasi
        }

        // Fungsi untuk membuka popup sukses
        function openPopup() {
            document.getElementById("popup").classList.remove("hidden"); // Tampilkan popup sukses
            setTimeout(function() {
                closePopup(); // Tutup popup sukses setelah 3 detik
            }, 500);
        }

        // Fungsi untuk menutup popup sukses
        function closePopup() {
            document.getElementById("popup").classList.add("hidden"); // Sembunyikan popup sukses
        }
    </script>
</body>

</html>