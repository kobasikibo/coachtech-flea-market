document.addEventListener("DOMContentLoaded", function () {
    const tabLinks = document.querySelectorAll(".tab-link");

    tabLinks.forEach((link) => {
        link.addEventListener("click", function (e) {
            e.preventDefault(); // デフォルトのリンク動作を無効にする

            // すべてのタブから 'active' クラスを削除
            tabLinks.forEach((link) => {
                link.classList.remove("active");
            });

            this.classList.add("active");
        });
    });
});
