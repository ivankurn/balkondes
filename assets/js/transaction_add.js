var FormValidation = function () {
    
    // basic validation
    var handleValidation1 = function() {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation

        var form1 = $('#form_tourist');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);

        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            messages: {

            },
            rules: {
                
            },

            invalidHandler: function (event, validator) { //display error alert on form submit     
                success1.hide();
                error1.show();
                App.scrollTo(error1, -200);
            },

            errorPlacement: function (error, element) { // render error placement for each input type
                var cont = $(element).parent('.input-group');
                if (cont.size() > 0) {
                    cont.after(error);
                } else {
                    element.after(error);
                }
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.validate-group').addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                    .closest('.validate-group').removeClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label
                    .closest('.validate-group').removeClass('has-error'); // set success class to the control group
            },

            submitHandler: function (form) {
                success1.show();
                error1.hide();
            }
        });
    }

    return {
        //main function to initiate the module
        init: function () {
            handleValidation1();
        }
    };
}();

function updateSummary(condition)
{
    var price = $('#package_type_select option:selected').attr('price');
    var personCount = personCount = $('div[data-repeater-list="group-a"] div.mt-repeater-item').length;
    
    if (condition == 'add')
    {
        personCount = $('div[data-repeater-list="group-a"] div.mt-repeater-item').length;
    }
    else if (condition == 'subtract')
    {
        personCount = $('div[data-repeater-list="group-a"] div.mt-repeater-item').length - 1;
    }

    $('#price_summary').text(price + '00');
    $('#price_summary').priceFormat({
        prefix: 'Rp ',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });
    $('#total_person_summary').text(personCount + " orang");
    $('#total_price_summary').text((price * personCount) + '00');
    $('#total_price_summary').priceFormat({
        prefix: 'Rp ',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });
}

function resetForm()
{
    $('form#form_package_select')[0].reset();
    $('form#form_package_type_select')[0].reset();
    $('form#form_tourist')[0].reset();

    $('#package_type_select').hide();
    $('#form_tourist').hide();
    $("#summary").hide();
    $('#submit_btn').hide();
    $('#cancel_btn').hide();
    $('div.invoice').hide();
    $('#print_btn').hide();
}

function showInvoice()
{
    $('#form').hide();
    $('#summary').hide();

    $('div.invoice').show();
    $('#print_btn').show();
}

