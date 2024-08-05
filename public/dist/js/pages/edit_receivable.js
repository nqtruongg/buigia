$(function () {

    $(document).ready(function () {
        datePicker();
        serviceSelect2();
        summerNote();
    })

    function datePicker() {
        $('.date-picker').datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true
        });
    }

    $(document).ready(function () {
        function formatResult(result) {
            if (!result.id) return result.text;
            var markup =
                '<div class="clearfix">' +
                "<p>" +
                result.text + "</p>" +
                "<p>" +
                $(result.element).data("name") + "</p>" +
                "</div>";
            return markup;
        }

        function formatSelection(result) {
            var name = $(result.element).data("name");
            if (typeof name === 'undefined') {
                return result.text;
            } else {
                return name + ' (' + result.text + ')';
            }
        }


        $("#customer_info").select2({
            escapeMarkup: function (m) {
                return m;
            },
            placeholder: "Chọn khách hàng",
            closeOnSelect: true,
            templateResult: formatResult,
            templateSelection: formatSelection,
            matcher: function (params, data) {
                if ($.trim(params.term) === '') {
                    return data;
                }
                if (typeof data.text === 'undefined' || typeof $(data.element).data("name") ===
                    'undefined') {
                    return null;
                }
                if (data.text.toUpperCase().indexOf(params.term.toUpperCase()) > -1 ||
                    $(data.element).data("name").toUpperCase().indexOf(
                        params.term.toUpperCase()) > -1) {
                    return data;
                }
                return null;
            }
        });
    });

    function formatNumberWithCommas(number) {
        var numberString = number.toString();
        return numberString.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    $(document).on('input', '.input-price', function () {
        var value = $(this).val();
        value = value.replace(/\D/g, '');
        value = formatNumberWithCommas(value);
        $(this).val(value);
    });

    $(document).on('change', '.input-price', function () {
        var value = $(this).val();
        value = value.replace(/\D/g, '');
        value = formatNumberWithCommas(value);
        $(this).val(value);
    });

    $(document).ready(function () {
        $('.input-price').each(function (index, element) {
            var value = $(element).val();
            value = value.replace(/\D/g, '');
            value = formatNumberWithCommas(value);
            $(this).val(value);
        });
    });

    $(document).on('input', '.input-price', function () {
        var contract_value_str = $('input[name="contract_value"]').val().replace(/,/g, '');
        var value_1_str = $('input[name="advance_value_1"]').val().replace(/,/g, '');
        var value_2_str = $('input[name="advance_value_2"]').val().replace(/,/g, '');
        var value_3_str = $('input[name="advance_value_3"]').val().replace(/,/g, '');

        // Chuyển đổi chuỗi thành số và kiểm tra nếu giá trị không hợp lệ, gán giá trị mặc định là 0
        var contract_value = parseFloat(contract_value_str) || 0;
        var value_1 = parseFloat(value_1_str) || 0;
        var value_2 = parseFloat(value_2_str) || 0;
        var value_3 = parseFloat(value_3_str) || 0;

        var total_value = value_1 + value_2 + value_3;
        var amount_owed = contract_value - total_value;

        $('input[name="total_advance"]').val(formatNumberWithCommas(total_value));
        if (amount_owed >= 0) {
            amount_owed = amount_owed;
        } else {
            amount_owed = ' ';
        }
        $('input[name="amount_owed"]').val(formatNumberWithCommas(amount_owed));
    })

    $(document).on('change', '#customer_info', function () {
        var customer_id = $(this).val();
        $.ajax({
            url: '/receivable/get-list-service',
            dataType: "JSON",
            method: 'POST',
            data: {
                customer_id: customer_id
            },
            success: function (data) {
                if (data.code === 200) {
                    let services = data.services;
                    let count = services.length;
                    var html = '';
                    for (let i = 0; i < count; i++) {
                        html += `<option value="` + services[i].id + `">` + services[i].name + `</option>`
                    }
                    $('#list_service').html(html);
                    serviceSelect2();
                }
            },
            error: function (err) {
                toastr.error("Thất bại", { timeOut: 5000 });
            },
        });
    })

    function serviceSelect2() {
        $('#list_service').select2({
            closeOnSelect: false
        })
    }

    function summerNote() {
        $('.summernote').summernote({
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
            placeholder: 'Ghi chú',
            minHeight: 250,
            callbacks: {
                onFocus: function (contents) {
                    if ($('#summernote').summernote('isEmpty')) {
                        $("#summernote").html('');
                    }
                }
            }
        })
    }
});
