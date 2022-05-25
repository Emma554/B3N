<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B3NAuto : L'application de gestion de voitures la plus sure</title>
    <script src="assets\bootstrap-5.0.2\dist\js\bootstrap.min.js"></script>
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <link rel="stylesheet" href="assets\bootstrap-5.0.2\dist\css\bootstrap.min.css">
    <link rel="stylesheet" href="assets\fontawesome-free-6.1.1-web\css\all.min.css">
    <link rel="stylesheet" href="assets\css\root.css">
    <link rel="stylesheet" href="style.css">
    <!-- <link rel="stylesheet" href="assets/css/admin_demandes.css"> -->
    <script src="assets\js\jquery.js"></script>
</head>

<body>
    <?php 

require "assets/php/db.php";
if (isset($_POST['id_user']) && $_POST['which-form']=='create') {
    $id_user=$_POST['id_user'];

    $pwd_user=$_POST['pwd_user'];
    
    $pwd_user1=$_POST['pwd_user1'];
    
    $nom_user=$_POST['nom_user'];
    
    $prenom_user=$_POST['prenom_user'];
    
    $adresse_user=$_POST['adresse_user'];
    
    $num_cni=$_POST['num_cni'];
    
    $nationalite=$_POST['nationalite'];
    
    $numtel_user=$_POST['numtel_user'];

    if ($pwd_user != $pwd_user1) {
        ?>
    <script>
        alert("Les mots de passe ne sont pas coherents");
    </script>
    <?php
    } else {
    
    $sql="INSERT INTO utilisateur VALUES ('".$id_user."','".$nom_user."','".$prenom_user."','".$adresse_user."','".$numtel_user."','".$nationalite."','".$num_cni."','".$pwd_user."')";

    if ($conn->query($sql)) {
     ?>
    <script>
        alert("MR/MME/MLLE <?php echo $nom_user.' '.$prenom_user; ?>,votre compte a bien ete cree");
    </script>
    <?php
    } else {
        echo "<p>".$conn->error."</p>";
        echo "<p>".$sql."</p>";
    }
    
     }
}

if(isset($_POST['id_user']) && $_POST['which-form']=='connect'){
    $id_user=$_POST['id_user'];

    $pwd_user=$_POST['pwd_user'];
    
    $sql="SELECT id_user,pwd_user from utilisateur where id_user='".$id_user."' AND pwd_user='".$pwd_user."';";
    $rows= $conn->query($sql);
    
$num=$rows->num_rows;

if ($num==1) {
     header("Location: assets/php/utilisateur_historique.php?id_user=".$id_user);
    } elseif($id_user=="admin" && $pwd_user=="admin") {
        header("Location: assets/php/admin_demandes.php");
    }
   else{
       echo "<p>".$conn->error."</p>";
       echo "<p>".$sql."</p>";
   }
   
}
    
