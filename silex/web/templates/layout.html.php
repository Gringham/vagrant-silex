<!DOCTYPE html>
<?php //Variablendeklaration (diese werden importiert)
/**
 * @var $active
 * @var $view
 * @var $signed
 */
?>

<html>
<head>
    <title><?php $view['slots']->output('title', 'Default title') ?></title>
    <link rel="stylesheet" href="/vendor/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/vendor/CSS/MyCss.css">
    <!-- Mein eigenes CSS File wird für den Hintergrund benötigt-->
    <script src="/vendor/jquery/dist/jquery.min.js"></script>
    <!-- wird für die Navbar verwendet, JQuery muss vor Javascript eingebunden werden, da es sonst scheinbar nicht mitgeladen wird-->
    <script src="/vendor/bootstrap/dist/js/bootstrap.min.js"></script>


</head>


<body class="bgimage">

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <!-- mit # wird das Element weiter unten angesprochen, das weiter untern myNavbar heißt-->
                <span class="icon-bar"></span> <!-- Hier wird der Button designed ^^-->
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/home">Meine Website</a>
        </div>

        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li <?= $active == 'blog' ? 'class = "active"' : '' ?>><a href="/blog">Blog</a></li>
                <!-- Der Php Tag ist eine Kurzabfrage, ob der Link als aktiv angezeigt werden mzss-->
                <li <?= $active == 'new' ? 'class  = "active"' : '' ?>><a href="/new">Neuer Beitrag</a></li>
                <li <?= $active == 'impressum' ? 'class= "active"' : '' ?>><a href="/impressum">Impressum</a></li>
                <?php if (!$signed) : ?>                             <!-- Abfrage ob ein User eingeloggt ist oder nicht-->
                    <li <?= $active == 'sign' ? 'class = "active"' : '' ?>><a href="/sign">Anmelden</a></li>
                <?php else: ?>
                    <li <?= $active == 'sign' ? 'class = "active"' : '' ?>><a href="/sign_out">Abmelden
                            von <?= $signed ?></a>
                    </li>
                <?php endif; ?>

                <?php if ($signed == 'admin') : ?>                      <!-- Abfrage, ob der User der Admin ist, dann bekommt er Zugriff auf die Mitgliederliste-->
                    <li <?= $active == 'members' ? ' class = "active" ' : '' ?>><a href="/members">Mitgliederliste</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid" id="myContainer">
    <div class="row">
        <div class="col-xs-12 col-sm-offset-1 col-sm-10 well well-grey">
            <!-- Für kleinere größen füllt der Inhalt die komplette Seite-->
            <!-- well erzeugt den grauen Rahmen der Überschrift-->
            <h1>
                <?php $view['slots']->output('title', 'Default title') ?>
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-offset-1 col-sm-10 ">
            <?php $view['slots']->output('_content', 'My content') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <hr/>                                     <!-- hr erzeugt eine so genannte Header Row-->
            <footer>by Christoph Leiter 2016</footer>
        </div>
    </div>
</div>

</body>
</html>