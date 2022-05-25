<?php
  include("db1.php");
  $req = "SELECT * FROM vehicule";
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
  <link rel="stylesheet" href="..\css\root.css">

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
            <ul class="navbar-nav ms-auto ">
                <li class="nav-item">
                    <a class="nav-link mx-2" href="utilisateurs.php">utilisateurs</a>
                  </li>
              <li class="nav-item">
                <a class="nav-link mx-2 active" aria-current="page" href="voitures.php">Véhicules</a>
              </li>
              
              <li class="nav-item">
                <a class="nav-link mx-2" href="admin_demandes.php">Demandes</a>
              </li>
              
            </ul>
          </div>
        </div>
        </nav>
      
       <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Id</th>
			<th>Nom</th>
			<th>Type</th>
			<th>Immatriculation de location</th>
			<th>Marque</th>
      <th>Prix journalier</th>
			<th>Couleur</th>
      <th>Année</th>
      <th>Nombre de places</th>
      <th>image</th>
			<th style="text-align:center;width:100px;">Action
                
		</tr>

	</thead>
	<tbody>

    <?php   // LOOP TILL END OF DATA 
        while($rows=$result->fetch(PDO::FETCH_ASSOC))
        {
    ?>
		<tr id="<?php echo $rows['id_vehicule'];?>">
        <td><?php echo $rows['id_vehicule'];?></td>
        <td><?php echo $rows['nom_vehicule'];?></td>
        <td><?php echo $rows['type_vehicule'];?></td>
        <td><?php echo $rows['immatriculation'];?></td>
        <td><?php echo $rows['marque'];?></td>
        <td><?php echo $rows['prix_journalier'];?></td>
        <td><div class='d-flex align-items-center'>
                  <div style ='background-color:  <?php echo $rows['couleur'];?>;width: 50px;height: 20px;'></div>
                  </div>
                 </td>
        <td><?php echo $rows['annee'];?></td>
        <td><?php echo $rows['nbre_places'];?></td>
        <td> <img src="../imgs/vehicules/<?php echo $rows['image']; ?>" class='card-img-top' alt='...'>
     </td>
        <td><?php echo'<a class="btn btn-primary" href="update.php?id='. $rows['id_vehicule'] . '"><span class="fa fa-pencil "></span> </a>';
                  echo' <a class="btn btn-danger" href="delete.php?id='. $rows['id_vehicule'] . '" ><span class="fa fa-remove "></span> </a>'?></td>;
   
          <!--
				<td><button type="button" class="btn btn-primary btn-xs dt-edit" style="margin-right:16px;" >
					<span class="fa fa-pencil" aria-hidden="true"></span>
				</button>
				<button type="button" class="btn btn-danger btn-xs dt-delete" onclick="">
					<span class="fa fa-remove" aria-hidden="true"></span>
				</button>
			</td>-->
		</tr>
		<?php } ?>
	</tbody>
</table>


<div class="register-form mt-3 mb-3">
  <div class="container">
        <div class="row">
            
          <div class="col-md-6 bg-dark">
              <form method="POST" action="ajout.php" enctype="multipart/form-data" class="p-4 text-white">
                
                <div class="form-group">
                    <label for="name"> Nom</label>
                    <input type="text" class="form-control" name="nom">
                </div>
                <div class="form-group">
                    <label for="name"> Type</label>
                    <input type="text" class="form-control"  name="type">
                </div>
                <div class="form-group">
                    <label for="name"> Immatriculation</label>
                    <input type="text" class="form-control" name="immat">
                </div>
                <div class="form-group">
                    <label for="name"> Marque</label>
                    <input type="text" class="form-control" name="marque">
                </div>
                <div class="form-group">
                  <label for="name"> Prix journalier</label>
                  <input type="text" class="form-control" name="prix">
              </div>
              <div class="form-group">
                  <label for="name"> Couleur</label>
                  <input type="color" class="form-control" name="couleur">
              </div>
              <div class="form-group">
                  <label for="name"> Année</label>
                  <input type="text" class="form-control" name="annee">
              </div>
              <div class="form-group">
                  <label for="name"> Nombre de place</label>
                  <input type="text" class="form-control" name="nbre">
              </div>
              <div class="form-group">
                  <label for="name"> Image</label>
                  <input type="file" class="form-control" name="image" accept="image/*">
              </div>
                
                <button type="submit" class="btn btn-warning mb-3 mt-3 float-right">Valider</button>
              </form>
          </div>
        </div>
    </div>
</div>

<script>


</script>
</body>
</html>
