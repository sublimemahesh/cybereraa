
 var count=0;
 $(document).ready(function() {

     $("#commissions").keyup(function() {

         commissions = $("#commissions").val();
         commissions = parseInt(commissions);
         add_flied=commissions-count;
         for (i = 0; i < add_flied; ++i) {
             newDiv = $(
                 '<div class="form-group row mb-2">'+
                 '<label class="col-sm-3 col-form-label" for="amount">Commissions Level</label>'+
                  '<div class="col-sm-9">'+
                  '<input class="form-control" id="commission" name="" placeholder="Commissions Level" type="text">'+
                  '</div>'+
                '</div>'
             );
             $('#add_textflied').append(newDiv);

             count=count+1
         }
     });
 });








