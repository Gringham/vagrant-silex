<?php
use Symfony\Component\HttpFoundation\Request;

/**
 * @var $db_connection Doctrine\DBAL\Connection
 * @var $app silex\application
 * @var $template symfony\component\templating\DelegatingEngine
 */

//Hinweis, die new_done.html.php wird oftmals als allgemeine Antwort verwendet

$dbConnection = $app['db'];
$template = $app['templating'];

$app->get('/home', function () use ($template, $app) {
    return $template->render( //Gibt beim aufruf von /home die home.hmtl Seite wieder
        'home.html.php',
        array('active' => 'home', 'signed' => $app['session']->get('user'))
    );
});

$app->get('/members', function () use ($template, $app, $dbConnection) {
    if ($app['session']->get('user') == 'admin') {                           //Ist der Nutzer der angemeldet ist wirklich der Nutzer, der den Beitrag verfasst hat ?
        $inhalt = $dbConnection->fetchAll("SELECT username from usrpwd");        //speichert alle Nutzer in Inhalt und übergibt sie an $inhalt
        return $template->render(
            'members.html.php',
            array('active' => 'members', 'cont' => $inhalt, 'signed' => $app['session']->get('user'))
        );
    } else {   //Hat der Nutzer nicht die berechtigungen wird er zur Anmeldung weitergeleitet
        return $app->redirect('\sign');
    }
});//Gibt eine Liste alle rMitglieder aus, member/Delete/usr kann diese dann löschen
$app->post('/member/delete/{usr}', function ($usr) use ($template, $app, $dbConnection) {  //Methode zum löschen von Beiträgen
    if ($app['session']->get('user') == 'admin' and $usr != 'admin') {                           //Ist der Nutzer der angemeldet ist wirklich der Nutzer, der den Beitrag verfasst hat ?
        $dbConnection->delete('usrpwd', array('username' => $usr));                       //Dann lösche den Blogpost an der übergebenen Stelle
        return $template->render(
            'new_done.html.php',
            array('active' => 'new_done', 'cont' => "Der Nutzer wurde erfolgreich gelöscht", 'titel' => "Glückwunsch:", 'signed' => $app['session']->get('user'))
        );
    } else {
        return $template->render(                                 //Ist das Passwort falsch wird eine Fehlermeldung angegeben
            'new_done.html.php',
            array('active' => 'new_done', 'cont' => "Du besitzt nicht die Rechte den Nutzer zu löschen", 'titel' => "Warnung:", 'signed' => $app['session']->get('user'))
        );
    }


}); //Einige Browser sind nicht direkt kompatibel mit delete Typ Formularen, deshalb wurde hier eine post Methode genutzt

$app->get('/register/start', function () use ($template, $app) {
    return $app->redirect('/register');
});//Die beiden Routen sind nur zur Vorsicht, dass der Button nicht die Daten des normalen Login übermittelt
$app->post('/register/start', function () use ($template, $app) {
    return $app->redirect('/register');
});


