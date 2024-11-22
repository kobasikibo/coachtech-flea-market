document.addEventListener("DOMContentLoaded", function () {
    const paymentSelect = document.querySelector(
        'select[name="payment_method"]'
    ); // 支払い方法の選択肢
    const paymentDisplay = document.getElementById("payment-method-display"); // 支払い方法の表示部分

    // 初期の支払い方法を表示する関数
    function updatePaymentMethodDisplay() {
        const selectedOption =
            paymentSelect.options[paymentSelect.selectedIndex].text;
        paymentDisplay.textContent =
            selectedOption === "選択してください" ? "未選択" : selectedOption;
    }

    // 初期表示を更新
    updatePaymentMethodDisplay();

    // 支払い方法が変更されたときに表示を更新
    paymentSelect.addEventListener("change", function () {
        updatePaymentMethodDisplay();
    });
});
