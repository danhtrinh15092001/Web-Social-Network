$(function () {
    var modal = document.querySelector(".d-wrapper-container");
    var modalDelete = document.querySelector(".del-post-wrapper-container");

    $(document).on("click", "#deletePostModal", function () {
        $postId = $(this).data("tweet");
        $tweetBy = $(this).data("tweetby");
        $userId = $(this).data("user");
        modal.style.display = "block";
    });

    $(window).on("click", function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    });

    $(document).on("click", "#del-content", function () {
        modalDelete.style.display = "block";
    });

    $(document).on("click", "#cancel", function () {
        modalDelete.style.display = "none";
        modal.style.display = "none";
    });

    $(document).on("click", "#delete-post-btn", function () {
        $.post("http://localhost/Twitter/backend/ajax/deletePost.php", { postId: $postId, userId: $userId, tweetBy: $tweetBy }, function (data) {
            modalDelete.style.display = "none";
            modal.style.display = "none";
            $(".postContainer").html(data);
            // $(".postContainer").html(data);
        });
    });

    $(window).on("click", function (event) {
        if (event.target == modalDelete) {
            modalDelete.style.display = "none";
        }
    });
});
