function likeTweet(button, postId, postedBy, likeBy) {
    $.post("http://localhost/twitter/backend/ajax/likeTweet.php", { tweetID: postId, likeOn: postedBy, likeBy: likeBy }, function (data) {
        let likeButton = $(button);
        likeButton.addClass("like-active");
        let result = JSON.parse(data);
        updateLikesValue(likeButton.find(".likesCounter"), result.likes);

        if (result.likes < 0) {
            likeButton.removeClass("like-active");
            likeButton.find(".fas").addClass("far");
            likeButton.find(".far").removeClass("fas");
        } else {
            likeButton.addClass("like-active");
            likeButton.find(".far").addClass("fas");
            likeButton.find(".fas").removeClass("far");
        }
    });
}

function updateLikesValue(element, num) {
    let likesCountVal = element.text() || "0";
    element.text(parseInt(likesCountVal) + parseInt(num));
}
