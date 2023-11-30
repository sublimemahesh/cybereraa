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


 var activity1 = function(){
    var optionsArea = {
      series: [{
        name: "Running",
        data: [1400, 800, 1200, 550, 1550, 600, 1250]
      },
      {
        name: "Pending",
        data: [500, 600, 300, 1200, 1200, 800, 1400]
      }
    ],
      chart: {
      height: 400,
      type: 'area',
      group: 'social',
      toolbar: {
        show: false
      },
      zoom: {
        enabled: false
      },
    },
    dataLabels: {
      enabled: false
    },

    legend: {
        show:false,
      tooltipHoverFormatter: function(val, opts) {
        return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
      },
      markers: {
        fillColors:['var(--secondary)','var(--primary)'],
        width: 3,
        height: 16,
        strokeWidth: 0,
        radius: 16
      }
    },
    markers: {
      size: [8,0],
      strokeWidth: [4,0],
      strokeColors: ['#fff','#fff'],
      border:4,
      radius: 4,
      colors:['#2A353A','#2A353A','#fff'],
      hover: {
        size: 10,
      }
    },
    xaxis: {
      categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
      labels: {
       style: {
          colors: '#3E4954',
          fontSize: '14px',
           fontFamily: 'Poppins',
          fontWeight: 100,

        },
      },
      axisBorder:{
          show: false,
      }
    },
    yaxis: {
        labels: {
            show: true,
            align: 'right',
            minWidth: 15,
            offsetX:-16,
            style: {
              colors: '#666666',
              fontSize: '14px',
               fontFamily: 'Poppins',
              fontWeight: 100,

            },
        },
    },
    fill: {
        colors:['#fff','#FF9432'],
        type:'gradient',
        opacity: 1,
        gradient: {
            shade:'light',
            shadeIntensity: 1,
            colorStops: [
              [
                {
                  offset: 0,
                  color: 'var(--secondary)',
                  opacity: 0.4
                },
                {
                  offset: 0.6,
                  color: 'var(--secondary)',
                  opacity: 0.25
                },
                {
                  offset: 100,
                  color: 'var(--secondary)',
                  opacity: 0
                }
              ],
              [
                {
                  offset: 0,
                  color: 'var(--primary)',
                  opacity: .4
                },
                {
                  offset: 50,
                  color: 'var(--primary)',
                  opacity: 0.25
                },
                {
                  offset: 100,
                  color: '#fff',
                  opacity: 0
                }
              ]
            ]

      },
    },
    colors:['red','blue'],
    stroke:{
        curve : "straight",
         width: 3,
    },
    grid: {
      borderColor: '#e1dede',
      strokeDashArray:8,

        xaxis: {
            lines: {
            show: true,
            opacity: 0.5,
            }
        },
        yaxis: {
            lines: {
            show: true,
            opacity: 0.5,
            }
        },
        row: {
            colors: undefined,
            opacity: 0.5
        },
        column: {
            colors: undefined,
            opacity: 0.5
        },
    },
     responsive: [{
        breakpoint: 1602,
        options: {
            markers: {
                 size: [6,6,4],
                 hover: {
                    size: 7,
                  }
            },chart: {
            height: 230,
        },
        },

     }]
    };
    var chartArea = new ApexCharts(document.querySelector("#activity1"), optionsArea);
    chartArea.render();

}


activity1();
