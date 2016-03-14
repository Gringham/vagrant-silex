<?php
/**
 * @var $view
 */
?>
<?php $view->extend('layout.html.php') ?>

<?php $view['slots']->set('title', "Willkommen") ?>
<div class="row">
    <div class="col-xs-12 jumbotron">
        <p>Dies ist mein Blog, den ich für Webengineering implementiert habe. Er umfasst folgende
            Funktionen:</p>
        <ul>
            <li>Eine statische Home Seite</li>
            <li>Eine Seite, auf der man neue Beiträge verfassen kann, solange man eingeloggt ist</li>
            <li>Die Möglichkeit sich zu registrieren und den Nutzer später mit einem Passwort wieder einzuloggen</li>
            <li>Beiträge kann man über den Blog ansehen und mit weiterlesen komplett anzeigen lassen (sowie daraufhin
                auch vorwärts und rückwärts wandern)
            </li>
            <li>Ist man angemeldet kann man die Beiträge, die von diesem User erstellt wurden löschen und bearbeiten
            </li>
            <li>Meldet man sich als "admin" an (Passwort : 0000) kann man alle Beiträge löschen und bearbeiten!</li>
            <li>Ist man angemeldet kann man sich mit dem Abmelden-Button wieder abmelden</li>
            <li>Der Admin hat die Möglichkeit alle angemeldeten User zu sehen und diese zu löschen</li>
            <li>Einen Schutz gegen Codeinjections (htmlspecialchars)</li>

        </ul>
    </div>
</div>


