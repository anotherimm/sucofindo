<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna - Monitoring Pengajuan TOR</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom Styles */
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

        .table-fixed {
            table-layout: fixed;
        }

        .w-1 {
            width: 2%;
        }

        .w-2 {
            width: 23%;
        }

        .w-3 {
            width: 30%;
        }

        .w-4 {
            width: 30%;
        }

        .w-5 {
            width: 15%;
        }

        td {
            word-wrap: break-word;
            word-break: break-all;
        }

        #editModal,
        #confirmDeleteModal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        #editModal.show,
        #confirmDeleteModal.show {
            display: flex;
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
            <li><a href="<?= base_url('adminPenerima') ?>" class="block py-1 px-2 rounded-md underline-effect">Penerima</a></li>
        </ul>
        <ul class="space-y-2 w-full flex flex-col items-center mt-5">
            <li><a href="<?= base_url('adminDatapengguna') ?>" class="block py-1 px-2 rounded-md underline-effect active">Pengguna</a></li>
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

    <div class="mt-24 ml-36 p-6">
        <div class="container mx-auto">
            <div class="flex justify-between items-center mb-6">
                <div class="flex space-x-2">
                    <!-- Additional navigation buttons if needed -->
                </div>
                <div class="flex items-center">
                    <input type="text" id="search" class="border border-gray-300 rounded py-1 px-2 w-80" placeholder="Cari Nama Pengguna" oninput="searchTable()">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table id="tableData" class="min-w-full bg-white shadow-md rounded-lg">
                    <thead>
                        <tr class="bg-blue-600 text-white text-center">
                            <th class="w-1 border p-3">No</th>
                            <th class="w-2 border p-3">Username</th>
                            <th class="w-3 border p-3">Email</th>
                            <th class="w-4 border p-3">Password</th>
                            <th class="w-4 border p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $index => $user) : ?>
                            <tr>
                                <td class="border p-3 text-center"><?= $index + 1 ?></td>
                                <td class="border p-3"><?= esc($user['username']) ?></td>
                                <td class="border p-3"><?= esc($user['email']) ?></td>
                                <td class="border p-3"><?= esc($user['password']) ?></td>
                                <td class="border p-3 text-center relative">
                                    <button onclick="showEditModal(<?= $user['id'] ?>, '<?= esc($user['username']) ?>', '<?= esc($user['email']) ?>')" class=" bg-yellow-500 text-white rounded py-1 px-2">Edit</button>
                                    <button class="bg-red-500 text-white border-none py-1 px-3 rounded cursor-pointer" data-id="<?= $user['id'] ?>" onclick="confirmDeleteDocument(this)">Hapus</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for Edit -->
    <div id="editModal">
        <div class="bg-white rounded-lg p-6 w-1/2">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="text-lg font-bold">Edit Password</h3>
                <button class="text-black" onclick="closeEditModal()">✖</button>
            </div>
            <form id="editForm">
                <input type="hidden" id="editId" name="id">
                <div class="mb-4 mt-4">
                    <label for="newPassword" class="block text-sm font-medium text-gray-700">New Password</label>
                    <input type="password" id="newPassword" name="newPassword" class="border border-gray-300 rounded py-2 px-3 w-full">
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeEditModal()" class="bg-gray-500 text-white rounded py-2 px-4 mr-2">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white rounded py-2 px-4">Update</button>
                </div>
            </form>
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
            <h3 style="margin-bottom: 1rem; font-size: 1.5rem; font-weight: bold; color: #333;">Sukses!</h3>
            <p style="margin-bottom: 1.5rem; font-size: 1rem; color: #666;">Data berhasil diperbarui.</p>
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
        function showEditModal(id, username, email) {
            document.getElementById('editId').value = id;
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('show');
        }

        // Function to close edit modal
        function closeEditModal() {
            document.getElementById('editModal').classList.remove('show');
            document.getElementById('editModal').classList.add('hidden');
        }


        // Event listener for edit form submission
        document.getElementById('editForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);

            fetch('/adminDatapengguna/updatePassword', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json()) // Parse JSON response
                .then(data => {
                    if (data.success) {
                        showSuccessPopup(); // Show success popup
                        closeEditModal();
                        window.location.reload();
                    } else {
                        alert('Error updating password: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating password: ' + error.message);
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
                fetch("<?= base_url('adminDatapengguna/deleteDocument') ?>", { // Ganti URL dengan URL endpoint penghapusan dokumen Anda
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: "id=" + documentIdToDelete // Kirim ID dokumen sebagai data POST
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