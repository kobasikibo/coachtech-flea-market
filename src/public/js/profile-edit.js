document.querySelectorAll(".form-group input[type='text']").forEach((input) => {
    input.addEventListener("input", () => {
        input.style.color = "rgba(0, 0, 0, 1)";
    });
});
