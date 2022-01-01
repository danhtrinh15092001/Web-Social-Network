$(function () {
    let userid = $(".id").data("uid");

    function notificationUpdate(userId) {
        $.post("http://localhost/twitter/backend/ajax/notify.php", { notificationUpdate: userId }, function (data) {
            if (data.trim() == "0") {
                $(".notification-badge-show").css("display", "none !important");
                $(".notification-badge--count").html(data);
                $(".notification-badge-show").css({ "opacity ": "0 !important" });
            } else {
                $(".notification-badge-show").css("display", "block !important");
                $(".notification-badge-show").css({ "opacity ": "1 !important" });
                $(".notification-badge--count").html(data);
            }
        });
    }
    var notificationInterval;
    notificationInterval = setInterval(function () {
        notificationUpdate(userid);
    }, 1000);

    $(document).on("click", ".nav__main-link", function () {
        if (userid != undefined) {
            $.post("http://localhost/twitter/backend/ajax/notify.php", { notify: userid }, function (data) {
                // alert(data);
            });
        }
    });

    $(document).on("click", ".notify-container,.notify-msg-container,.notify-like-container", function () {
        let hasNotify = $(this).hasClass("unread-notification");
        let notificationid = $(this).data("notificationid");

        if (hasNotify) {
            $(this).addClass("read-notification").removeClass("unread-notification");
            $.post("http://localhost/twitter/backend/ajax/notify.php", { notificationStatusUpdate: userid, notificationid: notificationid }, function (data) {
                // alert(data);
            });
        }
    });
});
