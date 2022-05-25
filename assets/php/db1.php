<?php
   //connexion à la bd
   try{
    $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
    $bdd = new PDO('mysql:host=localhost;dbname=b3nauto', 'root','',$pdo_options);
    //echo"connexion reussie ";
    }
    catch(Exception $e)
    {
        die('Erreur : ' .$e->getMessage());
    }
?>