function submitGeneralForm(csrfToken, tourists)
{
    $.post(APP_URL + '/transaction/ajax/add/general',
    { 
        _token: csrfToken,
        package_id: $('#package_type_select option:selected').val(),
        tourists: JSON.stringify(tourists)
    },
    function(data, status)
    {
        App.stopPageLoading();

        $('.alert.alert-success').remove();
        $('.alert.alert-danger').remove();

        var json = JSON.parse(data);
        
        if (json['status'] == 'success')
        {
            var htmlText =  [
                '<div class="alert alert-success hidden-print">',
                    '<button class="close" data-close="alert"></button>',
                    '<span>', json['messages'], '</span>',
                '</div>'].join('');

            $(htmlText).insertBefore('div.portlet.light.bordered:eq(0)');

            App.scrollTo($('div.alert.alert-success'));

            resetForm();

            $('#invoice_id').html([
                '#', json['data']['transaction_id'], 
                '<br><br>',
                json['data']['date'],
                '<br>',
                json['data']['time']].join('')
            );

            $('#transaction_no').text(json['data']['transaction_id']);

            $('#package_name').text(json['data']['package_name']);
            $('#price').text(json['data']['price'] + '00');
            $('#price').priceFormat({
                prefix: 'Rp ',
                centsSeparator: ',',
                thousandsSeparator: '.'
            });
            $('#tourist_count').text(json['data']['tourist_count'] + " orang");
            $('#grand_total').text(json['data']['grand_total'] + '00');
            $('#grand_total').priceFormat({
                prefix: 'Rp ',
                centsSeparator: ',',
                thousandsSeparator: '.'
            });
            $('#grand_total_2').text(json['data']['grand_total'] + '00');
            $('#grand_total_2').priceFormat({
                prefix: 'Rp ',
                centsSeparator: ',',
                thousandsSeparator: '.'
            });

            showInvoice();

            $.each(json['data']['tickets'], function(index, value) {
                htmlText = [
                    '<div class="page-break"></div>',
                    '<div class="ticket bordered">',
                        '<div class="row ticket-logo">',
                            '<div class="col-xs-6 ticket-logo">',
                                '<p class="left">',
                                    'Wisata Balkondes',
                                '</p>',
                            '</div>',
                            '<div class="col-xs-6 ticket-logo">',
                                '<p class="right">',
                                    'Tiket',
                                '</p>',
                            '</div>',
                        '</div>',
                        '<div class="row ticket-detail">',
                            '<div class="col-xs-12">',
                                '<span class="bold">Kode Tiket : #', value['barcode'],'</span>',
                            '</div>',
                            '<div class="col-xs-6 text-center">',
                                '<div class="something-semantic">',
                                    '<div class="something-else-semantic">',
                                        '<img src="/abt/barcode/', value['barcode'], '.png" width="300px;" />',
                                    '</div>',
                                '</div>',
                            '</div>',
                            '<div class="col-xs-1 text-center">',
                                '<div class="something-semantic">',
                                    '<div class="something-else-semantic">',
                                        '<img src="/abi/line_6.png" />',
                                    '</div>',
                                '</div>',
                            '</div>',
                            '<div class="col-xs-5 text-center">',
                                '<div class="something-semantic">',
                                    '<div class="something-else-semantic">',
                                        '<img src="/abt/qrcode/', value['barcode'], '.png" width="200px;" />',
                                    '</div>',
                                '</div>',
                            '</div>',
                        '</div>',
                        '<div class="row ticket-tourist">',
                            '<div class="col-xs-12">',
                                '<font class="bold uppercase" style="color: #D3A64E !important;">Penumpang</font>',
                            '</div>',
                            '<div class="col-xs-3">',
                                '<p>',
                                    'Nama<br><br>',
                                    json['data']['tourists'][index]['name'],
                                '</p>',
                            '</div>',
                            '<div class="col-xs-1">',
                                '<img src="/abi/line_7.png" height="115px" />',
                            '</div>',
                            '<div class="col-xs-3">',
                                '<p>',
                                    'Nomor Telepon<br><br>',
                                    json['data']['tourists'][index]['mobilephone'],
                                '</p>',
                            '</div>  ',
                            '<div class="col-xs-1">',
                                '<img src="/abi/line_7.png" height="115px" />',
                            '</div>',
                            '<div class="col-xs-3">',
                                '<p>',
                                    'Email<br><br>',
                                    json['data']['tourists'][index]['email'],
                                '</p>',
                            '</div>',  
                        '</div>',
                        '<div class="row ticket-driver">',
                            '<div class="col-xs-12">',
                                '<font class="bold uppercase" style="color: #D3A64E !important;">Driver</font>',
                            '</div>',
                            '<div class="col-xs-12 table-responsive table-head">',
                                '<table class="table table-hover">',
                                    '<thead>',
                                        '<tr>',
                                            '<th class="invoice-title text-center">',
                                                '<span class="bold uppercase">',
                                                    'Trip',
                                                '</span>',
                                                '<br>',
                                                '(Balkondes)',
                                            '</th>',
                                            '<th class="invoice-title text-center">',
                                                '<span class="bold uppercase">',
                                                    'Driver',
                                                '</span>',
                                            '</th>',
                                            '<th class="invoice-title text-center">',
                                                '<span class="bold uppercase">',
                                                    'Vehicle',
                                                '</span>',
                                            '</th>',
                                            '<th class="invoice-title text-center">',
                                                '<span class="bold uppercase">',
                                                    'Jam',
                                                '</span>',
                                            '</th>',
                                        '</tr>',
                                    '</thead>',
                                    '<tbody>'].join('');
                
                $.each(json['data']['routes'], function(index, value) {
                    htmlText += [
                        '<tr>',
                            '<td align="center">', value['balkondes_from_name'], ' - ', value['balkondes_to_name'], '</td>',
                            '<td align="center">', '</td>',
                            '<td align="center">', value['vehicle_type'], '</td>',
                            '<td align="center">', '</td>',
                        '</tr>'
                    ].join('');
                });

                htmlText += [
                                    '</tbody>',
                                '</table>',
                            '</div>',
                        '</div>',
                    '</div>'
                ].join('');
                
                $('div.page-content').append(htmlText);
            });
        }
        else
        {
            if (data['messages'] != null)
            {
                showAlertPopUp('Error', data['messages']);

                var htmlText = '<div class="alert alert-danger">' +
                                    '<button class="close" data-close="alert"></button>' +
                                    '<span>' + data['messages'] + '</span>' +
                                '</div>';
            }
            else
            {
                showAlertPopUp('Error', data['error']);

                var htmlText = '<div class="alert alert-danger">' +
                                    '<button class="close" data-close="alert"></button>' +
                                    '<span>' + data['error'] + '</span>' +
                                '</div>';
            }

            $('.alert.alert-danger').remove();
            $(htmlText).insertBefore('#submit_form');
        }
    },
    "json"
    );
}

