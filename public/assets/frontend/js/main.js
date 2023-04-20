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



$('.gift-slider').owlCarousel({
    loop: true,
    margin: 30,
    autoplay: true,
    autoPlaySpeed: 5000,
    autoPlayTimeout: 5000,
    pagination: false,
    dots: false,

    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 1
        },
        1000: {
            items: 3
        }
    }
})