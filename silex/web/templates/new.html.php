<?php $view->extend('layout.html.php');

$view['slots']->set('title', "Neuen Blogeintrag erstellen");
?>

<form action="/new" method="post" class="jumbotron">

    <div class="row">
        <div class="col-xs-5 col-sm-2">
            <label>Überschrift:</label>
        </div>

        <div class="col-xs-5">
            <input type="text" class="form-control" name="Name" required="required">
        </div>
    </div>

    <div class="row">
        <div class="col-xs-5 col-sm-2">
            <label>Dein Text:</label>
        </div>

        <div class="col-xs-5">
            <textarea class="form-control" name="Area" required="required"><?=$cont[0]['text']?></textarea>
        </div>


    </div>

    <div class="row">
        <div class="col-xs-offset-5 col-xs-2 col-sm-offset-2 col-sm-3">
            <input type="submit" value="Senden"/>
        </div>
    </div>

    <?php if ($cont == "Du hast ein Feld freigelassen") : ?>
        <div class="row">
            <div class="col-xs-offset-2 col-xs-5">
                <br/>
                <p class="alert alert-danger"><?php echo $cont ?></p>
            </div>
        </div>
    <?php endif; ?>

</form>



