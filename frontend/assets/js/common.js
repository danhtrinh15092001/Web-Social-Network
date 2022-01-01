$(function () {
    let path = window.location.href;
    $(".nav__main-link").each(function () {
        if (this.href === path) {
            $(this).addClass("active");
        }
    });
});

// Logout
const btn = document.querySelector(".nav__footer-container");
const modal = document.querySelector("#myLogoutModal");
$(document).on("click", ".nav__footer-container", function () {
    modal.style.display = "block";
});
$(window).on("click", function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
});
$(document).on("keyup", "#postTextarea,#replyInput", function (e) {
    e.preventDefault();
    let textbox = $(e.target);
    let value = textbox.val().trim();
    let isReplyModal = textbox.parents(".reply-wrapper").length == 1;
    let submitButton = isReplyModal ? $("#replyBtn") : $("#submitPostButton");
    // let submitButton = $("#submitPostButton");

    if (value == "") {
        submitButton.prop("disabled", true);
        return;
    } else if (value.length >= 200) {
        submitButton.prop("disabled", true);
        return;
    }
    submitButton.prop("disabled", false);
});

let id = $(".id").data("uid");
$("#submitPostButton").click((e) => {
    e.preventDefault();
    let submitButton = $("#submitPostButton");
    let textValue = $("#postTextarea").val();
    let postImage = document.querySelector("#addPhoto").files[0];
    let postImageWrapper = document.querySelector(".postImageContainer__wrapper");
    let userid = id;
    let max = 200;
    if (textValue != "" && textValue != null && postImage == null) {
        $.post("http://localhost/Twitter/backend/ajax/post.php", { Statustext: textValue, userid: userid }, function (data) {
            $(".postContainer").html(data);
            $("#postTextarea").val("");
            $("#count").text(max);
            submitButton.prop("disabled", true);
        });
    } else if (postImage != "" && postImage != null && textValue == "") {
        let formData = new FormData();
        formData.append("user_id", userid);
        formData.append("postImage", postImage);
        $.ajax({
            url: "http://localhost/Twitter/backend/ajax/post.php",
            type: "POST",
            cache: false,
            processData: false,
            data: formData,
            contentType: false,
            success: (data) => {
                $(".postContainer").html(data);
                postImageWrapper.style.display = "none";
                $("#addPhoto").val("");
                submitButton.prop("disabled", true);
            },
        });
    } else if (postImage != null && textValue != "") {
        let formData = new FormData();
        formData.append("user_id", userid);
        formData.append("postImageText", postImage);
        formData.append("postText", textValue);
        $.ajax({
            url: "http://localhost/Twitter/backend/ajax/post.php",
            type: "POST",
            cache: false,
            processData: false,
            data: formData,
            contentType: false,
            success: (data) => {
                $(".postContainer").html(data);
                postImageWrapper.style.display = "none";
                $("#addPhoto").val("");
                submitButton.prop("disabled", true);
            },
        });
    }
});

$(document).on("click", "#go-back-home", function (event) {
    event.preventDefault();
    window.location.href = "http://localhost/Twitter/home";
});

$(document).on("click", ".notify-container", function () {
    var profileid = $(this).data("profileid");
    if (profileid != undefined) {
        $.post("http://localhost/Twitter/backend/ajax/getUsername.php", { profileid: profileid }, function (data) {
            window.location.href = "http://localhost/Twitter/" + data;
        });
    }
});

$(document).on("click", ".notify-msg-container", function () {
    var profileid = $(this).data("profileid");
    // alert(profileid);
    if (profileid != undefined) {
        window.location.href = "http://localhost/Twitter/messages/" + profileid;
    }
});

$(document).on("click", ".notify-like-container", function () {
    var profileid = $(this).data("profileid");
    var tweetid = $(this).data("tweetid");
    if (profileid != undefined) {
        window.location.href = "http://localhost/Twitter/home/" + tweetid;
    }
});

$(document).on("click", "#go-back-profile", function () {
    window.location.href = "http://localhost/Twitter/profile";
});
$(document).on("click", ".small-btn", function () {
    window.location.href = "http://localhost/Twitter/profile/editProfile";
    document.querySelector(".modal-edit").style.display = none;
    document.querySelector(".modal-edit-preview-container").style.display = none;
});

$(document).on("click", ".go-back-profile", function () {
    window.location.href = "http://localhost/Twitter/profile";
});

$(document).on("click", ".icon", function () {
    window.location.href = "http://localhost/Twitter/index";
});

$("#addPhoto").change(function () {
    let postImageWrapper = document.querySelector(".postImageContainer__wrapper");
    let submitButton = $("#submitPostButton");
    let image = document.getElementById("postImageItem");

    if (this.files && this.files[0]) {
        postImageWrapper.style.display = "block";
        submitButton.prop("disabled", false);
        let reader = new FileReader();
        reader.onload = function (e) {
            image.src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);
    }
});
// $(document).on("click", ".post", function () {
//     var tweetID = $(this).data("tweetid");
//     var userID = $(this).data("tweetby");
//     // alert(tweetID);
//     if (userID != undefined) {
//         window.location.href = "http://localhost/Twitter/home/" + tweetID;
//     }
// });
