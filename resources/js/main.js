$(function(){

    //Start parsley em formulários no sistema
    $('form').parsley();

    console.log($('.date'))

    $('.date').mask('99/99/9999',{placeholder:"dd/mm/yyyy"});

})
