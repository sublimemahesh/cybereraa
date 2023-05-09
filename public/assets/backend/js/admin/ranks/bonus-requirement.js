$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const month = urlParams.get("month");

    flatpickr("#month", {
        mode: "single",
        minDate: "2023-03",
        dateFormat: "Y-m",
        defaultDate: month,
        plugins: [
            new monthSelectPlugin({
                shorthand: true, //defaults to false
                dateFormat: "Y-m", //defaults to "F Y"
                altFormat: "F Y", //defaults to "F Y"
                theme: "dark" // defaults to "light"
            })
        ]
    });

    $(document).on("click", "#search", function (e) {
        e.preventDefault();
        urlParams.set("month", $("#month").val());
        urlParams.set("user_id", $("#user_id").val());
        location.href = location.href.split(/\?|\#/)[0] + "?" + urlParams.toString()
    });
})
