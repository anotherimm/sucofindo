<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Monitoring Pengajuan TOR</title>
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

        #confirmDeleteModal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        #confirmDeleteModal.show {
            display: flex;
        }

        .w-1 {
            width: 3%;
        }

        .w-2 {
            width: 40%;
        }

        .w-3 {
            width: 40%;
        }

        .w-4 {
            width: 17%;
        }

        td {
            word-wrap: break-word;
            word-break: break-all;
        }
    </style>
</head>

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
        </div>
    </div>

    <div class="fixed top-20 left-0 h-full w-36 bg-blue-700 text-white py-6 pl-4 pr-6 font-medium shadow-md flex flex-col items-center">
        <div class="flex items-center justify-center w-full bg-blue-500 p-2 rounded-full mb-5 mt-4">
            <img src="/images/profile.png" alt="Profile" class="h-7 w-6 mr-2">
            <div class="font-bold"><?php echo session()->get('username'); ?></div>
        </div>
        <ul class="space-y-2 w-full flex flex-col items-center">
            <li><a href="<?= base_url('admin/dashboard') ?>" class="block py-1 px-2 rounded-md underline-effect">Beranda</a></li>
        </ul>
        <ul class="space-y-2 w-full flex flex-col items-center mt-5">
            <li><a href="<?= base_url('adminDatakepala') ?>" class="block py-1 px-2 rounded-md underline-effect">Data Kepala</a></li>
        </ul>
        <ul class="space-y-2 w-full flex flex-col items-center mt-5">
            <li><a href="<?= base_url('adminPenerima') ?>" class="block py-1 px-2 rounded-md underline-effect active">Penerima</a></li>
        </ul>
        <ul class="space-y-2 w-full flex flex-col items-center mt-5">
            <li><a href="<?= base_url('adminDatapengguna') ?>" class="block py-1 px-2 rounded-md underline-effect">Pengguna</a></li>
        </ul>
        <ul class="space-y-2 w-full flex flex-col items-center mt-5">
            <li><a href="/panduanAdmin.pdf" class="block py-1 px-2 rounded-md underline-effect">Panduan</a></li>
        </ul>

    </div>

    <div class="fixed bottom-4 left-4">
        <a href="/auth/logout" class="flex items-center justify-center bg-gradient-to-r from-blue-500 to-blue-700 rounded-full py-2 px-4 font-bold text-white max-w-[8rem]">
            <img src="/images/logoLogout.png" alt="Logout" class="h-5 mr-2">
            Logout
        </a>
    </div>

    <!-- Main Content -->
    <div class="mt-24 ml-36 p-6">
        <div class="container mx-auto">

            <div class="flex justify-between items-center mb-6">
                <div class="flex ">
                    <a href="/adminTambahpenerima" class="bg-cyan-500 text-white border-none py-2 px-4 mr-2 rounded cursor-pointer hover:bg-cyan-600 transition bg-blue-600 sm:hidden">+</a>
                    <a href="/adminTambahpenerima" class="hidden sm:block bg-cyan-500 text-white border-none py-2 px-4 rounded cursor-pointer hover:bg-cyan-600 transition bg-blue-600">+ Tambah Penerima</a>
                </div>
                <div class="flex items-center">
                    <input type="text" id="search" class="border border-gray-300 rounded py-1 px-2 w-80" placeholder="Cari Nama Penerima" oninput="searchTable()">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table id="tableData" class="w-full table-auto bg-white shadow-md rounded-lg">
                    <thead>
                        <tr class="bg-blue-600 text-white text-center">
                            <th class="w-1 border p-3">No</th>
                            <th class="w-2 border p-3">Nama Penerima</th>
                            <th class="w-3 border p-3">Role</th>
                            <th class="w-4 border p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($penerima) && is_array($penerima)) : ?>
                            <?php foreach ($penerima as $index => $item) : ?>
                                <tr>
                                    <td class="border p-3 text-center"><?= $index + 1 ?></td>
                                    <td class="py-2 px-4 border-b"><?= esc($item['nama_penerima']) ?></td>
                                    <td class="py-2 px-4 border-b"><?= esc($item['role']) ?></td>
                                    <td class="border p-3 text-center relative">
                                        <button onclick="showEditModal(this)" class="bg-yellow-500 text-white border-none py-1 px-3 rounded cursor-pointer edit-button" data-id="<?= $item['id'] ?>" data-nama-penerima="<?= $item['nama_penerima'] ?>" data-role="<?= $item['role'] ?>">
                                            Edit
                                        </button>
                                        <button class="bg-red-500 text-white border-none py-1 px-3 rounded cursor-pointer" data-id="<?= $item['id'] ?>" data-nama-penerima="<?= $item['nama_penerima'] ?>" data-role="<?= $item['role'] ?>" onclick=" confirmDeleteDocument(this)">Hapus</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="4" class="border p-3 text-center">Tidak ada data</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Penghapusan Data -->
    <div id="confirmDeleteModal" class="modal-bg flex justify-center items-center">
        <div class="modal bg-white p-6 rounded shadow-md">
            <h3 class="text-lg font-bold">Konfirmasi Penghapusan</h3>
            <p class="mt-4">Apakah Anda yakin ingin menghapus dokumen ini?</p>
            <div class="flex justify-end mt-4">
                <button class="bg-red-500 text-white px-4 py-2 rounded mr-2" onclick="deleteDocument()">Hapus</button>
                <button class="bg-gray-500 text-white px-4 py-2 rounded" onclick="closeConfirmDeleteModal()">Batal</button>
            </div>
        </div>
    </div>


    <!-- Modal for Edit -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-1/2">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="text-lg font-bold">Edit Nama Penerima</h3>
                <button class="text-black" onclick="closeEditModal()">✖</button>
            </div>
            <div class="mt-4">
                <form id="editForm" action="<?= base_url('adminPenerima/updateNamapenerima') ?>" method="post">
                    <input type="hidden" id="editId" name="id">
                    <div class="mb-4">
                        <label for="namaPenerima" class="block text-sm font-medium text-gray-700">Nama Penerima:</label>
                        <input type="text" id="namaPenerima" name="namaPenerima" class="mt-1 block w-full border border-gray-300 rounded py-2 px-3 shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" class="bg-gray-500 text-white border-none py-1 px-4 rounded cursor-pointer" onclick="closeEditModal()">Cancel</button>
                        <button type="submit" class="bg-blue-600 text-white border-none py-1 px-4 rounded cursor-pointer ml-2">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Popup Berhasil Update -->
    <div id="successPopup" class="popup-bg flex justify-center items-center fixed inset-0 hidden z-50">
        <div class="popup-content bg-white p-6 rounded shadow-md max-w-sm mx-auto text-center">
            <div class="check-icon-container" style="border: 4px solid #10b981; border-radius: 50%; width: 4rem; height: 4rem; display: flex; justify-content: center; align-items: center; margin: 0 auto 1rem;">
                <svg class="check-icon" style="color: #10b981; width: 2rem; height: 2rem;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 6L9 17l-5-5"></path>
                </svg>
            </div>
            <h3 style="margin-bottom: 1rem; font-size: 1.5rem; font-weight: bold; color: #333;">Data Berhasil Diupdate!</h3>
            <p style="margin-bottom: 1.5rem; font-size: 1rem; color: #666;">Data Anda telah berhasil diperbarui.</p>
        </div>
    </div>




    <!-- New Popup for Deletion Success -->
    <div id="popupHapus" class="popup-bg flex justify-center items-center fixed inset-0 hidden z-50">
        <div class="popup-contenthapus bg-white p-6 rounded shadow-md max-w-sm mx-auto text-center">
            <div class="check-icon-container" style="border: 4px solid #10b981; border-radius: 50%; width: 4rem; height: 4rem; display: flex; justify-content: center; align-items: center; margin: 0 auto 1rem;">
                <svg class="check-icon" style="color: #10b981; width: 2rem; height: 2rem;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 6L9 17l-5-5"></path>
                </svg>
            </div>
            <h3 style="margin-bottom: 1rem; font-size: 1.5rem; font-weight: bold; color: #333;">Data Berhasil Dihapus!</h3>
            <p style="margin-bottom: 1.5rem; font-size: 1rem; color: #666;">Data Anda telah berhasil dihapus dari database.</p>
        </div>
    </div>

    <script>
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


        // Function to show edit modal
        function showEditModal(id, nama_penerima, role) {
            document.getElementById('editId').value = id;
            document.getElementById('namaPenerima').value = '';
            document.getElementById('editModal').classList.remove('hidden');
        }

        // Event listener for each edit button in the table
        var editButtons = document.querySelectorAll('.edit-button');
        editButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var id = this.getAttribute('data-id');
                var namaPenerima = this.getAttribute('data-nama-penerima');
                showEditModal(id, namaPenerima);
            });
        });

        // Function to show success popup
        function showSuccessPopup() {
            document.getElementById('successPopup').classList.remove('hidden');
            setTimeout(function() {
                closeSuccessPopup(); // Tutup popup sukses setelah 3 detik
            }, 500);
        }

        // Fungsi untuk menutup popup sukses
        function closeSuccessPopup() {
            document.getElementById("successPopup").classList.add("hidden"); // Sembunyikan popup sukses
        }


        // Event listener for edit form submission
        document.getElementById('editForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var id = document.getElementById('editId').value;
            var namaPenerima = document.getElementById('namaPenerima').value;

            var formData = new FormData();
            formData.append('id', id);
            formData.append('namaPenerima', namaPenerima);

            fetch('<?= base_url("adminPenerima/updateNamapenerima") ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        showSuccessPopup();
                        // Update table without reloading the page
                        var row = document.querySelector(`button[data-id='${id}']`).closest('tr');
                        row.querySelectorAll('td')[1].textContent = namaPenerima;

                        closeEditModal();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });

        // Function to close edit modal
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }


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
                fetch("<?= base_url('adminPenerima/deleteDocument') ?>", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: new URLSearchParams({
                            'id': documentIdToDelete
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            openPopupHapus(); // Tampilkan popup sukses
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
        function openPopupHapus() {
            document.getElementById("popupHapus").classList.remove("hidden"); // Tampilkan popup sukses
            setTimeout(function() {
                closePopupHapus(); // Tutup popup sukses setelah 3 detik
            }, 500);
        }

        // Fungsi untuk menutup popup sukses
        function closePopupHapus() {
            document.getElementById("popupHapus").classList.add("hidden"); // Sembunyikan popup sukses
        }
    </script>
</body>

</html>