$app->get('/sign', function () use ($template, $app) {
    return $template->render(
        'sign.html.php',
        array('active' => 'sign', 'signed' => $app['session']->get('user'))
    );
});   //Der Controller der Login Seite
$app->post('/sign', function (Request $request) use ($template, $app, $dbConnection) {
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
        if ($comppwd === $pas) {
            $app['session']->set('user', $usr);   //Ist das Passwort richtig wird der Nutzer eingeloggt
        } else {
            return $template->render(                                 //Ist das Passwort falsch wird eine Fehlermeldung angegeben
                'new_done.html.php',
                array('active' => 'new_done', 'cont' => "Falsches Passwort eingegeben!", 'titel' => "Warnung:", 'signed' => $app['session']->get('user'))
            );
        }
    } else {
        return $template->render(                                 //Ist das Passwort falsch wird eine Fehlermeldung angegeben
            'new_done.html.php',
            array('active' => 'new_done', 'cont' => "Falschen Nutzer eingegeben!", 'titel' => "Warnung:", 'signed' => $app['session']->get('user'))
        );
    }

    if ($app['session']->get('user') === 'admin') {  //Ist der User der Admin wird eine spezielle Admin Variable gesetzt
        $app['session']->set('admin', true);
    }

    return $template->render(                                   //Dann wird die Erfolgsmeldung angezeigt
        'new_done.html.php',
        array('active' => 'new_done', 'cont' => "Du wurdest eingeloggt als $usr", 'titel' => "Glückwunsch", 'signed' => $app['session']->get('user'))
    );

});  //Handelt die Einlogganfrage
$app->get('/sign_out', function () use ($template, $app) {
    $app['session']->clear();

    return $template->render(                                   //Dann wird die Erfolgsmeldung angezeigt
        'new_done.html.php',
        array('active' => 'new_done', 'cont' => "Du wurdest ausgeloggt", 'titel' => "Glückwunsch", 'signed' => NULL)  // Da hier kein User mehr eingeloggt ist wird dieser Wert zurück gesetzt.
    );

}); //Löscht alle Sessionvariablen / Loggt aus

$app->get('/register', function () use ($template, $app) {
    return $template->render(
        'register.html.php',
        array('active' => 'register', 'signed' => Null)
    );
}); //Gibt die Registrierungsseite wieder
$app->post('/register', function (Request $request) use ($template, $app, $dbConnection) {
    $usr = $request->get('Sign');           //Hier wird der eingegebene Name abgefragt
    $pas = $request->get('Passwort');       //Hier wird das eingegebene Passwort abgefragt
    $compusr = "";                          //In diese Variable wird der Nutzername aus der Datenbank geladen
    $userlist = $dbConnection->fetchAll("SELECT * FROM usrpwd");     //Hier wird die Liste der eingetragenen Nutzer + Passwörter gespeichert

    if ($request->get('Sign') and $request->get('Passwort') and $request->get('Passwort2')) {  //Wenn Name und Textfeld etwas enthalten lies es in die Datenbank


        foreach ($userlist as $row) {                                      //Hier wird gesucht, ob der eingegebene Nutzer bereits existiert
            if ($row['username'] === $usr) {
                $compusr = $usr;
            }
        }
        if ($compusr === $usr) {                                             //Existiert er, wird das Passwort verglichen
            return $template->render(                                 //Ist das Passwort falsch wird eine Fehlermeldung angegeben
                'new_done.html.php',
                array('active' => 'new_done', 'cont' => "Der Nutzer existiert bereits!", 'titel' => "Warnung:", 'signed' => $app['session']->get('user'))
            );
        }
        if ($pas != $request->get('Passwort2')) {
            return $template->render(                                 //Ist das Passwort falsch wird eine Fehlermeldung angegeben
                'new_done.html.php',
                array('active' => 'new_done', 'cont' => "Das Passwort unterscheidet sich!", 'titel' => "Warnung:", 'signed' => $app['session']->get('user'))
            );
        }
        if (strpos($usr, "String") !== false) {
            return $template->render(                                 //Enthält der Name Leerzeichen
                'new_done.html.php',
                array('active' => 'new_done', 'cont' => "Das Passwort unterscheidet sich!", 'titel' => "Warnung:", 'signed' => $app['session']->get('user'))
            );
        } else {                                                             //ansonsten wird der neue User angelegt und in der Datenbank gespeicher
            $app['session']->set('user', $usr);
            $dbConnection->insert(
                'usrpwd',
                array('username' => htmlspecialchars($usr),  //gegen Codeinjection
                    'password' => htmlspecialchars($pas),
                ));

        }
    } else {              //Ansonsten gib eine Fehlermeldung aus
        return $template->render(                                   //Dann wird die Erfolgsmeldung angezeigt
            'new_done.html.php',
            array('active' => 'new_done', 'cont' => "Der Zugriff wurde verweigert!", 'titel' => "Warnung", 'signed' => $app['session']->get('user'))
        );
    }

    return $template->render(                                   //Dann wird die Erfolgsmeldung angezeigt
        'new_done.html.php',
        array('active' => 'new_done', 'cont' => "Du wurdest eingeloggt als $usr", 'titel' => "Glückwunsch", 'signed' => $app['session']->get('user'))
    );
}); //Der Controller der Registrierungsseite

