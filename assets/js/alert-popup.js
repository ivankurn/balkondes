function showAlertPopUp(title, message)
{
    var htmlText = [
        '<div class="sweet-overlay" tabindex="-1" style="opacity: 1.04; display: block;"></div>',
        '<div class="sweet-alert  showSweetAlert visible" tabindex="-1" data-custom-class="" data-has-cancel-button="false" data-has-confirm-button="true" data-allow-outside-click="true" data-has-done-function="true" data-animation="pop" data-timer="null" style="display: block; margin-top: -150px;">',
            '<div class="sa-icon sa-error animateErrorIcon" style="display: block;">',
                '<span class="sa-x-mark animateXMark">',
                    '<span class="sa-line sa-left"></span>',
                    '<span class="sa-line sa-right"></span>',
                '</span>',
            '</div>',
            '<div class="sa-icon sa-warning" style="display: none;">',
                '<span class="sa-body"></span>',
                '<span class="sa-dot"></span>',
            '</div>',
            '<div class="sa-icon sa-info" style="display: none;"></div>',
            '<div class="sa-icon sa-success" style="display: none;">',
                '<span class="sa-line sa-tip"></span>',
                '<span class="sa-line sa-long"></span>',
                '<div class="sa-placeholder"></div>',
                '<div class="sa-fix"></div>',
            '</div>',
            '<div class="sa-icon sa-custom" style="display: none;"></div>',
            '<h2>', title, '</h2>',
            '<p class="lead text-muted " style="display: block;">', message + '</p>',
            '<div class="form-group">',
                '<input type="text" class="form-control" tabindex="3" placeholder="">',
                '<span class="sa-input-error help-block">',
                    '<span class="glyphicon glyphicon-exclamation-sign"></span> <span class="sa-help-text">Not valid</span>',
                '</span>',
            '</div>',
            '<div class="sa-button-container">',
                '<button class="cancel btn btn-lg btn-default" tabindex="2" style="display: none;">Cancel</button>',
                '<div class="sa-confirm-button-container">',
                    '<button class="confirm btn btn-lg btn-danger" onclick="closeAlertPopUp()" tabindex="1" style="display: inline-block;">OK</button>',
                    '<div class="la-ball-fall">',
                        '<div></div>',
                        '<div></div>',
                        '<div></div>',
                    '</div>',
                '</div>',
            '</div>',
        '</div>'].join("");
    
    $('body').append(htmlText);
}

function closeAlertPopUp()
{
    $('.sweet-overlay').remove();
    $('.sweet-alert.showSweetAlert.visible').remove();
}