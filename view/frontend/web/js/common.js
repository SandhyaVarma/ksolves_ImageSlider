require(['jquery', 'jquery/ui', 'slick'], function($) {
    $(document).ready(function() {
        $(".regular").slick({
            dots: true,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1
        });
    });
});
