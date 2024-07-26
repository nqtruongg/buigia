
$('#name').on('input', function() {
    let name = $('#name').val().trim().toLowerCase();

    const vnAccents = [
        'à', 'á', 'ạ', 'ả', 'ã', 'â', 'ầ', 'ấ', 'ậ', 'ẩ', 'ẫ', 'ă', 'ằ', 'ắ', 'ặ', 'ẳ', 'ẵ',
        'è', 'é', 'ẹ', 'ẻ', 'ẽ', 'ê', 'ề', 'ế', 'ệ', 'ể', 'ễ',
        'ì', 'í', 'ị', 'ỉ', 'ĩ',
        'ò', 'ó', 'ọ', 'ỏ', 'õ', 'ô', 'ồ', 'ố', 'ộ', 'ổ', 'ỗ', 'ơ', 'ờ', 'ớ', 'ợ', 'ở', 'ỡ',
        'ù', 'ú', 'ụ', 'ủ', 'ũ', 'ư', 'ừ', 'ứ', 'ự', 'ử', 'ữ',
        'ỳ', 'ý', 'ỵ', 'ỷ', 'ỹ',
        'đ',
        'À', 'Á', 'Ạ', 'Ả', 'Ã', 'Â', 'Ầ', 'Ấ', 'Ậ', 'Ẩ', 'Ẫ', 'Ă', 'Ằ', 'Ắ', 'Ặ', 'Ẳ', 'Ẵ',
        'È', 'É', 'Ẹ', 'Ẻ', 'Ẽ', 'Ê', 'Ề', 'Ế', 'Ệ', 'Ể', 'Ễ',
        'Ì', 'Í', 'Ị', 'Ỉ', 'Ĩ',
        'Ò', 'Ó', 'Ọ', 'Ỏ', 'Õ', 'Ô', 'Ồ', 'Ố', 'Ộ', 'Ổ', 'Ỗ', 'Ơ', 'Ờ', 'Ớ', 'Ợ', 'Ở', 'Ỡ',
        'Ù', 'Ú', 'Ụ', 'Ủ', 'Ũ', 'Ư', 'Ừ', 'Ứ', 'Ự', 'Ử', 'Ữ',
        'Ỳ', 'Ý', 'Ỵ', 'Ỷ', 'Ỹ',
        'Đ'
    ];

    const vnAccentsOut = [
        'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
        'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
        'i', 'i', 'i', 'i', 'i',
        'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
        'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
        'y', 'y', 'y', 'y', 'y',
        'd',
        'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A',
        'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E',
        'I', 'I', 'I', 'I', 'I',
        'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O',
        'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U',
        'Y', 'Y', 'Y', 'Y', 'Y',
        'D'
    ];

    for (let i = 0; i < vnAccents.length; i++) {
        name = name.replace(new RegExp(vnAccents[i], 'g'), vnAccentsOut[i]);
    }

    name = name.replace(/[^\w\s-]/g, '');
    name = name.replace(/\s+/g, '-');

    $('#slug').val(name);
});

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


