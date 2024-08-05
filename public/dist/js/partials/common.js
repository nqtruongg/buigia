$(function () {
    CKEDITOR.config.versionCheck = false;
    CKEDITOR.config.allowedContent = true;
    $(document).ready(function () {
        $(".tinymce_editor_init").each(function () {
            var textareaID = $(this).attr("id");
            CKEDITOR.replace(textareaID, {});
        });

        function addImageCaption(img) {
            var altText = $(img).attr("alt");
            if (altText) {
                var caption = $("<div>", {
                    class: "image-caption",
                    text: altText,
                    css: {
                        "text-align": "center",
                        "font-style": "italic",
                    },
                });
                $(img).after(caption);
            }
        }

        CKEDITOR.on("instanceReady", function (evt) {
            var editor = evt.editor;

            $(document).on("click", ".cke_dialog_ui_button_ok", function () {
                setTimeout(function () {
                    var images = $(editor.document.$).find("img");
                    images.each(function () {
                        if (!$(this).next().hasClass("image-caption")) {
                            addImageCaption(this);
                        }
                    });
                }, 100);
            });
        });
    });

    // js load ảnh khi upload
    $(document).on("change", ".img-load-input", function () {
        let input = $(this);
        displayImage(input, ".wrap-load-image", ".img-load");
    });
    // js load nhiều ảnh khi upload
    $(document).on("change", ".img-load-input-multiple", function () {
        let input = $(this);
        displayMultipleImage(input, ".wrap-load-image", ".load-multiple-img");
    });
    // end js load ảnh khi upload

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    //select2
    $(".select2").select2({
        width: "100%",
    });

    // delete record
    $(document).on("click", ".deleteTable", deleteRecord);

    function deleteRecord(event) {
        event.preventDefault();

        let btn = $(this);

        Swal.fire({
            title: btn.data("title"),
            html: btn.data("text"),
            icon: btn.data("icon"),
            showCancelButton: true,
            confirmButtonText: "Xác nhận",
            cancelButtonText: "Thoát",
        }).then((result) => {
            if (result.isConfirmed) {
                let token = $('meta[name="csrf-token"]').length
                    ? $('meta[name="csrf-token"]').attr("content")
                    : "";
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": token,
                    },
                    url: btn.data("url"),
                    type: btn.data("method"),
                    dataType: "JSON",
                    data: btn.data("id"),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        if (data.status === 200) {
                            toastr.success(data.msg.text, { timeOut: 5000 });
                            btn.closest("tr").remove();
                        } else {
                            toastr.error(data.msg.title, { timeOut: 5000 });
                        }
                    },
                    error: function (err) {
                        console.log(err);
                        toastr.error("Thất bại", { timeOut: 5000 });
                    },
                });
            }
        });
    }

    //delete dialog
    $(document).on("click", ".deleteDialog", deleteDialog);

    function deleteDialog(e) {
        event.preventDefault();
        let btn = $(this);
        Swal.fire({
            title: btn.data("title"),
            html: btn.data("text"),
            icon: btn.data("icon"),
            showCancelButton: true,
            confirmButtonText: "Xác nhận",
            cancelButtonText: "Thoát",
        }).then((result) => {
            if (result.isConfirmed) {
                let token = $('meta[name="csrf-token"]').length
                    ? $('meta[name="csrf-token"]').attr("content")
                    : "";
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": token,
                    },
                    url: btn.data("url"),
                    type: btn.data("method"),
                    dataType: "JSON",
                    data: btn.data("id"),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        if (data.status === 200) {
                            toastr.success(data.msg.text, { timeOut: 5000 });
                            btn.closest(".dialog").remove();
                        } else {
                            toastr.error(data.msg.title, { timeOut: 5000 });
                        }
                    },
                    error: function (err) {
                        toastr.error("Thất bại", { timeOut: 5000 });
                    },
                });
            }
        });
    }
});
