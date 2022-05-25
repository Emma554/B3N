<?php

 require "db.php"; 
require "mail.php";
if(isset($_POST['id_location'])){
    $id_location=$_POST['id_location'];
    switch ($_POST['which-response-'.$id_location]) {
        case "acc":
        //   code to be executed if n=label1;
        $sql1="SELECT timediff(now(),concat(`date_debut`,' ',`heure_debut`)) FROM `location` where id_location='".$id_location."'" ;
    $result1=$conn->query($sql1);
    $row1=$result1->fetch_array();


    if (!function_exists('str_starts_with')) {
        function str_starts_with($haystack, $needle) {
            return (string)$needle !== '' && strncmp($haystack, $needle, strlen($needle)) === 0;
        }
    }


    $if_begin=(!str_starts_with($row1[0],'-'));

     $sql1="SELECT timediff(now(),concat(`date_fin`,' ',`heure_fin`)) FROM `location` where id_location='".$id_location."'" ;
    $result1=$conn->query($sql1);
    $row1=$result1->fetch_array();
    $if_not_end=(str_starts_with($row1[0],'-'));
    $statut_location=($if_begin && $if_not_end)? "en cours":(!$if_not_end)?"terminee":"non debutee";
        $sql1="UPDATE `location` set statut_demande='acceptee',statut_location='".$statut_location."' where id_location='".$id_location."'" ;
    $result1=$conn->query($sql1);
    if ($conn->query($sql1)===TRUE) {
        ?>
<script>
alert("La demande a ete valide,un email a ete envoye au client")
</script>
<?php
        sendAcceptMail($conn,$id_location);
    } else {
        # code...
        echo "<h2>".$conn->error."</h2>";
    }

          break;


        case "ref":
        //   code to be executed if n=label2;

        $sql1="UPDATE `location` set statut_demande='refusee',statut_location='refusee' where id_location='".$id_location."'" ;
        
        if ($conn->query($sql1)===TRUE) {
            ?>
<script>
alert("La demande a ete refusee,un email a ete envoye au client")
</script>
<?php
            sendRefuseMail($conn,$id_location);
        } else {
            # code...
            echo "<h2>".$conn->error."</h2>";
        }
          break;

        default:
        echo "Non dans acc ou ref";  
        }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" href="..\bootstrap-5.0.2\dist\css\bootstrap.min.css">
    <link rel="stylesheet" href="..\fontawesome-free-6.1.1-web\css\all.min.css">
    <link rel="stylesheet" href="..\css\root.css">
    <link rel="stylesheet" href="../../style.css">
    <link rel="icon" href="favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">

    <link rel="stylesheet" href="../css/admin_demandes.css">
    <script src="..\js\jquery.js"></script>
    <title>Administration</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark" id="navbar">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="../imgs/website/logo.png" alt="" srcset="" width=50 height=50>
            <h4 class="text-white">B3NAuto</h4>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav d-flex justify-content-end">
                <li class="nav-item">
                    <a class="nav-link text-white font-weight-bold" aria-current="page" href="admin_demandes.php">Demandes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" aria-current="page" href="utilisateurs.php">Utilisateurs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" aria-current="page" href="voitures.php">Vehicules</a>
                </li>
            </ul>

        </div>
    </nav>

    <section class="mt-3 container-fluid" id="history-section">
        <div class="row">
            <div class="col-3">
                <div class="mx-auto text-or">
                    <i class="fa fa-filter" aria-hidden="true"></i>
                    Filtres
                    <div class="d-block">
                        <div class="filter-item">
                            <button class="btn d-flex align-items-center" id="nt-btn">
                                <div class="rounded-circle bg-warning" style="width:25px ; height:25px;">

                                </div>
                                <span class="mx-2" class="text">Non Traitee</span>
                            </button>
                            <button class="btn d-flex align-items-center" id="acc-btn">
                                <div class="rounded-circle bg-success" style="width:25px ; height:25px;">

                                </div>
                                <span class="mx-2" class="text">Acceptee</span>
                            </button> <button class="btn d-flex align-items-center" id="ref-btn">
                                <div class="rounded-circle bg-danger" style="width:25px ; height:25px;">

                                </div>
                                <span class="mx-2" class="text">Refusee</span>
                            </button>
                        </div>
                    </div>

                </div>

            </div>
            <div class="col-9">

                <div class="wrapper-search ml-auto">
                    <div class="search-input">
                        <input type="text" name="" id="input" placeholder="Rechercher un utilisateur">
                        <div class="autocom-box">
                            <li>How to be a big manager</li>
                            <li>Whats is the importance</li>
                            <li>Allons y</li>
                            <li>Jeune homme ,il faut te lever</li>
                            <li>Le telephone est un danger pour la sante</li>
                        </div>
                        <div class="icon"><i class="fa fa-search text-blue" aria-hidden="true"></i></div>
                    </div>

                </div>
                <div id="history-asks">
                    <?php 
                  $sql="select id_location,id_vehicule,id_user,prix_location,date_demande,date_debut,date_fin,heure_debut,heure_fin,statut_demande,statut_location from location";
                  $result=$conn->query($sql);
                  $statut_map["non traitee"]="warning";
                  $statut_map["refusee"]="danger";
                  $statut_map["acceptee"]="success";
                  while($row=$result->fetch_assoc()){ ?>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                        <div class="card-car d-flex" style="width:40rem">
                            <img src="../imgs/vehicules/<?php 
                      $sql1="SELECT image FROM `vehicule` WHERE id_vehicule='".$row['id_vehicule']."'" ;
                      $result1=$conn->query($sql1);
                      $row1=$result1->fetch_array();
                      echo $row1[0];
                      ?>" alt="" style="width: 200px;height:200px">
                            <div class="card-content mx-1 border-start-0 border-2">
                                <p class="text-or">
                                    <?php 
                      $sql1="SELECT concat(marque,' ',nom_vehicule) FROM `vehicule` WHERE id_vehicule='".$row['id_vehicule']."'" ;
                      $result1=$conn->query($sql1);
                      $row1=$result1->fetch_array();
                      echo $row1[0];
                                ?>
                                </p>
                                <p>Montant de la demande : <?php echo $row['prix_location']; ?> FCFA</p>
                                <p>Demande le
                                    <?php 
                                
                                $date=explode(" ",$row['date_demande']);
                                
                                echo $date[0]." a ".$date[1]; ?>
                                    par <span class="who-ask"><?php 
                      $sql1="SELECT concat(nom_user,' ',prenom_user) FROM `utilisateur` WHERE id_user='".$row['id_user']."'" ;
                      $result1=$conn->query($sql1);
                      $row1=$result1->fetch_array();
                      echo $row1[0];
                      ?></span>
                                </p>
                                <div class="d-flex align-items-center mb-2">
                                    <span class="mx-2">

                                        Statut : <span class="stat"><?php echo $row['statut_demande']; ?></span></span>
                                    <div class="rounded-circle bg-<?php
                               
                                 echo ($statut_map[$row['statut_demande']]); ?>" style="width:25px ; height:25px;">

                                    </div>

                                </div>
                                <input type="text" value="send-demande" hidden
                                    name="which-response-<?php echo $row['id_location']?>"
                                    id="which-response-<?php echo $row['id_location']?>">
                                <input type="text" hidden value="<?php echo $row['id_location']; ?>" name="id_location"
                                    id="which-response">

                                <button
                                    class="btn btn-success rounded-pill <?php echo ($row['statut_demande']!="non traitee")? "d-none":""; ?>"
                                    type="submit"
                                    onclick="$('#which-response-<?php echo $row['id_location']?>').val('acc')">
                                    Accepter
                                </button>
                                <button
                                    class="btn btn-danger rounded-pill <?php echo ($row['statut_demande']!="non traitee")? "d-none":""; ?>"
                                    type="submit"
                                    onclick="$('#which-response-<?php echo $row['id_location']?>').val('ref')">
                                    Refuser
                                </button>
                            </div>
                        </div>

                    </form>

                    <?php
                }
                ?>
                </div>


            </div>
        </div>
    </section>

    <script src="..\bootstrap-5.0.2\dist\js\bootstrap.min.js"></script>
    <script>
    var btn_array = ["#nt-btn", "#acc-btn", "#ref-btn"];
    $(document).ready(function() {


        btn_array.forEach(element => {
            $(element).on("click", function() {
                // var value = $(this).val().toLowerCase();
                
    $("form").filter(function() {
      $(this).toggle($('.stat',this).text().toLowerCase() == $('.text',$(element)).text().toLowerCase());
    });
            });
        });
        $("#input").on("keyup", function() {
             var value = $(this).val().toLowerCase();
             $("form").filter(function() {
      $(this).toggle($('.who-ask',this).text().indexOf(value)>-1);
    });
            // console.log('---------------------')

    });

    });
    </script>
</body>


</html>