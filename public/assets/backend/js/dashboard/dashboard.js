(function ($) {
    /* "use strict" */

    var dzChartlist = function () {

        var screenWidth = $(window).width();

        var swipercard = function () {
            var swiper = new Swiper('.crypto-Swiper', {
                speed: 1500, slidesPerView: 4, spaceBetween: 40, parallax: true, loop: false, breakpoints: {

                    300: {
                        slidesPerView: 1, spaceBetween: 30,
                    }, 576: {
                        slidesPerView: 2, spaceBetween: 30,
                    }, 991: {
                        slidesPerView: 3, spaceBetween: 30,
                    }, 1200: {
                        slidesPerView: 3, spaceBetween: 30,
                    }, 1600: {
                        slidesPerView: 4, spaceBetween: 30,
                    },
                },
            });
        }




        var NewCustomers = function () {
            var options = {
                series: [
                    {
                        name: 'Net Profit',
                        data: [100, 300, 200, 250, 200, 240, 180, 230, 200, 250, 300],
                        /* radius: 30,	 */
                    },
                ],
                chart: {
                    type: 'area',
                    height: 130,
                    width: 400,
                    toolbar: {
                        show: false,
                    },
                    zoom: {
                        enabled: false
                    },
                    sparkline: {
                        enabled: true
                    }

                },

                colors: ['var(--primary)'],
                dataLabels: {
                    enabled: false,
                },

                legend: {
                    show: false,
                },
                stroke: {
                    show: true,
                    width: 3,
                    curve: 'smooth',
                    colors: ['var(--primary)'],
                },

                grid: {
                    show: false,
                    borderColor: '#eee',
                    padding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: -1

                    }
                },
                states: {
                    normal: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    hover: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    active: {
                        allowMultipleDataPointsSelection: false,
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    }
                },
                xaxis: {
                    categories: ['Jan', 'feb', 'Mar', 'Apr', 'May', 'June', 'July', 'August', 'Sept', 'Oct'],
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        show: false,
                        style: {
                            fontSize: '12px',
                        }
                    },
                    crosshairs: {
                        show: false,
                        position: 'front',
                        stroke: {
                            width: 1,
                            dashArray: 3
                        }
                    },
                    tooltip: {
                        enabled: true,
                        formatter: undefined,
                        offsetY: 0,
                        style: {
                            fontSize: '12px',
                        }
                    }
                },
                yaxis: {
                    show: false,
                },
                fill: {
                    opacity: 0.9,
                    colors: 'var(--primary)',
                    type: 'gradient',
                    gradient: {
                        colorStops: [

                            {
                                offset: 0,
                                color: 'var(--primary)',
                                opacity: .8
                            },
                            {
                                offset: 0.6,
                                color: 'var(--primary)',
                                opacity: .6
                            },
                            {
                                offset: 100,
                                color: 'white',
                                opacity: 0
                            }
                        ],

                    }
                },
                tooltip: {
                    enabled: false,
                    style: {
                        fontSize: '12px',
                    },
                    y: {
                        formatter: function (val) {
                            return "$" + val + " thousands"
                        }
                    }
                }
            };

            var chartBar1 = new ApexCharts(document.querySelector("#NewCustomers"), options);
            chartBar1.render();

        }
        var ProfitlossChart = function () {
            var options = {
                series: [
                    {
                        name: 'Net Profit',
                        data: [200, 300, 200, 250, 200, 240, 180, 230, 200, 250, 200],
                        /* radius: 30,	 */
                    },
                ],
                chart: {
                    type: 'area',
                    height: 130,
                    width: 400,
                    toolbar: {
                        show: false,
                    },
                    zoom: {
                        enabled: false
                    },
                    sparkline: {
                        enabled: true
                    }

                },

                colors: ['var(--primary)'],
                dataLabels: {
                    enabled: false,
                },

                legend: {
                    show: false,
                },
                stroke: {
                    show: true,
                    width: 3,
                    curve: 'smooth',
                    colors: ['#C0E192'],
                },

                grid: {
                    show: false,
                    borderColor: '#eee',
                    padding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 0

                    }
                },
                states: {
                    normal: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    hover: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    active: {
                        allowMultipleDataPointsSelection: false,
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    }
                },
                xaxis: {
                    categories: ['Jan', 'feb', 'Mar', 'Apr', 'May', 'June', 'July', 'August', 'Sept', 'Oct'],
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        show: false,
                        style: {
                            fontSize: '12px',
                        }
                    },
                    crosshairs: {
                        show: false,
                        position: 'front',
                        stroke: {
                            width: 1,
                            dashArray: 3
                        }
                    },
                    tooltip: {
                        enabled: true,
                        formatter: undefined,
                        offsetY: 0,
                        style: {
                            fontSize: '12px',
                        }
                    }
                },
                yaxis: {
                    show: false,
                },

                fill: {
                    opacity: 0.9,
                    colors: '#C0E192',
                    type: 'gradient',
                    gradient: {
                        colorStops: [

                            {
                                offset: 0,
                                color: '#C0E192',
                                opacity: .8
                            },
                            {
                                offset: 0.6,
                                color: '#C0E192',
                                opacity: .6
                            },
                            {
                                offset: 100,
                                color: 'white',
                                opacity: 0
                            }
                        ],

                    }
                },

                /* fill: {
                  opacity: 0.9,
                  colors:'#C0E192'
                }, */
                tooltip: {
                    enabled: false,
                    style: {
                        fontSize: '12px',
                    },
                    y: {
                        formatter: function (val) {
                            return "$" + val + " thousands"
                        }
                    }
                }
            };

            var chartBar1 = new ApexCharts(document.querySelector("#ProfitlossChart"), options);
            chartBar1.render();

        }

        var TotaldipositChart = function () {
            var options = {
                series: [
                    {
                        name: 'Net Profit',
                        data: [200, 300, 200, 250, 200, 240, 180, 230, 200, 200, 200],
                        /* radius: 30,	 */
                    },
                ],
                chart: {
                    type: 'area',
                    height: 130,
                    width: 400,
                    toolbar: {
                        show: false,
                    },
                    zoom: {
                        enabled: false
                    },
                    sparkline: {
                        enabled: true
                    }

                },

                colors: ['var(--primary)'],
                dataLabels: {
                    enabled: false,
                },

                legend: {
                    show: false,
                },
                stroke: {
                    show: true,
                    width: 3,
                    curve: 'smooth',
                    colors: ['#DE97DF'],
                },

                grid: {
                    show: false,
                    borderColor: '#eee',
                    padding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 0

                    }
                },
                states: {
                    normal: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    hover: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    active: {
                        allowMultipleDataPointsSelection: false,
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    }
                },
                xaxis: {
                    categories: ['Jan', 'feb', 'Mar', 'Apr', 'May', 'June', 'July', 'August', 'Sept', 'Oct'],
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        show: false,
                        style: {
                            fontSize: '12px',
                        }
                    },
                    crosshairs: {
                        show: false,
                        position: 'front',
                        stroke: {
                            width: 1,
                            dashArray: 3
                        }
                    },
                    tooltip: {
                        enabled: true,
                        formatter: undefined,
                        offsetY: 0,
                        style: {
                            fontSize: '12px',
                        }
                    }
                },
                yaxis: {
                    show: false,
                },
                fill: {
                    opacity: 0.9,
                    colors: '#DE97DF',
                    type: 'gradient',
                    gradient: {
                        colorStops: [

                            {
                                offset: 0,
                                color: '#DE97DF',
                                opacity: .8
                            },
                            {
                                offset: 0.6,
                                color: '#DE97DF',
                                opacity: .6
                            },
                            {
                                offset: 100,
                                color: 'white',
                                opacity: 0
                            }
                        ],

                    }
                },
                /* fill: {
                  opacity: 0.9,
                  colors:'#DE97DF'
                }, */
                tooltip: {
                    enabled: false,
                    style: {
                        fontSize: '12px',
                    },
                    y: {
                        formatter: function (val) {
                            return "$" + val + " thousands"
                        }
                    }
                }
            };

            var chartBar1 = new ApexCharts(document.querySelector("#TotaldipositChart"), options);
            chartBar1.render();

        }

        /* Function ============ */
        return {
            init: function () {
            },
            load: function () {
                swipercard();
                NewCustomers();
                ProfitlossChart();
                TotaldipositChart();
            },
            resize: function () {
            }
        }

    }();

    jQuery(window).on('load', function () {
        setTimeout(function () {
            dzChartlist.load();
        }, 1000);

    });
})(jQuery);
