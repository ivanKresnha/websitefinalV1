<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


    <script>
      $(document).ready(function () {
       $("#dataTable").DataTable({
    scrollX: true,
    responsive: false,
    language: {
        search: "Cari:",
        lengthMenu: "Tampilkan _MENU_ data per halaman",
        info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
        infoEmpty: "Tidak ada data yang tersedia",
        paginate: {
            first: "Pertama",
            last: "Terakhir",
            next: "Berikutnya",
            previous: "Sebelumnya",
        },
    },
});

      });

      function confirmDelete(id) {
        if (
          confirm(
            "Apakah Anda yakin ingin menghapus User dengan ID " + id + "?"
          )
        ) {
          console.log("User " + id + " dihapus.");
        }
      }
    </script> 