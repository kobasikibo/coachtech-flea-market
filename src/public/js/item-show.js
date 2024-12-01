document.addEventListener("DOMContentLoaded", function () {
    const commentTextareas = document.querySelectorAll(
        ".comment-form textarea"
    );
    commentTextareas.forEach((textarea) => {
        let isComposing = false;

        textarea.addEventListener("compositionstart", function () {
            isComposing = true;
        });

        textarea.addEventListener("compositionend", function () {
            isComposing = false;
        });

        textarea.addEventListener("keydown", function (event) {
            if (event.key === "Enter" && !event.shiftKey && !isComposing) {
                event.preventDefault();
                const form = this.closest("form");
                form.requestSubmit();
            }
        });
    });

    // 以下記述を未認証時に無効化することでmiddlewareでリダイレクト
    const isAuthenticated = window.isAuthenticated;

    if (!isAuthenticated) {
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    const likeButtons = document.querySelectorAll(".like-button");
    likeButtons.forEach((button) => {
        const likesCountSpan = button.querySelector(".likes-count");

        button.addEventListener("click", function (event) {
            event.preventDefault();
            const itemId = this.dataset.itemId;
            const isNowLiked = this.classList.toggle("liked");
            const method = isNowLiked ? "POST" : "DELETE";
            const url = `/item/${itemId}/like`;

            fetch(url, {
                method: method,
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
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

    const commentForms = document.querySelectorAll(".comment-form form");
    commentForms.forEach((form) => {
        form.addEventListener("submit", function (event) {
            event.preventDefault();
            const formData = new FormData(this);
            const itemId = this.getAttribute("action").split("/").pop(); // URLからアイテムIDを取得
            const commentsSection = document.querySelector(".comments-section");
            const existingComments =
                commentsSection.querySelectorAll(".comment");
            existingComments.forEach((comment) => {
                comment.style.display = "none"; // 既存コメントを非表示
            });

            fetch(this.action, {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        // コメントカウントとコメントラベルの更新
                        document.querySelector(".comments-count").textContent =
                            data.comments_count;
                        document.querySelector(
                            ".comment-label"
                        ).textContent = `コメント（${data.comments_count}）`;

                        // コメント一覧の更新
                        const commentsSection =
                            document.querySelector(".comments-section");
                        commentsSection.innerHTML += `
                            <div class="comment">
                                <div class="user-info">
                                    <div class="user-image-container">
                                        <img src="${data.comment.user_image}" class="user-image">
                                    </div>
                                    <span class="user-name">${data.comment.user_name}</span>
                                </div>
                                <div class="comment-content">
                                    <p>${data.comment.content}</p>
                                </div>
                            </div>`;

                        this.reset();

                        commentsSection.innerHTML = newComment;
                    }
                })
                .catch((error) => console.error("Error:", error));
        });
    });
});

