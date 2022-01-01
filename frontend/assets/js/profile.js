var cropper;
$uid = $(".id").data("uid");
$(function () {
    // Set up profile
    var modal = document.querySelector(".modal-pic");
    var profileModal = document.querySelector(".art-pic-step");
    var coverModal = document.querySelector(".art-cov-step");
    var previewContainer = document.querySelector(".modal-preview-container");

    $(document).on("click", "#set-up-profile", function () {
        modal.style.display = "block";
        profileModal.style.display = "block";
        coverModal.style.display = "none";
    });

    $(document).on("click", "#a-modal-skip", function () {
        profileModal.style.display = "none";
        coverModal.style.display = "block";
    });

    $(document).on("click", ".profile-go-back", function () {
        profileModal.style.display = "block";
        previewContainer.style.display = "none";
        coverModal.style.display = "none";
    });

    $(document).on("click", ".cover-go-back", function () {
        previewContainer.style.display = "none";
        coverModal.style.display = "block";
        profileModal.style.display = "none";
        let hasClassCover = $(this).hasClass("cover-go-back");
        if (hasClassCover) {
            $(".go-back-arrow").addClass("profile-go-back").removeClass("cover-go-back");
        }
    });

    $(document).on("change", "#topcard_filePhoto", function (e) {
        if (this.files && this.files[0]) {
            profileModal.style.display = "none";
            $(".go-back-arrow").addClass("profile-go-back").removeClass("cover-go-back");
            previewContainer.style.display = "block";
            let reader = new FileReader();
            reader.onload = function (e) {
                let image = document.getElementById("imagePreview");
                image.src = e.target.result;
                if (cropper !== undefined) {
                    cropper.destroy();
                }
                cropper = new Cropper(image, {
                    aspectRatio: 1 / 1,
                    background: false,
                });
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    $(document).on("change", "#topcard_covfilePhoto", function (e) {
        if (this.files && this.files[0]) {
            coverModal.style.display = "none";
            $(".go-back-arrow").removeClass("profile-go-back").addClass("cover-go-back");
            previewContainer.style.display = "block";
            let reader = new FileReader();
            reader.onload = function (e) {
                let image = document.getElementById("imagePreview");
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

    $(document).on("click", "#imageUploadbutton", function (e) {
        // alert("hi danh");
        let isProfile = $(".go-back-arrow").hasClass("profile-go-back");
        if (isProfile) {
            var name = document.getElementById("topcard_filePhoto").files[0];
            let canvas = cropper.getCroppedCanvas();
            if (canvas == null) {
                alert("NULL vcl");
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
                // alert(uid);
            });
        } else {
            var name = document.getElementById("topcard_covfilePhoto").files[0];
            let canvas = cropper.getCroppedCanvas();
            if (canvas == null) {
                alert("NULL vcl");
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

    $(window).on("click", function (e) {
        if (e.target == modal) {
            modal.style.display = "none";
        }
    });
});

$(function () {
    var modalEdit = document.querySelector(".modal-edit");
    var profileEdit = document.querySelector(".art-step");
    var previewEditContainer = document.querySelector(".modal-edit-preview-container");
    $(document).on("click", "#edited-profile", function () {
        modalEdit.style.display = "block";
        profileEdit.style.display = "block";
    });

    $(document).on("click", ".go-back-arrow", function () {
        profileEdit.style.display = "block";
        previewEditContainer.style.display = "none";
    });

    $(document).on("change", "#edit_picPhoto", function (e) {
        profileEdit.style.display = "none";
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
            profileEdit.style.display = "none";
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
        // alert("hi danh");
        let isProfile = $(".go-back-arrow").hasClass("edit-pic-go-back");
        if (isProfile) {
            var name = document.getElementById("topcard_filePhoto").files[0];
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
                // alert(uid);
            });
        } else {
            var name = document.getElementById("topcard_covfilePhoto").files[0];
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
