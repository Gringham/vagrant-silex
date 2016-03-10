
<html>
    <head>
        <title><?php $view['slots']->output('title', 'Default title') ?></title>

        <!-- Das neueste kompilierte und minimierte CSS -->
        <link rel="stylesheet" href="/vendor/bootstrap/dist/css/bootstrap.min.css">

        <!-- Das neueste kompilierte und minimierte JavaScript -->
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    </head>


    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="/home">Meine Website</a>
                </div>

                <div>
                    <ul class="nav navbar-nav">
                        <li><a href="/blog">Blog</a></li>
                        <li><a href="/new">Neuer Beitrag</a></li>
                        <?php if(!$in) :?>
                            <li><a href="/sign">Anmelden</a></li>
                        <?php else: ?>
                            <li><a href="/sign_out">Abmelden</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid">

            <div class="row">
                <div class = "col-xs-offset-1 col-xs-10 well well-grey">
                    <h1>
                        <?php $view['slots']->output('title', 'Default title') ?>
                    </h1>
                </div>
            </div>

            <div class="row">
                <div class = "col-xs-offset-2 col-xs-9">
                    <?php $view['slots']->output('_content', 'My content') ?>
                </div>
            </div>

            <div class="row">
                <div class = "col-xs-12">
                    <hr/>
                    <footer>by Christoph Leiter   2016</footer>
                </div>
            </div>
        </div>

    </body>
</html>