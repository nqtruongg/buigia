Dropzone.autoDiscover = false;
$(function () {
    $(document).on("focus", ".datepicker_start", function () {
        $(this).datepicker({
            dateFormat: "dd/mm/yy",
            changeMonth: true,
            changeYear: true,
            onSelect: function (selectedDate) {
                $(this)
                    .closest("tr")
                    .find(".datepicker_end")
                    .datepicker("option", "minDate", selectedDate);
            },
        });

        $(this)
            .closest("tr")
            .find(".datepicker_end")
            .datepicker({
                dateFormat: "dd/mm/yy",
                onSelect: function (selectedDate) {
                    // Cập nhật ngày tối thiểu cho ngày kết thúc
                    $(this)
                        .closest("tr")
                        .find(".datepicker_start")
                        .datepicker("option", "maxDate", selectedDate);
                },
            });

        $(this)
            .closest("tr")
            .find(".datepicker_contract_date")
            .datepicker({
                dateFormat: "dd/mm/yy",
                onSelect: function (selectedDate) {
                    $(this)
                        .closest("tr")
                        .find(".datepicker_contract_date")
                        .datepicker("option", "maxDate", selectedDate);
                },
            });
    });

    const dropzone = new Dropzone("#customerDropzone", {
        url: "/customer/upload",
        paramName: "files",
        autoProcessQueue: true,
        parallelUploads: 2,
        thumbnailHeight: 120,
        thumbnailWidth: 120,
        maxFilesize: 3,
        filesizeBase: 1000,
        addRemoveLinks: true, // Hiển thị liên kết Xóa
        dictRemoveFile: "Xoá",
        init: function () {
            this.on("removedfile", function (file) {
                $.ajax({
                    url: `/customer/remove`,
                    data: {
                        file_name: file.name,
                    },
                    type: "POST",
                    success: function (data) {
                        console.log(data.message);
                    },
                    error: function (error) {
                        console.error("Lỗi khi gửi yêu cầu đến server:", error);
                    },
                });
            });
            this.on("success", function (file, response) {
                var uploadedFilePath = response.path;

                var hiddenInput = $("<input>")
                    .attr("type", "hidden")
                    .attr("name", "file_paths[]")
                    .val(uploadedFilePath);

                var previewElement = $(file.previewElement);
                previewElement.append(hiddenInput);
            });
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="token"]').attr("content"),
        },
    });

    var filesFromDatabase = $('input[name="files_hidden"]').val();
    if (filesFromDatabase) {
        filesFromDatabase = JSON.parse(filesFromDatabase);
        $.each(filesFromDatabase, function (index, file) {
            var filePath = file.file_path;
            var mockFile = {
                name: filePath.split("/").pop(),
                size: file.file_size ?? 0,
            };
            if (isImageFile(filePath)) {
                dropzone.emit("addedfile", mockFile);
                dropzone.emit("thumbnail", mockFile, filePath);
            } else {
                dropzone.emit("addedfile", mockFile);
                dropzone.emit(
                    "thumbnail",
                    mockFile,
                    "/dist/img/file-default.png"
                );
            }
            var hiddenInput = $("<input>", {
                type: "hidden",
                name: "file_saves[]",
                value: file.id,
            });
            $(mockFile.previewElement).append(hiddenInput);
            dropzone.emit("complete", mockFile);
        });
    }

    // //////
    // var filesOld = $('input[name="files_hidden_old"]').val();
    // if (filesOld) {
    //     filesOld = JSON.parse(filesOld);
    //     $.each(filesOld, function (index, file) {
    //         console.log(file);
    //         // var filePath = file.file_path;
    //         // var mockFile = { name: filePath.split('/').pop(), size: file.file_size ?? 0 };
    //         var mockFile = {name: file.split('/').pop(), size: 0}
    //         if (isImageFile(file)) {
    //             dropzone.emit("addedfile", mockFile);
    //             dropzone.emit("thumbnail", mockFile, file);
    //         } else {
    //             dropzone.emit("addedfile", mockFile);
    //             dropzone.emit("thumbnail", mockFile, '/dist/img/file-default.png');
    //         }
    //         var hiddenInput = $('<input>', {
    //             type: 'hidden',
    //             name: 'file_paths[]',
    //             value: file
    //         });
    //         $(mockFile.previewElement).append(hiddenInput);
    //         dropzone.emit("complete", mockFile);
    //     });
    // }
    // /////



    function isImageFile(filePath) {
        var imageExtensions = ["jpg", "jpeg", "png", "gif"];
        var extension = filePath.split(".").pop().toLowerCase();
        return imageExtensions.includes(extension);
    }


    // $(document).on('change', '.status-dell', function () {
    //     var selectedValue = $(this).val();
    //     var currentRow = $(this).closest('tr');
    //
    //     var contractDateDisabled = currentRow.find('.contractDateDisabled');
    //     var contractDateInput = currentRow.find('.contractDateInput');
    //
    //     if (selectedValue == '3') {
    //         contractDateDisabled.hide();
    //         contractDateInput.show();
    //     } else {
    //         contractDateDisabled.show();
    //         contractDateInput.hide();
    //         contractDateInput.val('');
    //     }
    // });

    $(document).on("click", "#plus_record", function () {

        var newRow = $("#clone_tr tr").clone();
        newRow.addClass('booking-box');

        newRow.find('.contractDateInput  .contractDateDisabled').show();
        newRow.find('.contractDateInput input[name="contract_date[]"]').hide();

        $("#table_service").append(newRow);

        newRow.find('select[name="services[]"]').select2({
            width: "100%",
        });
        newRow.find('select[name="user_id[]"]').select2({
            width: "100%",
        });
        // newRow.find('.status-dell').select2({
        //     width: "100%",
        // });

        updateRowNumbers();
    });



    function updateRowNumbers() {
        $("#table_service tr:gt(0)").each(function (index) {
            $(this)
                .find("td:first")
                .text(index + 1);
        });
    }

    $(document).on("click", ".minus_record", function () {
        $(this).closest("tr").remove();
    });

    $(document).on("input", 'input[type="number"]', function () {
        var value = $(this).val();
        value = value.replace(/\D/g, "");
        value = formatNumberWithCommas(value);
        $(this).val(value);
    });

    $(document).on("change", ".service_change", function () {
        let element = $(this);
        var id_service = $(this).val(),
            time = element.closest("tr").find('input[type="number"]').val();
        $.ajax({
            url: "/customer/getPriceSv",
            dataType: "JSON",
            method: "POST",
            data: {
                id_service: id_service,
            },
            success: function (data) {
                if (data.code === 200) {
                    var total = data.service.price;
                    element
                        .closest("tr")
                        .find(".view-total")
                        .val(
                            total
                                .toString()
                                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                        );
                    element
                        .closest("tr")
                        .find('input[name="subtotal[]"]')
                        .val(total);
                    element.closest("tr").find(".price_ser").val(total);
                    if (data.service.type == 1) {
                        element
                            .closest("tr")
                            .find('input[name="time_view[]"]')
                            .prop("disabled", false);
                        element
                            .closest("tr")
                            .find('input[name="time_view[]"]')
                            .val(1);
                        element
                            .closest("tr")
                            .find('input[name="time[]"]')
                            .val(1);
                    } else {
                        element
                            .closest("tr")
                            .find('input[name="time_view[]"]')
                            .prop("disabled", true);
                        element
                            .closest("tr")
                            .find('input[name="time_view[]"]')
                            .val(" ");
                        element
                            .closest("tr")
                            .find('input[name="time[]"]')
                            .val(" ");
                    }
                }
            },
            error: function (err) {
                toastr.error("Thất bại", { timeOut: 5000 });
            },
        });
    });

    $(document).on("change", ".input-time", function () {
        var element = $(this);
        var value = $(this).val();
        var price = $(this).closest("tr").find(".price_ser").val();

        changeSubtotal(value, price, element);
    });

    $(document).on("input", ".input-time", function () {
        var element = $(this);
        var value = $(this).val();
        var price = $(this).closest("tr").find(".price_ser").val();

        changeSubtotal(value, price, element);
    });

    function changeSubtotal(value, price, element) {
        var total = price * value;
        element
            .closest("tr")
            .find(".view-total")
            .val(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        element.closest("tr").find('input[name="subtotal[]"]').val(total);
    }

    function formatNumberWithCommas(number) {
        var numberString = number.toString();
        return numberString.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    $(document).on("input", ".view-total", function () {
        var value = $(this).val();
        var value2 = value.replace(/\D/g, "");
        value2 = formatNumberWithCommas(value2);
        $(this).val(value2);
        $(this).closest("tr").find('input[name="subtotal[]"]').val(value);
    });

    $(document).on("input", 'input[name="time_view[]"]', function () {
        var value = $(this).val();
        $(this).closest("tr").find('input[name="time[]"]').val(value);
    });

    $(document).on("change", "#status", function () {
        var value = $(this).val();
        if (value == 1 || value == 2) {
            $("#custom-tabs-four-messages-tab").removeClass("d-none");
        } else {
            $("#custom-tabs-four-messages-tab").addClass("d-none");
        }
    });

    $(document).ready(function () {
        var value = $("#status").val();
        if (value == 1 || value == 2) {
            $("#custom-tabs-four-messages-tab").removeClass("d-none");
        } else {
            $("#custom-tabs-four-messages-tab").addClass("d-none");
        }
    });

    $(document).ready(function () {
        var $checkbox = $("#s1-14");
        var $inputDiv = $(".checkTypeCustomer");
        function toggleInput() {
            if ($checkbox.is(":checked")) {
                $inputDiv.show(); // Show
            } else {
                $inputDiv.hide(); // Hide
            }
        }
        toggleInput();
        $checkbox.change(toggleInput);
    });

    $("#image_path").on("change", function () {
        let reader = new FileReader();
        reader.onload = (e) => {
            $("#img").attr("src", e.target.result);
            $("#img").css("width", "200px");
            $("#img").css("height", "200px");
            $("#img").css("object-fit", "cover");
        };
        reader.readAsDataURL(this.files[0]);
    });
});
