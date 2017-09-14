function getCSRFToken(callback, params)
{
    var csrfToken = '';
    $.when(
        $.ajax({
            url: APP_URL + "/csrf_token",
            type: "get",
            dataType: "json",
            success: function(data) {
                data = JSON.parse(JSON.stringify(data));

                if (data['status'] == 'success')
                {
                    csrfToken = data['data']['csrf_token'];
                }
                else
                {
                    if (data['messages'] != null)
                    {
                        showAlertPopUp('Error', data['messages']);
                    }
                    else
                    {
                        showAlertPopUp('Error', data['error']);
                    }
                }
            },
            error: function(xhr, status, error) {
                showAlertPopUp('Error', error);
            }
        })
    ).done(function() {
        callback(csrfToken, params);
    });
}