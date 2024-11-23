document.addEventListener("DOMContentLoaded", () => {
    const paymentSelect = document.querySelector(
        'select[name="payment_method"]'
    );
    const paymentDisplay = document.getElementById("payment-method-display");
    const purchaseForm = document.getElementById("purchase-form");
    const stripeTokenInput = document.getElementById("stripe-token");
    const stripe = Stripe(
        "pk_test_51QOEzTRqGDePsrWjicZCJ5cH1kdDc3k4tI93D6OQy8EOy3etSjAbML9YSU3QD9D6GTTJTBMwpYZiAtLpP6I88HVJ00vvyrBOzj"
    ); // Stripe公開可能キー
    const cardElement = document.getElementById("card-element");

    // 支払い方法表示を更新
    const updatePaymentDisplay = () => {
        const selectedText = paymentSelect.selectedOptions[0]?.text || "未選択";
        paymentDisplay.textContent =
            selectedText === "選択してください" ? "未選択" : selectedText;
    };

    // 支払い方法が変更されたとき
    paymentSelect.addEventListener("change", updatePaymentDisplay);

    // フォーム送信時の処理
    purchaseForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        if (paymentSelect.value === "card") {
            try {
                const { error, paymentMethod } =
                    await stripe.createPaymentMethod({
                        type: "card",
                        card: cardElement,
                    });

                if (error) {
                    alert(error.message);
                } else {
                    stripeTokenInput.value = paymentMethod.id; // トークンをセット
                    purchaseForm.submit(); // フォーム送信
                }
            } catch (err) {
                console.error("Error creating payment method:", err);
                alert("カード情報の送信中にエラーが発生しました。");
            }
        } else {
            stripeTokenInput.value = ""; // コンビニ支払い時は空のまま送信
            purchaseForm.submit();
        }
    });

    // 初期表示を更新
    updatePaymentDisplay();
});
