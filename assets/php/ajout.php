<?php

include("db1.php");
include("db.php");

try{
        
    $file=$_FILES['image'];
    $sql1="select max(id_vehicule) from vehicule" ;
$result1=$conn->query($sql1);
$row1=$result1->fetch_array();

$nb_cars=str_replace("v","",$row1[0]);$nb_cars++;
$new_id_vehicule="v";
$new_id_vehicule.=($nb_cars<10)? "0".$nb_cars:$nb_cars;
    $photo=$file['name'];
    $name = $_file["name"];
    $tmp_name = $file["tmp_name"];
    $path = $tmp_name;
    $extension = pathinfo($path, PATHINFO_EXTENSION);
    // echo("The extension is $extension.");  

    $photo=$_POST['marque']."/".$_POST['nom'].".".$extension;
    $uploads_dir="../imgs/vehicules/".$photo;
    move_uploaded_file($tmp_name,$uploads_dir);
    
        $req = $bdd->prepare('INSERT INTO vehicule (id_vehicule,nom_vehicule,type_vehicule,immatriculation,marque,prix_journalier,couleur,annee,nbre_places,image)
        VALUES(?,?,?,?,?,?,?,?,?,?)');
        $req->execute(array($new_id_vehicule,$_POST['nom'], $_POST['type'],$_POST['immat'],$_POST['marque'],$_POST['prix'],$_POST['couleur'],$_POST['annee'],$_POST['nbre'],$photo));
        echo "<script>alert(\"Voiture ajoutée!!!\")</script>"; 
        header('Location: voitures.php'); 

          
    }catch(EXCEPTION $e){
        die("erreur".$e->getMessage());
    }
?>
