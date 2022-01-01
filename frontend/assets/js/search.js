var timer;
$uid = $(".id").data("uid");
$(function () {
    $(document).on("keydown", ".s-user", function (e) {
        // alert($uid);
        clearTimeout(timer);
        var textbox = $(e.target);

        timer = setTimeout(() => {
            $search = textbox.val().trim();
            if ($search != "") {
                $.post("http://localhost/Twitter/backend/ajax/search.php", { search: $search, userId: $uid }, function (data) {
                    // alert(data);
                    $(".s-result-user").html(data);
                });
            } else {
                $(".s-result-user").html("");
            }
        }, 500);
    });
});
