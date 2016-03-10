<?php
use Symfony\Component\HttpFoundation\Request;

/**
 * @var $db_connection Doctrine\DBAL\Connection
 * @var $app silex\application
 * @var $template symfony\component\templating\DelegatingEngine
 */



$dbConnection = $app['db'];
$template = $app['templating'];

$app->get('/home', function () use ($template,$app) {
    return $template->render(
        'home.html.php',
        array('active' => 'home', 'in' => $app['session']->get('user'))
    );
});

 $app->get('/sign', function () use ($template, $app){
    return $template->render(
        'sign.html.php',
        array('active' => 'sign' , 'in' => $app['session']->get('user'))
    );
});

$app->get('/register', function () use ($template, $app){
    return $template->render(
      'register.html.php',
        array('active' => 'register', 'in' => Null)
    );
});

$app->get('/sign_out', function () use ($template, $app){
    $app['session']->clear();

    return $template->render(                                   //Dann wird die Erfolgsmeldung angezeigt
        'new_done.html.php',
        array('active' => 'new_done', 'cont' => "Du wurdest ausgeloggt", 'titel' => "Glückwunsch" , 'in' => NULL)  // Da hier kein User mehr eingeloggt ist wird dieser Wert zurück gesetzt.
    );

});

$app->get('/register/start', function () use ($template, $app){   //Die beiden Routen sind nur zur Vorsicht, dass der Button nicht die Daten des normalen Login übermittelt
    return $app->redirect('/register');
});

$app->post('/register/start', function () use ($template, $app){
    return $app->redirect('/register');
});

$app->post('blog/delete/{page}', function ($page) use ($template, $app, $dbConnection){

        $dbConnection->delete('blog_post', array('id'=>1));
        return $template->render(                                 //Ist das Passwort falsch wird eine Fehlermeldung angegeben
            'new_done.html.php',
            array('active' => 'new_done', 'cont' => $page, 'titel' => "Warnung:" , 'in' => $app['session']->get('user'))
        );


});


$app->post('/sign', function (Request $request) use ($template, $app, $dbConnection){
    $usr = $request->get('Sign');           //Hier wird der eingegebene Name abgefragt
    $pas = $request->get('Passwort');       //Hier wird das eingegebene Passwort abgefragt
    $compusr = "";                          //In diese Variable wird der Nutzername aus der Datenbank geladen
    $comppwd = "";


    $userlist = $dbConnection->fetchAll("SELECT * FROM usrpwd");     //Hier wird die Liste der eingetragenen Nutzer + Passwörter gespeicher

    foreach($userlist as $row){                                      //Hier wird gesucht, ob der eingegebene Nutzer bereits existiert
        if($row['username'] === $usr){
            $compusr = $usr;
            $comppwd = $row['password'];
        }
    }
    if($compusr===$usr){                                             //Existiert er, wird das Passwort verglichen
        if($comppwd===$pas){
            $app['session']->set('user', $usr);   //Ist das Passwort richtig wird der Nutzer eingeloggt
        }}
    else{
        return $template->render(                                 //Ist das Passwort falsch wird eine Fehlermeldung angegeben
            'new_done.html.php',
            array('active' => 'new_done', 'cont' => "Falschen Nutzer oder falsches Passwort eingegeben!", 'titel' => "Warnung:" , 'in' => $app['session']->get('user'))
         );
        }

    if ($app['session']->get('user') === 'admin'){
        $app['session']->set('admin',true);
    }

    return $template->render(                                   //Dann wird die Erfolgsmeldung angezeigt
        'new_done.html.php',
        array('active' => 'new_done', 'cont' => "Du wurdest eingeloggt als $usr", 'titel' => "Glückwunsch" , 'in' => $app['session']->get('user'))
    );

});

