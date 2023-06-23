(function ($) {
    "use strict"

    const incomeBarChart = function () {

        const screenWidth = $(window).width();
        const overlappingBarsChart = function () {
            //Overlapping bars on mobile
            axios.post(`${APP_URL}/user/earnings/summarize-yearly-income`)
                .then(response => {
                    if (response.data.status) {
                        const data = {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                            series: [[220300.8665000465, 349120.5151199402, 327511.7729799642, 358804.2576399254, 11435.189020000238]]
                        };
                        const options = {
                            seriesBarDistance: 2,
                            axisX: {
                                showGrid: true,
                                offset: 60,
                                scaleMinSpace: 50,
                            },
                            axisY: {
                                showGrid: true,
                                offset: 80
                            },
                            //showLine: true,
                            // height: '600px',
                            plugins: [
                                Chartist.plugins.tooltip()
                            ]
                        };
                        const responsiveOptions = [
                            [
                                'screen and (max-width: 640px)',
                                {
                                    seriesBarDistance: 5,
                                    axisX: {
                                        labelInterpolationFnc: function (value) {
                                            return value[0];
                                        }
                                    }
                                }
                            ]
                        ];
                        new Chartist.Bar('#overlapping-bars', response.data.data, options, responsiveOptions);
                        new Chartist.Bar('#team-income-chart', response.data.team, options, responsiveOptions);
                    }
                })
                .catch(error => {
                    Toast.fire({
                        icon: 'error', title: error.response?.data.message || "Something went wrong!",
                    });
                });


        }
        return {
            init: function () {
            },


            load: function () {
                overlappingBarsChart();
            },

            resize: function () {
                overlappingBarsChart();
            }
        }

    }();

    jQuery(document).ready(function () {
    });

    jQuery(window).on('load', function () {
        setTimeout(function () {
            incomeBarChart.resize();
        }, 1000);
    });

    jQuery(window).on('resize', function () {
        setTimeout(function () {
            incomeBarChart.resize();
        }, 1000);

    });

})(jQuery);
