<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Monitoring Pengajuan TOR</title>
    <!-- Menggunakan Tailwind CSS dari CDN -->
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

        #popup {
            display: none;
            position: fixed;
            inset: 0;
            justify-content: center;
            align-items: center;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            transition: opacity 0.3s ease;
        }

        #popup.show {
            display: flex;
            opacity: 1;
        }

        #popup .popup-content {
            background: white;
            padding: 2rem;
            border-radius: 0.5rem;
            max-width: 90%;
            width: 400px;
            text-align: center;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.3);
            transform: translateY(-30px);
            opacity: 0;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        #popup.show .popup-content {
            transform: translateY(0);
            opacity: 1;
        }

        #popup .popup-content .check-icon-container {
            border: 4px solid #10b981;
            border-radius: 50%;
            width: 4rem;
            height: 4rem;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 1rem;
        }

        #popup .popup-content .check-icon {
            color: #10b981;
            width: 2rem;
            height: 2rem;
        }

        #popup .popup-content h3 {
            margin-bottom: 1rem;
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        #popup .popup-content p {
            margin-bottom: 1.5rem;
            font-size: 1rem;
            color: #666;
        }

        #popup .popup-content button {
            background-color: #1d4ed8;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        #popup .popup-content button:hover {
            background-color: #2563eb;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="bg-white py-4 px-6 shadow-md fixed top-0 left-0 right-0 z-40">
        <div class="container mx-auto flex justify-between items-center relative">
            <div class="flex items-center">
                <img src="/images/logosci.png" alt="Logo" class="h-12 mr-3">
                <h2 class="font-bold text-xl relative pb-2">
                    Monitoring Pengajuan TOR
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-yellow-400 to-transparent"></div>
                </h2>
            </div>
            <button id="hamburger-menu" class="block md:hidden focus:outline-none">
                <svg class="w-8 h-8 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="fixed top-20 left-0 h-full w-36 bg-blue-700 text-white py-6 pl-4 pr-6 font-medium shadow-md  hidden md:flex flex-col items-center">
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
        <ul class="space-y-2 w-full flex flex-col items-center mt-5">
            <li><a href="/panduanAdmin.pdf" class="block py-1 px-2 rounded-md underline-effect">Panduan</a></li>
        </ul>



    </div>

    <!-- Logout Button -->
    <div class="fixed bottom-4 left-4 z-50 hidden md:flex">
        <a href="/auth/logout" class="flex items-center justify-center bg-gradient-to-r from-blue-500 to-blue-700 rounded-full py-2 px-4 font-bold text-white max-w-[8rem]">
            <img src="/images/logoLogout.png" alt="Logout" class="h-5 mr-2">
            Logout
        </a>
    </div>

    <!-- Mobile Sidebar -->
    <div id="mobile-sidebarAdmin" class="fixed top-20 left-0 h-full w-1/3 bg-blue-700 text-white py-6 pl-4 pr-6 font-medium shadow-md hidden flex-col items-center md:hidden" style="z-index: 100;">
        <div class="flex items-center justify-center w-full bg-blue-500 p-2 rounded-full mb-5 mt-4">
            <img src="/images/profile.png" alt="Profile" class="h-7 w-6 mr-2">
            <div class="username-container font-bold truncate max-w-full text-center"><?php echo session()->get('username'); ?></div>
        </div>
        <ul class="space-y-2 w-full flex flex-col items-center">
            <li class="w-full">
                <a href="<?= base_url('admin/dashboard') ?>" class="block py-1 px-2 rounded-md underline-effect text-center w-full">Beranda</a>
            </li>
            <li class="w-full">
                <a href="<?= base_url('adminDatakepala') ?>" class="block py-1 px-2 rounded-md underline-effect text-center w-full">Data Kepala</a>
            </li>
            <li class="w-full">
                <a href="<?= base_url('adminPenerima') ?>" class="block py-1 px-2 rounded-md underline-effect text-center w-full">Penerima</a>
            </li>
            <li class="w-full">
                <a href="<?= base_url('adminDatapengguna') ?>" class="block py-1 px-2 rounded-md underline-effect text-center w-full">Pengguna</a>
            </li>
        </ul>
        <ul class="space-y-2 mt-4 w-full">
            <li class="w-full">
                <a href="/auth/logout" class="block py-1 px-2 rounded-md underline-effect text-center w-full">Logout</a>
            </li>
        </ul>
    </div>

    <!-- Mobile Sidebar -->
    <div id="mobile-sidebarAdmin" class="fixed top-20 left-0 h-full w-1/3 bg-blue-700 text-white py-6 pl-4 pr-6 font-medium shadow-md hidden flex-col items-center md:hidden ">
        <div class="flex items-center justify-center w-full bg-blue-500 p-2 rounded-full mb-5 mt-4">
            <img src="/images/profile.png" alt="Profile" class="h-7 w-6 mr-2">
            <div class="username-container font-bold"><?php echo session()->get('username'); ?></div>
        </div>
        <ul class="space-y-2 w-full flex flex-col items-center">
            <li><a href="<?= base_url('admin/dashboard') ?>" class="block py-1 px-2 rounded-md underline-effect">Beranda</a></li>
        </ul>
        <ul class="space-y-2 w-full flex flex-col items-center mt-5">
            <li><a href="<?= base_url('adminDatakepala') ?>" class="block py-1 px-2 rounded-md underline-effect">Data Kepala</a></li>
        </ul>
        <ul class="space-y-2 w-full flex flex-col items-center mt-5">
            <li><a href="<?= base_url('adminPenerima') ?>" class="block py-1 px-2 rounded-md underline-effect">Penerima</a></li>
        </ul>
        <ul class="space-y-2 w-full flex flex-col items-center mt-5">
            <li><a href="<?= base_url('adminDatapengguna') ?>" class="block py-1 px-2 rounded-md underline-effect">Pengguna</a></li>
        </ul>
        <ul class="space-y-2 mt-4">
            <a href="/auth/logout" class="block py-0 px-1 rounded-md underline-effect">
                Logout</a>
        </ul>
    </div>


    <!-- Main Content -->
    <div class="pt-28 pl-4 md:pl-48 pr-4 md:pr-10">
        <h1 class="text-3xl font-bold mb-6">DATA <span class="text-blue-500">MONITORING</span> :</h1>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4">SURAT PESANAN</h2>

            <form id="prosesSuratpesananForm" action="<?= base_url('adminSuratpesanan/saveSuratpesanan') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="tambahdata_id" value="<?= $form_data['tambahdata_id'] ?>" method="post" class="<?= $is_locked ? 'form-disabled' : '' ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="is_locked" value="<?= $form_data['tambahdata_id'] ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nomorPesanan" class="block mb-2">Nomor Pesanan:</label>
                        <input type="text" id="nomorPesanan" name="nomor_pesanan" value="<?= $form_data['nomor_pesanan'] ?>" class="w-full p-2 border border-gray-300 rounded-md" required <?= $is_locked ? 'disabled' : '' ?>>
                    </div>
                    <div>
                        <label for="tanggalPesanan" class="block mb-2">Tanggal Pesanan:</label>
                        <input type="date" id="tanggalPesanan" name="tanggal_pesanan" value="<?= $form_data['tanggal_pesanan'] ?>" class="w-full p-2 border border-gray-300 rounded-md" required <?= $is_locked ? 'disabled' : '' ?>>
                    </div>
                    <div>
                        <label for="hargaPesanan" class="block mb-2">Harga:</label>
                        <input type="text" id="hargaPesanan" name="harga_pesanan" value="<?= esc(old('hargaPesanan', $form_data['harga_pesanan'])) ?>" class="w-full p-2 border border-gray-300 rounded-md" required <?= $is_locked ? 'disabled' : '' ?>>
                    </div>
                    <div>
                        <label for="namaVendor" class="block mb-2">Nama Vendor:</label>
                        <input type="text" id="namaVendor" name="nama_vendor" value="<?= $form_data['nama_vendor'] ?>" class="w-full p-2 border border-gray-300 rounded-md" required <?= $is_locked ? 'disabled' : '' ?>>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row justify-end mt-4 space-y-4 md:space-y-0 md:space-x-4">
                    <a href="<?= base_url('adminSuratpesanan/resetSuratpesanan?tambahdata_id=' . $form_data['tambahdata_id']) ?>" class="w-full md:w-auto bg-gray-200 text-gray-700 py-2 px-4 rounded-md text-center">Reset</a>
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md">Simpan</button>
                    <a href="<?= base_url('admin/dashboard') ?>" class="bg-blue-200 text-blue-700 py-2 px-4 rounded-md text-center">Kembali</a>
                </div>
            </form>

            <!-- Popup -->
            <div id="popup">
                <div class="popup-content">
                    <div class="check-icon-container">
                        <svg class="check-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5"></path>
                        </svg>
                    </div>
                    <h3>Data Berhasil Disimpan!</h3>
                    <p>Data Anda telah berhasil disimpan ke database.</p>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const input = document.getElementById('hargaPesanan');

                    // Format nilai awal dalam format Rupiah
                    input.value = formatRupiah(removeFormat(input.value));

                    // Tambahkan event listener untuk input
                    input.addEventListener('input', function() {
                        let value = this.value;
                        this.value = formatRupiah(removeFormat(value));
                    });

                    // Event listener untuk form submit
                    document.getElementById('prosesSuratpesananForm').addEventListener('submit', function(event) {
                        // Mencegah pengiriman form default
                        event.preventDefault();

                        let nilaiInput = document.getElementById('hargaPesanan');

                        // Menghapus format Rupiah sebelum mengirim form
                        nilaiInput.value = removeFormat(nilaiInput.value);

                        // Tampilkan popup setelah submit form
                        showPopup();

                        setTimeout(function() {
                            // Kirim form setelah popup
                            event.target.submit();
                        }, 300);
                    });

                    // Fungsi untuk menampilkan popup
                    function showPopup() {
                        document.getElementById('popup').classList.add('show');
                    }

                    // Fungsi untuk menghapus format Rupiah
                    function removeFormat(angka) {
                        return angka.replace(/[^,\d]/g, '');
                    }

                    // Fungsi untuk memformat nilai sebagai Rupiah
                    function formatRupiah(angka) {
                        let number_string = angka.replace(/[^,\d]/g, '').toString(),
                            split = number_string.split(','),
                            sisa = split[0].length % 3,
                            rupiah = split[0].substr(0, sisa),
                            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                        if (ribuan) {
                            let separator = sisa ? '.' : '';
                            rupiah += separator + ribuan.join('.');
                        }

                        // Tidak menambahkan bagian desimal
                        return 'Rp ' + rupiah;
                    }
                });

                document.getElementById('hamburger-menu').addEventListener('click', function() {
                    document.getElementById('mobile-sidebarAdmin').classList.toggle('hidden');
                });
            </script>
        </div>
    </div>
</body>

</html>