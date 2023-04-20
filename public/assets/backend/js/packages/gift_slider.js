 $('.gift-slider').owlCarousel({
    loop: true,
    margin: 25,
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
            items: 4
        }
    }
})
