<?php
// Form ID (fallback to resource URI + unique identifier)
$form_id = $modx->getOption('form_id', $scriptProperties, $modx->resource->get('uri')) ?: 'ajaxform';
$form_id = preg_replace('/[^A-Za-z_]/', '', $form_id);

$action = $action ?: $form_id;

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
 
// Generate unique identifier for this form instance
$unique_id = $modx->getOption('unique_id', $scriptProperties, uniqid('rcv3_', true));
$unique_id = preg_replace('/[^A-Za-z0-9_]/', '_', $unique_id);

if (!$modx->getPlaceholder('rcv3_initialized')) {
    $modx->regClientStartupScript(
        '<script src="https://www.google.com/recaptcha/api.js?render=' 
        . $site_key 
        . '&hl=' . $lang 
        . '"></script>'
    );
    $modx->setPlaceholder('rcv3_initialized', 1);
}

// Register form-specific script
$modx->regClientScript('
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute("' . $site_key . '", {action: "' . $action . '"}).then(function(token) {
                var el = document.getElementById("' . $unique_id . '_token");
                if (el) {
                    el.value = token;
                }
            });
        });
    </script>
', true);

// Output hidden fields with unique IDs
$output = '
    <input type="hidden" id="' . $unique_id . '_token" name="' . $token_key . '">
    <input type="hidden" id="' . $unique_id . '_action" name="' . $action_key . '" value="' . $action . '">
';

return $output;
