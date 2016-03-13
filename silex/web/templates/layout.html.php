<!DOCTYPE html>
<html>
<head>
    <title><?php $view['slots']->output('title', 'Default title') ?></title>
    <link rel="stylesheet" href="/vendor/bootstrap/dist/css/bootstrap.min.css">
    <script src="/vendor/jquery/dist/jquery.min.js"></script>
    <!-- wird für die Navbar verwendet, JQuery muss vor Javascript eingebunden werden-->
    <script src="/vendor/bootstrap/dist/js/bootstrap.min.js"></script>


</head>


<body>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <!-- mit # wird das Element weiter unten angesprochen, das weiter untern myNavbar heißt-->
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/home">Meine Website</a>
        </div>

        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li><a href="/blog">Blog</a></li>
                <li><a href="/new">Neuer Beitrag</a></li>
                <?php if (!$in) : ?>                             <!-- Abfrage ob ein User eingeloggt ist oder nicht-->
                    <li><a href="/sign">Anmelden</a></li>
                <?php else: ?>
                    <li><a href="/sign_out">Abmelden von <?= $in ?></a></li>
                <?php endif; ?>

                <?php if ($in == 'admin') : ?>                      <!-- Abfrage, ob der User der Admin ist, dann bekommt er Zugriff auf die Mitgliederliste-->
                    <li><a href="/members">Mitgliederliste</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">

    <div class="row">
        <div class="col-xs-12 col-sm-offset-1 col-sm-10 well well-grey">
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
            <hr/>
            <footer>by Christoph Leiter 2016</footer>
        </div>
    </div>
</div>

</body>
</html>