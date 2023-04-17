$(function(){

    $('form.search-filter').each(function() {

        var $form = $(this);

        $form.find(".input").on("change", function() {
            $form.trigger("submit");
        });

    });

});
