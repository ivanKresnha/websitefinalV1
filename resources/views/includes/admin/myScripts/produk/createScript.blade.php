<script>
// views/includes/admin/myScripts/produk/createScript.blade.php

function previewImage(event) {
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onload = function (e) {
        const imgPreview = document.getElementById('imgPreview');
        imgPreview.src = e.target.result;
        imgPreview.style.display = 'block';
    };

    if (file) {
        reader.readAsDataURL(file);
    } else {
        const imgPreview = document.getElementById('imgPreview');
        imgPreview.style.display = 'none';
    }
} 

</script>