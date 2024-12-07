document.addEventListener("DOMContentLoaded", () => {
    const paymentSelect = document.querySelector(
        'select[name="payment_method"]'
    );
    const paymentDisplay = document.getElementById("payment-method-display");

    // 支払い方法表示を更新
    const updatePaymentDisplay = () => {
        const selectedValue = paymentSelect.value;
        const summaryText =
            selectedValue === "convenience" ? "コンビニ支払い" :
            selectedValue === "card" ? "カード支払い" :
            "";

        paymentDisplay.textContent = summaryText;
    };

    paymentSelect.addEventListener("change", updatePaymentDisplay);

    // 初期表示を更新
    updatePaymentDisplay();
});
