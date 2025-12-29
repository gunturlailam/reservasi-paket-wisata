// Pembayaran JavaScript Functions

/**
 * Format angka ke format Rupiah
 */
function formatRupiah(value) {
  const num = parseInt(value) || 0;
  return num.toLocaleString("id-ID");
}

/**
 * Format tanggal ke format Indonesia
 */
function formatTanggal(tanggal) {
  if (!tanggal) return "-";
  const date = new Date(tanggal);
  return date.toLocaleDateString("id-ID", {
    year: "numeric",
    month: "long",
    day: "numeric",
  });
}

/**
 * Format tanggal dengan jam
 */
function formatTanggalJam(tanggal) {
  if (!tanggal) return "-";
  const date = new Date(tanggal);
  return date.toLocaleDateString("id-ID", {
    year: "numeric",
    month: "long",
    day: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  });
}

/**
 * Load detail pemesanan saat select berubah
 */
function loadDetailPemesanan() {
  const select = document.getElementById("id_pemesanan_detail");
  const option = select.options[select.selectedIndex];

  if (!option.value) {
    document.getElementById("detailPaket").innerText = "-";
    document.getElementById("detailLokasi").innerText = "-";
    document.getElementById("detailBerangkat").innerText = "-";
    document.getElementById("detailKembali").innerText = "-";
    document.getElementById("jumlah_bayar").value = "";
    return;
  }

  document.getElementById("detailPaket").innerText =
    option.dataset.paket || "-";
  document.getElementById("detailLokasi").innerText =
    option.dataset.lokasi || "-";
  document.getElementById("detailBerangkat").innerText = formatTanggal(
    option.dataset.berangkat
  );
  document.getElementById("detailKembali").innerText = formatTanggal(
    option.dataset.kembali
  );
  document.getElementById("jumlah_bayar").value = formatRupiah(
    option.dataset.total || 0
  );
}

/**
 * Lihat detail pembayaran
 */
function lihat(id) {
  fetch(`/pembayaran/detail/${id}`)
    .then((response) => {
      if (!response.ok) throw new Error("Gagal memuat data");
      return response.json();
    })
    .then((data) => {
      let html = `
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>ID Pesanan:</strong> #${data.id}</p>
                        <p><strong>Paket Wisata:</strong> ${
                          data.nama_paket || "-"
                        }</p>
                        <p><strong>Lokasi:</strong> ${data.lokasi || "-"}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Tanggal Pesan:</strong> ${formatTanggalJam(
                          data.tanggal_pesan
                        )}</p>
                        <p><strong>Metode Pembayaran:</strong> ${formatMetodePembayaran(
                          data.metode_pembayaran
                        )}</p>
                        <p><strong>Status:</strong> <span class="badge badge-${
                          data.status_pembayaran === "sudah_dibayar"
                            ? "success"
                            : data.status_pembayaran === "menunggu_pembayaran"
                            ? "warning"
                            : "secondary"
                        }">${formatStatus(data.status_pembayaran)}</span></p>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Tanggal Berangkat:</strong> ${formatTanggal(
                          data.tanggal_berangkat
                        )}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Tanggal Kembali:</strong> ${formatTanggal(
                          data.tanggal_kembali
                        )}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h5>Total Bayar</h5>
                        <h3 class="text-primary">Rp ${formatRupiah(
                          data.total_bayar
                        )}</h3>
                    </div>
                    <div class="col-md-6">
                        ${
                          data.catatan
                            ? `<p><strong>Catatan:</strong><br>${data.catatan}</p>`
                            : ""
                        }
                    </div>
                </div>
            `;
      document.getElementById("detailContent").innerHTML = html;
      const modal = new bootstrap.Modal(
        document.getElementById("modalLihatDetail")
      );
      modal.show();
    })
    .catch((error) => {
      alert("Gagal memuat detail: " + error.message);
    });
}

/**
 * Format metode pembayaran
 */
function formatMetodePembayaran(metode) {
  const metodeMap = {
    transfer_bank: "Transfer Bank",
    kartu_kredit: "Kartu Kredit",
    e_wallet: "E-Wallet",
    tunai: "Tunai",
  };
  return metodeMap[metode] || metode;
}

/**
 * Format status pembayaran
 */
function formatStatus(status) {
  const statusMap = {
    menunggu_pembayaran: "Menunggu Pembayaran",
    sudah_dibayar: "Sudah Dibayar",
    dibatalkan: "Dibatalkan",
  };
  return statusMap[status] || status;
}

/**
 * Proses pembayaran
 */
function bayar(id) {
  if (confirm("Proses pembayaran untuk pesanan #" + id + "?")) {
    window.location.href = `/pembayaran/proses/${id}`;
  }
}

/**
 * Hapus pembayaran
 */
function hapus(id) {
  if (confirm("Apakah Anda yakin ingin menghapus pembayaran ini?")) {
    window.location.href = `/pembayaran/delete/${id}`;
  }
}

/**
 * Cetak detail pembayaran
 */
function cetakDetail() {
  window.print();
}

/**
 * Reset form modal
 */
function resetFormPembayaran() {
  document.getElementById("id_pemesanan_detail").value = "";
  document.getElementById("metode_pembayaran").value = "";
  document.getElementById("catatan").value = "";
  document.getElementById("detailPaket").innerText = "-";
  document.getElementById("detailLokasi").innerText = "-";
  document.getElementById("detailBerangkat").innerText = "-";
  document.getElementById("detailKembali").innerText = "-";
  document.getElementById("jumlah_bayar").value = "";
}

/**
 * Validasi form sebelum submit
 */
function validateFormPembayaran() {
  const idPemesanan = document.getElementById("id_pemesanan_detail").value;
  const metode = document.getElementById("metode_pembayaran").value;

  if (!idPemesanan) {
    alert("Pilih pemesanan terlebih dahulu");
    return false;
  }

  if (!metode) {
    alert("Pilih metode pembayaran");
    return false;
  }

  return true;
}

// Event listeners
document.addEventListener("DOMContentLoaded", function () {
  // Reset form saat modal ditutup
  const modalTambah = document.getElementById("modalTambahPesanan");
  if (modalTambah) {
    modalTambah.addEventListener("hidden.bs.modal", function () {
      resetFormPembayaran();
    });
  }

  // Validasi form saat submit
  const formPembayaran = document.querySelector(
    'form[action*="/pembayaran/save"]'
  );
  if (formPembayaran) {
    formPembayaran.addEventListener("submit", function (e) {
      if (!validateFormPembayaran()) {
        e.preventDefault();
      }
    });
  }
});
