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
    rules: {
      // The key name on the left side is the name attribute
      // of an input field. Validation rules are defined
      // on the right side
      id_produk  : {
        required: {
          depends: function(element){
            if('none' == $('select[name=id_produk]').val()){
                //Set predefined value to blank.
                $('select').val('');
            }
            return true;
          }
        }
      },
      kota_company  : {
        required: {
          depends: function(element){
            if('none' == $('select[name=kota_company]').val()){
                //Set predefined value to blank.
                $('select').val('');
            }
            return true;
          }
        }
      },
      kode_sparepart : "required",
      nama_sparepart  : "required",
      remind_at :{
        number: true,
        min: 0
      },
      replace_at :{
        number: true,
        min: 0
      },
      harga_sparepart :{
        required: true,
        number: true,
        min: 0
      },

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
