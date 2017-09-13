function peformAJAX(){

}

// Wait for the DOM to be ready
$(function() {
  // Initialize form validation on the registration form.
  // It has the name attribute "registration"

  var rootURL = $("#root-url").val() + '/';

  jQuery.validator.addMethod(
      "date-ID",
      function(value, element) {
          var check = false;
          var re = /^\d{1,2}\/\d{1,2}\/\d{4}$/;
          if( re.test(value)){
              var adata = value.split('/');
              var mm = parseInt(adata[1],10); // was gg (giorno / day)
              var dd = parseInt(adata[0],10); // was mm (mese / month)
              var yyyy = parseInt(adata[2],10); // was aaaa (anno / year)
              var xdata = new Date(yyyy,mm-1,dd);
              if ( ( xdata.getFullYear() == yyyy ) && ( xdata.getMonth () == mm - 1 ) && ( xdata.getDate() == dd ) )
                  check = true;
              else
                  check = false;
          } else
              check = false;
          return this.optional(element) || check;
      },
      "Please enter a valid date (dd/mm/yyyy)"
  );

  r = $("#form"),
  t = $(".alert-danger", r),
  i = $(".alert-success", r);
  $("#form").validate({
    doNotHideMessage: !0,
    errorElement: "span",
    errorClass: "help-block help-block-error",
    focusInvalid: !1,
    // Specify validation rules
    ignore: 'input[type=hidden]',
    rules: {
      // The key name on the left side is the name attribute
      // of an input field. Validation rules are defined
      // on the right side
      kodepos: {
        number: true
      },
      no_hp:{
        number: true
      },
      no_transaksi:{
        number: true
      }
    },
    // Specify validation error messages
    messages: {

    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    highlight: function(e) {
        $(e).closest(".form-group").removeClass("has-success").addClass("has-error")
    },
    unhighlight: function(e) {
        $(e).closest(".form-group").removeClass("has-error")
    },
    success: function(e) {

      e.addClass("valid").closest(".form-group").removeClass("has-error").addClass("has-success")
    },
    invalidHandler: function(e, r) {
        i.hide(), t.show(), App.scrollTo(t, -200)
    },
    submitHandler: function(form) {
      if($("#create-contact").is(':visible'))
      form.submit();
    }
  });
});
