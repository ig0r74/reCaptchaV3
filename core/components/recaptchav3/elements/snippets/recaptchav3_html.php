<?php
$public = $modx->getOption('formit.recaptcha_public_key');
$action = $action ?: 'ajaxform';

if (!$modx->getPlaceholder('rcv3_initialized')) {
    $modx->regClientStartupScript('<script src="https://www.google.com/recaptcha/api.js?onload=ReCaptchaCallbackV3&render=' . $public . '" async></script>');
    $modx->regClientScript('
        <script>
            var ReCaptchaCallbackV3 = function() {
                grecaptcha.ready(function() {
                    grecaptcha.reset = grecaptchaExecute;
                    grecaptcha.reset();
                });
            };
            function grecaptchaExecute() {
                grecaptcha.execute("' . $public . '", { action: "' . $action . '" }).then(function(token) {
                    var fieldsToken = document.querySelectorAll("[name =\'g-recaptcha-response\']");
                    Array.prototype.forEach.call(fieldsToken, function(el, i){
                        el.value = token;
                    });
                });
            };
        </script>
    ', true);
    $modx->setPlaceholder('rcv3_initialized', 1);
}

$output = '
    <span class="error_g-recaptcha-response error error_message">' . $error . '</span>
    <input type="hidden" name="g-recaptcha-response">
';

return $output;
