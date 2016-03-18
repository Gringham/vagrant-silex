<!-- <//?=?> wird hier nur für einzelne Variablen verwendet, ansonsten die normalen Php Tags-->
<?php
/**
 * @var $cont
 * @var $view
 * @var $signed
 */
?>

<?php $view->extend('layout.html.php') ?>

<?php $view['slots']->set('title', "Nutzerliste") ?>


<?php foreach ($cont as $row) : ?> <!--Ausgabeschleife der Usernamen Anfang-->
    <div class='jumbotron'>
        <div class='row'>
            <div class='col-xs-12'>
                <?= $row['username'] ?><!-- Hiermit wird jeweils der Username ausgelesen-->
            </div>
        </div>

        <div class='row'>
            <div class='col-xs-1'>
                <?php if ($signed == 'admin' and $row['username'] != 'admin'): ?>
                    <!-- Ist der User wirklich der Admin, dann zeige den löschen Knopf an-->
                    <br/><br/>
                    <?php $shortsave = "/member/delete/'" . $row['username'] . "'" ?>
                    <!-- Hier wird der Username in den String gebastelt-->
                    <form action=<?= $shortsave ?> , method='post'>
                        <!-- Hier wird einfach nur ein submitbutton erzeugt-->
                        <input type='submit' value='Löschen' class="btn btn-default">
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>

