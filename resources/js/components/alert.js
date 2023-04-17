$(function(){

    $('.alert').each(function() {
        var $alert = $(this);
        var $closeBtn = $alert.find(".close");

        $closeBtn.on("click", function() {
            $alert.remove();
        });

        setTimeout(() => {
            $alert.remove();
        }, 10000);

    });

});
