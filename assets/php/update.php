<?php

require 'db1.php';

if(!empty($_GET['id']))
{
    $id = checkinput($_GET['id']);

}

/*if(!empty($_POST))
{

try{

    $file=$_FILES['image'];
    $photo=$file['name'];
    
   $ide = checkinput($_POST['identifiant']);
   $nom = checkinput( $_POST['nom']);
   $type = checkinput($_POST['type']);
   $imm = checkinput($_POST['immat']);
   $marq = checkinput($_POST['marque']);
   $prix = checkinput($_POST['prix']);
   $couleur = checkinput( $_POST['couleur']);
   $annee = checkinput($_POST['annee']);
   $nbre = checkinput($_POST['nbre']);
   $image = checkinput($photo);
   
    $req = $bdd->prepare("UPDATE vehicule SET id_vehicule = ?, nom_vehicule = ?, type_vehicule = ?, immatriculation = ?, prix_journalier = ?, couleur = ?, annee = ?, nbre_places = ?, photo = ? where id_vehicule = ?");
    $req->execute(array($ide,$nom,$type,$imm,$marq,$prix,$couleur,$annee,$nbre,$image));
        header('Location: voitures.php'); 

          
    }catch(EXCEPTION $e){
        die("erreur".$e->getMessage());
    }
}*/
// Uniquement pour le php du insert.php
$ideError =$nomError =$typeError =$immError =$marqError =$prixError = $couleurError= $anneeError =$nbreError =$imageError = "";
if(!empty($_POST))
{
    $file=$_FILES['image'];
    $photo=$file['name'];
    
   $ide = checkinput($_POST['identifiant']);
   $nom = checkinput( $_POST['nom']);
   $type = checkinput($_POST['type']);
   $imm = checkinput($_POST['immat']);
   $marq = checkinput($_POST['marque']);
   $prix = checkinput($_POST['prix']);
   $couleur = checkinput( $_POST['couleur']);
   $annee = checkinput($_POST['annee']);
   $nbre = checkinput($_POST['nbre']);
   $image = checkinput($photo);
   $imagepath = '../images/' .basename($image);
   $imageextension = pathinfo($imagepath , PATHINFO_EXTENSION);
   $issucces = true;
    $isuploadsucces =  true;
   if(empty($ide))
   {
       $issucces = false;
       $ideError = 'ce champ ne peut pas etre vide';
   }
   if(empty($nom))
   {
       $issucces = false;
       $nomError = 'ce champ ne peut pas etre vide';

   }
   if(empty($type))
   {
       $issucces = false;
       $typeError = 'ce champ ne peut pas etre vide';

   }
   if(empty($imm))
   {
       $issucces = false;
       $immError = 'ce champ ne peut pas etre vide';

   }
   if(empty($marq))
   {
       $issucces = false;
       $marqError = 'ce champ ne peut pas etre vide';

   }
   if(empty($prix))
   {
       $issucces = false;
       $prixError = 'ce champ ne peut pas etre vide';

   }
   if(empty($couleur))
   {
       $issucces = false;
       $couleurError = 'ce champ ne peut pas etre vide';

   }
   if(empty($annee))
   {
       $issucces = false;
       $anneeError = 'ce champ ne peut pas etre vide';

   }
   if(empty($nbre))
   {
       $issucces = false;
       $nbreError = 'ce champ ne peut pas etre vide';

   }
   if(empty($image))
   {
       $isimageupdated = false;
   }
   else
   {
        $isimageupdated = true;
        if($imageextension != "jpg" && $imageextension != "png" && $imageextension !="jpeg" && $imageextension != "gif")
       {
           $imageError = "Les fichiers autorisés sont: Jpeg , png, gif, jpg ";
           $isuploadsucces = false;
       }
       if(file_exists($image))
       {
           $imageError = "le fichier exixte deja";
           $isuploadsucces = false;
       }
       if($_FILES["image"]["size"]>500000)
       {
           $imageError = "Le fichier ne doit pas depasser les 500 kb";
           $isuploadsucces = false;
       }
     /*  if($isuploadsucces)
       {
           if(!move_uploaded_file($_FILES["image"]["tmp_name"] , $imagepath))
           {
               $image = "il y'a eu une erreur lors de l'enregistrement";
               $isuploadsucces = false;
           }
       }*/
   }


   if(($issucces && $isimageupdated && $isuploadsucces) || ($issucces && !$isimageupdated))
   {
       
        $req = $bdd->prepare("UPDATE vehicule SET id_vehicule = ?, nom_vehicule = ?, type_vehicule = ?, immatriculation = ?, marque = ?, prix_journalier = ?, couleur = ?, annee = ?, nbre_places = ?, photo = ? where id_vehicule = ?");
        $req->execute(array($ide,$nom,$type,$imm,$marq,$prix,$couleur,$annee,$nbre,$image,$ide));
      
       
       header("Location: voitures.php");
   }

   else if ($isimageupdated && !$isuploadsucces)
   {

    $statement = $bdd->prepare("SELECT photo FROM vehicule where id_vehicule = ?");
    $statement->execute(array($id));
    $item = $statement->fetch();
    $image = $item['photo'];
    
   }

}
else
{


    $statement = $bdd->prepare("SELECT * FROM vehicule where id_vehicule = ?");
    $statement->execute(array($id));
    $item = $statement->fetch();
    $ide = $item['id_vehicule'];
   $nom = $item['nom_vehicule'];
   $type = $item['type_vehicule'];
   $imm = $item['immatriculation'];
   $marq = $item['marque'];
   $prix = $item['prix_journalier'];
   $couleur = $item['couleur'];
   $annee = $item['annee'];
   $nbre = $item['nbre_places'];
   $image = $item['photo'];
   
    
}


