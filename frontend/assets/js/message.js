$(function () {
    var modal = document.querySelector(".popup-msg-container");

    $(document).on("click", ".msg-btn", function (e) {
        modal.style.display = "block";
        e.preventDefault();
    });

    $(document).on("click", ".popup-msg-icon", function () {
        modal.style.display = "none";
    });

    $(window).on("click", function (e) {
        if (e.target == modal) {
            modal.style.display = "none";
        }
    });

    $(document).on("click", ".h-ment", function () {
        var profileID = $(this).data("profileid");
        if (profileID != "" && profileID != undefined) {
            window.location.href = "http://localhost/twitter/messages/" + profileID;
        }
    });

    // $(document).on("keydown", ".s-user", function (e) {
    //     console.log(e);
    // });
});
