<?php $view->extend('layout.html.php');

$view['slots']->set('title', "Bitte melde dich an:");
?>

<form action="/register" method="post" class="jumbotron">

    <div class="row">
        <div class="col-xs-3">
            <label>Username:</label>
        </div>

        <div class="col-xs-5">
            <input type="text" class="form-control" name="Sign" required="required"/>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-3">
            <label>Passwort:</label>
        </div>

        <div class="col-xs-5">
            <input type="password" class="form-control" name="Passwort" required="required"/>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-3">
            <label>Passwort:</label>
        </div>

        <div class="col-xs-5">
            <input type="password" class="form-control" name="Passwort2" required="required"/>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-offset-3 col-xs-3">
            <input type="submit" value="Ok"/>
                                     <!--Die alte Form muss hier beendet werden, da der Registrierungsbutton sonst keine andere Aufgabe übernehnem kann-->

        </div>
    </div>
</form>