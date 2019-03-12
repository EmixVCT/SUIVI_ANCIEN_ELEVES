<?php 
  
require_once('config.php'); #On inclut la configuration
require_once '.\PHPMailer\autoload.php'; //Load Composer's autoloader
use PHPMailer\PHPMailer\PHPMailer;

#Si on arrive sur cette page alors que l'on est pas connecté 
if (!estConnecte()) { 
    header('Location: connexion.php'); #On redirige vers la page de connexion
    exit;
}

//Si on clique sur le bouton destinataire	
if(isset($_POST['dst']) and $_POST['dst'] == 'Destinataire'){
	if (isset($_POST['src'])){
		$_SESSION['src'] = $_POST['src'];
	}
	if (isset($_POST['obj'])){
		$_SESSION['obj'] = $_POST['obj'];
	}
	if (isset($_POST['contenue'])){
		$_SESSION['contenue'] = $_POST['contenue'];
	}
	
	header('location: selectionDst.php');
	exit();

//clique sur le bouton "Retirer dst"
}else if(isset($_POST['suppdst']) and $_POST['suppdst'] == 'Retirer destinataire'){
	unset($_SESSION['dst']);
	
//Efface tout les champs
}else if(isset($_POST['clear']) and $_POST['clear'] == 'Effacer'){
	unset($_SESSION['src']);
	unset($_SESSION['obj']);
	unset($_SESSION['contenue']);
	unset($_SESSION['dst']);
	
}


//Si on clique sur envoyer
if(isset($_POST['envoyer']) and $_POST['envoyer'] == "Envoyer"){
	if (empty($_POST['src'])){
		$erreurMail = true;
	}else if (empty($_SESSION['dst'])){
		$erreurDestinataire = true;
	}else if (empty($_POST['contenue'])){
		$erreurContenu = true;
	}else{//ENVOIE DU MAIL
		$mail = new PHPMailer();
		//CONFIG
		$mail->SMTPDebug = 0;

		$mail->SMTPOptions = array('ssl' => array('verify_peer' => false,'verify_peer_name' => false,'allow_self_signed' => true));
		$mail->isSMTP(); // Paramétrer le Mailer pour utiliser SMTP 
		$mail->Host = 'smtp.gmail.com'; // Spécifier le serveur SMTP
		$mail->SMTPAuth = true; // Activer authentication SMTP
		$mail->Username = 'dilatete83@gmail.com'; // Votre adresse email d'envoi
		$mail->Password = 'maxime2601'; // Le mot de passe de cette adresse email
		$mail->SMTPSecure = 'tls'; // Accepter SSL
		$mail->Port = 587;
		$mail->Host = 'tls://smtp.gmail.com:587';

		//PARAMETRE du mail
		$mail->setFrom($_POST['src'], 'maxiimus'); // Personnaliser l'envoyeur
		$mail->isHTML(true); // Paramétrer le format des emails en HTML ou non
		
		$lien_desinscription = "http://localhost/p/desinscription.php";
		$lien_enquete = "http://localhost/p/formulaire/enquete.php";
		$contenu = $_POST['contenue'];
		$mail->Subject = $_POST['obj'];

		//$mail->addReplyTo('info@example.com', 'Information'); // L'adresse de réponse
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');
		//$mail->addAttachment('/var/tmp/file.tar.gz'); // Ajouter un attachement
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg'); 
		
		$n =0;
		//On envoie les mail un par un pour filtré les serveurs qui rencontrent des bogues
		foreach($_SESSION['dst'] as $mail_dst){
			$mail->addAddress($mail_dst); // Ajouter le destinataire
			$mail_crypt = dec_enc("encrypt",$mail_dst);
			
			$message_html = '<html><head><style type="text/css">#contenue{margin-left:20%;margin-right:20%}.footer{font-size: 0.8em;}</style></head>';
			$message_html .= "<body><div id='contenue'><p>".$contenu."</p>";
			if (isset($_POST['lien']) and $_POST['lien']=='enquete'){
				$message_html .= '<p>Lien vers l\'enquête :  <a href="'.$lien_enquete.'?q='.$mail_crypt.'">Enquête</a></p>';
			}
			$message_html .= "<br/><p><i class='footer'>L’envoi de ce mail a été fait par le IUT de Vélizy, 
				sans transmission d’aucune donnée personnelle.Conformément au Règlement Général sur la Protection des données, 
				adoptées le 14 avril 2016, vous bénéficiez d’un droit d’effacement des données personnelles.Vous pouvez exercer 
				vos droits et ne plus recevoir de mail de notre part en 
				<a href=\"".$lien_desinscription."?q=".$mail_crypt."\" >cliquant ici </a></i></p></div></body></html>";
			$mail->Body = $message_html;
			$mail->AltBody = $message_html;

			
			//=====Envoi de l'e-mail.
			if(!$mail->send()) {
				afficherErreur("Une erreur est survenue lors de l'envoi du mail à ".$mail_dst."!");
				//remplis le fichier avec les actions
				$file = fopen ("historique/actions.txt", "a");
				date_default_timezone_set('Europe/Paris');
				
				$txt = "[".date("d/m/y à H\hi")."] ";
				$txt .= "Erreur lors de l'envoie du mail à (".$mail_dst.")";
				$txt .= "\r\n";
				
				fputs ($file, $txt);
				fclose ($file);
				
				//echo 'Mailer Error: ' . $mail->ErrorInfo;
			} else {
				$mail->clearAddresses();
				//echo 'Le message a bien été envoyé !<br/>';
				$n++;
			}
		}		
		//=========
		//remplis le fichier avec les actions
		if ($n > 1){
			$txt = $n." mails ont été envoyés";
		}else{
			$txt = $n." mail a été envoyé";
		}
		$fichier = get_historique($_SESSION['login'],$connexion);
		$fichierAdmin = "historique/".dec_enc("encrypt","actions").".txt";
		set_historique($fichier,$txt);		
		set_historique($fichierAdmin,$txt." par ".$_SESSION['login']);	
		
		unset($_SESSION['src']);
		unset($_SESSION['obj']);
		unset($_SESSION['contenue']);
		unset($_SESSION['dst']);
		
	}	
}

