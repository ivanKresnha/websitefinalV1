<script>
    function previewImage(event) {
        const input = event.target;
        const file = input.files[0];
        const reader = new FileReader();

        reader.onload = function (e) {
            const imgPreview = document.getElementById('imgPreview');
            imgPreview.src = e.target.result;
            imgPreview.style.display = 'block';
        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            document.getElementById('imgPreview').style.display = 'none';
        }
    }
</script>
