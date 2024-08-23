<!-- Modal for Document Details -->
<div id="documentDetailsModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-60 hidden z-50">
    <div class="bg-white rounded-lg w-full max-w-7xl p-5 relative max-h-[80vh] overflow-y-auto">
        <!-- Close Button -->
        <button class="absolute top-6 right-2 text-gray-600 text-xl hover:text-gray-800 transition" onclick="closeModal()">✖</button>
        <!-- Konten Modal -->
        <div>
            <h3 class="text-2xl font-bold text-center text-gray-800 mb-3">Detail <span class="text-blue-500">Dokumen</span></h3>
            <form id="documentDetailsForm">
                <div class="overflow-x-auto">
                    <!-- Layout Flexbox untuk Detail Dokumen -->
                    <div class="flex flex-wrap gap-4">
                        <!-- Detail Dokumen Dasar -->
                        <!-- Informasi Dokumen -->
                        <div class="flex-none w-56 p-2">
                            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                                <div class="bg-blue-500 text-white text-lg font-semibold px-4 py-2">
                                    Informasi Dokumen
                                </div>
                                <div class="p-4 space-y-1">
                                    <div>
                                        <label for="namaDokumen" class="block text-sm font-medium text-gray-700">Nama Barang/Jasa:</label>
                                        <input type="text" id="namaDokumen" name="namaDokumen" class="mt-1 block w-full text-gray-900 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                    <div>
                                        <label for="jenisDokumen" class="block text-sm font-medium text-gray-700">Jenis Dokumen:</label>
                                        <input type="text" id="jenisDokumen" name="jenisDokumen" class="mt-1 block w-full text-gray-900 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                    <div>
                                        <label for="namaBidang" class="block text-sm font-medium text-gray-700">Nama Bidang:</label>
                                        <input type="text" id="namaBidang" name="namaBidang" class="mt-1 block w-full text-gray-900 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                    <div>
                                        <label for="KABID" class="block text-sm font-medium text-gray-700">KABID:</label>
                                        <input type="text" id="KABID" name="KABID" class="mt-1 block w-full text-gray-900 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                    <div>
                                        <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal:</label>
                                        <input type="text" id="tanggal" name="tanggal" class="mt-1 block w-full text-gray-900 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                    <!-- Tambahan kolom baru -->
