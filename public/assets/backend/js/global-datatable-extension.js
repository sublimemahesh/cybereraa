$(function () {

    if ($.fn.hasOwnProperty('dataTable')) {
        console.log('set table default');
        $.extend(true, $.fn.dataTable.defaults, {
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                }
            },
            dom: "Bfrtip",
            autoWidth: false,
            lengthChange: false,
            lengthMenu: [[10, 25, 50, 100, 250, 500, -1], ["10 rows", "25 rows", "50 rows", "100 rows", "250 rows", "500 rows", "Show all"]],
            buttons: [
                {
                    extend: 'pdfHtml5',
                    //footer: true, // TODO: Remove all the colspan="" in the table footer and add footer columns to the table ex: if colspan=2 add <th></th> <th></th>
                    split: ['csv', 'excel'],
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions: {
                        columns: [":visible"],
                    },
                },
                "colvis",
                "pageLength",
            ]
        });
    }

});
