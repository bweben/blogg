/**
 * Created by Nathanael Weber on 17.09.2015.
 * Used to make sure all Values are valid
 * and checks if it's an registration or a sign in
 * because of the validation
 */

/**
 * Is called when the document is ready to prevent errors
 */
$(document).ready(function (){

    /**
     * Checks if an email is valid with a regular expression
     * @param email
     * @returns {boolean}
     */
    function emailValidation(email) {
        var regex = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        return regex.test(email);
    }

    /**
     * checks if the second password matches the first
     * @param password
     * @param password2
     * @returns {boolean}
     */
    function secPasswordValidation(password,password2) {
        return password == password2;
    }

    /**
     * Checks if min one sportType is checked
     * @param sportTypes
     * @returns {boolean}
     */
    function sportTypesValidation(sportTypes) {
        return sportTypes.length > 0;
    }

    function nicknameValidation(nickname) {
        var regex = /^[\d\w]{3,}$/i;
        return regex.test(nickname);
    }

    /**
     * Shows the error <p> with the error text
     * @param text
     */
    function showError(text) {
        var error = $("#error");
        if (error.html() == "") {
            error.html("Leider nicht ganz richtig...<br>"+text);
            error.show("fast");
        } else {
            error.html(error.html() + "<br>" + text)
        }
    }

    /**
     * Can be called if you want to hide the error field
     */
    function hideError() {
        $("#error").fadeOut(500);
    }

    /**
     * is called when the form is submitted, checks the validation
     * and prevents from redirecting or refresh of the page if
     * the values aren't valid
     */
    $("#form1").submit(function (event) {
        $("#error").hide();

        var email = $("#user").val();
        var password1 = $("#password1").val();
        var password2 = $("#password2").val();
        var man = $("#gender").is(":checked");
        var woman = $("#gender2").is(":checked");
        var location = $("#location").find("option:selected").text();
        var nickname = $("#nickName").val();
        var ret = true;

        if (!emailValidation(email)) {
            $("#userLbl").css("color","red");
            showError("Email nicht im gültigen Format. Beispielsweise abc@abc.com.");
            ret = false;
        }

        // if its a sign up and not a sign in
        if (!((password2 == null || password2 == "") && man == false && woman == false
            && email != "" && password1 != "" && nickname != "")) {
            if (!secPasswordValidation(password1,password2)) {
                $("#password2Lbl").css("color","red");
                showError("'Passwort wiederholen' stimmt nicht mit 'Passwort' überein.");
                ret = false;
            }

            if (!(man || woman)) {
                $("#genderLbl").css("color","red");
                showError("Sie haben kein Geschlecht ausgewählt.");
                ret = false;
            }

            if (!nicknameValidation(nickname)) {
                $("#nickLbl").css("color","red");
                showError("Sie haben einen ungültigen Nicknamen gewählt.");
                ret = false;
            }

            if (!sportTypesValidation(sportTypes)) {
                $("#sportLbl").css("color","red");
                showError("Sie haben keine Sportart angekreuzt, wählen Sie eine oder mehrere.");
            }
        }

        return ret;
    });

    /**
     * Wants a confirmation to reset the informations
     */
    $("#form1").on('reset',function (event) {
        return confirm("Wollen Sie alle Angaben zurücksetzen?");
    });
});