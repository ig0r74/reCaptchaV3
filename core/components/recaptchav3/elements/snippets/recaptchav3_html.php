<?php
$public = $modx->getOption('formit.recaptcha_public_key');
$action = $action ?: 'ajaxform';

if (!$modx->getPlaceholder('rcv3_initialized')) {
    $modx->regClientStartupScript('<script src="https://www.google.com/recaptcha/api.js?render=' . $public . '"></script>');
    $modx->regClientScript('
        <script>
            function grecaptchaExecute() {
                grecaptcha.execute("' . $public . '", { action: "' . $action . '" })
                .then(function(token) {
                    $("[name =\'g-recaptcha-response\']").val(token);
                });
            }
            grecaptcha.ready(function() {
                grecaptchaExecute();
            });
            $(document).on("af_complete", function(event, response) {
                if (response.success) {
                    grecaptchaExecute();
                }
            });
        </script>
    ', true);
    $modx->setPlaceholder('rcv3_initialized', 1);
}

$output = '
    <span class="error_g-recaptcha-response error error_message">' . $error . '</span>
    <input type="hidden" name="g-recaptcha-response">
';

return $output;