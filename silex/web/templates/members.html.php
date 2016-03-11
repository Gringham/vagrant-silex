<!-- <//?=?> wird hier nur für einzelne Variablen verwendet, ansonsten die normalen Php Tags-->

<?php $view->extend('layout.html.php') ?>

<?php $view['slots']->set('title', "Nutzerliste") ?>


<?php foreach ($cont as $row) : ?> <!--Ausgabeschleife der Usernamen Anfang-->
    <div class='jumbotron'>
        <div class='row'>
            <div class='col-xs-12'>
                <?= $row['username'] ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-xs-1'>
                <?php if ($in == 'admin' and $row['username'] != 'admin'): ?>
                    <!-- Ist der User wirklich der Admin, dann zeige den löschen Knopf an-->
                    <br/><br/>
                    <?php $inhalt = "/member/delete/{$row['username']}" ?>
                    <!-- Hier wird der Username in den String gebastelt-->
                    <form action=<?= $inhalt ?> , method='post'>
                        <!-- Hier wird einfach nur ein submitbutton erzeugt-->
                        <input type='submit' value='Löschen'>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>

