--------------------
reCaptchaV3
--------------------
Author: ig0r74 <ig0r74@yandex.ru>
--------------------

Нужно добавить _rcv3_ в _hooks_ вызова сниппета (самым первым) и чанк _rcv3_html_ в форму (внутри тэга _form_). В системных настройках Formit указать ключи:

*   секретный - _formit.recaptcha_private_key_
*   и публичный - _formit.recaptcha_public_key_

Получить ключи можно на этой странице [https://www.google.com/recaptcha/admin](https://www.google.com/recaptcha/admin).

### Пример вызова:

```
{'!AjaxForm' | snippet : [
    'snippet' => 'FormIt',
    'form' => 'tpl.AjaxForm.example',
    'emailTpl' => 'contactEmailTpl',
    'hooks' => 'rcv3,email',
    'emailFrom' => $_modx->config.emailsender,
    'emailFromName' => $_modx->config.site_name,
    'emailSubject' => 'Сообщение с сайта' ~ $_modx->config.site_name,
    'emailTo' => $_modx->config.emailsender,
    'validate' => 'name:required',
    'validationErrorMessage' => 'В форме содержатся ошибки!',
    'successMessage' => 'Сообщение успешно отправлено',
    'rcv3Action' => 'contactform',
]}
```

Параметр _rcv3Action_ предназначен для изменения идентификатора action. Подробнее в документации: [https://developers.google.com/recaptcha/docs/v3#actions](https://developers.google.com/recaptcha/docs/v3#actions)