$('#image_path').on('change', function() {
    let reader = new FileReader()
    reader.onload = (e) => {
        $('#img').attr('src', e.target.result);
        $('#img').css('width', '200px');
        $('#img').css('height', '200px');
    }
    reader.readAsDataURL(this.files[0]);
})

$('#banner_path').on('change', function() {
    let reader = new FileReader()
    reader.onload = (e) => {
        $('#img_banner_path').attr('src', e.target.result);
        $('#img_banner_path').css('width', '200px');
        $('#img_banner_path').css('height', '200px');
    }
    reader.readAsDataURL(this.files[0]);
})
