document.addEventListener("DOMContentLoaded", function () {
    const tabLinks = document.querySelectorAll(".tab-link");

    tabLinks.forEach((link) => {
        link.addEventListener("click", function (e) {
            e.preventDefault(); // デフォルトのリンク動作を無効にする

            // すべてのタブから 'active' クラスを削除
            tabLinks.forEach((link) => {
                link.classList.remove("active");
            });

            // クリックされたタブに 'active' クラスを追加
            this.classList.add("active");

            // 商品リストの切り替えロジックを追加
            // ここで出品した商品と購入した商品を切り替えられるようにします
        });
    });
});