$app->get('/blog', function () use ($template, $dbConnection, $app) {
    $inhalt = $dbConnection->fetchAll("SELECT * FROM blog_post ORDER BY id DESC"); //Ordnet die  Blogeinträge mit dem neusten zuerst und speichert sie in Inhalt
    return $template->render(
        'blog.html.php',
        array('active' => 'blog', 'cont' => $inhalt, 'signed' => $app['session']->get('user'), 'full' => Null)
    );
});  //Gibt den Blog normal wieder
$app->get('/blog/{page}', function ($page) use ($template, $dbConnection, $app) {    //merke dir bind
    $inhalt = $dbConnection->fetchAll("SELECT * from blog_post WHERE id=$page");
    if ($inhalt) {      //Wenn ein Blogeintrag mit der gewünschten ID vorhanden ist gib ihn wieder
        return $template->render(
            'blog.html.php',
            array('active' => 'blog', 'cont' => $inhalt, 'signed' => $app['session']->get('user'), 'full' => true)
        );
    } else {
        return $template->render(                                   //Ansonsten gib eine Fehlermeldung aus
            'new_done.html.php',
            array('active' => 'new_done', 'cont' => "Es wurde leider kein Beitrag gefunden", 'titel' => "Warnung", 'signed' => $app['session']->get('user'))
        );
    }
}); //Gibt einen Blogeintrag genauer wieder
$app->get('/blog/prev/{page}', function ($page) use ($template, $dbConnection, $app) {
    $inhalt = $dbConnection->fetchAll("select id from blog_post where id = (select max(id) from blog_post where id < $page)");  //Sucht die größte Id, die kleiner als die letzte ist
    if ($inhalt) {
        return $app->redirect("/blog/{$inhalt[0]['id']}"); //Ist keine vorherige Seite vorhanden bleibe auf der momentanen
    } else {
        return $app->redirect("/blog/{$page}");
    }
}); //Wechselt zum letzten Blogeintrag
$app->get('/blog/next/{page}', function ($page) use ($template, $dbConnection, $app) {
    $inhalt = $dbConnection->fetchAll("select id from blog_post where id = (select min(id) from blog_post where id > $page)");
    if ($inhalt) {
        return $app->redirect("/blog/{$inhalt[0]['id']}"); //Ist keine nächste Seite vorhanden bleibe auf der momentanen
    } else {
        return $app->redirect("/blog/{$page}");
    }

}); //Wecheslt zum nächsten Blogeintrag

$app->get('/impressum', function () use ($template, $dbConnection, $app) {
    return $template->render(
        'impressum.html.php',
        array('active' => 'impressum', 'signed' => $app['session']->get('user'))
    );
}); //Gib das statische Impressum wieder

