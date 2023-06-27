(function ($) {
    "use strict"

    const incomeBarChart = function () {

        const screenWidth = $(window).width();
        const overlappingBarsChart = function () {
            loader()
            //Overlapping bars on mobile
            axios.post(location.href)
                .then(response => {
                    Swal.close()
                    if (response.data.status) {
                        const myChart = new Chart(document.getElementById('overlapping-bars'), {
                            type: 'bar',
                            data: response.data.my_income,
                            responsive: true,
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    title: {
                                        display: true,
                                        text: `My Total Income ${response.data.my_total_income}`
                                    }
                                }
                            },
                        });
                        const myTeamChart = new Chart(document.getElementById('team-income-chart'), {
                            type: 'bar',
                            data: response.data.team,
                            responsive: true,
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    /*title: {
                                        display: true,
                                        text: 'Chart.js Bar Chart'
                                    }*/
                                }
                            },
                        });
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
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const year = urlParams.get("year");

        $(document).on("click", "#search", function (e) {
            e.preventDefault();
            urlParams.set("year", $("#year").val());
            let url = location.href.split(/\?|\#/)[0] + "?" + urlParams.toString();
            history.replaceState({}, "", url);
            incomeBarChart.load()
        });
    });

    jQuery(window).on('load', function () {
        setTimeout(function () {
            incomeBarChart.load();
        }, 1000);
    });

    // jQuery(window).on('resize', function () {
    //     setTimeout(function () {
    //         incomeBarChart.resize();
    //     }, 1000);
    //
    // });

})(jQuery);
