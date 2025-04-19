   
   <!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>


<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker();

        const permissionsTable = $('#permissionsTable tbody');

        // Event listener untuk selectpicker
        $('#permissions').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
            const selectedOptions = $(this).find('option:selected');
            permissionsTable.empty(); // Kosongkan tabel terlebih dahulu

            // Iterasi setiap item yang dipilih
            selectedOptions.each(function(index) {
                const permissionId = $(this).val();
                const permissionName = $(this).text();

                // Tambahkan baris ke tabel
                const row = `
                        <tr data-id="${permissionId}">
                            <td>${index + 1}</td>
                            <td>${permissionName}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-permission">Hapus</button>
                            </td>
                        </tr>
                    `;
                permissionsTable.append(row);
            });
        });

        // Event listener untuk tombol hapus di tabel
        permissionsTable.on('click', '.remove-permission', function() {
            const row = $(this).closest('tr');
            const permissionId = row.data('id');

            // Hapus dari tabel
            row.remove();

            // Hapus dari selectpicker
            $('#permissions').find(`option[value="${permissionId}"]`).prop('selected', false);
            $('#permissions').selectpicker('refresh');
        });
    });
</script>

 
    <script>
        $(document).ready(function() {
            $('.selectpicker').selectpicker();

            const permissionsTable = $('#permissionsTable tbody');

            // Event listener untuk selectpicker
            $('#permissions').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
                const selectedOptions = $(this).find('option:selected');
                permissionsTable.empty(); // Kosongkan tabel terlebih dahulu

                // Iterasi setiap item yang dipilih
                selectedOptions.each(function(index) {
                    const permissionId = $(this).val();
                    const permissionName = $(this).text();

                    // Tambahkan baris ke tabel
                    const row = `
                        <tr data-id="${permissionId}">
                            <td>${index + 1}</td>
                            <td>${permissionName}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-permission">Hapus</button>
                            </td>
                        </tr>
                    `;
                    permissionsTable.append(row);
                });
            });

            // Event listener untuk tombol hapus di tabel
            permissionsTable.on('click', '.remove-permission', function() {
                const row = $(this).closest('tr');
                const permissionId = row.data('id');

                // Hapus dari tabel
                row.remove();

                // Hapus dari selectpicker
                $('#permissions').find(`option[value="${permissionId}"]`).prop('selected', false);
                $('#permissions').selectpicker('refresh');
            });
        });
    </script>

    <script>
    if (typeof $ === 'undefined' || typeof $.fn.selectpicker === 'undefined') {
        console.error("jQuery atau bootstrap-select belum terload.");
    } else {
        console.log("Library berhasil ditemukan.");
    }
</script>


<script>
    console.log('createScripts.blade.php berhasil dipanggil');
</script>
