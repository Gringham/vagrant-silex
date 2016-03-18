<?php //Variablendeklaration (diese werden importiert)
/**
 * @var $cont
 * @var $view
 */
?>
<?php $view->extend('layout.html.php');

$view['slots']->set('title', "Neuen Blogeintrag erstellen");
?>

<form action="/new" method="post" class="jumbotron"> <!--Das Einleseformular für neue Blogeinträge-->

    <div class="row">
        <div class="col-xs-5 col-sm-2">
            <label>Überschrift:</label>
        </div>

        <div class="col-xs-5">
            <input type="text" class="form-control" name="Name" required="required">
            <!-- required sorgt dafür, das ein Inhalt eingegeben werden muss-->
        </div>
    </div>

    <div class="row">
        <div class="col-xs-5 col-sm-2">
            <label>Dein Text:</label>
        </div>

        <div class="col-xs-5">
            <textarea class="form-control" name="Area" required="required"></textarea>
        </div>


    </div>

    <div class="row">
        <div class="col-xs-offset-5 col-xs-2 col-sm-offset-2 col-sm-3">
            <br/>
            <input type="submit" value="Senden" class="btn btn-default"/>
        </div>
    </div>

    <?php if ($cont == "Du hast ein Feld freigelassen") : ?>
        <!-- hier wird der String, der übergeben wird genutzt, um
        einen alert zu triggern. Dieser alert kommt beim normalen gebrauch der Website nicht vor,
        weshalb er meines erachtens in Ordnung ist-->
        <div class="row">
            <div class="col-xs-offset-2 col-xs-5">
                <br/>
                <p class="alert alert-danger"><?php echo $cont ?></p>
            </div>
        </div>
    <?php endif; ?>

</form>



