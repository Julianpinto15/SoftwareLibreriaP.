// Add this JavaScript code to your script file
document.addEventListener("DOMContentLoaded", function () {
  const fileInput = document.getElementById("usuario_foto");
  const previewContainer = document.getElementById("image-preview-container");
  const previewImage = document.getElementById("image-preview");
  const fileName = document.getElementById("file-name");

  fileInput.addEventListener("change", function (event) {
    const file = event.target.files[0];

    if (file) {
      // Show the preview container
      previewContainer.style.display = "block";

      // Display file name
      fileName.textContent = file.name;

      // Create preview image
      const reader = new FileReader();
      reader.onload = function (e) {
        previewImage.src = e.target.result;
      };
      reader.readAsDataURL(file);
    } else {
      // Hide the preview container if no file is selected
      previewContainer.style.display = "none";
      previewImage.src = "";
      fileName.textContent = "";
    }
  });
});
