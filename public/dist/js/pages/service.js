$(function () {
    function formatNumberWithCommas(number) {
        var numberString = number.toString();
        return numberString.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    $(document).on('input', 'input[name="price"]', function() {
        var value = $(this).val();
        value = value.replace(/\D/g, '');
        value = formatNumberWithCommas(value);
        $(this).val(value);
    });

    $(document).ready(function(){
        var value = $('input[name="price"]').val();
        value = value.replace(/\D/g, '');
        value = formatNumberWithCommas(value);
        $('input[name="price"]').val(value);
    })

    
})