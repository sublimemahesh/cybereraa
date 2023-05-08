let userDash = function () {
    "use strict"
    /* Search Bar ============ */
    var screenWidth = $(window).width();
    var screenHeight = $(window).height();
    var handleWebpicker = function () {
        $('#crypto-webticker').webTicker({
            height: '96px',
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