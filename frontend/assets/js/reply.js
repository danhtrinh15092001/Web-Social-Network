$(function () {
    var modal = document.querySelector(".reply-wrapper");

    $(document).on("click", ".replyModal,.commented", function (e) {
        e.preventDefault();
        $postId = $(this).data("post");
        $userId = $(this).data("user");
        $postedBy = $(this).data("postby");
        $button = $(this);
        $counter = $(this).find(".replyCount");
        let isCommented = $button.hasClass("commented");
        if (isCommented) {
            $.post("http://localhost/twitter/backend/ajax/reply.php", { delCommentOn: $postId, commentBy: $userId, tweetBy: $postedBy }, function (data) {
                let result = JSON.parse(data);
                updateRetweetValue($counter, result.delComment);
                if (result.delComment < 0) {
                    $button.removeClass("commented").addClass("replyModal");
                    $button.removeClass("replyCountColor");
                    $counter.removeClass("replyCountColor");
                }
            });
        } else {
            modal.style.display = "block";

            $.post("http://localhost/twitter/backend/ajax/reply.php", { tweetID: $postId, tweetBy: $postedBy, userid: $userId }, function (data) {
                // alert(data);
                $(".reply-wrapper").html(data);
            });
        }
    });

    $(document).on("click", ".close", function (e) {
        modal.style.display = "none";
    });

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };

    $(document).on("click", "#replyBtn", function (event) {
        event.preventDefault();
        let userId = $button.data("user");
        let postId = $button.data("post");
        let tweetBy = $button.data("postby");
        let counter = $button.find(".replyCount");
        let textValue = $("#replyInput").val().trim();
        if (textValue != " " && textValue != null) {
            $.post("http://localhost/twitter/backend/ajax/reply.php", { commentOn: postId, commentBy: userId, comment: textValue, tweetBy: tweetBy }, function (data) {
                // let likeButton = $(button);
                // likeButton.addClass("like-active");

                $(".reply-wrapper").hide();
                let result = JSON.parse(data);
                updateRetweetValue(counter, result.comment);
                if (result.comment < 0) {
                    $button.removeClass("commented").addClass("replyModal");
                    $button.removeClass("replyCountColor");
                    counter.removeClass("replyCountColor");
                } else {
                    $button.addClass("commented").removeClass("replyModal");
                    $button.addClass("replyCountColor");
                    counter.addClass("replyCountColor");
                }
            });
        }
        // alert("danh");
    });

    function updateRetweetValue(element, num) {
        let RetweetCountVal = element.text() || "0";
        element.text(parseInt(RetweetCountVal) + parseInt(num));
    }
});
