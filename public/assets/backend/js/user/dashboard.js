let userDash = function () {
    "use strict"
    /* Search Bar ============ */
    var screenWidth = $(window).width();
    var screenHeight = $(window).height();
    var handleWebpicker = function () {
        $('#crypto-webticker').webTicker({
            height: '90px',
            duplicate: true,
            startEmpty: false,
            rssfrequency: 4
        });
    }
    return {
        init: function () {
        },
        resize: function () {
        },

        load: function () {
            handleWebpicker();
        },
    }
}();


/* Document.ready Start */
jQuery(document).ready(function () {
    $('[data-bs-toggle="popover"]').popover();
    'use strict';
    userDash.init();

});
/* Document.ready END */

/* Window Load START */
jQuery(window).on('load', function () {
    'use strict';
    userDash.load();
});
/*  Window Load END */
/* Window Resize START */
jQuery(window).on('resize', function () {
    'use strict';
    userDash.resize();
});




var owl = $('.owl-banner');
owl.owlCarousel({
    items:1,
    loop:true,
    margin:10,
    autoplay:true,
    autoplayTimeout:1000,
    autoplayHoverPause:true
});



var donutChart = function(){
   
    Morris.Donut({
        element: 'morris_donught',
        data: [{
            label: "\xa0 \xa0 Promotion \xa0 \xa0",
            value: 12,
 
        }, {
            label: "\xa0 \xa0 In-Store Sales \xa0 \xa0",
            value: 30
        },{
            label: "\xa0 \xa0 In-Store Sales \xa0 \xa0",
            value: 30
        }, {
            label: "\xa0 \xa0 Mail-Order Sales \xa0 \xa0",
            value: 20
        }],
        resize: true,
        redraw: true,
        colors: ['#E085E4', '#2A353A', '#C0E192','#9568ff'],
        //responsive:true,
        
    });
 }
 

 donutChart();
            