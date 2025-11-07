// ==============================
//  Loading Indicator
// ==============================
$(document).ajaxStart(() => {
  $("#loadingIndicator").fadeIn(150);
});
$(document).ajaxStop(() => {
  $("#loadingIndicator").fadeOut(150);
});

// ==============================
//  Fungsi Global untuk Register Event
// ==============================
function registerDeleteEvent() {
  // hapus event lama
  $(document).off("click", ".btn-delete");

  // pasang ulang event
  $(document).on("click", ".btn-delete", function (e) {
    e.preventDefault();
    const id = $(this).data("id");
    const file = $(this).data("file");
    if (!file || !id) return;

    if (confirm("Yakin ingin menghapus data ini?")) {
      const row = $(this).closest("tr");
      row.css("background", "#ffe6e6");
      row.fadeOut(250, () => {
        $.ajax({
          url: file,
          method: "GET",
          data: { id: id },
          success: function (res) {
            $("#mainContent").html(res);
            registerDeleteEvent(); // pasang ulang setelah load baru
          },
          error: function () {
            alert("Terjadi kesalahan saat menghapus data!");
          },
        });
      });
    }
  });
}

// ==============================
//  Navigasi Sidebar (AJAX Load)
// ==============================
$(document).off("click", "#sidebarMenu a, a[data-load='true']").on("click", "#sidebarMenu a, a[data-load='true']", function (e) {
  e.preventDefault();
  const page = $(this).attr("href");
  $("#sidebarMenu a").removeClass("active");
  $(this).addClass("active");

  $("#mainContent").fadeOut(100, function () {
    $("#mainContent").load(page, function () {
      $("#mainContent").fadeIn(150);
      registerDeleteEvent(); // setiap kali halaman baru dimuat, pasang event delete lagi
    });
  });
});

// ==============================
//  Register event pertama kali
// ==============================
$(document).ready(function () {
  registerDeleteEvent();
});
