<div id="form_div">
    <form class="form-horizontal" method="get" action="Login/login/" id="form1">
        <fieldset>
            <legend>Anmeldung</legend>
            <p id="error" hidden></p>
            <div class="form-group">
                <label class="col-lg-2 control-label" id="userLbl" for="user">Email*: </label>
                <div class="col-lg-10" title="Bitte geben Sie eine email Adresse in diesem Format (test@test.ch) an">
                    <input class="form-control" type="email" name="username" id="user" required placeholder="Email Adresse" title="Format wie: abc@abc.ch">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" id="password1Lbl" for="password1">Passwort*: </label>
                <div class="col-lg-10" title="Verlangt mind. 9 Zeichen mit Gross und Kleinbuchstaben sowie mind. einem Sonderzeichen">
                    <input class="form-control" type="password" name="password1" id="password1" required placeholder="Passwort"
                           pattern="(?=.*[\(\)\[\]\{\}\?\!\$\%\&\/\=\*\+\~\,\.\;\:\<\>\-\_])(?=.*[a-z])(?=.*[A-Z0-9]).{9,}"
                           title="Mindestens 9 Zeichen plus Gross und Kleinbuchstaben und mind. ein Sonderzeichen">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" id="password2Lbl" for="password2">Passwort wiederholen*: </label>
                <div class="col-lg-10" title="Passwort Wiederholung vom oben eingegebenen">
                    <input class="form-control" type="password" name="password2" id="password2" placeholder="Passwort"
                           pattern="(?=.*[\(\)\[\]\{\}\?\!\$\%\&\/\=\*\+\~\,\.\;\:\<\>\-\_])(?=.*[a-z])(?=.*[A-Z0-9]).{9,}"
                           title="Gleiches Passwort wie im Feld Passwort">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" id="genderLbl">Geschlecht*: </label>
                <div class="col-lg-10">
                    <div class="radio" title="Auswahl Ihres Geschlechts"><label for="gender"><input type="radio" name="gender" id="gender" value="Mann">Mann</label></div>
                    <div class="radio" title="Auswahl Ihres Geschlechts"><label for="gender2"><input type="radio" name="gender" id="gender2" value="Frau">Frau</label></div>
                </div>
            </div>
            <div class="form-group" title="Wählen Sie Ihre Sportart oder Ihre Sportarten">
                <label class="col-lg-2 control-label" id="nickLbl" for="nickName">Nickname*: </label>
                <div class="col-lg-10" title="Bitte geben Sie Ihren Nicknamen ein">
                    <input class="form-control" type="text" name="nickName" id="nickName" placeholder="Nickname">
                </div>
            </div>
            <div class="form-group" title="Wählen Sie Ihren Wohnort">
                <label class="col-lg-2 control-label" id="locationLbl" for="location">Wohnort*: </label>
                <div class="col-lg-10">
                    <select class="form-control" name="location" id="location" size="1">
                        <option selected>Schweiz</option>
                        <option>Deutschland</option>
                        <option>Italien</option>
                        <option>Österreich</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <input type="reset" value="reset" id="reset" class="btn btn-default">
                    <input type="submit" value="senden" id="submit" class="btn btn-primary">
                </div>
            </div>
            <p id="info">Alle Felder mit * sind obligatorisch.<br>Wenn man sich einloggen möchte, bitte nur Email und Passwort
                eingeben.<br><br>Um Informationen über die verlangten Angaben zu erhalten,<wbr>
                fahren Sie mit Ihrer Maus über das gewünschte Eingabefeld</p>
        </fieldset>
    </form>