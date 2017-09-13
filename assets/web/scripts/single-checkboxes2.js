$(document).ready(function() {

  if($("input[name=set_replacement_reminder]:checked").val() == 'no')
    $("#replacement-reminder").empty();


    $(document).on('click', "input:checkbox", function() {
      if($(this).is(":checked")){
        //console.log('checked')
        $(this).prop('checked', true);

        var classname = $(this).attr('data-class');
        if($(this).attr('data-position') == 1){
          $("."+classname+"[data-position='"+2+"']").prop('checked', false);

          if($(this).hasClass('remind_at')){
            var count  = $(this).attr('data-count');
            $("#maintenance-reminder-" + count).show();
            $("#input-remind-" + count).val('1');
          }

          if($(this).hasClass('replace-at')){
            //$(this).closest('input[type=checkbox]').prop('checked', false);
            var count  = $(this).attr('data-count');
            $("#replace-select-" + count).show();
            $("#input-replace-" + count).val('1');
          }
        }
        else {
          if($(this).hasClass('remind_at')){
            var count  = $(this).attr('data-count');
            $("#maintenance-reminder-" + count).hide();
            $("#input-remind-" + count).val('0');
          }

          if($(this).hasClass('replace-at')){

            var count  = $(this).attr('data-count');
            console.log("count : " + count)
            $("#replace-select-" + count).hide();
            $("#input-replace-" + count).val('0');
          }

          $("."+classname+"[data-position='"+1+"']").prop('checked', false);
        }
      }
      else {
        //console.log('not checked')
        $(this).prop('checked', true);
      }

    });
});