if (isset($_POST['id_user']) && $_POST['which-form']=='send-demande') {
    $id_user=$_POST['id_user'];
    $sql="select nom_user,prenom_user from utilisateur where id_user='".$id_user."'";
//   echo $sql."<br>";

  $result=$conn->query($sql);
  $row = $result->fetch_assoc();
$nom_user=$row['nom_user'];
$prenom_user=$row['prenom_user'];
    $pwd_user=$_POST['pwd_user'];
   
    $full_name_car=explode(" ",$_POST['car']);
    
    $name_car=$full_name_car[1];
    
    $marque_car=$full_name_car[0];
    
    $date_debut=$_POST['date_debut'];
    
    $date_fin=$_POST['date_fin'];
    
    $heure_debut=$_POST['heure_debut'];
    
    $heure_fin=$_POST['heure_fin'];

    
    
  $sql="select id_vehicule,prix_journalier from vehicule where nom_vehicule='".$name_car."' and marque='".$marque_car."'";
//   echo $sql."<br>";

  $result=$conn->query($sql);
  $row = $result->fetch_assoc();
  $id_vehicule=$row["id_vehicule"];
  $prix_journalier=$row["prix_journalier"];
  $date_debut_tmp=$_POST['date_debut']." ".$_POST['heure_debut'];
  $date_fin_tmp=$_POST['date_fin']." ".$_POST['heure_fin'];

  $sql1="SELECT now() FROM `location`" ;
    $result1=$conn->query($sql1);
    $row1=$result1->fetch_array();

    $date_auj=$row1[0];
  
$sql1="select max(id_location) from location" ;
$result1=$conn->query($sql1);
$row1=$result1->fetch_array();

$nb_cars=str_replace("l","",$row1[0]);$nb_cars++;
$new_id_location="l";
$new_id_location.=($nb_cars<10)? "0".$nb_cars:$nb_cars;

  
  $sql1="SELECT datediff('".$date_fin_tmp."','".$date_debut_tmp."') FROM `location`" ;
    $result1=$conn->query($sql1);
    $row1=$result1->fetch_array();

    $nb_days=$row1[0];
//   id_location	id_vehicule	id_user	id_contrat	date_demande	statut_demande	statut_location	prix_location	date_debut	date_fin	heure_debut	heure_fin	

  $sql="insert into location values ('".$new_id_location."','".$id_vehicule."','".$id_user."','".$date_auj."','non traitee','non debutee','".($prix_journalier*$nb_days)."','".$date_debut."','".$date_fin."','".$heure_debut."','".$heure_fin."')";
//  echo "SQL : ".$sql."<br>"; 
  if ($conn->query($sql)===TRUE) { ?>
     <script>
        alert("MR/MME/MLLE <?php echo $nom_user.' '.$prenom_user; ?>,votre demande a bien ete envoyee\nVeuillez regarder votre boite mail pour savoir notre decision");
     </script>
 <?php } else {
     # code...
     echo "<h2>".$conn->error."</h2>";
 }
 


}



    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-white" id="navbar">
        <div class="container-fluid d-flex justify-content-between">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="assets/imgs/website/logo.png" alt="" srcset="" width=50 height=50>
                <h4 class="text-blue">B3NAuto</h4>
            </a>
            <button class="navbar-toggler text-blue" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">
                            <i class="fa fa-user-circle" aria-hidden="true"></i>
                            <span class="link">Accueil</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page"  id="connect-link">
                            <i class="fa fa-user-circle" aria-hidden="true"></i>
                            <span class="link">Connexion</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  id="create-link"><i class="fas fa-sign-in"></i>
                            <span class="link">Inscription</span>
                        </a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    <section class="header d-flex justify-content-around align-items-center">
        <div id="dark">


        </div>


        <div id="wrapper-form-in">
            <h5 class="text-nowrap d-flex justify-content-between align-items-center d-block" id="form-title">

                Louez une voiture des maintenant
