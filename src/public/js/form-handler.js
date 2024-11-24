document.addEventListener("DOMContentLoaded", function () {
    const formGroups = document.querySelectorAll(".form-group");

    formGroups.forEach(function (group) {
        const input = group.querySelector("input");
        if (input) {
            // ユーザーが入力していない場合、placeholder を値として設定
            input.addEventListener("blur", function () {
                // 入力が空の場合のみ、placeholderの値をinputにセット
                if (!input.value && input.placeholder) {
                    input.value = input.placeholder; // placeholderの値をセット
                }
            });
        }
    });
});
