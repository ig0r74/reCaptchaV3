<?php
// Register API keys at https://www.google.com/recaptcha/admin
$site_key = $modx->getOption('formit.recaptcha_public_key', null, '');
// reCAPTCHA supported languages: https://developers.google.com/recaptcha/docs/language
$lang = $modx->getOption('cultureKey', null, 'en', true);

// "Actions" key
$action_key = $modx->getOption(
    'action_key',
    $scriptProperties,
    $modx->getOption('recaptchav3.action_key', null, 'recaptcha-action', true),
    true
);

// "Token" key
$token_key = $modx->getOption(
    'token_key',
    $scriptProperties,
    $modx->getOption('recaptchav3.token_key', null, 'recaptcha-token', true),
    true
);

// Form ID (fallback to resource URI)
$form_id = $modx->getOption('form_id', $scriptProperties, $modx->resource->get('uri'));
$form_id = preg_replace('/[^A-Za-z_]/', '', $form_id);

if (!$modx->getPlaceholder('rcv3_initialized')) {
    $modx->regClientStartupScript(
        '<script src="https://www.google.com/recaptcha/api.js?render=' 
        . $site_key 
        . '&hl=' . $lang 
        . '"></script>'
    );
    $modx->regClientScript('
        <script>
            grecaptcha.ready(function() {
                grecaptcha.execute("' . $site_key . '", {action: "' . $form_id . '"}).then(function(token) {
                    var el = document.querySelector("[name=\'' . $token_key . '\']");
                    if (el) {
                        el.value = token;
                    }
                });
            });
        </script>
    ', true);
    $modx->setPlaceholder('rcv3_initialized', 1);
}

// Output hidden fields
$output = '
    <input type="hidden" name="' . $token_key . '">
    <input type="hidden" name="' . $action_key . '" value="' . $form_id . '">
';

return $output;
