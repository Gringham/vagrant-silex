<?php $view->extend('layout.html.php');

$view['slots']->set('title', "Bitte melde dich an:");
?>

<form action="/register" method="post" class="jumbotron">
    <div class="row">
        <div class="" col-xs-12>
            <p>Hier kannst du einen neuen User anlegen. Dabei ist zu beachten, dass der Name keine leerzeichen enthalten
                darf!</p>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-3">
            <label>Username:</label>
        </div>

        <div class="col-xs-5">
            <input type="text" class="form-control" name="Sign" required="required" pattern="^\S*$"/>
            <!-- Darf keine Leerzeichen enthalten. Aus diesem Grund das Pattern. Es ist nicht schlimm,
             wenn jemand dies über eine eigenständige Post Methode trotzdem erreicht.
              Nur kann der Admin diese Person dann nicht löschen, sondern sie muss aus der Datenbank direkt entfernt werden.-->
        </div>
    </div>

    <div class="row">
        <div class="col-xs-3">
            <label>Passwort:</label>
        </div>

        <div class="col-xs-5">
            <input type="password" class="form-control" name="Passwort" required="required" pattern="^\S*$"/>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-3">
            <label>Passwort:</label>
        </div>

        <div class="col-xs-5">
            <input type="password" class="form-control" name="Passwort2" required="required" pattern="^\S*$"/>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-offset-3 col-xs-3">
            <input type="submit" value="Ok"/>
        </div>
    </div>
</form>