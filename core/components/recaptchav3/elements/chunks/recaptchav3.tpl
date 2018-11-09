<script src='https://www.google.com/recaptcha/api.js?render=[[++formit.recaptcha_public_key]]'></script>
<span class="error_g-recaptcha-response error error_message">[[+fi.error.g-recaptcha-response]]</span>
<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
<script>
    grecaptcha.ready(function() {
        grecaptcha.execute('[[++formit.recaptcha_public_key]]', { action: '[[+rcv3Action:default=`ajaxform`]]' })
        .then(function(token) {
            document.getElementById('g-recaptcha-response').value=token;
        });
    });
</script>