<?php 
    function checkRecaptcha() {
        $recaptcha_url = URLCAPTCHA;
        $recaptcha_secret = KEYCAPTCHA;
        $recaptcha_response = $_POST['recaptcha_response'];
        // Make and decode POST request:
        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
        $recaptcha = json_decode($recaptcha);
        // Take action based on the score returned:
        return $recaptcha;
 }