$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //select2
    $('.select2').select2({
        width: '100%'
    });


    // delete record
    $(document).on('click', '.deleteTable', deleteRecord);

    function deleteRecord(event) {
        event.preventDefault();

        let btn = $(this);

        Swal.fire({
            title: btn.data('title'),
            html: btn.data('text'),
            icon: btn.data('icon'),
            showCancelButton: true,
            confirmButtonText: 'Xác nhận',
            cancelButtonText: 'Thoát',
        }).then((result) => {
            if (result.isConfirmed) {
                let token = $('meta[name="csrf-token"]').length ? $('meta[name="csrf-token"]').attr('content') : '';
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    url: btn.data('url'),
                    type: btn.data('method'),
                    dataType: "JSON",
                    data: btn.data('id'),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        if (data.status === 200) {
                            toastr.success(data.msg.text, {timeOut: 5000})
                            btn.closest('tr').remove();
                        } else {
                            toastr.error(data.msg.title, {timeOut: 5000})
                        }
                    },
                    error: function (err) {
                        console.log(err);
                        toastr.error('Thất bại', {timeOut: 5000})
                    }
                })
            }
        })
    }

    //delete dialog
    $(document).on('click', '.deleteDialog', deleteDialog);

    function deleteDialog(e) {
        event.preventDefault();
        let btn = $(this);
        Swal.fire({
            title: btn.data('title'),
            html: btn.data('text'),
            icon: btn.data('icon'),
            showCancelButton: true,
            confirmButtonText: 'Xác nhận',
            cancelButtonText: 'Thoát',
        }).then((result) => {
            if (result.isConfirmed) {
                let token = $('meta[name="csrf-token"]').length ? $('meta[name="csrf-token"]').attr('content') : '';
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    url: btn.data('url'),
                    type: btn.data('method'),
                    dataType: "JSON",
                    data: btn.data('id'),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        if (data.status === 200) {
                            toastr.success(data.msg.text, {timeOut: 5000})
                            btn.closest('.dialog').remove();
                        } else {
                            toastr.error(data.msg.title, {timeOut: 5000})
                        }
                    },
                    error: function (err) {
                        toastr.error('Thất bại', {timeOut: 5000})
                    }
                })
            }
        })
    }
})
