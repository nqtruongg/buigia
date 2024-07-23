$(function () {
    // Summernote
    $('#summernote').summernote({
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
        ],
        placeholder: 'Thêm nội dung trò chuyện mới',
        minHeight: 250,
        callbacks: {
            onFocus: function (contents) {
                if ($('#summernote').summernote('isEmpty')) {
                    $("#summernote").html('');
                }
            }
        }
    })


    $(document).ready(function () {
        $(".edit-dialog").each(function (index) {
            $('.summernote_' + index).summernote({
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                ],
                placeholder: 'Nội dung trò chuyện',
                minHeight: 250,

            })
        });
    });

    $(document).on('click', 'button[type="submit"]', function (e) {
        e.preventDefault();
        var element = $(this).closest('form').find('textarea');
        if (element.val() == '<p><br></p>') {
            element.html('');
        }
        $(this).closest('form').submit();

    })

    $(document).on('focus', '.datepicker_start', function () {
        $(this).datepicker({
            dateFormat: 'dd/mm/yy',
            onSelect: function (selectedDate) {
                $(this).closest('.search-file').find(".datepicker_end").datepicker("option", "minDate", selectedDate);
            }
        });

        $(this).closest('.search-file').find('.datepicker_end').datepicker({
            dateFormat: 'dd/mm/yy',
            onSelect: function (selectedDate) {
                $(this).closest('.search-file').find(".datepicker_start").datepicker("option", "maxDate", selectedDate);
            }
        });
    })

    //service
    $(document).on('click', '#plus_record', function () {
        var newRow = $("#clone_tr tr").clone();

        $("#table_service").append(newRow);
        newRow.find('select').select2();

        updateRowNumbers();
    });

    function updateRowNumbers() {
        $("#table_service tr:gt(0)").each(function (index) {
            $(this).find("td:first").text(index + 1);
        });
    }

    $(document).on('click', '.minus_record', function () {
        $(this).closest('tr').remove();
    })

    $(document).on('input', 'input[type="number"]', function () {
        var value = $(this).val();
        value = value.replace(/\D/g, '');
        value = formatNumberWithCommas(value);
        $(this).val(value);
    });

    $(document).on('change', '.service_change', function () {
        let element = $(this);
        var id_service = $(this).val(),
            time = element.closest('tr').find('input[type="number"]').val();
        $.ajax({
            url: '/customer/getPriceSv',
            dataType: "JSON",
            method: 'POST',
            data: {
                id_service: id_service
            },
            success: function (data) {
                if (data.code === 200) {
                    var total = data.service.price;
                    element.closest('tr').find('.view-total').val(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    element.closest('tr').find('input[name="subtotal[]"]').val(total);
                    element.closest('tr').find('.price_ser').val(total);
                    if (data.service.type == 1) {
                        element.closest('tr').find('input[name="time_view[]"]').prop('disabled', false);
                        element.closest('tr').find('input[name="time_view[]"]').val(1);
                        element.closest('tr').find('input[name="time[]"]').val(1);
                    } else {
                        element.closest('tr').find('input[name="time_view[]"]').prop('disabled', true);
                        element.closest('tr').find('input[name="time_view[]"]').val(' ');
                        element.closest('tr').find('input[name="time[]"]').val(' ');
                    }
                }
            },
            error: function (err) {
                toastr.error("Thất bại", { timeOut: 5000 });
            },
        });
    })

    $(document).on('change', '.input-time', function () {
        var element = $(this);
        var value = $(this).val();
        var price = $(this).closest('tr').find('.price_ser').val();

        changeSubtotal(value, price, element)
    })

    $(document).on('input', '.input-time', function () {
        var element = $(this);
        var value = $(this).val();
        var price = $(this).closest('tr').find('.price_ser').val();

        changeSubtotal(value, price, element)
    })

    function changeSubtotal(value, price, element) {
        var total = price * value;
        element.closest('tr').find('.view-total').val(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        element.closest('tr').find('input[name="subtotal[]"]').val(total);
    }

    function formatNumberWithCommas(number) {
        var numberString = number.toString();
        return numberString.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    $(document).on('input', '.view-total', function () {
        var value = $(this).val();
        var value2 = value.replace(/\D/g, '');
        value2 = formatNumberWithCommas(value2);
        $(this).val(value2);
        $(this).closest('tr').find('input[name="subtotal[]"]').val(value);
    });

    $(document).on('focus', '.datepicker_start_sv', function () {
        $(this).datepicker({
            dateFormat: 'dd/mm/yy',
            onSelect: function (selectedDate) {
                $(this).closest('tr').find(".datepicker_end_sv").datepicker("option", "minDate", selectedDate);
            }
        });

        $(this).closest('tr').find('.datepicker_end_sv').datepicker({
            dateFormat: 'dd/mm/yy',
            onSelect: function (selectedDate) {
                // Cập nhật ngày tối thiểu cho ngày kết thúc
                $(this).closest('tr').find(".datepicker_start_sv").datepicker("option", "maxDate", selectedDate);
            }
        });
    })
})