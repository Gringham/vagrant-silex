<?php $view->extend('layout.html.php') ?>

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
                    Am <?= $row['created_at'] ?> erstellt von <?= $row['author'] ?>
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

<?php else: ?>                          <!--Wenn nur ein Beitrag ausgegeben werden soll-->
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
        <div class="row alert alert-success">
            <div class="col-xs-12">
                <?= $row['text'] ?> <!--Ausgabe der ersten 75 Zeichen des Inhaltes-->
            </div>
        </div>
        <!--Der weiterlesen- Link wird für alle Seiten implementiert-->
        <div class="row">
            <div class="col-xs-12 alert alert-info">
                Am <?= $row['created_at'] ?> erstellt von <?= $row['author'] ?>
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
<?php endif; ?>