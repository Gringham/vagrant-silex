<?php $view->extend('layout.html.php') ?>
<?php /**
 * @var $cont
 * @var $full
 * @var $in
 */
?>

<?php $view['slots']->set('title', "Mein Blog") ?>
<?php if (!$full): ?> <!--Wenn alle Beiträge ausgegeben werden sollen-->
    <?php foreach ($cont as $row) : ?> <!--Ausgabeschleife beginnt-->
        <?php $inhalt = "/blog/{$row['id']}"; ?>

        <div class='row jumbotron'>

            <div class="row ">
                <div class="col-xs-12">
                    <h4>
                        Beitrag: <?= $row['title'] ?>
                    </h4>
                </div>
            </div>

            <!--Ausgabe einer Zeile der Datenbank-->
            <br/>
            <div class="row alert alert-success">
                <div class="col-xs-12">
                    <?= substr($row['text'], 0, 75); ?> <!--Ausgabe der ersten 75 Zeichen des Inhaltes-->
                    <a href=<?= $inhalt ?>>weiterlesen... </a>
                </div>
            </div>

            <!--Der weiterlesen- Link wird für alle Seiten implementiert-->
            <div class="row">
                <div class="col-xs-12 alert alert-info">
                    Um <?= date("H:i:s",strtotime($row['created_at'])); ?> Uhr, Am <?= date("d.m.Y",strtotime($row['created_at'])); ?> in Unixzeit, Erstellt von <?= $row['author'] ?>
                </div>
            </div>


            <?php if ($in == $row['author'] or $in == 'admin'): ?>
                <!--Jeder User kann seine eigenen Beiträge löschen und der Admin alle-->
                <br/>
                <div class="row">
                    <div class="col-xs-1">
                        <?php $insert = "/blog/edit/{$row['id']}"; ?> <!--Die übergebene ID wird bearbeitet-->
                        <form action=<?= $insert ?> , method='get'>
                            <input type='submit' value='Bearbeiten'>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-1">
                        <?php $input = "/blog/delete/{$row['id']}"; ?> <!--Die übergebene ID wird gelöscht-->
                        <form action=<?= $input ?> , method='post'>
                            <input type='submit' value='Löschen    '>
                        </form>
                    </div>
                </div>

            <?php endif; ?>
        </div>
    <?php endforeach; ?>

<?php else: ?>                          <!--Wenn nur ein Beitrag ausgegeben werden soll. Hier beginnt quasi das Template für Einzeldarstellungen-->
    <?php foreach ($cont as $row) : ?>   <!--Die for each Schleife eliminiert hier einen zwei Parametrigen Aufruf von $cont-->
        <div class='row jumbotron'>

            <div class="row ">
                <div class="col-xs-12">
                    <h4>
                        Beitrag: <?= $row['title'] ?>
                    </h4>
                </div>
            </div>

            <!--Ausgabe einer Zeile der Datenbank-->
            <br/>
            <div class="row alert alert-success"> <!-- hier habe ich alerts für mein Design verwendet-->
                <div class="col-xs-12">
                    <?= nl2br($row['text']) ?>
                    <!--Automatischer Zeilenumbruch, wenn bei der Eingabe Return betätigt wurde-->
                </div>
            </div>

            <!--Der weiterlesen- Link wird für alle Seiten implementiert-->
            <div class="row">
                <div class="col-xs-12 alert alert-info">
                    Um <?= date("H:i:s",strtotime($row['created_at'])); ?> Uhr, Am <?= date("d.m.Y",strtotime($row['created_at'])); ?> in Unixzeit, Erstellt von <?= $row['author'] ?>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-1">
                    <?php $insert = "/blog/prev/{$row['id']}"; ?> <!--Der letzte Beitrag wird ausgewählt-->
                    <form action=<?= $insert ?> , method='get'>
                        <input type='submit' value='Vorheriger Beitrag'>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-1">
                    <?php $input = "/blog/next/{$row['id']}"; ?> <!--Der nächste Beirag wird ausgewählt-->
                    <form action=<?= $input ?> , method='get'>
                        <input type='submit' value='Nächster Beitrag   '>
                    </form>
                </div>
            </div>


            <?php if ($in == $row['author'] or $in == 'admin'): ?>
                <!--Jeder User kann seine eigenen Beiträge löschen und der Admin alle-->
                <br/>

                <div class="row">
                    <div class="col-xs-1">
                        <?php $insert = "/blog/edit/{$row['id']}"; ?>
                        <!--Die übergebene ID wird bearbeitet/
                        Dies wird vorher in eine extra Variable gespeichert, um das ganze übersichtlicher zu machen und
                        nicht zu viele Tags zu schachteln-->
                        <form action=<?= $insert ?> , method='get'>
                            <!--Das Formular wird verwendet um eine get Methode
                        an einen Button zu binden-->
                            <input type='submit' value='Bearbeiten'>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-1">
                        <?php $input = "/blog/delete/{$row['id']}"; ?> <!--Die übergebene ID wird gelöscht-->
                        <form action=<?= $input ?> , method='post'>
                            <input type='submit' value='Löschen    '>
                        </form>
                    </div>
                </div>

            <?php endif; ?>
        </div>

    <?php endforeach; ?>
<?php endif; ?>