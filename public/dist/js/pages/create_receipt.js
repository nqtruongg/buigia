const defaultNumbers = ' hai ba bốn năm sáu bảy tám chín';

const chuHangDonVi = ('1 một' + defaultNumbers).split(' ');
const chuHangChuc = ('lẻ mười' + defaultNumbers).split(' ');
const chuHangTram = ('không một' + defaultNumbers).split(' ');

function convert_block_three(number) {
    if (number == '000') return '';
    var _a = number + ''; //Convert biến 'number' thành kiểu string

    //Kiểm tra độ dài của khối
    switch (_a.length) {
        case 0:
            return '';
        case 1:
            return chuHangDonVi[_a];
        case 2:
            return convert_block_two(_a);
        case 3:
            var chuc_dv = '';
            if (_a.slice(1, 3) != '00') {
                chuc_dv = convert_block_two(_a.slice(1, 3));
            }
            var tram = chuHangTram[_a[0]] + ' trăm';
            return tram + ' ' + chuc_dv;
    }
}

function convert_block_two(number) {
    var dv = chuHangDonVi[number[1]];
    var chuc = chuHangChuc[number[0]];
    var append = '';

    // Nếu chữ số hàng đơn vị là 5
    if (number[0] > 0 && number[1] == 5) {
        dv = 'lăm'
    }

    // Nếu số hàng chục lớn hơn 1
    if (number[0] > 1) {
        append = ' mươi';

        if (number[1] == 1) {
            dv = ' mốt';
        }
    }

    return chuc + '' + append + ' ' + dv;
}

const dvBlock = '1 nghìn triệu tỷ'.split(' ');

function to_vietnamese(number) {
    var str = parseInt(number) + '';
    var i = 0;
    var arr = [];
    var index = str.length;
    var result = [];
    var rsString = '';

    if (index == 0 || str == 'NaN') {
        return '';
    }

    // Chia chuỗi số thành một mảng từng khối có 3 chữ số
    while (index >= 0) {
        arr.push(str.substring(index, Math.max(index - 3, 0)));
        index -= 3;
    }

    // Lặp từng khối trong mảng trên và convert từng khối đấy ra chữ Việt Nam
    for (i = arr.length - 1; i >= 0; i--) {
        if (arr[i] != '' && arr[i] != '000') {
            result.push(convert_block_three(arr[i]));

            // Thêm đuôi của mỗi khối
            if (dvBlock[i]) {
                result.push(dvBlock[i]);
            }
        }
    }

    // Join mảng kết quả lại thành chuỗi string
    rsString = result.join(' ');

    // Trả về kết quả kèm xóa những ký tự thừa
    return rsString.replace(/[0-9]/g, '').replace(/ /g, ' ').replace(/ $/, '');
}
$(document).ready(function(){
    var price = $('input[name="price"]').val();
    var price_text =  to_vietnamese(price.replace(/,/g, '')).charAt(0).toUpperCase() + to_vietnamese(price.replace(/,/g, '')).slice(1);
    $('.text-price').html(price_text);
})

$(document).on('click', '#view', function(){
    var customer = $('input[name="customer_name"]').val();
    var price = $('input[name="price"]').val();
    var reason = $('input[name="reason"]').val();
    var address = $('input[name="address"]').val();
    var price_text =  to_vietnamese(price.replace(/,/g, '')).charAt(0).toUpperCase() + to_vietnamese(price.replace(/,/g, '')).slice(1);

    if (customer === '' || price === '' || reason === '' || address === '') {
        toastr.error('Vui lòng điền đầy đủ thông tin.');
        return; // Dừng lại nếu một trong các trường bị bỏ trống
    }
    
    $('#payer').html(customer);
    $('#address_pay').html(address);
    $('#reason_pay').html(reason);
    $('#price_pay').html(price);
    $('#price_pay').html(price);
    $('.text-price').html(price_text);
    $('#preview').removeClass('d-none');
    $('button[type="submit"]').removeClass('d-none');
})

$(document).on('change', 'select[name="customer"]', function(){
    var customer = $(this).val();

    $.ajax({
        url: '/receipt/getAddress',
        dataType: "JSON",
        method: 'POST',
        data: {
            customer: customer
        },
        success: function (data) {
            if (data.code === 200) {
                $('input[name="address"]').val(data.address);
                $('input[name="customer_name"]').val(data.name);
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

$(document).on('input', 'input[name="price"]', function () {
    var value = $(this).val();
    value = value.replace(/\D/g, '');
    value = formatNumberWithCommas(value);
    $(this).val(value);
});

$(document).on('change', 'input[name="price"]', function () {
    var value = $(this).val();
    value = value.replace(/\D/g, '');
    value = formatNumberWithCommas(value);
    $(this).val(value);
});