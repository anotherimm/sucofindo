<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pegawai - Monitoring Pengajuan TOR</title>
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

        .username-container {
            max-width: 8rem;
            /* Adjust as needed */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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

<!-- Header -->

<body class="bg-gray-100">
    <div class="bg-white py-4 px-6 shadow-md fixed top-0 left-0 right-0 z-50">
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
    <div class="fixed top-20 left-0 h-full w-36 bg-blue-700 text-white py-6 pl-4 pr-6 font-medium shadow-md hidden md:flex flex-col items-center">
        <div class="flex items-center justify-center w-full bg-blue-500 p-2 rounded-full mb-5 mt-4">
            <img src="/images/profile.png" alt="Profile" class="h-7 w-6 mr-2">
            <div class="username-container font-bold"><?php echo session()->get('username'); ?></div>
        </div>
        <ul class="space-y-2">
            <li><a href="/user/dashboard" class="block py-0 px-1 rounded-md underline-effect">Beranda</a></li>
        </ul>
        <!-- Logout Button -->
        <div class="mb-10 left-4"></div>
        <div class="mt-80 mb-2 left-4">
            <a href="/auth/logout" class="flex items-center justify-center bg-gradient-to-r from-blue-500 to-blue-700 rounded-full py-2 px-4 font-bold text-white max-w-[8rem]">
                <img src="/images/logoLogout.png" alt="Logout" class="h-5 mr-2">
                Logout
            </a>
        </div>

    </div>

    <!-- Mobile Sidebar -->
    <div id="mobile-sidebar" class="fixed top-20 left-0 h-full w-1/3 bg-blue-700 text-white py-6 pl-4 pr-6 font-medium shadow-md hidden flex-col items-center md:hidden ">
        <div class="flex items-center justify-center w-full bg-blue-500 p-2 rounded-full mb-5 mt-4">
            <img src="/images/profile.png" alt="Profile" class="h-7 w-6 mr-2">
            <div class="username-container font-bold"><?php echo session()->get('username'); ?></div>
        </div>
        <ul class="space-y-2">
            <li><a href="/user/dashboard" class="block py-0 px-1 rounded-md underline-effect">Beranda</a></li>
        </ul>
        <ul class="space-y-2 mt-4">
            <a href="/auth/logout" class="block py-0 px-1 rounded-md underline-effect">
                Logout</a>
        </ul>
    </div>


    <!-- Main konten -->
    <div class="pt-28 pl-4 md:pl-48 pr-4 md:pr-10">
        <h1 class="text-3xl font-bold mb-6">TAMBAH <span class="text-blue-500">DATA</span> :</h1>
        <div class="bg-white p-6 rounded-lg shadow-md">

            <form id="tambahForm" action="/userTambah/tambahData" method="post">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nama_dokumen" class="block mb-2">Nama Barang/Jasa</label>
                        <input type="text" id="nama_dokumen" name="nama_dokumen" class="w-full border border-gray-300 rounded-md p-2">
                    </div>
                    <div>
                        <label for="tanggal" class="block mb-2">Tanggal Pembuatan TOR :</label>
                        <input type="date" id="tanggal" name="tanggal" class="w-full border border-gray-300 rounded-md p-2">
                    </div>
                    <div>
                        <label for="jenis_dokumen" class="block mb-2">Jenis Dokumen</label>
                        <select id="jenisDokumen" name="jenis_dokumen" class="w-full p-2 border border-gray-300 rounded-md">
                            <option value="">Pilih Jenis Dokumen</option>
                            <option value="TOR">TOR</option>
                            <option value="FORM KALIBRASI">FORM KALIBRASI</option>
                        </select>
                    </div>
                    <div>
                        <label for="nama_bidang" class="block mb-2">Nama Bidang/Portofolio</label>
                        <select id="nama_bidang" name="nama_bidang" class="w-full border border-gray-300 rounded-md p-2">
                            <option value="">Pilih Nama Bidang/Portofolio</option>
                            <option value="DUKBIS">DUKBIS</option>
                            <option value="BIU">BIU</option>
                            <option value="BIP">BIP</option>
                            <option value="BIT">BIT</option>
                            <option value="PDO">PDO</option>
                            <option value="KDS">KDS</option>
                            <option value="SRK">SRK</option>
                            <option value="MNGT">MNGT</option>
                        </select>
                    </div>
                    <div>
                        <label for="KABID" class="block mb-2">KABID</label>
                        <select id="KABID" name="KABID" class="w-full p-2 border border-gray-300 rounded-md">
                            <option value="">Pilih KABID</option>
                            <?php foreach ($bidangs as $bidang) : ?>
                                <option value="<?= esc($bidang['id']) ?>"><?= esc($bidang['nama_kepala']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- Tambahan kolom baru -->
                    <div>
                        <label for="jumlah" class="block mb-2">Jumlah</label>
                        <input type="number" id="jumlah" name="jumlah" class="w-full border border-gray-300 rounded-md p-2">
                    </div>
                    <div>
                        <label for="harga_satuan" class="block mb-2">Harga Satuan</label>
                        <input type="text" id="harga_satuan" name="harga_satuan" class="w-full border border-gray-300 rounded-md p-2">
                    </div>
                    <div>
                        <label for="total_harga" class="block mb-2">Total Harga</label>
                        <input type="text" id="total_harga" name="total_harga" class="w-full border border-gray-300 rounded-md p-2" readonly>
                    </div>

                </div>

                <div class="flex flex-col md:flex-row justify-end mt-4 space-y-4 md:space-y-0 md:space-x-4">
                    <button type="submit" class="w-full md:w-auto bg-blue-500 text-white py-2 px-4 rounded-md">Simpan</button>
                    <a href="/user/dashboard" class="w-full md:w-auto bg-blue-200 text-blue-700 py-2 px-4 rounded-md text-center">Kembali</a>
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
                    const jumlahInput = document.getElementById('jumlah');
                    const hargaSatuanInput = document.getElementById('harga_satuan');
                    const totalHargaInput = document.getElementById('total_harga');

                    function calculateTotalHarga() {
                        const jumlah = parseFloat(jumlahInput.value) || 0;
                        const hargaSatuan = parseFloat(hargaSatuanInput.value.replace(/[^0-9]/g, '')) || 0;
                        const totalHarga = jumlah * hargaSatuan;
                        totalHargaInput.value = `Rp ${totalHarga.toLocaleString()}`; // Tambahkan "Rp" di depan dan format angka
                    }

                    jumlahInput.addEventListener('input', calculateTotalHarga);
                    hargaSatuanInput.addEventListener('input', calculateTotalHarga);
                });
                document.addEventListener('DOMContentLoaded', function() {
                    const hargaSatuanInput = document.getElementById('harga_satuan');
                    const totalHargaInput = document.getElementById('total_harga');

                    // Format nilai awal dalam format Rupiah
                    hargaSatuanInput.value = formatRupiah(removeFormat(hargaSatuanInput.value), true);
                    totalHargaInput.value = formatRupiah(removeFormat(totalHargaInput.value), true);

                    // Tambahkan event listener untuk input
                    hargaSatuanInput.addEventListener('input', function() {
                        let value = this.value;
                        this.value = formatRupiah(removeFormat(value), true);
                    });

                    totalHargaInput.addEventListener('input', function() {
                        let value = this.value;
                        this.value = formatRupiah(removeFormat(value), true);
                    });

                    // Event listener untuk form submit
                    document.getElementById('prosesForm').addEventListener('submit', function(event) {
                        event.preventDefault(); // Mencegah pengiriman form default

                        let nilaiHargaSatuan = document.getElementById('harga_satuan');
                        let nilaiTotalHarga = document.getElementById('total_harga');

                        // Menghapus format Rupiah sebelum mengirim form
                        nilaiHargaSatuan.value = removeFormat(nilaiHargaSatuan.value);
                        nilaiTotalHarga.value = removeFormat(nilaiTotalHarga.value);

                        // Tampilkan popup setelah format dihapus
                        showPopup();

                        // Kirim form setelah 300ms
                        setTimeout(function() {
                            event.target.submit();
                        }, 300);
                    });

                    function showPopup() {
                        document.getElementById('popup').classList.remove('hidden');
                    }

                    function removeFormat(angka) {
                        return angka.replace(/[^,\d]/g, '');
                    }

                    function formatRupiah(angka, prefix) {
                        let number_string = angka.replace(/[^,\d]/g, '').toString(),
                            split = number_string.split(','),
                            sisa = split[0].length % 3,
                            rupiah = split[0].substr(0, sisa),
                            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                        if (ribuan) {
                            separator = sisa ? '.' : '';
                            rupiah += separator + ribuan.join('.');
                        }

                        return prefix ? 'Rp ' + rupiah : rupiah;
                    }


                    document.getElementById('hamburger-menu').addEventListener('click', function() {
                        document.getElementById('mobile-sidebar').classList.toggle('hidden');
                    });
                });
            </script>


</body>

</html>