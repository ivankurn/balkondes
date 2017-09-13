$(document).ready(function(){
  $("#select-template").change(function(){
    var element = $("option:selected", this);
    var id = element.attr("data-id");
    // alert(id)
    if(id != null){
      var text = $("#template-" + id).val();
      console.log(text);
      $("#text-0").text(text);
    }
    else if(id === undefined) $("#text-0").text("");


  });
});
