<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pegawai - Monitoring Pengajuan TOR</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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

        .table-fixed {
            table-layout: fixed;
        }

        .w-1 {
            width: 4%;
        }

        .w-5 {
            width: 10%;
        }

        .w-3 {
            width: 10%;
        }

        .w-4 {
            width: 15%;
        }

        .w-2 {
            width: 21%;
        }

        .w-6 {
            width: 40%;
        }

        td {
            word-wrap: break-word;
            word-break: break-all;
        }

        .username-container {
            max-width: 8rem;
            /* Adjust as needed */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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

        footer {
            background-color: #f8f8f8;
            color: #32a852;
            padding: 1rem;
            text-align: center;
            width: 100%;
            position: fixed;
            bottom: 0;
            left: 144;
            height: 50px;
            /* Adjust as needed */
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Header -->
    <div class="bg-white py-4 px-6 shadow-md fixed top-0 left-0 right-0 z-50">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <img src="/images/logosci.png" alt="Logo" class="h-12 mr-3">
                <h2 class="font-bold text-xl relative pb-2"> <!-- Menambahkan padding bottom pada judul -->
                    Monitoring Pengajuan TOR
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-yellow-400 to-transparent"></div>
                </h2>
            </div>
            <button id="hamburger-menu" class="md:hidden text-gray-600 focus:outline-none">

            </button>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="fixed top-20 left-0 h-full w-36 bg-blue-700 text-white py-6 pl-4 pr-6 font-medium shadow-md flex flex-col items-center">
        <div class="flex items-center justify-center w-full bg-blue-500 p-2 rounded-full mb-5 mt-4">
            <img src="/images/profile.png" alt="Profile" class="h-7 w-6 mr-2">
            <div class="username-container font-bold"><?php echo session()->get('username'); ?></div>
        </div>
        <ul class="space-y-2">
            <li><a href="/user/dashboard" class="block py-1 px-2 rounded-md underline-effect active">Beranda</a></li>
        </ul>

    </div>

    <!-- Logout Button -->
    <div class="fixed bottom-4 left-4 z-50">
        <a href="/auth/logout" class="flex items-center justify-center bg-gradient-to-r from-blue-500 to-blue-700 rounded-full py-2 px-4 font-bold text-white max-w-[8rem]">
            <img src="/images/logoLogout.png" alt="Logout" class="h-5 mr-2">
            Logout
        </a>
    </div>



    <!-- Main Content -->
    <div class="mt-20 ml-36 p-6">
        <div class=" container mx-auto">
            <div class="flex justify-between items-center mb-6">
                <a href="/userTambah" class="bg-cyan-500 text-white border-none py-2 px-4 mr-2 rounded cursor-pointer hover:bg-cyan-600 transition bg-blue-600 sm:hidden">+</a>
                <a href="/userTambah" class="hidden sm:block bg-cyan-500 text-white border-none py-2 px-4 rounded cursor-pointer hover:bg-cyan-600 transition bg-blue-600">+ Tambah Dokumen</a>
                <div class="flex items-center space-x-4">
                    <input type="text" id="search" class="border border-gray-300 rounded py-1 px-2 w-80" placeholder="Cari dokumen" oninput="searchTable()">
                    <input type="date" id="date-picker" class="border border-gray-300 rounded py-1 px-2 w-10" onchange="filterByDate()">

                    <button onclick="clearDateFilter()" class="border border-none rounded py-1 px-2 bg-blue-600  text-white hover:bg-blue-500">All</button>
                </div>
            </div>
            <table id="tableData" class="w-full table-auto bg-white shadow-md rounded-lg">
                <thead>
                    <tr class="bg-blue-600 text-white">
                        <th class="w-1 border p-3 text-left">No</th>
                        <th class="w-1 border p-3 text-left">ID</th>
                        <th class="w-2 border p-3 text-left">Nama Barang/Jasa</th>
                        <th class="w-3 border p-3 text-left">Jenis Dokumen</th>
                        <th class="w-4 border p-3 text-left">Nama Bidang/Portofolio</th>
                        <th class="w-5 border p-3 text-left">Aksi</th>
                        <th class="w-6 border p-3 text-left">Tracking Dokumen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dokumen as $index => $dokumenItem) : ?>
                        <tr>
                            <td class="border p-3"><?= $index + 1 ?></td>
                            <td class="border p-3"><?= $dokumenItem['id'] ?></td>
                            <td class="border p-3"><?= $dokumenItem['nama_dokumen'] ?></td>
                            <td class="border p-3"><?= $dokumenItem['jenis_dokumen'] ?></td>
                            <td class="border p-3"><?= $dokumenItem['nama_bidang'] ?></td>
                            <td class="border p-3 relative">
                                <button class="bg-blue-600 text-white border-none py-1 px-3 rounded cursor-pointer" data-id="<?= $dokumenItem['id'] ?>" onclick="fetchDocumentDetails(this)">
                                    ☰
                                </button>
                                <button class="bg-gray-200 border-none py-1 px-3 rounded cursor-pointer dropdown-btn">▼</button>
                                <div class="dropdown-content absolute right-0 mt-2 py-2 w-48 bg-white rounded-md shadow-lg">
                                    <a href="/prosesTor?tambahdata_id=<?= $dokumenItem['id'] ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Proses TOR</a>
                                    <a href="/prosesBudgeting?tambahdata_id=<?= $dokumenItem['id'] ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Proses Budgeting</a>
                                    <a href="/prosesPpbj?tambahdata_id=<?= $dokumenItem['id'] ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Proses PPBJ</a>
                                </div>
                            </td>
                            <!-- Contoh tampilan status -->
                            <td class="border p-3">
                                <div class="flex justify-between">
                                    <!-- Proses TOR -->
                                    <div class="relative text-center">
                                        <!-- Lingkaran default abu-abu -->
                                        <div class="inline-block w-8 h-8 rounded-full bg-gray-300 text-white font-bold flex items-center justify-center mx-auto">1</div>
                                        <!-- Overlay untuk warna status -->
                                        <div class="absolute inset-0 w-8 h-8 rounded-full flex items-center justify-center mx-auto <?= empty($dokumenItem['status_tor']) || $dokumenItem['status_tor'] == null || $dokumenItem['status_tor'] == '' ? '' : ($dokumenItem['status_tor'] == 'pending' ? 'bg-orange-500' : ($dokumenItem['status_tor'] == 'syarat_tidak_terpenuhi' ? 'bg-red-500' : 'bg-green-500')) ?> text-white font-bold">
                                            <span><?= !empty($dokumenItem['status_tor']) ? '1' : '' ?></span>
                                        </div>
                                        <div class="text-xs text-gray-600 mt-2">PROSES TOR</div>
                                    </div>

                                    <!-- Proses Budgeting -->
                                    <div class="relative text-center">
                                        <div class="inline-block w-8 h-8 rounded-full bg-gray-300 text-white font-bold flex items-center justify-center mx-auto">2</div>
                                        <div class="absolute inset-0 w-8 h-8 rounded-full flex items-center justify-center mx-auto <?= empty($dokumenItem['status_budgeting']) || $dokumenItem['status_budgeting'] == null || $dokumenItem['status_budgeting'] == '' ? '' : ($dokumenItem['status_budgeting'] == 'pending' ? 'bg-orange-500' : ($dokumenItem['status_budgeting'] == 'syarat_tidak_terpenuhi' ? 'bg-red-500' : 'bg-green-500')) ?> text-white font-bold">
                                            <span><?= !empty($dokumenItem['status_budgeting']) ? '2' : '' ?></span>
                                        </div>
                                        <div class="text-xs text-gray-600 mt-2">BUDGETING</div>
                                    </div>

                                    <!-- Proses PPBJ -->
                                    <div class="relative text-center">
                                        <div class="inline-block w-8 h-8 rounded-full bg-gray-300 text-white font-bold flex items-center justify-center mx-auto">3</div>
                                        <div class="absolute inset-0 w-8 h-8 rounded-full flex items-center justify-center mx-auto <?= empty($dokumenItem['status_ppbj']) || $dokumenItem['status_ppbj'] == null || $dokumenItem['status_ppbj'] == '' ? '' : ($dokumenItem['status_ppbj'] == 'pending' ? 'bg-orange-500' : ($dokumenItem['status_ppbj'] == 'syarat_tidak_terpenuhi' ? 'bg-red-500' : 'bg-green-500')) ?> text-white font-bold">
                                            <span><?= !empty($dokumenItem['status_ppbj']) ? '3' : '' ?></span>
                                        </div>
                                        <div class="text-xs text-gray-600 mt-2">PROSES PPBJ</div>
                                    </div>

                                    <!-- Proses Pesan -->
                                    <div class="relative text-center">
                                        <div class="inline-block w-8 h-8 rounded-full bg-gray-300 text-white font-bold flex items-center justify-center mx-auto">4</div>
                                        <div class="absolute inset-0 w-8 h-8 rounded-full flex items-center justify-center mx-auto <?= empty($dokumenItem['status_pesan']) || $dokumenItem['status_pesan'] == null || $dokumenItem['status_pesan'] == '' ? '' : ($dokumenItem['status_pesan'] == 'pending' ? 'bg-orange-500' : ($dokumenItem['status_pesan'] == 'syarat_tidak_terpenuhi' ? 'bg-red-500' : 'bg-green-500')) ?> text-white font-bold">
                                            <span><?= !empty($dokumenItem['status_pesan']) ? '4' : '' ?></span>
                                        </div>
                                        <div class="text-xs text-gray-600 mt-2">PROSES PESAN</div>
                                    </div>

                                    <!-- Proses Selesai -->
                                    <div class="relative text-center">
                                        <div class="inline-block w-8 h-8 rounded-full bg-gray-300 text-white font-bold flex items-center justify-center mx-auto">5</div>
                                        <div class="absolute inset-0 w-8 h-8 rounded-full flex items-center justify-center mx-auto <?= empty($dokumenItem['status_selesai']) || $dokumenItem['status_selesai'] == null || $dokumenItem['status_selesai'] == '' ? '' : ($dokumenItem['status_selesai'] == 'pending' ? 'bg-orange-500' : ($dokumenItem['status_selesai'] == 'syarat_tidak_terpenuhi' ? 'bg-red-500' : 'bg-green-500')) ?> text-white font-bold">
                                            <span><?= !empty($dokumenItem['status_selesai']) ? '5' : '' ?></span>
                                        </div>
                                        <div class="text-xs text-gray-600 mt-2">PROSES SELESAI</div>
                                    </div>
                                </div>
                            </td>

                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>

    <!-- Link ke dokument detail -->
    <?php include 'userDokdetail.php'; ?>
    <!-- Include footer -->
    <?= $this->include('footer'); ?>

    <!-- Link the JavaScript file -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hamburgerMenu = document.getElementById('hamburger-menu');
            const mobileSidebar = document.getElementById('mobile-sidebar');

            hamburgerMenu.addEventListener('click', function() {
                mobileSidebar.classList.toggle('hidden');
            });

        });
        document.getElementById('hamburger-menu').addEventListener('click', function() {
            document.getElementById('mobile-sidebar').classList.toggle('hidden');
        });

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

            const date = urlParams.get('date') || '';

            const datePickerElement = document.getElementById('date-picker');


            datePickerElement.value = date;
        }

        // Panggil fungsi saat halaman dimuat
        window.addEventListener('DOMContentLoaded', (event) => {
            loadFilters();
        });

        function formatRupiah(angka) {
            let number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return 'Rp. ' + rupiah;
        }

        function removeFormat(angka) {
            return angka.replace(/[^\d]/g, '');
        }



        function clearDateFilter() {
            document.getElementById('date-picker').value = '';
            const search = document.getElementById('search').value;
            const url = new URL(window.location.href);
            url.searchParams.delete('date');
            url.searchParams.set('search', search);
            window.location.href = url.toString();
        }

        document.getElementById('date-picker').addEventListener('change', function() {
            console.log('Selected date:', this.value);
        });


        // Dropdown menu script
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

        // Search functionality
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