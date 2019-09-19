export default function () {
    const formRegister = $('#form-register');
    const inputPassword = formRegister.find('#password');
    const passwordStrengthLabel = formRegister.find('#password-strength');

    inputPassword.on('keyup', function () {
        validatePassword($(this).val());
    });

    function validatePassword(password) {
        console.log('a');
        // Do not show anything when the length of password is zero.
        if (password.length === 0) {
            passwordStrengthLabel.text('none');
            return;
        }

        // Create an array and push all possible values that you want in password
        let matchedCase = [];
        matchedCase.push("[$@$!%*#?&]"); // Special Charector
        matchedCase.push("[A-Z]");      // Uppercase Alpabates
        matchedCase.push("[0-9]");      // Numbers
        matchedCase.push("[a-z]");     // Lowercase Alphabates

        // Check the conditions
        let ctr = 0;
        for (let i = 0; i < matchedCase.length; i++) {
            if (new RegExp(matchedCase[i]).test(password)) {
                ctr++;
            }
        }

        var color = "";
        var strength = "";
        switch (ctr) {
            case 0:
            case 1:
            case 2:
                strength = "Very Weak";
                color = "text-danger";
                break;
            case 3:
                strength = "Medium";
                color = "text-warning";
                break;
            case 4:
                strength = "Strong";
                color = "text-success";
                break;
        }
        passwordStrengthLabel.text(strength);
        passwordStrengthLabel
            .removeClass('text-success')
            .removeClass('text-warning')
            .removeClass('text-danger');
        passwordStrengthLabel.addClass(color);
    }

};