<div>
                                        <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah:</label>
                                        <input type="number" id="jumlah" name="jumlah" class="mt-1 block w-full text-gray-900 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                    <div>
                                        <label for="harga_satuan" class="block text-sm font-medium text-gray-700">Harga Satuan:</label>
                                        <input type="text" id="harga_satuan" name="harga_satuan" class="mt-1 block w-full text-gray-900 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                    <div>
                                        <label for="total_harga" class="block text-sm font-medium text-gray-700">Total Harga:</label>
                                        <input type="text" id="total_harga" name="total_harga" class="mt-1 mb-3 block w-full text-gray-900 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Detail TOR dan Budgeting -->
                        <div class="flex-none w-56 p-2">
                            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                                <!-- Detail TOR -->
                                <div class="bg-blue-500 text-white text-lg font-semibold px-4 py-2">
                                    Detail TOR
                                </div>
                                <div class="p-4 space-y-1">
                                    <div>
                                        <label for="tanggalDikirim" class="block text-sm font-medium text-gray-700">Tanggal Dikirim:</label>
                                        <input type="text" id="tanggalDikirim" name="tanggalDikirim" class="mt-1 block w-full text-gray-900 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                    <div>
                                        <label for="tanggalDiterima" class="block text-sm font-medium text-gray-700">Tanggal Diterima:</label>
                                        <input type="text" id="tanggalDiterima" name="tanggalDiterima" class="mt-1 block w-full text-gray-900 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                    <div>
                                        <label for="penerimaDokumen" class="block text-sm font-medium text-gray-700">Penerima Dokumen:</label>
                                        <input type="text" id="penerimaDokumen" name="penerimaDokumen" class="mt-1 block w-full text-gray-900 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                </div>

                                <!-- Detail Budgeting -->
                                <div class=" rounded-lg  bg-blue-500 text-white text-lg font-semibold px-4 py-2">
                                    Detail Budgeting
                                </div>
                                <div class="p-4 space-y-1">
                                    <div>
                                        <label for="tanggalMasukBudget" class="block text-sm font-medium text-gray-700">Tanggal Masuk Budget:</label>
                                        <input type="text" id="tanggalMasukBudget" name="tanggalMasukBudget" class="mt-1 block w-full text-gray-900 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                    <div>
                                        <label for="tanggalDiterimaBudget" class="block text-sm font-medium text-gray-700">Tanggal Diterima Setelah Budgeting:</label>
                                        <input type="text" id="tanggalDiterimaBudget" name="tanggalDiterimaBudget" class="mt-1 block w-full text-gray-900 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                    <div>
                                        <label for="penerimaDokumenBudget" class="block text-sm font-medium text-gray-700">Penerima Dokumen Budget:</label>
                                        <input type="text" id="penerimaDokumenBudget" name="penerimaDokumenBudget" class="mt-1 block w-full text-gray-900 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Detail PPBJ -->
                        <div class="flex-none w-56 p-2">
                            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                                <div class="bg-blue-500 text-white text-lg font-semibold px-4 py-2">
                                    Detail PPBJ
                                </div>
                                <div class="p-4 space-y-1">
                                    <div>
                                        <label for="nomorPpbj" class="block text-sm font-medium text-gray-700">Nomor PPBJ:</label>
                                        <input type="text" id="nomorPpbj" name="nomorPpbj" class="mt-1 block w-full text-gray-900 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                    <div>
                                        <label for="tanggalPpbj" class="block text-sm font-medium text-gray-700">Tanggal PPBJ:</label>
                                        <input type="text" id="tanggalPpbj" name="tanggalPpbj" class="mt-1 block w-full text-gray-900 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                    <div>
                                        <label for="nilaiPpbj" class="block text-sm font-medium text-gray-700">Nilai PPBJ:</label>
                                        <input type="text" id="nilaiPpbj" name="nilaiPpbj" class="mt-1 block w-full text-gray-900 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                    <div>
                                        <label for="tanggalPelimpahan" class="block text-sm font-medium text-gray-700">Tanggal Pelimpahan:</label>
                                        <input type="text" id="tanggalPelimpahan" name="tanggalPelimpahan" class="mt-1 block w-full text-gray-900 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                    <div>
                                        <label for="penerimaDokumenppbj" class="block text-sm font-medium text-gray-700">Penerima Dokumen:</label>
                                        <input type="text" id="penerimaDokumenppbj" name="penerimaDokumenppbj" class="mt-1 mb-40 block w-full text-gray-900 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Surat Pesanan -->
                        <div class="flex-none w-56 p-2">
                            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                                <div class="bg-blue-500 text-white text-xl font-semibold px-4 py-2">
                                    Surat Pesanan
                                </div>
                                <div class="p-4 space-y-">
                                    <!-- Nomor Pesanan -->
                                    <div>
                                        <label for="nomorPesanan" class="block text-sm font-medium text-gray-700">Nomor Pesanan:</label>
                                        <input type="text" id="nomorPesanan" name="nomor_pesanan" class="mt-1 block w-full text-gray-900 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                    <!-- Tanggal Pesanan -->
                                    <div>
                                        <label for="tanggalPesanan" class="block text-sm font-medium text-gray-700">Tanggal Pesanan:</label>
                                        <input type="text" id="tanggalPesanan" name="tanggal_pesanan" class="mt-1 block w-full text-gray-900 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                    <!-- Harga Pesanan -->
                                    <div>
                                        <label for="nilaiPesanan" class="block text-sm font-medium text-gray-700">Harga Pesanan:</label>
                                        <input type="text" id="nilaiPesanan" name="harga_pesanan" class="mt-1 block w-full text-gray-900 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                    <!-- Nama Vendor -->
                                    <div>
                                        <label for="namaVendor" class="block text-sm font-medium text-gray-700">Nama Vendor:</label>
                                        <input type="text" id="namaVendor" name="nama_vendor" class="mt-1 block w-full text-gray-900 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                </div>
                                <!-- Uang Muka -->
                                <div class=" rounded-lg  bg-blue-500 text-white text-lg font-semibold px-4 py-2">Uang Muka</div>
                                <div class="p-4 space-y-1">
                                    <!-- Tanggal Uang Muka -->
                                    <div>
                                        <label for="tanggalUmk" class="block text-sm font-medium text-gray-900">Tanggal Uang Muka:</label>
                                        <input type="text" id="tanggalUmk" name="tanggal_umk" class="mt-1 block w-full text-gray-900 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                    <!-- Harga Uang Muka -->
                                    <div>
                                        <label for="hargaUmk" class="block text-sm font-medium text-gray-900">Harga Uang Muka:</label>
                                        <input type="text" id="hargaUmk" name="harga_umk" class="mt-1 block w-full text-gray-900 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                    <!-- Nama Vendor Uang Muka -->
                                    <div>
                                        <label for="vendorUmk" class="block text-sm font-medium text-gray-900">Nama Vendor:</label>
                                        <input type="text" id="vendorUmk" name="vendor_umk" class="mt-1 block w-full text-gray-900 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- SPPH -->
                        <div class="flex-none w-56 p-2">
                            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                                <div class="bg-blue-500 text-white text-xl font-semibold px-4 py-2">
                                    SPPH
                                </div>
                                <div class="p-4 space-y-1">
                                    <div>
                                        <label for="nomorSpph" class="block text-sm font-medium text-gray-900">Nomor SPPH:</label>
                                        <input type="text" id="nomorSpph" name="nomor_spph" class="mt-1 block w-full text-gray-800 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                    <div>
                                        <label for="tanggalSpph" class="block text-sm font-medium text-gray-900">Tanggal SPPH:</label>
                                        <input type="text" id="tanggalSpph" name="tanggal_spph" class="mt-1 block w-full text-gray-800 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                        <div>
                                            <label for="namaVendor1" class="block text-sm font-medium text-gray-900">Nama Vendor 1:</label>
                                            <input type="text" id="namaVendor1" name="nama_vendor1" class="mt-1 block w-full text-gray-800 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                        </div>
                                        <div>
                                            <label for="namaVendor2" class="block text-sm font-medium text-gray-900">Nama Vendor 2:</label>
                                            <input type="text" id="namaVendor2" name="nama_vendor2" class="mt-1 block w-full text-gray-800 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                            <div>
                                                <label for="namaVendor3" class="block text-sm font-medium text-gray-900">Nama Vendor 3:</label>
                                                <input type="text" id="namaVendor3" name="nama_vendor3" class="mt-1 mb-44 block w-full text-gray-800 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kontrak -->
                        <div class="flex-none w-56 p-2">
                            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                                <div class="bg-blue-500 text-white text-xl font-semibold px-4 py-2">
                                    Kontrak
                                </div>
                                <div class="p-4 space-y-1">
                                    <div>
                                        <label for="nomorKontrak" class="block text-sm font-medium text-gray-900">Nomor Kontrak:</label>
                                        <input type="text" id="nomorKontrak" name="nomor_kontrak" class="mt-1 block w-full text-gray-800 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                    <div>
                                        <label for="tanggalKontrak" class="block text-sm font-medium text-gray-900">Tanggal Kontrak:</label>
                                        <input type="text" id="tanggalKontrak" name="tanggal_kontrak" class="mt-1 block w-full text-gray-800 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                    <div>
                                        <label for="vendorPemenang" class="block text-sm font-medium text-gray-900">Vendor Pemenang:</label>
                                        <input type="text" id="vendorPemenang" name="vendor_pemenang" class="mt-1 block w-full text-gray-800 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                    <div>
                                        <label for="hargaKontrak" class="block text-sm font-medium text-gray-900">Harga Kontrak:</label>
                                        <input type="text" id="hargaKontrak" name="harga_kontrak" class="mt-1 mb-44 block w-full text-gray-800 text-sm border border-gray-300 rounded-md shadow-sm" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


            </form>
        </div>
    </div>
</div>
</div>