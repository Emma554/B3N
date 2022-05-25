<?php
  include("db1.php");
  $req = "SELECT * FROM utilisateur ";
  $result=$bdd->query($req);
 // $voitures=$result->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  
    <script src="..\bootstrap-5.0.2\dist\js\bootstrap.min.js"></script>
  
    <link rel="stylesheet" href="..\bootstrap-5.0.2\dist\css\bootstrap.min.css">
    <link rel="stylesheet" href="..\fontawesome-free-6.1.1-web\css\all.min.css">

    <link rel="stylesheet" href="..\css\styleV.css">

    <link rel="stylesheet" href="..\css\root.css">  

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
      integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
      integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
      integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
  
  
    <title>Utilisateurs</title>
</head>
<body>

  
    <nav class="navbar navbar-expand-lg navbar-dark bg-blue p-3">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">B3N Auto </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        
          <div class=" collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto ">
                
              <li class="nav-item">
                <a class="nav-link mx-2 active" aria-current="page" href="utilisateurs.php">Utilisateurs</a>
              </li>
              <li class="nav-item">
                <a class="nav-link mx-2" href="voitures.php">Véhicules</a>
            </li>
              <li class="nav-item">
                <a class="nav-link mx-2" href="admin_demandes.php">Demandes</a>
              </li>
              
            </ul>
          </div>
        </div>
        </nav>
<span class="text-center pb-2 border-bottom mt-3 mb-2 text-blue border-5">Liste des utilisateurs</span>
    <table id="example" class="table table-hover table-striped table-bordered container-fluid mt-3" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Adresse</th>
                <th>Téléphone</th>
                <th>Nationalité</th>
                <th>N°CNI</th>
                <th>Mot de passe</th>

                <th style="text-align:center;width:100px;">Action</th>
                    
            </tr>
        </thead>
        <tbody>
        <?php   // LOOP TILL END OF DATA 
        while($rows=$result->fetch(PDO::FETCH_ASSOC))
        {
    ?>
        <td><?php echo $rows['id_user'];?></td>
        <td><?php echo $rows['nom_user'];?></td>
        <td><?php echo $rows['prenom_user'];?></td>
        <td><?php echo $rows['adresse_user'];?></td>
        <td><?php echo $rows['numtel_user'];?></td>
        <td><?php echo $rows['nationalite'];?></td>
        <td><?php echo $rows['num_cni'];?></td>
        <td><?php echo $rows['pwd_user'];?></td>
<td class='d-flex'>
                    <button type="button" class="btn btn-primary btn-xs dt-edit" style="margin-right:16px;">
                        <span class="fa fa-pencil" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-danger btn-xs dt-delete">
                        <span class="fa fa-remove" aria-hidden="true"></span>
                    </button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    
</body>
</html>