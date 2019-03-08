<?php
require_once('../config.php'); #On inclut la configuration
?>
<html>
	<head>
        <meta charset="utf-8" />
		
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="../css/style.css">
	
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		
        <title>Enquête des anciens étudiants</title>
    </head>
	
	<body>
		<div class="jumbotrom">
			<img alt='logo UVSQ site Vélizy' src="../images/uvsq_iut_velizy_CMJN.jpg" width="250px"/> 
		</div>

		<div id='contenue' class='container-fluid'>
			<?php
				//décrypt le mail dans l'url
				if (isset($_GET['q'])){
					$mail = dec_enc('decrypt',$_GET['q']);

					//récupère l'identifiant lié au mail
					$sql = "SELECT id,nom,prenom FROM annuaire where mail like '".$mail."'";
					$resultat=mysqli_query($connexion,$sql);
					
					while ($ligne=mysqli_fetch_row($resultat)) {
						$id = $ligne[0];
						$etudiant = $ligne[2]." ".$ligne[1];
					}
					//si l'identifiant a été trouver et que l'on a appuyer sur envoyer
					if(isset($id) and isset($_POST['envoyer']) AND $_POST['envoyer'] == 'Envoyer'){
						
						//si l'etudiant accepte d'être dans l'annuaire
						if (isset($_POST['inscription']) and $_POST['inscription'] == 'oui'){
							//si l'adresse mail est definie et differente
							if (isset($_POST['email']) and !empty($_POST['email']) and $_POST['email'] != $mail){
								//vérifie qu'il n'est pas deja attribué
								if (verifieDoublonsMail($_POST['email'],$connexion)){
									$req = "UPDATE annuaire set mail = '".$_POST['email']."' WHERE id = ".$id;
									mysqli_query($connexion,$req) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));
								}else{//redirige et lui affiche une erreur
									header('location: enquete.php?q='.$_GET['q'].'&erreur='.dec_enc("encrypt","doublons"));
									exit();
								}
							}
						//sinon	
						}else{
							$req = "DELETE from annuaire WHERE id = ".$id;
							mysqli_query($connexion,$req) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));
						}
						
						//si l'etudiant est en poursuite d'étude
						if (isset($_POST['Poursuite']) and $_POST['Poursuite'] == 'Oui'){
							//ajout les donnée a la base
							if ($_POST['formation'] == "Autre"){
								$formationPost = $_POST['autreform'];
							}else{
								$formationPost = $_POST['formation'];
							}
							$req = 'UPDATE info set formation_poursuite = "'.$formationPost.'" , lieu_poursuite = "'.$_POST['lieu'].' / '.$_POST['codeP'].'" , type_poursuite = "'.$_POST['type_formation'].'" ';
							$req .= "WHERE id = ".$id;
							mysqli_query($connexion,$req) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));
						//sinon	
						}else{
							$req = "UPDATE info set formation_poursuite = 'Aucune' WHERE id = ".$id;
							mysqli_query($connexion,$req) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));
						}
						
						
						echo '<h1>Merci '.$etudiant.' !</h1><br/> <h4>Vos réponses ont été transmise, merci de votre temps ! </h4>'; 
						
						//remplis le fichier avec les actions
						$fichier = "historique/".dec_enc("encrypt","actions").".txt";
						set_historique("../".$fichier,$etudiant." a répondu à l'enquête");
						
					}else{
						echo '<h4>Nous avons rencontré une erreur merci de bien vouloir réessayer ! </h4>';  
					}
				}else{
					echo '<h4>L\'URL est éronné, merci de bien vouloir réessayer ! </h4>';  
				}
			?>
		</div>
	</body>
	
<?php
require_once('../'.$fichiersInclude.'footer.html'); 
?>

