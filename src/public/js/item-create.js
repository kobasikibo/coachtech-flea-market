function previewImage(event) {
    const preview = document.querySelector(".image");
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.classList.add("show");
        };
        reader.readAsDataURL(file);
    }
}
