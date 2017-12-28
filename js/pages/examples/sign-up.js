$(function () {
    if (localStorage.getItem("theme") !== null) { 
        skinCache();
     }else{
        var $body = $('body');
        $body.addClass('theme-red');  
     }
    $('#sign_up').validate({
        rules: {
            'terms': {
                required: true
            },
            'confirm': {
                equalTo: '[name="password"]'
            }
        },
        highlight: function (input) {
            console.log(input);
            $(input).parents('.form-line').addClass('error');
        },
        unhighlight: function (input) {
            $(input).parents('.form-line').removeClass('error');
        },
        errorPlacement: function (error, element) {
            $(element).parents('.input-group').append(error);
            $(element).parents('.form-group').append(error);
        }
    });
});

//Skin changer cache
function skinCache(){
    // leer datos
    var miDato = localStorage.getItem("theme");
    var $body = $('body');
    $body.addClass('theme-' + miDato);
}