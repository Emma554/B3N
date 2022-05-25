<?php

require 'db1.php';

if(!empty($_GET['id']))
{
    $id = checkinput($_GET['id']);

}
if(!empty($_POST['id']))
{
    $id = checkinput($_POST['id']);
    
    $statement = $bdd->prepare('DELETE FROM vehicule WHERE id_vehicule = ?');
    $statement->execute(array($id));
   
    header("Location: voitures.php");

}

function checkinput($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html>

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

<div class="container admins">
   <div class="row">
       <h1><strong>Supprimer une voiture</strong></h1>
       <table class="table table-striped table-bordered">
         <thead>
          <p class="alert alert-warning" >Etes vous sure de vouloir supprimer cette voiture ?</p>

         </thead>
         <tbody>
         <form class="form" role = "form" action="delete.php" method="post" enctype="multipart/form-data">
         <input type="hidden" name="id" value="<?php echo $id; ?>"/>
         <button type="submit" class="btn btn-warning "> oui</button><span><?php  echo " " ?></span>
         <a href="voitures.php" class="btn btn-default"> non</a></h1>
         </form>
         </tbody>
       </table>
</div>
  </div>
</body>



</html>