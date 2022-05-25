<?php
require "../php/db.php";
$id_user=$_GET['id_user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique utilisateur</title>
    <script src="..\bootstrap-5.0.2\dist\js\bootstrap.min.js"></script>
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <link rel="stylesheet" href="..\bootstrap-5.0.2\dist\css\bootstrap.min.css">
    <link rel="stylesheet" href="..\fontawesome-free-6.1.1-web\css\all.min.css">
    <link rel="stylesheet" href="..\css\root.css">
    <link rel="stylesheet" href="../css/utilisateur_historique.css">
    <script src="..\js\jquery.js"></script>
    <title>B3NAuto</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light" id="navbar">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="../imgs/website/logo.png" alt="" srcset="" width=50 height=50>
            <h4 class="text-blue">B3NAuto</h4>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav d-flex justify-content-end">
                <li class="nav-item">
                    <a class="nav-link active text-blue" aria-current="page" href="utilisateur_historique.php">Historique de location</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="../../index.php">Location de voiture</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="#">Profil</a>
                </li>
            </ul>

        </div>
    </nav>

    <section>
        
        <div class="box">  
            <h2>Recherche une location</h2>
            <div class="d-flex">
                           <input class="form-control me-2" id="myInput" type="search" placeholder="Mot-cle" aria-label="Search">
                           <button class="btn btn-blue"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
        </div>
    </section>
    <section class="table-historique">
        <div class="table-responsive">
            <table class="table table-sm table-dark" id="myTable">
                <thead>
                  <tr>
                    <th scope="col">id</th>
                    <th scope="col">Voiture</th>
                    <th scope="col">Prix</th>
                    <th scope="col">Date Demande</th>
                    <th scope="col">Debut</th>
                    <th scope="col">Fin</th>
                    <th scope="col">Statut Demande</th>
                    <th scope="col">Statut Location</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $sql="select id_location,id_vehicule,prix_location,date_demande,date_debut,date_fin,heure_debut,heure_fin,statut_demande,statut_location from location where id_user='".$id_user."'";
                  $result=$conn->query($sql);
                  while($row=$result->fetch_assoc()){
                  ?>
                  <tr>
                    <th scope="row"><?php echo $row['id_location']; ?></th>
                    <td>
                      <?php 
                      $sql1="SELECT concat(marque,' ',nom_vehicule) FROM `vehicule` WHERE id_vehicule='".$row['id_vehicule']."'" ;
                      $result1=$conn->query($sql1);
                      $row1=$result1->fetch_array();
                      echo $row1[0];
                      ?>
                  </td>
                    <td><?php echo $row['prix_location']?></td>
                    <td><?php echo $row['date_demande']?></td>
                    <td><?php echo $row['date_debut']." a ".$row['heure_debut']?></td>
                    <td><?php echo $row['date_fin']." a ".$row['heure_fin']?></td>
                    <td><?php echo $row['statut_demande']?></td>
                    <td><?php echo $row['statut_location']?></td>
              
                  </tr>
                  <?php 
                  }
                  
                  
                  ?>
                </tbody>
              </table>
        </div>
    </section>
    <script>
$(document).ready(function(){
   
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
    });
</script>
</body>
</html>