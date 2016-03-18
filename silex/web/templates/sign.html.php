<?php
/**
 * @var $view
 */ ?>
<?php $view->extend('layout.html.php');


$view['slots']->set('title', "Bitte melde dich an:");
?>
<div class="jumbotron">
    <form action="/sign" method="post">

        <div class="row">
            <div class="col-xs-5 col-sm-3">
                <label>Username:</label>
            </div>

            <div class="col-xs-5">
                <input type="text" class="form-control" name="Sign" required="required"/>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-5 col-sm-3">
                <label>Passwort:</label>
            </div>

            <div class="col-xs-5">
                <input type="password" class="form-control" name="Passwort" required="required"/>
            </div>


        </div>

        <div class="row">
            <br/>
            <div class="col-xs-offset-5 col-sm-offset-3 col-lg-1">
                <input type="submit" value="Login         " class="btn btn-default"/>
            </div>

    </form>
    <!--Die alte Form muss hier beendet werden, da der Registrierungsbutton sonst keine andere Aufgabe übernehnem kann-->

    <div class=" col-xs-offset-5 col-sm-offset-3 col-lg-offset-0 col-lg-2">
        <form action="/register/start">
            <input type="submit" value="Registrieren " class="btn btn-default">
        </form>
    </div>
</div>
</div>