<!-- <i class="fa fa-times" aria-hidden="true"></i> -->
                <i class="fa fa-times text-or p-2 d-none" id="close-other-form" aria-hidden="true"></i>
            </h5>

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" id="main-form" autocomplete="off">
                <div class="txt_field"><input type="text" name="id_user" id="" autocomplete="off"><label for="">Identifiant</label></input>
                </div>
                <div class="txt_field"><input type="password" name="pwd_user" id="" autocomplete="off"><label for="">Mot de
                        passe</label></input></div>
                <div id="account-infos" class="d-none">
                    <div class="txt_field"><input type="password" name="pwd_user1" id="" autocomplete="off"><label for="">Confirmer le mot
                            de
                            passe</label></input></div>
                    <div class="txt_field"><input type="text" name="nom_user" id="" autocomplete="off"><label for="">Nom</label></input>
                    </div>
                    <div class="txt_field"><input type="text" name="prenom_user" id="" autocomplete="off"><label for="">
                            Prenom</label></input></div>
                    <div class="txt_field"><input type="email" name="adresse_user" id="" autocomplete="off"><label for="">Adresse
                            Email</label></input></div>
                    <div class="txt_field"><input type="text" name="nationalite" id="" autocomplete="off"><label for="">
                            Nationalite</label></input></div>

                    <div class="txt_field"><input type="text" name="num_cni" id="" autocomplete="off"><label for="">
                            Numero de CNI</label></input></div>

                    <div class="txt_field"><input type="tel" name="numtel_user" id="" autocomplete="off"><label for="">
                            Numero de telephone</label></input></div>

                </div>
                <div id="car-locate-infos">
                    <div class="d-block">
                        <label for="">Voiture</label><br>
                        <select name="car" id="cars" class="my-2">
                            <?php 
                                $sql="select nom_vehicule,marque from vehicule";
                                $result=$conn->query($sql);
                                
                                while($row=$result->fetch_assoc()){
                                    ?>
                            <option value="<?php echo $row['marque']." ".$row['nom_vehicule'];?>">
                                <?php echo $row['marque']." ".$row['nom_vehicule'];?>
                            </option>
                            <?php
                                }
                                
                                ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="date_debut">Date de depart</label>
                            <input type="date" name="date_debut" id="" autocomplete="off" min="<?php echo date("Y-m-d")?>">
                        </div>
                        <div class="col-6">
                            <label for="date_fin">Date de remise</label>
                            <input type="date" name="date_fin" id="" autocomplete="off" min="<?php echo date("Y-m-d")?>">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <label for="heure_debut">Heure de depart</label>
                            <input type="time" name="heure_debut" id="" autocomplete="off" >
                        </div>
                        <div class="col-6">
                            <label for="heure_fin">Heure de remise</label>
                            <input type="time" name="heure_fin" id="" autocomplete="off" >
                        </div>
                    </div>
                </div>
                <input type="text" value="send-demande" hidden name="which-form" id="which-form">
                <input type="submit" value="Envoyer ma demande" id="main-btn">
            </form>
        </div>

        <div id="headingtext">
            <h1 class="text-or">
                B3NAuto
            </h1>
            <h3 class="lora text-wrap w-75 mx-auto text-white">
                La location de voiture vue sous un autre angle
            </h3>
            <div>
                <button class="btn btn-or" id="btn-create">
                    <span> Creer un compte</span>
                    <i class="fa fa-sign-in" aria-hidden="true"></i>
                </button>
                <button class="btn btn-or" id="btn-connect">
                    <span> Se connecter</span>
                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                </button>
                <a href="#main-section">
                    <button class="btn btn-or my-2 text-center" id="btn-see-car">
                        Voir les voitures
                        <i class="fa fa-car" aria-hidden="true"></i>
                    </button>
                </a>
            </div>

        </div>

    </section>

    <section class="cars-section container-fluid" id="main-section">
        <div id="marques">
            <h5 class="text-blue">Marques</h5>

            <div class="d-flex">
                <div class="marque-item active" id="marques-Toutes">
                    Toutes
                </div>
                <?php 
                $sql="select distinct(marque) from vehicule";
                $result=$conn->query($sql);
                while($row=$result->fetch_assoc()){
                    ?>
                <div class="marque-item" id="marque-<?php echo $row["marque"]?>">
                    <?php echo $row["marque"]?>
                </div>
                <?php
                }
                
                ?>
            </div>
        </div>

        <div class="cars-place">
            <div class="wrapper-search">
                <div class="search-input">
                    <input type="text" name="" id="" placeholder="Rechercher une voiture">
                    <div class="autocom-box">
                       
                    </div>
                    <div class="icon"><i class="fa fa-search text-blue" aria-hidden="true"></i></div>
                </div>

            </div>
            <div class="cars-gallery d-flex justify-content-around flex-wrap" id="cars-gallery">
                <?php 
  $sql="select id_vehicule,marque,nom_vehicule,prix_journalier,annee,nbre_places,couleur,type_vehicule,image from vehicule";
  $result=$conn->query($sql);
  
  
  while($row=$result->fetch_assoc()){
      $card="<div class='card card-car' id='".$row['id_vehicule']."'>
      <img src='assets/imgs/vehicules/".$row['image']."' class='card-img-top' alt='...'>
      <div class='card-body'>
          <h5 class='card-title'>".$row['marque']." ".$row['nom_vehicule']."</h5>
      
          <ul class='car-description'>
              <li>Prix: ".$row['prix_journalier']." FCFA/Jour</li>
              <li>Annee: ".$row['annee']."</li>
              <li>Nombre de places: ".$row['nbre_places']."</li>
              <div id='other-infos-".$row['id_vehicule']."' class='d-none'>
                  <li>
                  <div class='d-flex align-items-center'>
                  Couleur : <div style ='background-color: ".$row['couleur'].";width: 50px;height: 20px;'></div>
                  </div>
                
                  </li>
                  <li>
                      Type : ".$row['type_vehicule']."
                  </li>
      
      
              </div>
          </ul>
      
          <button type='button' class='btn btn-or rounded px-2' data-bs-toggle='modal'
              data-bs-target='#modal-form' onclick='changeCar(\"".$row['marque']." ".$row['nom_vehicule']."\")'>
              Louer
          </button>
          <button class='btn btn-blue rounded' onclick='sp(\"".$row['id_vehicule']."\")' id='btn-".$row['id_vehicule']."'>
              Savoir plus
          </button>
      </div>
      
      
      </div>";

    echo $card;
            }

                ?>
            </div>
            <!-- <div class="pagination1 border-success">
                <div class="ml-auto d-flex justify-content-between align-items-center">
                    <i class="fa fa-arrow-circle-left text-blue disabled" aria-hidden="true"></i>
                    <div class="page-number active" onclick="">
                        1
                    </div>
                    <div class="page-number" onclick="">
                        2
                    </div>

                    <i class="fa fa-arrow-circle-right text-blue disabled" aria-hidden="true"></i>

                </div>
            </div> -->
        </div>

    </section>


    <!-- Modal -->
    <div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-or">
                        <h5 class="modal-title" id="exampleModalLabel">Formulaire de demande</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="txt_field"><input type="text" name="id_user" id=""><label
                                for="">Identifiant</label></input>
                        </div>
                        <div class="txt_field"><input type="password" name="pwd_user" id=""><label for="">Mot de
                                passe</label></input></div>
                        <div id="car-locate-infos-1">
                            <div class="d-block">

                                <div class="mb-3">
                                    <label for="which-car" class="form-label">Voiture</label>
                                    <input type="text" disabled class="form-control" id="which-car" aria-describedby="textHelp">
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="date_debut">Date de depart</label>
                                    <input type="date" name="date_debut" id="">
                                </div>
                                <div class="col-6">
                                    <label for="date_fin">Date de remise</label>
                                    <input type="date" name="date_fin" id="">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-6">
                                    <label for="heure_debut">Heure de depart</label>
                                    <input type="time" name="heure_debut" id="">
                                </div>
                                <div class="col-6">
                                    <label for="heure_fin">Heure de remise</label>
                                    <input type="time" name="heure_fin" id="">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                    <input type="text" value="send-demande" hidden name="which-form" id="which-form">
                        <button type="button" class="btn btn-blue rounded px-2" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-or rounded px-2">Envoyer ma demande</button>
                    </div>
                </div>
            </div>

        </form>

    </div>

    <script>
    function changeCar(params) {
        $('#which-car').val(params);
    }

    function sp(params) {
        if ($("#btn-" + params).text() == "Savoir plus") {
            $("#btn-" + params).text("Reduire");
            $("#other-infos-" + params).removeClass("d-none");

        } else {
            $("#btn-" + params).text("Savoir plus");
            $("#other-infos-" + params).addClass("d-none");


        }
    }
    </script>
    
    <script>
        $(document).ready(function () {
            $("#close-other-form").click(()=>{
    
    resetLocateForm();
}); 

function  resetLocateForm(){

    $('#form-title').text("Louez une voiture des maintenant");
        changeTo('#account-infos',"d-block","d-none");
        changeTo('#car-locate-infos',"d-none","d-block");
        changeTo('#close-other-form',"d-block","d-none");
        $('#main-btn').attr("value","Envoyez ma demande");
        $('#btn-connect').removeClass('disabled');
        $('#btn-create').removeClass('disabled');
};
//Boutons connecter etc...
$('#btn-create,#create-link').on("click",()=>{
    // e.preventDefault();
    changeTo('#car-locate-infos',"d-block","d-none");
    changeTo('#account-infos',"d-none","d-block");
    changeTo('#close-other-form',"d-none","d-block");
    $('#main-btn').attr("value","Creer mon compte");
    $('#form-title').text("Nouvel utilisateur");
    $('#btn-create').addClass('disabled');
    $('#btn-connect').removeClass('disabled');
    $('#which-form').val("create");
    // $(this).css("cursor","pointer");
    
});

$('#btn-connect,#connect-link').on("click",()=>{
    // e.preventDefault();
    changeTo('#car-locate-infos',"d-block","d-none");
    changeTo('#account-infos',"d-block","d-none");
    changeTo('#close-other-form',"d-none","d-block");
    $('#btn-create').removeClass('disabled');
    $('#btn-connect').addClass('disabled');
    $('#main-btn').attr("value","Acceder a mon compte");
    $('#form-title').text("Connexion");
    $('#which-form').val("connect");
    // $(this).css("cursor","pointer");

    
});
//  $(document).click(()=>{

//          resetLocateForm();
//      })  ;


function changeTo(id,class1,class2){
    
    $(id).removeClass(class1);
    $(id).addClass(class2);
}
// Barre de recherche

let cars =[
   <?php $sql1="SELECT concat(marque,' ',nom_vehicule) as c FROM `vehicule`" ;
                      $result1=$conn->query($sql1);
                      $cars=array();
                      while($row1=$result1->fetch_assoc()){
                        array_push($cars,"\"".$row1['c']."\"");
                       };
                       echo join(",",$cars);
                     ?>
];
    

const searchWrapper=document.querySelector(".search-input");
const inputBox=searchWrapper.querySelector("input");
const suggBox=searchWrapper.querySelector(".autocom-box");


$('.search-input input').on("keyup",function(e){
    let userData=e.target.value;
    let emptyArray=[];
    var value = $(this).val().toLowerCase();
        
        $("#cars-gallery div").filter(function() {
           
          $(this).toggle($('h5',this).text().toLowerCase().indexOf(value) > -1);
        });
    // filter_cars();
    if (userData) {
        emptyArray=cars.filter((data)=>{
            return data.toLocaleLowerCase().includes(userData.toLocaleLowerCase());
        });
        emptyArray=emptyArray.map((data)=>{
            return data ='<li>'+data+'</li>';
        });
       
        searchWrapper.classList.add("active");
        let allList=suggBox.querySelectorAll('li');
        for (let index = 0; index < allList.length; index++) {
            allList[index].setAttribute("onclick","select(this)");
            
        }
       
    }
    else{

        searchWrapper.classList.remove("active");
    }
    afficherCars(emptyArray);
});
function select(element){
   let selectUserData=element.textContent;
   inputBox.value=selectUserData;   
}

function afficherCars(list){
    let listData;
    if (!list.length) {
        let uservalue=inputBox.value;
        listData='<li>'+uservalue+'</li>';
    } else {
        listData=list.join('');
    }
    suggBox.innerHTML=listData;
}

//--------------------------------------------

$("#sp").on("click",()=>{
    if ($("#sp").text()=="Savoir plus") {
        $("#sp").text("Reduire");
        $("#other-infos").removeClass("d-none");
    } else {
        $("#sp").text("Savoir plus");
        $("#other-infos").addClass("d-none");
    }
   
});
        });
   

 
    </script>
</body>

</html>