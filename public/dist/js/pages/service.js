$(function () {
    function formatNumberWithCommas(number) {
        var numberString = number.toString();
        return numberString.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    $(document).on('input', 'input[name="price"]', function () {
        var value = $(this).val();
        value = value.replace(/\D/g, '');
        value = formatNumberWithCommas(value);
        $(this).val(value);
    });

    $(document).ready(function () {
        var value = $('input[name="price"]').val();
        value = value.replace(/\D/g, '');
        value = formatNumberWithCommas(value);
        $('input[name="price"]').val(value);
    })

    function attachFileInputListener(fileInput) {
        $(fileInput).on('change', function (event) {
            const files = event.target.files;
            let firstBox = true;
            for (let i = 0; i < files.length; i++) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    if (firstBox) {
                        let wrapper = $(fileInput).closest('.file-input-wrapper');
                        let img = wrapper.find('img');
                        let customButton = wrapper.find('.custom-button');
                        let removeButton = wrapper.find('.remove-button');

                        img.attr('src', e.target.result);
                        img.show();
                        customButton.hide();
                        removeButton.show();
                        firstBox = false;
                    } else {
                        let container = $('#variantContainer');
                        let newBox = $('<div>').addClass('variantColor d-flex align-items-center').html(`
                            <div class="mb-3 w-25 file-input-wrapper" style="margin-right: 18px; width: 110px !important;">
                                <div class="custom-button" style="display: none;"><i class="nav-icon fas fa-upload"></i></div>
                                <img src="${e.target.result}" alt="Preview Image" style="display: block;">
                                <button class="remove-button" type="button" style="display: flex;">&times;</button>
                            </div>
                        `);
                        let removeButton = newBox.find('.remove-button');
                        attachRemoveButtonListener(removeButton);
                        container.append(newBox);
                    }
                };
                reader.readAsDataURL(files[i]);
            }
        });
    }

    function attachRemoveButtonListener(removeButton) {
        $(removeButton).on('click', function (event) {
            var variantColor = $('.variantColor');

            variantColor.each(function (index, element) {
                if (variantColor.length === 1) {
                    let wrapper = $(event.target).closest('.file-input-wrapper');
                    let img = wrapper.find('img');
                    let fileInput = wrapper.find('input[type="file"]');
                    let customButton = wrapper.find('.custom-button');
                    img.attr('src', '');
                    img.hide();
                    customButton.show();
                    fileInput.val('');
                    $(removeButton).hide();
                } else {
                    $(event.target).closest('.variantColor').remove();
                }
            });
        });
    }

    $('#addAnhLienQuan').on('click', function () {
        let container = $('#variantContainer');
        let newBox = $('<div>').addClass('variantColor d-flex align-items-center').html(`
            <div class="mb-3 w-25 file-input-wrapper" style="margin-right: 18px; width: 110px !important;">
                <input type="file" multiple name="relatedPhotos[]" class="form-control">
                <div class="custom-button"><i class="nav-icon fas fa-upload"></i></div>
                <img src="#" alt="Preview Image" style="display: none;">
                <button class="remove-button" type="button" style="display: flex;">&times;</button>
            </div>
        `);
        let fileInput = newBox.find('input[type="file"]');
        let removeButton = newBox.find('.remove-button');
        attachFileInputListener(fileInput);
        attachRemoveButtonListener(removeButton);
        container.append(newBox);
    });

    $('input[name="relatedPhotos[]"]').each(function () {
        attachFileInputListener(this);
    });

    $('.remove-button').each(function () {
        attachRemoveButtonListener(this);
    });

    $(".btnRemoveEditAjax").click(function () {
        var url = $(this).data('url');
        var method = $(this).data('method');
        var button = $(this);

        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa ảnh này?',
            text: "Hành động này không thể hoàn tác!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: method,
                    success: function (data) {
                        Swal.fire(
                            data.message
                        );

                        var fileInputWrapper = button.closest('.variantColor');
                        fileInputWrapper.remove();

                        // if ($('#variantContainer .file-input-wrapper').length === 0) {
                        //     var newBoxHTML = `
                        //         <div class="variantColor d-flex align-items-center">
                        //             <div class="mb-3 w-25 file-input-wrapper" style="margin-right: 18px; width: 110px !important;">
                        //                 <input type="file" multiple name="relatedPhotos[]" id="relatedPhotos" class="form-control">
                        //                 <div class="custom-button" style="border: 2px solid #565656;">
                        //                     <i class="nav-icon fas fa-upload"></i>
                        //                 </div>
                        //                 <img src="#" alt="Preview Image">
                        //                 <button class="remove-button" type="button">×</button>
                        //             </div>
                        //         </div>
                        //     `;
                        //     $('#variantContainer').append(newBoxHTML);
                        // }

                    }.bind(this),
                    error: function (xhr, status, error) {
                        Swal.fire(
                            'Lỗi!',
                            'Có lỗi xảy ra trong quá trình xóa ảnh.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    $('select[name="typeOrder"]').on('change', function(e) {
        var type = $(this).val();
        var id = $(this).data('id');
        var url = $(this).data('url');
        var method = $(this).data('method');
        Swal.fire({
            title: 'Bạn muốn thay đổi trạng thái đơn này?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Hủy'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: method,
                    data: {
                        id: id,
                        type: type
                    },
                    success: function(data) {
                        Swal.fire(
                            data.message
                        );
                    },
                    error: function (xhr, status, error) {
                        Swal.fire(
                            'Lỗi!',
                            'Có lỗi xảy ra trong quá trình cập nhật.',
                            'error'
                        );
                    }
                });
            }
        });
    });

})