function submitCustomForm(csrfToken, tourists)
{
    alert('custom form');
}

function submitForm(csrfToken)
{
    if (csrfToken != '')
    {
        var tourists = [];
        var i = 0;
    
        $('div[data-repeater-list="group-a"] div.mt-repeater-item').each(function() {
            tourists[i] = {};
            tourists[i].name = $(this).find('input[name*="name-input"]').val();
            tourists[i].email = $(this).find('input[name*="email-input"]').val();
            tourists[i].mobilephone = $(this).find('input[name*="mobilephone-input"]').val();
    
            i++;
        });

        if ($('#package_select option:selected').val() == 'general')
        {
            submitGeneralForm(csrfToken, tourists);
        }
        else if ($('#package_select option:selected').val() == 'custom')
        {
            submitCustomForm(csrfToken, tourists);
        }
    }
}

function checkInput()
{
    alert('gagal');
}

$(function() {
    $('#package_type_select').hide();
    $('#form_tourist').hide();
    $("#summary").hide();
    $('#submit_btn').hide();
    $('#cancel_btn').hide();
    $('div.invoice').hide();
    $('#print_btn').hide();

    FormValidation.init();

    $('#package_select').on('change', function () {
        if (this.value == "general")
        {
            $('#package_type_select').show();
        }
        else
        {
            $('#package_type_select').hide();
        }
    });

    $('#package_type_select').on('change', function () {
        if (this.value != "")
        {
            $('#form_tourist').show();
        }
        else
        {
            $('#form_tourist').hide();
        }

        updateSummary();
    });

    $('input[name="group-a[0][name-input]"]').on('input', function () {
        
        if (this.value != "" && !$('#summary').is(':visible'))
        {
            $("#summary").show();
            $('#submit_btn').show();
        }
        else if (this.value == "" && $('#summary').is(':visible'))
        {
            $("#summary").hide();
            $('#submit_btn').hide();
        }
    });

    // $('input[name*="name-input').change(function () {
    //     alert('check');
    // });

    $("#submit_btn").click(function() {
        $('div.alert.alert-danger.display-hide').remove();

        if ($('#package_select').val() == "")
        {
            $('div.alert.alert-danger.display-hide').remove();
            $('div.form-body').prepend(
                '<div class="alert alert-danger display-hide" style="display: block;">' +
                    '<button class="close" data-close="alert"></button>' +
                    'You have some form errors. Please check below.' +
                '</div>'
            );

            App.scrollTo($('div.alert.alert-danger.display-hide'));
        }
        else
        {
            var isFormValid = true;

            $.when(
                $('input[name*="name-input"]').each(function(index)
                {
                    if ($(this).val() == "")
                    {
                        $('div.alert.alert-danger.display-hide').remove();
                        $('div.form-body').prepend(
                            '<div class="alert alert-danger display-hide" style="display: block;">' +
                                '<button class="close" data-close="alert"></button>' +
                                'You have some form errors. Please check below.' +
                            '</div>'
                        );
                        
                        $(this).parent().addClass('has-error');
                        $(this).parent().append('<span class="help-block help-block-error">This field is required.</span>')

                        App.scrollTo($('div.alert.alert-danger.display-hide'));

                        isFormValid = false;
                    }
                })
            ).done(function() {
                if (isFormValid)
                {
                    App.startPageLoading({animate: true});
                    
                    getCSRFToken(submitForm);
                }
            });
        }
    });
});