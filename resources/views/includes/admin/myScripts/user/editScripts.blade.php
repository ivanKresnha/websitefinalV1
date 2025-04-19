<script>
    function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('imgPreview');
        output.style.display = 'block'; // Menampilkan preview
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}

</script>
