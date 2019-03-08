<?php
require_once('config.php'); #On inclut la configuration
require_once($fichiersInclude.'header.html'); 

?>
<body>
	<div class="jumbotrom">
		<img alt='logo UVSQ site Vélizy' src="images/uvsq_iut_velizy_CMJN.jpg" width="250px"/> 
	</div>

	<div id='contenue' class='container-fluid'>
		<?php
			if (isset($_GET['q'])){
				//décrypt le mail dans l'url
				$mail = dec_enc('decrypt',$_GET['q']);

				//récupère l'identifiant lié au mail
				$sql = "SELECT id,nom,prenom FROM annuaire where mail like \"".$mail."\"";
				
				//$sql = "SELECT id,nom,prenom FROM annuaire where mail like 'maxs.vincent78@gmail.com'";
				
				$resultat=mysqli_query($connexion,$sql);
								
				while ($ligne=mysqli_fetch_row($resultat)) {
					$id = $ligne[0];
					$etudiant = $ligne[2]." ".$ligne[1];
				}
				
				//si l'identifiant a été trouver et que l'on a appuyer sur désinscrire
				if(isset($_POST['desinscription']) AND $_POST['desinscription'] == 'Oui'){
					if(isset($id)){//si l'identifiant a été trouver le désinscrie
						
						$req = "DELETE from annuaire WHERE id = ".$id;
						mysqli_query($connexion,$req) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));
						
						echo '<h1>Merci '.$etudiant.' !</h1><br/> <h4>Vous n\'êtes plus inscrit à l\'annuaires ! </h4>'; 
						
						//remplis le fichier avec les actions
						$fichier = "historique/".dec_enc("encrypt","actions").".txt";
						set_historique($fichier,$etudiant." c'est désinscrie de l'annuaire");
						
					}else{ //sinon lui dit qu'il n'est pas inscrit a l'annuaire
						echo "Vous n'êtes pas inscrit à l'annuaire, si vous continuer à recevoir des mails de notre part veuillez contacter un responsable de l'IUT de Velizy";
					}

					
				}else{//demande s'il veut ce désinscrire
					
					
					echo "<h4> Êtes vous sûr de vouloir vous désinscrire de l'annuaire des anciens étudiants ?
						Vous ne receverez plus de mail. </h4>";
					?>
					
					<form action='' method='POST'>
						<button type="submit" value="Oui" name="desinscription">Continuer</button>	
					</form>
					<?php
				}
			}else{					
				echo '<h4>Nous avons rencontré une erreur merci de bien vouloir réessayer ! </h4>';  
			}
		?>
	</div>
</body>
	
<?php
require_once($fichiersInclude.'footer.html'); 
?>

