document.addEventListener("DOMContentLoaded", function () {
    const likeButtons = document.querySelectorAll(".like-button");

    likeButtons.forEach((button) => {
        const likesCountSpan = button.querySelector(".likes-count");

        button.addEventListener("click", function (event) {
            event.preventDefault(); // デフォルトの動作を防ぐ

            const itemId = this.dataset.itemId;
            const isNowLiked = this.classList.toggle("liked");

            const method = isNowLiked ? "POST" : "DELETE";
            const url = `/items/${itemId}/like`;

            fetch(url, {
                method: method,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    "Content-Type": "application/json",
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.likes_count !== undefined) {
                        likesCountSpan.textContent = data.likes_count;
                    }
                })
                .catch((error) => console.error("Error:", error));
        });
    });
});
