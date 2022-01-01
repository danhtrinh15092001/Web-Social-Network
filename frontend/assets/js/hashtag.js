const modalHash = document.querySelector(".hash__box");

$(window).on("click", function (e) {
    if (e.target == modalHash) {
        modalHash.style.display = "none";
    }
});

$("#postTextarea").keyup((e) => {
    let hash = /[#|@](\w+)$/gi;
    let textbox = $(e.target);
    let content = textbox.val().trim();
    let max = 200;
    let text = content.match(hash);

    if (text != null && text != "") {
        var dataString = "hashtag=" + text;
        $.ajax({
            type: "POST",
            data: dataString,
            url: "http://localhost/twitter/backend/ajax/getHashtag.php",
            cache: false,
            success: function (data) {
                modalHash.style.display = "block";
                $(".hash__box ul").html(data);
                $(".hash__box li").click(function () {
                    let value = $.trim($(this).find(".getValue").text());
                    let old_post = $("#postTextarea").val();
                    let new_post = old_post.replace(hash, "");
                    $("#postTextarea").val(new_post + value + "");
                    modalHash.style.display = "none";
                    $("#postTextarea").focus();
                    $("#count").text(max - content.length);
                });
            },
        });
    } else {
        modalHash.style.display = "none";
    }
    let submitButton = $("#submitPostButton");

    $("#count").text(max - content.length);
    if (content.length >= max) {
        $("#count").css("color", "red");
    } else {
        $("#count").css("color", "#000");
    }

    $("#submitPostButton").click((e) => {
        e.preventDefault();
        $.post("http://localhost/tweety/backend/ajax/post.php", { fetchHashtag: true }, function (data) {
            $(".trends-body").html(data);
            $("#postTextarea").val("");
            $(".hash-box li").hide();
        });
    });
});
