
 $(document).ready(function() {

    $("input").keyup(function() {
        packages = $("#packages").val();
        commission = $("#commission").val();

        if (packages.trim().length === 0 || commission.trim().length === 0) {

            mw = 'Pending Calculate';

        } else {

            packages = parseInt(packages);
            commission = parseInt(commission);
            mw = packages + commission;
        }

        $("#mw").val(mw);

    });
});
