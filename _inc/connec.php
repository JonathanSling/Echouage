<?php
$mysqlDsn = "mysql:host=127.0.0.1;dbname=echouage;charset=UTF8;";

$mysqlUserDb = "echouage";
$mysqlPwdDb = "A4ySVdjdNl2LUsUr";

try{
    $dbCnx = new PDO($mysqlDsn, $mysqlUserDb, $mysqlPwdDb);
}catch (PDOException $e){
    echo 'Erreur : ' . $e->getMessage();
}