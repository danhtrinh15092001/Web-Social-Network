$uid = $(".id").data("uid");
$(function () {
    $(".f-btn").click(function () {
        var followID = $(this).data("follow");
        var userId = $uid;
        $button = $(this);
        if ($button.hasClass("following-btn")) {
            $.post(
                "http://localhost/Twitter/backend/ajax/follow.php",
                {
                    unfollow: followID,
                    userId: userId,
                },
                function (data) {
                    let result = JSON.parse(data);
                    $button.removeClass("following-btn");
                    $button.removeClass("unfollow-btn");
                    $button.addClass("follow-btn");
                    $button.text("Follow");
                    $(".count-following").text(result.following);
                    $(".count-followers").text(result.followers);
                }
            );
        } else {
            $.post(
                "http://localhost/Twitter/backend/ajax/follow.php",
                {
                    follow: followID,
                    userId: userId,
                },
                function (data) {
                    let result = JSON.parse(data);
                    $button.addClass("following-btn");
                    $button.addClass("unfollow-btn");
                    $button.removeClass("follow-btn");
                    $button.text("Following");
                    $(".count-following").text(result.following);
                    $(".count-followers").text(result.followers);
                }
            );
        }
    });
});
