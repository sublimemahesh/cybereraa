var owl_price_slider = $("#price-slider");
owl_price_slider.owlCarousel({
    items: 6,
    loop: true,
    margin: 10,
    autoplay: true,
    autoplayTimeout: 3000,
    autoplayHoverPause: true,
});

$(function() {
    // Owl Carousel
    var owl = $(".casino-slider");
    owl.owlCarousel({
        
        navigation: false,
        pagination: false,
        dots: false,
        items: 1,
        loop: true,
        margin: 10,
        autoplay: true,
        //autoplayTimeout: 10000,
        autoplayHoverPause: true
    });
});