<?php 
require "db.php";
// Include autoloader 
require_once 'dompdf/autoload.inc.php'; 
 
// Reference the Dompdf namespace 
use Dompdf\Dompdf;
 
// Instantiate and use the dompdf class 

//Envoi du mail
//Avoir le pdf pour le telechargement

function getAcceptMailContent($conn,$id_location){
    $sql="select id_vehicule,id_user,prix_location,date_demande,date_debut,date_fin,heure_debut,heure_fin from location where id_location='".$id_location."'";
    $result=$conn->query($sql);
    $row=$result->fetch_assoc();
    
    $dompdf=new Dompdf();
    
    
    
        $sql1="SELECT concat(marque,' ',nom_vehicule) FROM `vehicule` WHERE id_vehicule='".$row['id_vehicule']."'" ;
        $result1=$conn->query($sql1);
        $row1=$result1->fetch_array();
        $voiture = $row1[0];
      
      $prix_location=$row['prix_location'];
      $date_debut=$row['date_debut']." a ".$row['heure_debut'];
      $date_fin=$row['date_fin']." a ".$row['heure_fin'];
      $sql1="SELECT datediff(date_fin,date_debut) FROM `location` WHERE id_location='".$id_location."'" ;
        $result1=$conn->query($sql1);
        $row1=$result1->fetch_array();
    
        $nb_days=$row1[0];
      $sql1="SELECT concat(nom_user,' ',prenom_user) FROM `utilisateur` WHERE id_user='".$row['id_user']."'" ;
      $result1=$conn->query($sql1);
      $row1=$result1->fetch_array();
       $user=$row1[0];
       $dompdf->load_html(getAcceptContratHTML($conn,$id_location));
       $dompdf->setPaper('A4','landscape');
       $dompdf->render();
       file_put_contents("../contrats/cd".$id_location.".pdf",$dompdf->output());
       $path="../contrats/cd".$id_location.".pdf";
       $html="
<!DOCTYPE html>
<html lang=\"en\">

<head>
    <meta charset=\"UTF-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Mail</title>
    <script src=\"..\bootstrap-5.0.2\dist\js\bootstrap.min.js\"></script>
    <link rel=\"stylesheet\" href=\"..\bootstrap-5.0.2\dist\css\bootstrap.min.css\">
    <link rel=\"stylesheet\" href=\"..\fontawesome-free-6.1.1-web\css\all.min.css\">
    <link rel=\"stylesheet\" href=\"..\css\root.css\">
    

    <script src=\"..\js\jquery.js\"></script>
</head>

<body>
    <section class=\"container-fluid\">
        
        <p>Mr/Mme/Mlle 
            ".$user."
            ,votre demande de location pour la voiture 
            ".$voiture." a ete acceptee.
  
            <p>Veuillez telecharger le contrat ci-contre et vous presenter a l'e/se pour recuperer le vehicule</p>
     </p>

    </section>
    <div class=\"container-fluid\">
           <embed src=\"".$path."\" type=\"application/pdf\" style=\"width:100%;height: 800px;\"><embed>
    <button><a href=\"".$path."\" download>Telecharger</a></button>
           </div>
</body>

</html>
 ";    
return $html;
}
function sendAcceptMail($conn,$id_location){
     $sql="select adresse_user from utilisateur where id_user in (select id_user from location where id_location='".$id_location."')";
     $result=$conn->query($sql);
     $adresse_user=$result->fetch_array()[0];

    //  $dompdf = new Dompdf();
     $to = $adresse_user;
     $subject = "Reponses a la demande de location de voiture";
     
     $message = getAcceptMailContent($conn,$id_location);
     
     // Always set content-type when sending HTML email
     $headers = "MIME-Version: 1.0" . "\r\n";
     $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
     
     // More headers
     $headers .= 'From: b3nauto@gmail.com' . "\r\n";
     
     
     mail($to,$subject,$message,$headers);
    }
     function getAcceptContratHTML($conn,$id_location){
    $sql="select id_vehicule,id_user,prix_location,date_demande,date_debut,date_fin,heure_debut,heure_fin from location where id_location='".$id_location."'";
    $result=$conn->query($sql);
    $row=$result->fetch_assoc();
    
    
    
    
        $sql1="SELECT concat(marque,' ',nom_vehicule) FROM `vehicule` WHERE id_vehicule='".$row['id_vehicule']."'" ;
        $result1=$conn->query($sql1);
        $row1=$result1->fetch_array();
        $voiture = $row1[0];
      
      $prix_location=$row['prix_location'];
      $date_debut=$row['date_debut']." a ".$row['heure_debut'];
      $date_fin=$row['date_fin']." a ".$row['heure_fin'];
      $sql1="SELECT datediff(date_fin,date_debut) FROM `location` WHERE id_location='".$id_location."'" ;
        $result1=$conn->query($sql1);
        $row1=$result1->fetch_array();
    
        $nb_days=$row1[0];
      $sql1="SELECT concat(nom_user,' ',prenom_user) FROM `utilisateur` WHERE id_user='".$row['id_user']."'" ;
      $result1=$conn->query($sql1);
      $row1=$result1->fetch_array();
       $user=$row1[0];
$html="

<h1>Contrat de location</h1>\n
<hr style=\"width:100%;\">\n
<p><p> Locataire : ".$user."</p>\n
<p>Voiture : ".$voiture."</p>\n
    <p>Montant : ".$prix_location."</p>\n
    <p>Date de debut : ".$date_debut."</p>\n
    <p>Date de fin : ".$date_fin."</p>\n
    <p>Nbre de jours : ".$nb_days."</p>\n
    <div>\n
       <h3>B3NAuto</h3>\n
        <p style=\"float:right;\">Votre signature</p>\n
    </div>   \n
</p>\n";


   
return $html;    
}

