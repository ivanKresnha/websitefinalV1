 <script>
      function previewImage(event) {
        const imgPreview = document.getElementById("imgPreview");
        const file = event.target.files[0];

        if (file) {
          const reader = new FileReader();

          reader.onload = function (e) {
            imgPreview.src = e.target.result;
            imgPreview.style.display = "block";
          };

          reader.readAsDataURL(file);
        } else {
          imgPreview.src = "";
          imgPreview.style.display = "none";
        }
      }
    </script>