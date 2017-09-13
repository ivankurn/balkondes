$(document).ready(function() {

  if($("#send-at").is(':checked')) $("#input-date").prop('required',true);
  else $("#input-date").prop('required',false);

    $(document).on('click', "input:checkbox", function() {
        // in the handler, 'this' refers to the box clicked on
        var $box = $(this);
        // the name of the box is retrieved using the .attr() method
        // as it is assumed and expected to be immutable
        var group = "input:checkbox[name='" + $box.attr("name") + "']";
        if ($box.is(":checked")) {

            // the checked state of the group/box on the other hand will change
            // and the current value is retrieved using .prop() method
            $(group).prop("checked", false);
            $box.prop("checked", true);
        } else {
          $(group).prop("checked", true);
            $box.prop("checked", false);

        }

        if($("#send-at").is(':checked')) $("#input-date").prop('required',true);
        else $("#input-date").prop('required',false);

    });
});
