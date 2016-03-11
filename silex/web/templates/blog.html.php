<?php $view->extend('layout.html.php') ?>

<?php $view['slots']->set('title', "Mein Blog") ?>
<?php if (!$full): ?> <!--Wenn alle Beiträge ausgegeben werden sollen-->
    <?php foreach ($cont as $row) : ?> <!--Ausgabeschleife beginnt-->
        <?php $inhalt = "/blog/{$row['id']}"; ?>

        <div class='row jumbotron'>
            <div class="row">
                <div class="col-xs-12">
                    <?= $row['title'] ?> am <?= $row['created_at'] ?> von <?= $row['author'] ?>
                    <!--Ausgabe einer Zeile der Datenbank-->
                    <br/>
                    <?= substr($row['text'], 0, 75); ?> <!--Ausgabe der ersten 75 Zeichen des Inhaltes-->
                    <br/>
                    <a href=<?= $inhalt ?>>weiterlesen... </a>
                    <!--Der weiterlesen- Link wird für alle Seiten implementiert-->
                </div>
            </div>
            <div class="row">
                <?php if ($in == $row['author'] or $in == 'admin'): ?> <!--Jeder User kann seine eigenen Beiträge löschen und der Admin alle-->
                    <?php $insert = "/blog/delete/{$row['id']}"; ?>  <!--Die übergebene ID wird gelöscht-->
                    <br/><br/>
                    <div class="col-xs-1">
                        <form action=<?= $insert ?> , method='post'>
                            <input type='submit' value='Bearbeiten'>
                        </form>
                    </div>
                    <div class="col-xs-1">
                        <form action=<?= $insert ?> , method='post'>
                            <input type='submit' value='Löschen   '>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>

<?php else: ?>                          <!--Wenn nur ein Beitrag ausgegeben werden soll-->
    <?php foreach ($cont as $row) : ?>   <!--Die for each Schleife eliminiert hier einen zwei Parametrigen Aufruf von $cont-->
        <div class='row jumbotron'>
            <?= $row['title'] ?> am <?= $row['created_at'] ?> von <?= $row['author'] ?> <br/> <?= $row['text'] ?> <br/>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

