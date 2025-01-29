// Script DataTables

$("#myTable").DataTable({
    columnDefs: [
        {
            target: -1,
            className: "dt-head-center",
        },
    ],
});

$("#myTable1").DataTable({
    columnDefs: [
        {
            target: -1,
            className: "dt-head-center",
        },
    ],
});
$("#myTable2").DataTable({
    columnDefs: [
        {
            target: -1,
            className: "dt-head-center",
        },
    ],
});



// Fungsi untuk menandai elemen sidebar yang aktif berdasarkan URL

function markActiveSidebar() {
    // Ambil URL halaman saat ini
    const currentUrl = window.location.pathname;

    // Daftar elemen sidebar yang perlu di-mark sebagai aktif
    const sidebarItems = document.querySelectorAll(".menu-item");

    sidebarItems.forEach((item) => {
        const link = item.querySelector("a");

        // Ambil atribut "href" dari tautan sidebar dan hapus domain dan protokol
        const itemUrl = link
            ? new URL(link.getAttribute("href"), window.location.origin)
                  .pathname
            : "";

        // Bandingkan URL item sidebar dengan URL halaman saat ini (hanya path-nya)
        if (currentUrl === itemUrl) {
            item.classList.add("active");
        } else {
            item.classList.remove("active");
        }
    });
}

// Panggil fungsi markActiveSidebar() saat halaman dimuat
document.addEventListener("DOMContentLoaded", markActiveSidebar);


    $(document).ready(function() {
        // Fungsi untuk menyembunyikan alert setelah beberapa detik
        function hideAlerts() {
            $('.alert').fadeOut(300, function() {
                $(this).remove();
            });
        }

        // Cek apakah ada alert 'success' dan sembunyikan setelah 5 detik
        if ($('.alert-success').length) {
            setTimeout(hideAlerts, 15000);
        }

        // Cek apakah ada alert 'warning' dan sembunyikan setelah 5 detik
        if ($('.alert-warning').length) {
            setTimeout(hideAlerts, 15000);
        }

        // Cek apakah ada alert 'error' dan sembunyikan setelah 5 detik
        if ($('.alert-danger').length) {
            setTimeout(hideAlerts, 15000);
        }
    });