// generateContratHTML($conn,'l01');
// sendMail($conn,'l01');
// echo getMailContent($conn,'l01',$dompdf)
function getRefuseMailContent($conn,$id_location){
  $sql="select id_vehicule,id_user,prix_location,date_demande,date_debut,date_fin,heure_debut,heure_fin from location where id_location='".$id_location."'";
  $result=$conn->query($sql);
  $row=$result->fetch_assoc();
   
  
  
  
      $sql1="SELECT concat(marque,' ',nom_vehicule) FROM `vehicule` WHERE id_vehicule='".$row['id_vehicule']."'" ;
      $result1=$conn->query($sql1);
      $row1=$result1->fetch_array();
      $voiture = $row1[0];
    
    
    $sql1="SELECT concat(nom_user,' ',prenom_user) FROM `utilisateur` WHERE id_user='".$row['id_user']."'" ;
    $result1=$conn->query($sql1);
    $row1=$result1->fetch_array();
     $user=$row1[0];
    
     $html="
<!DOCTYPE html>
<html lang=\"en\">

<head>
  <meta charset=\"UTF-8\">
  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
  <title>Mail</title>
  <script src=\"..\bootstrap-5.0.2\dist\js\bootstrap.min.js\"></script>
  <link rel=\"stylesheet\" href=\"..\bootstrap-5.0.2\dist\css\bootstrap.min.css\">
  <link rel=\"stylesheet\" href=\"..\fontawesome-free-6.1.1-web\css\all.min.css\">
  <link rel=\"stylesheet\" href=\"..\css\root.css\">
  

  <script src=\"..\js\jquery.js\"></script>
</head>

<body>
  <section class=\"container-fluid\">
      
      <p>Mr/Mme/Mlle 
          ".$user."
          ,votre demande de location pour la voiture 
          ".$voiture." a ete refuse.

          <p>Veuillez nous excuser</p>
   </p>

  </section>
  
</body>

</html>
";    
return $html;
}
function sendRefuseMail($conn,$id_location){
   $sql="select adresse_user from utilisateur where id_user in (select id_user from location where id_location='".$id_location."')";
   $result=$conn->query($sql);
   $adresse_user=$result->fetch_array()[0];

   
   $to = $adresse_user;
   $subject = "Reponses a la demande de location de voiture";
   
   $message = getRefuseMailContent($conn,$id_location);
   
   // Always set content-type when sending HTML email
   $headers = "MIME-Version: 1.0" . "\r\n";
   $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
   
   // More headers
   $headers .= 'From: b3nauto@gmail.com' . "\r\n";
   
   
   echo mail($to,$subject,$message,$headers);
  }
  
// echo sendRefuseMail($conn,'l01');
?>