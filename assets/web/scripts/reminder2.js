$(document).ready(function(){
  var maintenanceHTML = $("#maintenance-reminder").html();
  var replaceHTML = $("#replacement-reminder").html();

  // console.log(replaceHTML);
  // console.log('------------------------')
  // console.log(maintenanceHTML)

  if($("input[name=set_maintenance_reminder]:checked").val() == 'no')
    $("#maintenance-reminder").empty();

  if($("input[name=set_replacement_reminder]:checked").val() == 'no')
    $("#replacement-reminder").empty();

  $("input[name=set_maintenance_reminder]").click(function(){
    var radioValue = $("input[name=set_maintenance_reminder]:checked").val();

    if(radioValue == 'no') $("#maintenance-reminder").empty();
    else $("#maintenance-reminder").html(maintenanceHTML);
  })

  $("input[name=set_replacement_reminder]").click(function(){
    var radioValue = $("input[name=set_replacement_reminder]:checked").val();

    if(radioValue == 'no') $("#replacement-reminder").empty();
    else $("#replacement-reminder").html(replaceHTML);
  })
});
