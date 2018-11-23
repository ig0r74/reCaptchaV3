<?php
$public = $modx->getOption('formit.recaptcha_public_key');
$action = $action ?: 'ajaxform';

$modx->regClientScript('
    <script>
        function grecaptchaExecute() {
            grecaptcha.execute("' . $public . '", { action: "' . $action . '" })
            .then(function(token) {
                document.getElementById("g-recaptcha-response").value=token;
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

$output = '
    <script src="https://www.google.com/recaptcha/api.js?render=' . $public . '"></script>
    <span class="error_g-recaptcha-response error error_message">' . $error . '</span>
    <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
';

return $output;