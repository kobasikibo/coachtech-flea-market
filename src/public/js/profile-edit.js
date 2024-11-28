document.querySelectorAll(".form-group input[type='text']").forEach((input) => {
    input.addEventListener("input", () => {
        input.style.color = "rgba(0, 0, 0, 1)";
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const imageInput = document.querySelector(".image-input");
    const preview = document.querySelector(".image-preview");
    const originalImage = preview.src;

    imageInput.addEventListener("change", function (event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = "block";
            };

            reader.readAsDataURL(file);
        } else {
            preview.src = originalImage;
            preview.style.display = originalImage ? "block" : "none";
        }
    });
});