<?php $view->extend('layout.html.php') ?>
<?php /**
 * @var $cont
 * @var $full
 * @var $signed
 */
?>

<?php $view['slots']->set('title', "Mein Blog") ?>
<?php if (!$full): ?> <!--Wenn alle Beiträge ausgegeben werden sollen-->
    <?php foreach ($cont as $row) : ?> <!--Ausgabeschleife beginnt-->
        <?php $shortsave = "/blog/{$row['id']}"; ?>

        <div class='row jumbotron'>

            <div class="row ">
                <div class="col-xs-12">
                    <h4>
                        <em>
                            Beitrag: <?= $row['title'] ?>
                        </em>
                    </h4>
                </div>
            </div>

            <!--Ausgabe einer Zeile der Datenbank-->
            <br/>
            <div class="row alert alert-success">
                <div class="col-xs-12">
                    <?= substr($row['text'], 0, 75); ?> <!--Ausgabe der ersten 75 Zeichen des Inhaltes-->
                    <a href=<?= $shortsave ?>>weiterlesen... </a>
                </div>
            </div>

            <!--Der weiterlesen- Link wird für alle Seiten implementiert-->
            <div class="row">
                <div class="col-xs-12 alert alert-info">
                    Um <?= date("H:i:s", strtotime($row['created_at'])); ?> Uhr,
                    Am <?= date("d.m.Y", strtotime($row['created_at'])); ?> in Unixzeit, Erstellt
                    von <?= $row['author'] ?>
                </div>
            </div>


            <?php if ($signed == $row['author'] or $signed == 'admin'): ?>
                <!--Jeder User kann seine eigenen Beiträge löschen und der Admin alle-->
                <div class="row">
                    <br/>
                    <div class="col-lg-1">
                        <?php $insert = "/blog/edit/{$row['id']}"; ?> <!--Die übergebene ID wird bearbeitet-->
                        <form action=<?= $insert ?> , method='get'>
                            <input type='submit' value='Bearbeiten' class="btn btn-default">
                        </form>
                    </div>

                    <div class="col-lg-2">
                        <div class="col-lg-offset-2"> <!--Hierdurch werden die Knöpfe schöner positioniert-->
                            <?php $input = "/blog/delete/{$row['id']}"; ?> <!--Die übergebene ID wird gelöscht-->
                            <form action=<?= $input ?> , method='post'>
                                <input type='submit' value='Löschen' class="btn btn-default">
                            </form>
                        </div>
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
                        <em>
                            Beitrag: <?= $row['title'] ?>
                        </em>
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
                    Um <?= date("H:i:s", strtotime($row['created_at'])); ?> Uhr,
                    Am <?= date("d.m.Y", strtotime($row['created_at'])); ?> in Unixzeit, Erstellt
                    von <?= $row['author'] ?>
                </div>
            </div>

            <div class="row">
                <br/>
                <div class="col-lg-1">
                    <?php $insert = "/blog/prev/{$row['id']}"; ?> <!--Der letzte Beitrag wird ausgewählt-->
                    <form action=<?= $insert ?> , method='get'>
                        <input type='submit' value='Vorheriger Beitrag' class="btn btn-default">
                    </form>
                </div>

                <div class="col-lg-8">
                    <div class="col-lg-offset-1"> <!--Hierdurch werden die Knöpfe schöner positioniert-->
                        <?php $input = "/blog/next/{$row['id']}"; ?> <!--Der nächste Beirag wird ausgewählt-->
                        <form action=<?= $input ?> , method='get'>
                            <input type='submit' value='Nächster Beitrag' class="btn btn-default">
                        </form>
                    </div>
                </div>


                <?php if ($signed == $row['author'] or $signed == 'admin'): ?>
                <!--Jeder User kann seine eigenen Beiträge löschen und der Admin alle-->


                <div class="col-lg-1">
                    <?php $insert = "/blog/edit/{$row['id']}"; ?> <!--Die übergebene ID wird bearbeitet-->
                    <form action=<?= $insert ?> , method='get'>
                        <input type='submit' value='Bearbeiten' class="btn btn-default">
                    </form>
                </div>

                <div class="col-lg-2">
                    <div class="col-lg-offset-2"> <!--Hierdurch werden die Knöpfe schöner positioniert-->
                        <?php $input = "/blog/delete/{$row['id']}"; ?> <!--Die übergebene ID wird gelöscht-->
                        <form action=<?= $input ?> , method='post'>
                            <input type='submit' value='Löschen' class="btn btn-default">
                        </form>
                    </div>
                </div>
            </div>

            <?php endif; ?>
        </div>

    <?php endforeach; ?>
<?php endif; ?>