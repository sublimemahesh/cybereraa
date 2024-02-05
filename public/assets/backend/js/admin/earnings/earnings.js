$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");

    let table = $('#earnings').DataTable({
        scrollX: true,
        destroy: true,
        processing: true,
        serverSide: true,
        fixedHeader: true,
        responsive: true,
        order: [[5, 'desc']],
        //stateSave: true,
        ajax: EARNING_URL,
        columns: [
            {data: "earnable_type", searchable: false, orderable: false},
            {data: "user_id", searchable: false, orderable: false},
            {data: "user", name: 'user.username', searchable: true, orderable: false},
            //{data: "username"},
            {data: "package", searchable: false, orderable: false},
            {data: "status", searchable: false, orderable: false},
            {data: "date", name: 'created_at', searchable: false},
            {data: "amount_formatted", name: 'amount', orderable: true},
        ],
        footerCallback: function (row, data, start, end, display) {
            let api = this.api();

            // Remove the formatting to get integer data for summation
            let intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };

            // Total over this page
            let pageTotal = api
                .column(6, {page: 'current'})
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            let numberFormatOptions = {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            }
            // Update footer
            pageTotal = new Intl.NumberFormat('en-US', numberFormatOptions).format(pageTotal);
            $(api.column(6).footer()).html(`${pageTotal}`);
        },
        columnDefs: [
            {
                render: function (amount, type, full, meta) {
                    return `<div style="font-size:0.76rem" > ${amount} </div>`;
                },
                targets: [0, 1, 2, 3, 4, 5,],
            }, {
                render: function (amount, type, full, meta) {
                    return `<div style="font-size:0.76rem"  class="text-right"> ${amount} </div>`;
                },
                targets: [6],
            },
        ],
    });

    flatpickr("#earnings-date-range", {
        mode: "range",
        dateFormat: "Y-m-d H:i",
        defaultDate: date_range && date_range.split("to"),
        enableTime: true,
        time_24hr: true,
        onOpen: function (selectedDates, dateStr, instance) {
            // Switch back to range mode
            instance.set("mode", "range");
        },
        onChange: function (selectedDates, dateStr, instance) {
            if (selectedDates.length === 1) {
                // If a single date is selected, switch to single mode
                instance.set('mode', 'single');
            } else if (selectedDates.length === 2) {
                // If two dates are selected, switch to range mode
                instance.set('mode', 'range');
            }
        },
    });

    $(document).on("click", "#earnings-search", function (e) {
        e.preventDefault();
        urlParams.set("date-range", $("#earnings-date-range").val());
        urlParams.set("status", $("#earnings-status").val());
        urlParams.set("user_id", $("#user_id").val());
        urlParams.set("earning-type", $("#earning-type").val());
        urlParams.set("amount-start", $("#amount-start").val());
        urlParams.set("amount-end", $("#amount-end").val());
        let url = EARNING_URL.split(/\?|\#/)[0] + "?" + urlParams.toString();
        HISTORY_STATE && history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });

    if (HISTORY_STATE) {
        async function fetchRemainingEarningCount(selectedDate) {
            $(Swal.getHtmlContainer()).hide();
            $(Swal.getValidationMessage()).hide();
            try {
                Swal.showLoading();
                const response = await axios.post(APP_URL + '/admin/reports/users/earnings/get-pending-earnings', {
                    date: selectedDate,
                });

                if (response.status === 200 && response.data.status) {
                    return response.data.data.earningPendingActivePackages;
                } else {
                    $(Swal.getValidationMessage()).html(`Error fetching earnings count.`);
                    // Swal.getContent().querySelector(".swal2-validation-message").textContent = `Error fetching earnings count.`;
                    throw new Error("Error fetching earnings count.");
                }
            } catch (error) {
                console.error("Error:", error);
                // Swal.getContent().querySelector(".swal2-validation-message").textContent = "An unexpected error occurred. Please try again.";
                throw new Error("An unexpected error occurred. Please try again.");
            } finally {
                Swal.hideLoading();
            }
        }

        async function handleDateInputChange(event) {
            $(Swal.getHtmlContainer()).hide();
            $(Swal.getValidationMessage()).hide();
            const selectedDate = event.target.value;

            try {
                // Fetch and display the updated count as the input changes
                const remainingCount = await fetchRemainingEarningCount(selectedDate);

                // Swal.getContent().querySelector(".swal2-validation-message").textContent = `Remaining Earnings: ${count}`;
                if (remainingCount > 0) {
                    $(Swal.getHtmlContainer()).html(`<div class="alert alert-outline-info">Remaining Earnings: ${remainingCount}</div>`)
                    $(Swal.getHtmlContainer()).show();
                } else {
                    $(Swal.getValidationMessage()).html("No pending earnings for the selected date.")
                    $(Swal.getValidationMessage()).show();
                }
            } catch (error) {
                console.error("Error:", error);
                $(Swal.getValidationMessage()).html("Error fetching earnings count.")
                $(Swal.getValidationMessage()).show();
                // Swal.getContent().querySelector(".swal2-validation-message").textContent = "Error fetching earnings count.";
            }
        }

        $(document).on('click', '#calculate-profit', async function (e) {
            e.preventDefault();
            const {value: date} = await Swal.fire({
                title: "select earning date",
                input: "date",
                didOpen: () => {
                    const today = (new Date()).toISOString();
                    // Swal.getInput().min = today.split("T")[0];

                    Swal.getInput().max = today.split("T")[0];

                    Swal.getInput().addEventListener('input', handleDateInputChange);
                },
                willClose: () => {
                    // Remove the event listener when Swal is closed
                    Swal.getInput().removeEventListener('input', handleDateInputChange);
                },
                showCancelButton: true,
                inputValidator: (value) => {
                    return new Promise(async (resolve) => {
                        if (value === null || value.length <= 0) {
                            resolve("Please provide the earning date!");
                        } else {
                            // Make a POST request to the server to get the remaining earning count
                            try {
                                const remainingCount = await fetchRemainingEarningCount(value);
                                // $(Swal.getHtmlContainer()).html(`Remaining Earnings: ${count}`);

                                if (remainingCount > 0) {
                                    resolve();
                                } else {
                                    resolve("No pending earnings for the selected date.");
                                }
                            } catch (error) {
                                console.error("Error:", error);
                                resolve("An unexpected error occurred. Please try again.");
                            }
                        }
                        // resolve();
                    });
                }
            });

            if (typeof date == 'undefined') {
                return false
            }

            if (date === null || date.length <= 0) {
                await Toast.fire({
                    icon: 'error',
                    title: "Please provide the earning date!",
                })
                return false
            }
            console.log(date)
            Swal.fire({
                title: "Are You Sure?",
                text: `Calculate profit for (${moment(date).format("Y-MM-D")}) now!`,
                icon: "info",
                showCancelButton: true,
            }).then((calculate) => {
                if (calculate.isConfirmed) {
                    loader()
                    axios.post(APP_URL + "/admin/reports/users/earnings/calculate-profit", {date}).then(response => {
                        Toast.fire({
                            icon: response.data.icon, title: response.data.message,
                        })
                        let url = location.href.split(/\?|\#/)[0];
                        history.replaceState({}, "", url);
                        table.ajax.url(url).load();
                    }).catch(error => {
                        console.log(error)
                        Toast.fire({
                            icon: 'error', title: error.response.data.message || "Something went wrong!",
                        })
                    })
                }
            });
        })
        $(document).on('click', '#calculate-commission', function (e) {
            e.preventDefault();
            Swal.fire({
                title: "Are You Sure?",
                text: `Calculate commission allowance for today(${moment().format('Y-MM-D')}) now!`,
                icon: "info",
                showCancelButton: true,
            }).then((calculate) => {
                if (calculate.isConfirmed) {
                    loader()
                    axios.post(APP_URL + "/admin/reports/users/earnings/calculate-commission").then(response => {
                        Toast.fire({
                            icon: response.data.icon, title: response.data.message,
                        })
                        let url = location.href.split(/\?|\#/)[0];
                        history.replaceState({}, "", url);
                        table.ajax.url(url).load();
                    }).catch(error => {
                        console.log(error)
                        Toast.fire({
                            icon: 'error', title: error.response.data.message || "Something went wrong!",
                        })
                    })
                }
            });
        })
        $(document).on('click', '#release-staking-interest', function (e) {
            e.preventDefault();
            Swal.fire({
                title: "Are You Sure?",
                text: `Release the staking interest for maturity date (${moment().format('Y-MM-D')})!`,
                icon: "info",
                showCancelButton: true,
            }).then((calculate) => {
                if (calculate.isConfirmed) {
                    loader()
                    axios.post(APP_URL + "/admin/reports/users/earnings/release-staking-interest")
                        .then(response => {
                            Toast.fire({
                                icon: response.data.icon, title: response.data.message,
                            })
                            let url = location.href.split(/\?|\#/)[0];
                            history.replaceState({}, "", url);
                            table.ajax.url(url).load();
                        })
                        .catch(error => {
                            console.log(error)
                            Toast.fire({
                                icon: 'error', title: error.response.data.message || "Something went wrong!",
                            })
                        })
                }
            });
        })
    }

})
