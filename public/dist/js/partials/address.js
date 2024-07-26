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
