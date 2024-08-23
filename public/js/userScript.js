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