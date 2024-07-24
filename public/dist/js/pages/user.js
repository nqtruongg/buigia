$(function () {
    $(document).ready(function () {
        var department_id = $('#department_id').val();
        if (department_id != ' ') {
            getRoleByDepartment(department_id);
        }
    });

    $(document).on('change', '#department_id', function () {
        var department_id = $('#department_id').val();
        if (department_id != ' ') {
            getRoleByDepartment(department_id);
        }
    })

    function getRoleByDepartment(department_id) {
        $.ajax({
            url: '/user/get-list-role',
            dataType: "JSON",
            method: 'POST',
            data: {
                department_id: department_id
            },
            success: function (data) {
                if (data.code === 200) {
                    let roles = data.roles;
                    let count = roles.length;
                    var html = '';
                    for (let i = 0; i < count; i++) {
                        html += `<option value="` + roles[i].id + `">` + roles[i].name + `</option>`
                    }
                    $('#role_id').html(html)
                }
            },
            error: function (err) {
                toastr.error("Thất bại", {timeOut: 5000});
            },
        });
    }
});
