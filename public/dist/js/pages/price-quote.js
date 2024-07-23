
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
        placeholder: 'Nội dung',
        minHeight: 230,
        callbacks: {
            onFocus: function (contents) {
                if ($('#summernote').summernote('isEmpty')) {
                    $("#summernote").html('');
                }
            }
        }
    })

    $(document).on('click', '#plus_record', function () {
        var newRow = $("#clone_tr tr").clone();

        $("#table_service").append(newRow);
        newRow.find('select').select2({
            width: '100%'
        });

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
                    sumPrice();
                }
            },
            error: function (err) {
                toastr.error("Thất bại", { timeOut: 5000 });
            },
        });
    })


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

    $(document).on('change', 'select[name="services[]"]', function () {
        sumPrice();
    })

    $(document).on('change', 'select[input="view_total[]"]', function () {
        sumPrice();
    })

    $(document).on('input', 'select[input="view_total[]"]', function () {
        sumPrice();
    })

    function sumPrice() {
        var sum = 0;
        $('#table_service input[name="view_total[]"]').each(function (index, value) {
            var val = $(value).val().replace(/,/g, '');
            sum += parseInt(val);
        });

        $('.sum-price').html(formatNumberWithCommas(sum));
        $('input[name="total_hidden"]').val(sum)
    }
});
