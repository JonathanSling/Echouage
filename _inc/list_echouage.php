<?php
try{
    $sth = $dbCnx->prepare("SELECT * FROM echouage LIMIT 10");
    $sth->execute();
    $results = $sth->fetchAll(PDO::FETCH_OBJ);
}catch (PDOException $e){
    echo 'Erreur : ' . $e->getMessage();
}
foreach ($results as $result){
    echo '<tr style="border: 1px solid black;"><td class="id">'.$result->id.'</td><td class="id">'.$result->date.'</td><td class="label">'.$result->espece.'</td><td class="label">'.$result->zone.'</td><td class="label">'.$result->nombre.'</td></tr>';
}