/*Stock dans une list (SESSION Array) les emails des etudiants selectionner (grace a leur id)*/
function getEmail($listEtu,$cnx){
	/*prend en parametre une liste d'id et la variable de connexion a la bd*/
	$requete = "SELECT mail FROM ANNUAIRE WHERE";
	$i = 0;
	$listEmail = Array();
	
	foreach($listEtu as $v){
		if ($i == 0){
			$requete = $requete . " id = ".$v;
		}else{
			$requete = $requete . " OR id = ".$v;
		}
		$i++;
	}
		
	$resultat = mysqli_query($cnx,$requete);
	while ($l = mysqli_fetch_row($resultat)) {	
		foreach($l as $val){
			$listEmail[] = $val;
		}
	}
	return $listEmail;
}

require_once($fichiersInclude.'header.html'); #On inclut l'entête

?>	
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

<body>
	<?php require_once($fichiersInclude.'navbar.php'); #On inclut la bar de navigation ?>

	<div id='contenue' class='container-fluid'>
		<header>
			<center><h1>Envoyer un mail</h1></center>
		</header>
		
		<?php
		if (isset($erreurMail) && $erreurMail){
			afficherErreur("Vous devez entrez votre adresse email !");
			$erreurMail = false;
		}else if(isset($erreurDestinataire) && $erreurDestinataire){
			afficherErreur("Vous devez selectionner au moins 1 destinnataire !");
			$erreurDestinataire = false;
		}else if(isset($erreurContenu) && $erreurContenu){
			afficherErreur("Vous devez remplir le contenue du mail !");
			$erreurContenu = false;
		}
		
		
		?>
		<!-------------------->
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-12 pb-5">

					<form action='' method='POST'>
						<div class="input-group">
							<div class="input-group-prepend mb-2">
								<input class="btn btn-outline-secondary" type="submit" name ="dst" value="Destinataire">
								<input class="btn btn-outline-secondary" type="submit" name ="suppdst" value="Retirer destinataire">
							</div>
							<?php
							$list_dst = "";
							if(isset($_POST['etu'])){ //la selection a été faite
								$_SESSION['dst'] = getEmail($_POST['etu'],$connexion);
								foreach($_SESSION['dst'] as $v){
									$list_dst .= $v.";";
								}		
							}else if(isset($_SESSION['dst']) and !empty($_SESSION['dst'])){
								foreach($_SESSION['dst'] as $v){
									$list_dst .= $v.";";
								}
							}else{
								$_SESSION['dst'] = Array();
							}
							?>
							<input type="text" class="form-control" placeholder="Aucun destinataire" value=<?php echo "'".$list_dst."'";?> readonly>
						</div>

						<div class="form-group">
							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="fa fa-user text-info"></i></div>
								</div>
								<input class="form-control" type="email" name="src" placeholder='Source' <?php
								if (isset($_SESSION['src'])){
									echo "value="."'".$_SESSION['src']."'";
								} ?> />
							</div>
						</div>
						<div class="form-group">
							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="fa fa-envelope text-info"></i></div>
								</div>
								<input class="form-control" type="text"  name="obj" placeholder='Objet' <?php
								if (isset($_SESSION['obj'])){
									echo "value="."'".$_SESSION['obj']."'";
								} ?> />
							</div>
						</div>

						<div class="form-group">
							<div class="input-group mb-2">
								<div class="input-group-prepend">
									<div class="input-group-text"><i class="fa fa-comment text-info"></i></div>
								</div>
								<textarea class="form-control" name="contenue" rows="10" ><?php
								if (isset($_SESSION['contenue'])){
									echo $_SESSION['contenue'];
								}?></textarea>
							</div>
						</div>
						
						<div class="form-row">
							<div class="form-group col-md-3">
								<label for="lien"><b>Lien vers pages ? </b></label>
							</div>
							<div class="form-group col-md-9">
								<label class="radio-inline mr-3"><input type="radio" name="lien" value="aucun" id="aucun" checked/>Aucun</label>
								<label class="radio-inline mr-3"><input type="radio" name="lien" value="enquete" id="enquete" />Enquête anciens étudiants</label>
							</div>
						</div>
						
						<div class="text-center">
							<input type="submit" name ="envoyer" value="Envoyer" class="btn btn-outline-secondary rounded-0 " />
							<input type="submit" name ="clear" value="Effacer" class="btn btn-outline-secondary rounded-0 " />
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
<?php
require_once($fichiersInclude.'footer.html'); 
?>