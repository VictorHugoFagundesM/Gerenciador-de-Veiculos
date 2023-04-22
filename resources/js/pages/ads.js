'use strict';
import moment from 'moment';

$(function(){

    $(".page.page-ad-rent").each(function() {

        var $page = $(this);
        var $beginInput = $page.find('[name="begin_date"]');
        var $endInput = $page.find('[name="end_date"]');
        var $total = $page.find('.form-footer .total span');
        var pricePerDay = parseFloat($page.find('.form-footer .total').data("price-per-day"));

        $page.find('[name="end_date"], [name="begin_date"]').on("change", function() {
            var beginDate = moment($beginInput.val(), 'DD/MM/YYYY');
            var endDate = moment($endInput.val(), 'DD/MM/YYYY');
            var days = endDate.diff(beginDate, 'days');

            if(days > 0) {
                $total.text(days*pricePerDay);

            } else {
                $total.text(0);
            }

        });

    });

});
