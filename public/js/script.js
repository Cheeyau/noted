grecaptcha.ready(function () {
    grecaptcha.execute('6LfeVpAaAAAAAPyaZMMSXkwNFel63Ci9Z_dyEw-x    ', { action: 'register' }).then(function (token) {
        var recaptchaResponse = document.getElementById('recaptchaResponse');
        recaptchaResponse.value = token;
    });
});