$app->post('/register', function (Request $request) use ($template, $app, $dbConnection) {
    $usr = $request->get('Sign');           //Hier wird der eingegebene Name abgefragt
    $pas = $request->get('Passwort');       //Hier wird das eingegebene Passwort abgefragt
    $compusr = "";                          //In diese Variable wird der Nutzername aus der Datenbank geladen
    $comppwd = "";


    $userlist = $dbConnection->fetchAll("SELECT * FROM usrpwd");     //Hier wird die Liste der eingetragenen Nutzer + Passwörter gespeicher

    foreach ($userlist as $row) {                                      //Hier wird gesucht, ob der eingegebene Nutzer bereits existiert
        if ($row['username'] === $usr) {
            $compusr = $usr;
            $comppwd = $row['password'];
        }
    }
    if ($compusr === $usr) {                                             //Existiert er, wird das Passwort verglichen
        return $template->render(                                 //Ist das Passwort falsch wird eine Fehlermeldung angegeben
            'new_done.html.php',
            array('active' => 'new_done', 'cont' => "Der Nutzer existiert bereits!", 'titel' => "Warnung:", 'in' => $app['session']->get('user'))
        );
    }
    if ($pas != $request->get('Passwort2')) {
        return $template->render(                                 //Ist das Passwort falsch wi rd eine Fehlermeldung angegeben
            'new_done.html.php',
            array('active' => 'new_done', 'cont' => "Das Passwort unterscheidet sich!", 'titel' => "Warnung:", 'in' => $app['session']->get('user'))
        );
    } else {                                                             //ansonsten wird der neue User angelegt und in der Datenbank gespeicher
        $app['session']->set('user', $usr);
        $dbConnection->insert(
            'usrpwd',
            array('username' => $usr,
                'password' => $pas,
            ));

    }


    return $template->render(                                   //Dann wird die Erfolgsmeldung angezeigt
        'new_done.html.php',
        array('active' => 'new_done', 'cont' => "Du wurdest eingeloggt als $usr", 'titel' => "Glückwunsch", 'in' => $app['session']->get('user'))
    );
});

$app->get('/blog', function () use ($template, $dbConnection, $app) {
    $inhalt = $dbConnection->fetchAll("SELECT * from blog_post");
    return $template->render(
        'blog.html.php',
        array('active' => 'blog', 'cont'=>$inhalt , 'in' => $app['session']->get('user'), 'full' => Null)
    );
});



$app->get('/blog/{page}', function ($page) use ($template, $dbConnection, $app) {    //merke dir bind
    $inhalt = $dbConnection->fetchAll("SELECT * from blog_post WHERE id=$page");
    if($inhalt){
        return $template->render(
            'blog.html.php',
            array('active' => 'blog', 'cont'=>$inhalt , 'in' => $app['session']->get('user'), 'full' => true)
    );}
    else{
        return $template->render(                                   //Dann wird die Erfolgsmeldung angezeigt
            'new_done.html.php',
            array('active' => 'new_done', 'cont' => "Es wurde leider kein Beitrag gefunden", 'titel' => "Warnung", 'in' => $app['session']->get('user'))
        );}
});

$app->match('/new', function (Request $request) use ($template, $dbConnection,$app) {
    if (null === $user = $app['session']->get('user')) return $app->redirect('/sign');

    if ($request->isMethod('POST')) {

        if ($request->get('Name') and $request->get('Area')) {
            $dbConnection->insert(
                'blog_post',
                array('title'=>$request->get('Name'),
                    'author'=>$app['session']->get('user'),
                    'text' => $request->get('Area'),
                    'created_at' => date("c")

        )
            );
        } else {
            return $template->render(
                'new.html.php',
                array('active' => 'new', 'cont' => "Du hast ein Feld freigelassen",  'in' => $app['session']->get('user'))
            );
        }

        return $template->render(
            'new_done.html.php',
            array('active' => 'new_done', 'cont' => "Dein Blogeintrag wurde gespeichert!", 'titel' => "Dein eingegebener Text:", 'in' => $app['session']->get('user'))
        );
    }
    if(!$request->isMethod('GET'))
    {
        $app->abort(405);
    }
    else{
    return $template->render(
        'new.html.php',
        array('active' => 'new', 'cont' => false , 'in' => $app['session']->get('user'))
    );}
});