// // Uniquement pour le php du view.php

// if(!empty($_GET['id']))
// {
//     $id = checkinput($_GET['id']);

// }

// $db = Database::connect();
// $statement = $db->prepare('SELECT items.id, items.name, items.description, items.price, items.image, Categories.name AS category 
//                             FROM items LEFT JOIN Categories ON items.category = Categories.id WHERE items.id = ?');
// $statement->execute(array($id));
// $item = $statement->fetch();
// Database::deconnection();


function checkinput($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">


  <script src="..\bootstrap-5.0.2\dist\js\bootstrap.min.js"></script>

  <script src="Voiture.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="..\bootstrap-5.0.2\dist\css\bootstrap.min.css">
  <link rel="stylesheet" href="..\fontawesome-free-6.1.1-web\css\all.min.css">
  <link rel="stylesheet" href="..\css\styleV.css">

  <link rel="stylesheet" href="..\css\style.css">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
    integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
    integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
  </script>
  <script src="https://code.jquery.com/jquery-3.5.1.js">
  </script>
  <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js">
  </script>

  <title>Voitures</title>
</head>

<body>
  
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">B3N Auto </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        
          <div class=" collapse navbar-collapse" id="navbarNavDropdown">
           
          </div>
        </div>
    </nav>

       

    <div class="register-form mt-3 mb-3">
        <div class="container">
            <div class="row">
                
            <div class="col-md-6 bg-dark">
                <form method="POST" action="<?php echo 'update.php?id=' .$id; ?>" enctype="multipart/form-data" class="p-4 text-white">
                    <div class="form-group">
                    <label for="name"> Identifiant</label>
                    <input type="text" class="form-control" name="identifiant" require value="<?php echo $ide; ?>">
                    <span class="help-inline"><?php echo $ideError; ?></span>
                </div>
                    <div class="form-group">
                        <label for="name"> Nom</label>
                        <input type="text" class="form-control" name="nom" require value="<?php echo $nom; ?>">
                        <span class="help-inline"><?php echo $nomError; ?></span>

                    </div>
                    <div class="form-group">
                        <label for="name"> Type</label>
                        <input type="text" class="form-control"  name="type" require value="<?php echo $type; ?>">
                        <span class="help-inline"><?php echo $typeError; ?></span>

                    </div>
                    
                    <div class="form-group">
                        <label for="name"> Immatriculation</label>
                        <input type="text" class="form-control" name="immat" require value="<?php echo $imm; ?>">
                        <span class="help-inline"><?php echo $immError; ?></span>

                    </div>
                    <div class="form-group">
                        <label for="name"> Marque</label>
                        <input type="text" class="form-control" name="marque" require value="<?php echo $marq; ?>">
                        <span class="help-inline"><?php echo $marqError; ?></span>

                    </div>
                    <div class="form-group">
                    <label for="name"> Prix journalier</label>
                    <input type="text" class="form-control" name="prix" require value="<?php echo $prix; ?>">
                    <span class="help-inline"><?php echo $prixError; ?></span>

                </div>
                <div class="form-group">
                    <label for="name"> Couleur</label>
                    <input type="text" class="form-control" name="couleur" require value="<?php echo $couleur; ?>">
                    <span class="help-inline"><?php echo $couleurError; ?></span>

                </div>
                <div class="form-group">
                    <label for="name"> Année</label>
                    <input type="text" class="form-control" name="annee" require value="<?php echo $annee; ?>">
                    <span class="help-inline"><?php echo $anneeError; ?></span>

                </div>
                <div class="form-group">
                    <label for="name"> Nombre de place</label>
                    <input type="text" class="form-control" name="nbre" require value="<?php echo $nbre; ?>">
                    <span class="help-inline"><?php echo $nbreError; ?></span>

                </div>
                <div class="form-group">
                    <label for="name"> Image</label>
                    <input type="file" class="form-control" name="image" require accept="image/*" value="<?php echo $image; ?>">
                    <span class="help-inline"><?php echo $imageError; ?></span>

                </div class="form-actions">
                    
                    <button type="submit" class="btn btn-warning mb-3 mt-3 float-right">Modifier</button>
                    <a href="voitures.php" class="btn btn-warning mb-3 mt-3 float-right">Retour</a>
                    

                </form>
            </div>
            </div>
        </div>
    </div>


</body>
</html>
