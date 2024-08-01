Dropzone.autoDiscover = false;
$(function () {
    $(document).ready(function () {
        $('#multiCollapseExample1').on('show.bs.collapse', function () {
            $('#multiCollapseExample2').collapse('hide');
        });

        $('#multiCollapseExample2').on('show.bs.collapse', function () {
            $('#multiCollapseExample1').collapse('hide');
        });
    });

    const dropzone = new Dropzone("#customerDropzone", {
        url: '/customer/upload',
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
            this.on('removedfile', function (file) {
                $.ajax({
                    url: `/customer/remove`,
                    data: {
                        file_name: file.name
                    },
                    type: 'POST',
                    success: function (data) {
                        console.log(data.message);
                    },
                    error: function (error) {
                        console.error('Lỗi khi gửi yêu cầu đến server:', error);
                    }
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
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
        }
    });

    $(document).on('focus', '.datepicker_start', function () {
        $(this).datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            onSelect: function (selectedDate) {
                $(this).closest('.search-file').find(".datepicker_end").datepicker("option", "minDate", selectedDate);
            }
        });

        $(this).closest('.search-file').find('.datepicker_end').datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            onSelect: function (selectedDate) {
                $(this).closest('.search-file').find(".datepicker_start").datepicker("option", "maxDate", selectedDate);
            }
        });
    })

    $(document).on('focus', '.datepicker_end', function () {
        $(this).datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            onSelect: function (selectedDate) {
                $(this).closest('.search-file').find(".datepicker_end").datepicker("option", "minDate", selectedDate);
            }
        });

        $(this).closest('.search-file').find('.datepicker_end').datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            onSelect: function (selectedDate) {
                $(this).closest('.search-file').find(".datepicker_start").datepicker("option", "maxDate", selectedDate);
            }
        });
    })

    //service
    $(document).on('click', '#plus_record', function () {
        var newRow = $("#clone_tr tr").clone();

        newRow.addClass('booking-box');

        $("#table_service").append(newRow);
        newRow.find('select[name="services[]"]').select2({
            width: '100%'
        });
        newRow.find('select[name="supplier[]"]').select2({
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

    $(document).on('input', 'input[name="time_view[]"]', function () {
        var value = $(this).val();
        $(this).closest('tr').find('input[name="time[]"]').val(value);
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
});
