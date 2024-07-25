
//index
$(document).ready(function () {
    // Abstracted function to handle the AJAX request and UI updates
    function toggleStatus(button, statusType) {
        var itemId = button.data("id");
        var url = button.data("url");
        var csrfToken = $('meta[name="csrf-token"]').attr("content");

        $.ajax({
            url: url,
            type: "POST",
            data: {
                id: itemId,
                _token: csrfToken,
            },
            success: function (response) {
                var newStatus =
                    statusType === "active"
                        ? response.newStatus
                        : response.newHot;
                button.data("status", newStatus);

                var buttonText =
                    newStatus == 1
                        ? statusType === "active"
                            ? "Hiển thị"
                            : "Nổi bật"
                        : "Ẩn";
                button.text(buttonText);

                button.removeClass("btn-success btn-danger");
                var buttonClass = newStatus == 1 ? "btn-success" : "btn-danger";
                button.addClass(buttonClass);

                Swal.fire({
                    title: "Thành công!",
                    text: "Cập nhật trạng thái thành công!",
                    icon: "success",
                    confirmButtonText: "OK",
                });
            },
        });
    }

    // Event handler for toggling active status
    $(".toggle-active-btn").click(function () {
        toggleStatus($(this), "active");
    });

    // Event handler for toggling hot status
    $(".toggle-hot-btn").click(function () {
        toggleStatus($(this), "hot");
    });
});


//create and edit
$(document).ready(function () {
    $(document).on("change", "#city_register", function () {
        let urlRequest = $(this).data("url");
        let mythis = $(this);
        let value = $(this).val();
        let defaultCity = "<option value=''>--Tỉnh/Thành Phố--</option>";
        let defaultDistrict = "<option value=''>--Quận/Huyện--</option>";
        let defaultCommune = "<option value=''>--Phường/Xã--</option>";
        if (!value) {
            $("#district_register").html(defaultDistrict);
            $("#commune_register").html(defaultCommune);
        } else {
            $.ajax({
                type: "GET",
                url: urlRequest,
                data: {
                    cityId: value,
                },
                success: function (data) {
                    if (data.code == 200) {
                        let html = defaultDistrict + data.data;
                        $("#district_register").html(html);
                        $("#commune_register").html(defaultCommune);
                    }
                },
            });
        }
    });
    $(document).on("change", "#district_register", function () {
        let urlRequest = $(this).data("url");
        let mythis = $(this);
        let value = $(this).val();
        let defaultCity = "<option value=''>--Tỉnh/Thành Phố--</option>";
        let defaultDistrict = "<option value=''>--Quận/Huyện--</option>";
        let defaultCommune = "<option value=''>--Phường/Xã--</option>";
        if (!value) {
            $("#commune_register").html(defaultCommune);
        } else {
            $.ajax({
                type: "GET",
                url: urlRequest,
                data: {
                    districtId: value,
                },
                success: function (data) {
                    if (data.code == 200) {
                        let html = defaultCommune + data.data;
                        $("#commune_register").html(html);
                    }
                },
            });
        }
    });
});
