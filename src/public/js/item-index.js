document.addEventListener("DOMContentLoaded", function () {
    const tabLinks = document.querySelectorAll(".tab-link");

    tabLinks.forEach((link) => {
        link.addEventListener("click", function (e)
        {
            window.location.href = this.href;
        });
    });
});
