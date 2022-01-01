$(function () {
    const retweetbtn = document.querySelector(".retweet");
    const retweetModal = document.querySelector(".retweet__container");

    $(document).on("click", ".retweet,.retweeted-icon", function (e) {
        e.preventDefault();
        $postId = $(this).data("post");
        $uid = $(this).data("user");
        $counter = $(this).find(".retweetsCount");
        $button = $(this);
        let wasRetweeted = $(this).hasClass("retweeted-icon");
        if (wasRetweeted) {
            $.post("http://localhost/twitter/backend/ajax/retweet.php", { retweetID: $postId, retweetBy: $uid }, function (data) {
                retweetModal.style.display = "block";
                $(".retweet__container").html(data);
            });
        } else {
            $.post("http://localhost/twitter/backend/ajax/retweet.php", { retweetID: $postId, retweetBy: $uid }, function (data) {
                retweetModal.style.display = "block";
                $(".retweet__container").html(data);
            });
        }
    });

    window.onclick = function (event) {
        if (event.target == retweetModal) {
            retweetModal.style.display = "none";
        }
    };

    $(document).on("click", ".content__retweet-it,.content__retweeted-it", function () {
        let postId = $button.data("post");
        let userId = $button.data("user");
        let postedby = $button.data("postby");
        let retweetText = "";
        let wasRetweeted = $(this).hasClass("content__retweeted-it");
        if (wasRetweeted) {
            $.post("http://localhost/twitter/backend/ajax/retweet.php", { tweetID: postId, status: retweetText, retweetBy: userId, tweetby: postedby }, function (data) {
                // console.log(data);
                // let likeButton = $(button);
                // likeButton.addClass("like-active");
                let result = JSON.parse(data);
                updateRetweetValue($counter, result.retweet);
                if (result.retweet < 0) {
                    $(".content__retweet-item .retweet_text .retweet-no-quote").text("Retweet");
                    $button.removeClass("retweeted-icon").addClass("retweet");
                    $(".content__retweeted-it").removeClass("content__retweeted-it").addClass("content__retweet-it");
                    retweetModal.style.display = "none";
                }
            });
        } else {
            $.post("http://localhost/twitter/backend/ajax/retweet.php", { tweetID: postId, status: retweetText, retweetBy: userId, tweetby: postedby }, function (data) {
                // console.log(data);
                // let likeButton = $(button);
                // likeButton.addClass("like-active");
                let result = JSON.parse(data);
                updateRetweetValue($counter, result.retweet);
                if (result.retweet > 0) {
                    $(".content__retweet-item .retweet_text .retweet-no-quote").text("Undo Retweet");
                    $button.addClass("retweeted-icon").removeClass("retweet");
                    $(".content__retweet-it").addClass("content__retweeted-it").removeClass("content__retweet-it");
                    retweetModal.style.display = "none";
                }
            });
        }
        // console.log(postId, userId);
    });

    function updateRetweetValue(element, num) {
        let RetweetCountVal = element.text() || "0";
        element.text(parseInt(RetweetCountVal) + parseInt(num));
    }

    $(document).on("click", ".content__retweet-it", function () {
        $.post("http://localhost/twitter/backend/ajax/retweet.php", { retweetPostID: $postId, retweetBy: $uid }, function (data) {
            // retweetModal.style.display = "block";
            // $(".retweet__container").html(data);
            // alert(data);
            $(".postContainer").html(data);
        });
    });

    // $(document).on("click", ".content__retweeted-it", function () {
    //     $.post("http://localhost/twitter/backend/ajax/retweet.php", { retweetedPostID: $postId, retweetBy: $uid }, function (data) {
    //         // retweetModal.style.display = "block";
    //         // $(".retweet__container").html(data);
    //         // alert(data);
    //         $(".postContainer").html(data);
    //     });
    // });
});
