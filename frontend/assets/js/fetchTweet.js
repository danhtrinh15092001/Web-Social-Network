$(function () {
    let id = $(".id").data("uid");
    let win = $(window);
    let offset = 5;

    win.scroll(function () {
        let content_height = $(document).height() - 1;
        let content_y = win.height() + win.scrollTop();
        console.log(content_y + "/" + content_height);
        if (content_y >= content_height) {
            offset = offset + 5;
            $.post("http://localhost/Twitter/backend/ajax/fetchTweet.php", { fetchTweets: offset, userID: id }, function (data) {
                // alert(data);
                $(".postContainer").html(data);
            });
        }
    });
});
