$(document).ready(function(){
  var id = "";
  $(".delete").click(function(){
    id        = $(this).attr('data-for');
    var name  = $('#name-' + id).text();
    $("#removed-data").html(name);
    $("#small").modal('show');
  });

  $("#yes-remove").click(function(){

    $("#delete-" + id).submit();
  });
});
