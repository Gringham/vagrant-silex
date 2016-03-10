<?php $view->extend('layout.html.php') ?>

<?php $view['slots']->set('title', "Mein Blog") ?>

<p><?php             //Aufgrund der großen Anzahl an Variablen, die hier vorkommen habe ich ausnahmsweise einen großen Php Block verwendet
    $count = 0;
    if(!$full){      //Full wird übergeben, wenn ein Beitrag vollständig angezeigt werden soll.
        foreach ($cont as $row) {
            $count+=1;
            echo "<div class='row jumbotron'>" . $row['title'] . " am " . $row['created_at'] . " von " . $row['author'] .
                 "<br/>". substr($row['text'],0, 75) ."<br/><a href='/blog/$count'>weiter lesen...</a>";

            if($in == $row['author']){
                $insert = "/blog/delete/{$count}";
                echo "<br/><br/><form action=$insert , method='post' ><input type='submit' value='Löschen'></form></div>";
            }
            else{echo "</div>";};
        }
    }
    else{
        foreach ($cont as $row) {
            echo "<div class='row jumbotron'>" . $row['title'] . " am " . $row['created_at'] . " von " . $row['author'] .
                "<br/>". $row['text'] ."<br/></div>";
        }
    }

    ?></p>
