// Wait for the DOM to be ready
$(function() {
  // Initialize form validation on the registration form.
  // It has the name attribute "registration"
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
      nama  : "required",
      email : {
        required: true,
        email   : true
      },
      no_hp : {
        required: true,
        number: true
      },
      no_rumah:{
        number: true
      },
      no_hp_lain: {
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
      form.submit();
    }
  });
});
