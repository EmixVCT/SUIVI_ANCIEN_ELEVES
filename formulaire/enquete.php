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
		<script type='text/javascript'>
			$(document).ready(function(){
				$('#poursuite_oui').click(function(){
					$('#poursuite_etude').show('normal');
				});
				$('#poursuite_non').click(function(){
					$('#poursuite_etude').hide('normal');
				});
				$('#Envoyer').click(function(){
					valid = true;

					if ( $('input[name="Poursuite"]:checked', '#formulaire').val() == "Oui"){ 
						if ( $('#lieu').val() == "" ) {
							$('#lieu').css("border-color","#FF0000");
							valid = false;
						}if ( $('#codeP').val() == "" ){
							$('#codeP').css("border-color","#FF0000");
							valid = false;
						}
					}
					return valid;
				});
				$('#formation').click(function(){
					if ($('#formation').val() == "Autre"){
						$('#div_autre').show('normal');
					}else{
						$('#div_autre').hide('normal');
					}
					//$('#div_autre').toggle('fast');
				});
			});
		</script>
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
			//Récupère l'identifiant de l'étudiant a qui appartient l'addresse mail quand la formation poursuite n'est pas renseigner (formation_poursuite == NULL)
			$sql = ' SELECT id FROM info where formation_poursuite IS NULL and id in ( SELECT id from annuaire where mail like "'.$mail.'")';
			$res = mysqli_query($connexion,$sql);
			
			//Si le code hasher dans l'url est incorrecte (ne correspond a aucun mail)
			if (empty($mail)){ ?>
				<h1>Erreur URL</h1>
				<p>Il semblerait l'URL soit Erronée.<br>
				Veuillez recharger votre page ou vérifier l'URL..</p>
			<?php 
			//sinon si on ne trouve pas d'id avec une formation poursuite null correspondant au mail
			}else if(mysqli_num_rows($res) == 0) {
				?>
				<h1>Réponse enregistré</h1>
				<p>Il semblerait que vous ayez déjà répondu à l'enquête. Vous ne pouvez répondre qu'une seule fois à l'enquête.</p>
				
				<?php
			}else{ //sinon
				
				?>
				<header>
					<center><h1>Enquête des anciens étudiants</h1></center>
				</header>
				<?php
				if (isset($_GET['erreur']) and dec_enc("decrypt",$_GET['erreur']) == "doublons"){
					afficherErreur("Mail deja utilisez par un autre étudiant. Veuillez entrez une autre addresse email");
				}
				?>
				</br>
				<form id="formulaire" action=<?php echo "action_formulaire.php?q=".$_GET['q']; ?> method="POST">	
					<div class="form-row">
						<div class="form-group col-md-3">
							<label for="Poursuite">Êtes-vous en poursuite d'études  : **</label>
						</div>
						
						<div class="form-group col-md-9">
							<label class="radio-inline mr-3"><input type="radio" name="Poursuite" id="poursuite_oui" value="Oui" checked>Oui</label>
							<label class="radio-inline"><input type="radio" name="Poursuite" id="poursuite_non" value="Non">Non</label>
						</div>
					</div>
					
					<div id='poursuite_etude'>
						<div class="form-group">
							<label for="formation">Quelle est votre formation : **</label>
							<select class="custom-select" name="formation" id="formation" required>
								<option value="Ecole d'ingenieur"> École d'ingénieur</option>
								<option value="Miage"> MIAGE</option>
								<option value="L3"> L3 </option>
								<option value="Licence professionnelle"> Licence professionnelle</option>
								<option value="Bachelor"> Bachelor </option>
								<option id="autre" value="Autre"> Autre..</option>
							</select>
						</div>	
						<div id='div_autre'>
							<div class="form-group">
								<label for="autreform"><b><i>Spécifiez votre formation :</i></b></label>
								<input type="text" class="form-control" name="autreform" id="autreform">
							</div>
						</div>
						
						
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="lieu">Commune de votre établissement : **</label>
								<input type="text" class="form-control" name="lieu" id="lieu" placeholder='ex:Saint-remy-lès-schevreuse' >
							</div>
							<div class="form-group col-md-6">
								<label for="codeP">Code postal de votre établissement : **</label>
								<input type="text" class="form-control" name="codeP" id="codeP" placeholder='ex:78470' >
							</div>
						</div>
						
					
						<div class="form-row">
							<div class="form-group col-md-3">
								<label for="type_formation">Type de formation  : ** </label>
							</div>
							
							<div class="form-group col-md-9">
								<label class="radio-inline mr-3"><input type="radio" name="type_formation" value="initiale" id="formation_initiale" checked/>Formation initale</label>
								<label class="radio-inline"><input type="radio" name="type_formation" value="alternance" id="formation_alternance" />Formation en alternance</label>
							</div>
						</div>
					</div>
					
					<header>
						<center><h1>Vos coordonnées</h1></center>
					</header>
					
					<div class="form-row">
						<div class="form-group col-md-3">
							<label for="inscription"><b>Souhaitez-vous être dans l'annuaire des étudiants ? ** </b></label>
						</div>
						<div class="form-group col-md-9">
							<label class="radio-inline mr-3"><input type="radio" name="inscription" value="oui" id="inscription_oui" checked/>Oui</label>
							<label class="radio-inline mr-3"><input type="radio" name="inscription" value="non" id="inscription_non" />Non</label>
						</div>
					</div>
					
					<div class="form-group">
						<label for="email">Changer d'adresse Email :</label>
						<input type="email" class="form-control" name="email" id="email" placeholder="ex:abc@mail.com">
					</div>
				
					<button id='Envoyer' type="submit" name="envoyer" value="Envoyer" class="btn btn-outline-secondary">Envoyer</button>
				</form>
				
		

				<p>** Champs obligatoires</p>
				<p><b>Nous vous rappelons que vous pouvez toujours vous désinscrire, en cliquent sur <i>"désinscription"</i> en pied de mail.</b></p>
			<?php 
			}
		}else{ //Si q n'est pas renseigner
			header("location: ../404.html");
		}
		?>
		
	</div>
</body>
	
	
<?php
require_once('../'.$fichiersInclude.'footer.html'); 
?>

