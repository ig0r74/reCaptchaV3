<?php
$recaptcha = $hook->getValue('g-recaptcha-response');
$url_google_api = "https://www.google.com/recaptcha/api/siteverify";
$secret = $modx->getOption('formit.recaptcha_private_key');
$ip = $_SERVER['REMOTE_ADDR'];

$modx->lexicon->load('recaptchav3:default');

class Captcha{
    public function getCaptcha($SecretKey, $secret, $url_google_api, $ip){
        $response = file_get_contents($url_google_api . "?secret=" . $secret . "&response=" . $SecretKey . "&remoteip=" . $ip);
        $data = json_decode($response);
        return $data;
    }
}

if ($recaptcha) {
    $ObjCaptcha = new Captcha();
    $data = $ObjCaptcha->getCaptcha($recaptcha, $secret, $url_google_api, $ip); 

    if ($data->success) {
        return true;
    } else {   
        $hook->addError('g-recaptcha-response', $modx->lexicon('recaptchav3_check_error'));
        $error_message = "";
        $error_message .= $modx->lexicon('recaptchav3_check_error_log') . "<br/>";
        foreach ($data->{'error-codes'} as $k => $v) {
            $error_message .= "{$k} - {$v}<br/>";
        }
        $modx->log(MODX_LOG_LEVEL_ERROR, $error_message);
        return false;
    }
} else {
    $hook->addError('g-recaptcha-response', $modx->lexicon('recaptchav3_check_empty_error'));
    $modx->log(MODX_LOG_LEVEL_ERROR, $modx->lexicon('recaptchav3_check_empty_error_log'));
    return false;
}

return true;