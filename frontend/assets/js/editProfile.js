var cropper;
$uid = $(".id").data("uid");
$(function () {
    var modalEdit = document.querySelector(".modal-edit");
    var previewEditContainer = document.querySelector(".modal-edit-preview-container");
    $(document).on("click", ".go-back-arrow", function () {
        modalEdit.style.display = "none";
        previewEditContainer.style.display = "none";
    });

    $(document).on("change", "#edit_picPhoto", function (e) {
        modalEdit.style.display = "block";
        previewEditContainer.style.display = "block";
        $(".go-back-arrow").removeClass("edit-cover-go-back").addClass("edit-pic-go-back");
        let image = document.getElementById("imageEditPreview");
        image.src = URL.createObjectURL(e.target.files[0]);
        if (cropper !== undefined) {
            cropper.destroy();
        }
        cropper = new Cropper(image, {
            aspectRatio: 1 / 1,
            background: false,
        });
    });

    $(document).on("change", "#edit_filePhoto", function (e) {
        if (this.files && this.files[0]) {
            modalEdit.style.display = "block";
            previewEditContainer.style.display = "block";
            $(".go-back-arrow").removeClass("edit-pic-go-back").addClass("edit-cover-go-back");
            let reader = new FileReader();
            reader.onload = function (e) {
                let image = document.getElementById("imageEditPreview");
                image.src = e.target.result;
                if (cropper !== undefined) {
                    cropper.destroy();
                }
                cropper = new Cropper(image, {
                    aspectRatio: 16 / 9,
                    background: false,
                });
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    $(document).on("click", "#imageEditUploadbutton", function (e) {
        // alert($uid);
        let isProfile = $(".go-back-arrow").hasClass("edit-pic-go-back");
        if (isProfile) {
            // var name = document.getElementById("topcard_filePhoto").files[0];
            let canvas = cropper.getCroppedCanvas();
            if (canvas == null) {
                alert("NULL");
                return;
            }
            canvas.toBlob((blob) => {
                let formData = new FormData();
                formData.append("croppedImage", blob);
                formData.append("user_id", $uid);
                $.ajax({
                    url: "http://localhost/Twitter/backend/ajax/profilePhoto.php",
                    type: "POST",
                    processData: false,
                    data: formData,
                    contentType: false,
                    success: function (data) {
                        // alert(data);
                        location.reload(true);
                    },
                });
                alert(uid);
            });
        } else {
            // var name = document.getElementById("topcard_covfilePhoto").files[0];
            let canvas = cropper.getCroppedCanvas();
            if (canvas == null) {
                alert("NULL");
                return;
            }
            canvas.toBlob((blob) => {
                let formData = new FormData();
                formData.append("croppedCoverImage", blob);
                formData.append("user_id", $uid);
                $.ajax({
                    url: "http://localhost/Twitter/backend/ajax/profilePhoto.php",
                    type: "POST",
                    processData: false,
                    data: formData,
                    contentType: false,
                    success: function (data) {
                        // alert(data);
                        location.reload(true);
                    },
                });
                // alert(uid);
            });
        }
    });

    $(document).on("click", "#a-modal-save", function () {
        let usernameText = $(".edit_username").val();
        $.post("http://localhost/twitter/backend/ajax/profileText.php", { userid: $uid, usernameText: usernameText }, function (data) {
            location.reload(true);
        });

        let bioText = $(".edit_bio").val();
        $.post("http://localhost/twitter/backend/ajax/profileText.php", { userid: $uid, bioText: bioText }, function (data) {
            location.reload(true);
        });

        let locationText = $(".edit_location").val();
        $.post("http://localhost/twitter/backend/ajax/profileText.php", { userid: $uid, locationText: locationText }, function (data) {
            location.reload(true);
        });

        let websiteText = $(".edit_website").val();
        $.post("http://localhost/twitter/backend/ajax/profileText.php", { userid: $uid, websiteText: websiteText }, function (data) {
            location.reload(true);
        });

        $.post("http://localhost/twitter/backend/ajax/profileText.php", { userid: $uid, genderText: $("input[name='edit_gender']:checked").val() }, function (data) {
            location.reload(true);
        });

        let birthdayText = $(".edit_birthday").val();
        $.post("http://localhost/twitter/backend/ajax/profileText.php", { userid: $uid, birthdayText: birthdayText }, function (data) {
            location.reload(true);
        });

        let workText = $(".edit_work").val();
        $.post("http://localhost/twitter/backend/ajax/profileText.php", { userid: $uid, workText: workText }, function (data) {
            location.reload(true);
        });
    });

    $(window).on("click", function (e) {
        if (e.target == modalEdit || e.target == previewEditContainer) {
            modalEdit.style.display = "none";
            previewEditContainer.style.display = "none";
        }
    });
});