$app->get('/blog/edit/{page}', function ($page) use ($template, $dbConnection, $app) {
    $inhalt = $dbConnection->fetchAll("SELECT * from blog_post WHERE id=$page");
    return $template->render(
        'edit.html.php',
        array('active' => 'new', 'cont' => $inhalt, 'site' => $page, 'signed' => $app['session']->get('user')));


}); //Öffnet das Editierungstemplate
$app->post('/blog/edit/{page}', function ($page, Request $request) use ($template, $dbConnection, $app) {
    $author = $dbConnection->fetchAll("SELECT author FROM blog_post WHERE id=$page");
    if ($app['session']->get('user') == $author[0]['author'] or $app['session']->get('user') == 'admin') {                           //Ist der Nutzer der angemeldet ist wirklich der Nutzer, der den Beitrag verfasst hat ?
        $dbConnection->delete('blog_post', array('id' => $page));   //löscht den alten Beitrag
        $dbConnection->insert(                                     //Speichert den neuen Beitrag
            'blog_post',
            array('title' => htmlspecialchars($request->get('Name')),
                'author' => $app['session']->get('user'),
                'text' => htmlspecialchars($request->get('Area')),
                'created_at' => date("c")

            )
        );
        return $template->render(
            'new_done.html.php',
            array('active' => 'new_done', 'cont' => "Der Beitrag wurde erfolgreich bearbeitet", 'titel' => "Glückwunsch", 'signed' => $app['session']->get('user'))
        );
    } else {
        return $template->render(                                 //Ist das Passwort falsch wird eine Fehlermeldung angegeben
            'new_done.html.php',
            array('active' => 'new_done', 'cont' => "Du besitzt nicht die Rechte den Beitrag zu bearbeiten", 'titel' => "Warnung:", 'signed' => $app['session']->get('user'))
        );
    }


});
$app->post('/blog/delete/{page}', function ($page) use ($template, $app, $dbConnection) {  //Methode zum löschen von Beiträgen
    $author = $dbConnection->fetchAll("SELECT author FROM blog_post WHERE id=$page");
    if ($app['session']->get('user') == $author[0]['author'] or $app['session']->get('user') == 'admin') {                           //Ist der Nutzer der angemeldet ist wirklich der Nutzer, der den Beitrag verfasst hat ?
        $dbConnection->delete('blog_post', array('id' => $page));                       //Dann lösche den Blogpost an der übergebenen Stelle
        return $template->render(
            'new_done.html.php',
            array('active' => 'new_done', 'cont' => "Der Beitrag wurde erfolgreich gelöscht", 'titel' => "Glückwunsch:", 'signed' => $app['session']->get('user'))
        );
    } else {
        return $template->render(                                 //Ist das Passwort falsch wird eine Fehlermeldung angegeben
            'new_done.html.php',
            array('active' => 'new_done', 'cont' => "Du besitzt nicht die Rechte den Beitrag zu löschen", 'titel' => "Warnung:", 'signed' => $app['session']->get('user'))
        );
    }


}); //Einige Browser sind nicht direkt kompatibel mit delete Typ Formularen, deshalb wurde hier eine post Methode genutzt


$app->match('/new', function (Request $request) use ($template, $dbConnection, $app) { //Diese Methode entstand im Unterricht um match zu testen
    if (null === $user = $app['session']->get('user')) return $app->redirect('/sign');//Ist kein Nutzer registriert wird er zur Anmeldung zurückgeleitet

    if ($request->isMethod('POST')) {  //Im Falle eine Post Methode
        if ($request->get('Name') and $request->get('Area')) {  //Wenn Name und Textfeld etwas enthalten lies es in die Datenbank
            $dbConnection->insert(
                'blog_post',
                array('title' => htmlspecialchars($request->get('Name')),
                    'author' => $app['session']->get('user'),
                    'text' => htmlspecialchars($request->get('Area'))
                )
            );
        } else {              //Ansonsten gib eine Fehlermeldung aus
            return $template->render(
                'new.html.php',
                array('active' => 'new', 'cont' => "Du hast ein Feld freigelassen", 'signed' => $app['session']->get('user'))
            );
        }

        return $template->render( //wurde etwas in der DB gespeichert gib eine Erfolgsmeldung aus
            'new_done.html.php',
            array('active' => 'new_done', 'cont' => "Dein Blogeintrag wurde gespeichert!", 'titel' => "Glückwunsch:", 'signed' => $app['session']->get('user'))
        );
    }
    if (!$request->isMethod('GET')) //Wenn eine ganz andere Methode genutzt wird brich ab
    {
        $app->abort(405);
    } else {
        return $template->render(   //Ansonsten gib das Eingabeformular aus
            'new.html.php',
            array('active' => 'new', 'cont' => false, 'signed' => $app['session']->get('user'))
        );
    }
}); // Der Controller der Post Funktion des Blogs



