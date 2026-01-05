/**
 * Menu Active State Handler
 * Menandai menu yang sedang aktif berdasarkan URL
 */

$(document).ready(function () {
  // Ambil URL saat ini
  var currentUrl = window.location.pathname;

  // Hapus semua class active
  $("#sidebar-menu a").removeClass("active");

  // Cari menu yang sesuai dengan URL saat ini
  $("#sidebar-menu a").each(function () {
    var menuUrl = $(this).attr("href");

    // Jika URL menu sama dengan URL saat ini
    if (
      menuUrl &&
      currentUrl.includes(menuUrl.replace(window.location.origin, ""))
    ) {
      $(this).addClass("active");

      // Jika ini submenu, buka parent menu
      var parentMenu = $(this).closest(".has_sub");
      if (parentMenu.length > 0) {
        parentMenu.addClass("active");
        parentMenu.find("> ul").show();
      }
    }
  });

  // Khusus untuk laporan perjalanan
  if (currentUrl.includes("/pemberangkatan/laporan")) {
    // Tandai menu laporan sebagai aktif
    $('a[href*="/laporanpemberangkatan"]')
      .closest(".has_sub")
      .addClass("active");
    $('a[href*="/laporanpemberangkatan"]')
      .closest(".has_sub")
      .find("> ul")
      .show();

    // Tandai submenu yang sesuai
    if (currentUrl.includes("laporanTujuan")) {
      $('a[href*="laporanTujuan"]').addClass("active");
    } else if (currentUrl.includes("laporanPeriode")) {
      $('a[href*="laporanPeriode"]').addClass("active");
    }
  }

  // Animasi hover untuk menu laporan perjalanan
  $('a[href*="laporanTujuan"], a[href*="laporanPeriode"]').hover(
    function () {
      $(this).find("i").addClass("animated pulse");
    },
    function () {
      $(this).find("i").removeClass("animated pulse");
    }
  );
});

/**
 * Fungsi untuk menampilkan notifikasi menu
 */
function showMenuNotification(message, type = "info") {
  // Buat elemen notifikasi
  var notification = $(
    '<div class="menu-notification alert alert-' +
      type +
      ' alert-dismissible fade show" role="alert">' +
      message +
      '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
      "</div>"
  );

  // Tambahkan ke container
  $(".content").prepend(notification);

  // Auto hide setelah 3 detik
  setTimeout(function () {
    notification.fadeOut();
  }, 3000);
}

/**
 * Fungsi untuk highlight menu baru
 */
function highlightNewMenus() {
  // Tambahkan badge "NEW" untuk menu laporan perjalanan
  $('a[href*="laporanTujuan"], a[href*="laporanPeriode"]').each(function () {
    if (!$(this).find(".new-badge").length) {
      $(this).append(
        '<span class="new-badge badge bg-success ms-2">NEW</span>'
      );
    }
  });

  // Hapus badge setelah 10 detik
  setTimeout(function () {
    $(".new-badge").fadeOut();
  }, 10000);
}
