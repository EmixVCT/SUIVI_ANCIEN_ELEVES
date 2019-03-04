<?php 
  
require_once('config.php'); #On inclut la configuration

if (estConnecte()) { #Si l'utilisateur est déjà connecté
	header('location: index.php');
	exit(); #On le dirige à sa bonne page
}

require_once($fichiersInclude.'header.html'); #On inclut l'entête

?>

<body>
		
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-xs-2 col-sm-9 col-md-7 col-lg-5">
				<div class="panel panel-default connexion">	
					<img class='img mb-1'alt='logo UVSQ site Vélizy' src="images/uvsq_iut_velizy_CMJN.jpg" /> 
					
					<form action='login.php' method='POST'>
						
						<div class="form-group">
							<input class="form-control" placeholder="Identifiant" name="login" type="text" <?php
							if (isset($_GET['erreur'])){
								echo "value="."'".dec_enc("decrypt",$_GET["erreur"])."'";
							}?> required>
						</div>
						
						<div class="form-group">
							<input class="form-control" placeholder="Mot de passe" name="mdp" type="password" value="" required>
						</div>
						
						<div class='input-group'>
							<input name='connection' class="btn btn-lg btn-outline-secondary btn-block" type="submit" value="Se connecter">
						</div>
					</form>
				</div>
				<?php 
				  if (isset($_GET['erreur'])) { #Si il y a eu une erreur on l'affiche
					afficherErreur("<strong>Identifiant</strong> ou <strong>mot de passe</strong> incorrect !");
				  }
				?>
			</div>
		
		</div>
	</div>
<body>

<?php

/**TEST SI IL EXISTE AUCUN COMPTE DANS LA BD**/

$req = "SELECT * FROM UTILISATEUR";
if ($res = mysqli_query($connexion,$req)){ //test si la commande est bien exec
	$rowcount=mysqli_num_rows($res);
	if ($rowcount <= 0) { //test si on a des resultats
		echo "Pas il n'existe pas de compte !";
		?>
		<h3>Formulaire de création compte admin</h3>
		<fieldset>
		<form action='' method='POST'><table align='center'><tr>
			<tr><td>LOGIN : </td><td><input type='text' maxsize='10' name='clogin' required></td></tr>
			<tr><td>MDP :</td><td><input type='password' maxsize='10' name='cmdp' required ></td></tr>
			<tr><td>MDP (confirmation):</td><td><input type='m' maxsize='10' name='cmdpconf' required ></td></tr>
			
			<tr><td>type :</td><td> <select name="type">
									  <option value="user">user</option>
									  <option value="admin">admin</option>
									</select></td></tr>
			
			<tr><td>&nbsp;</td><td><input type='submit' name='plus' value='crée'></td></tr></table>
		</form></fieldset></div></table></div></div>	
		</fieldset>
		<?php
		
		if (isset($_POST["clogin"],$_POST["cmdp"],$_POST["cmdpconf"],$_POST["type"]) and $_POST["cmdp"] == $_POST["cmdpconf"]){
			$reqinsert="INSERT into UTILISATEUR(login,mdp,droit)";
			$reqinsert.="VALUES(?,?,?)";

			$reqprepare=mysqli_prepare($connexion,$reqinsert);

			//liaison des parametres :
			if (isset($_POST['cmdp'],$_POST['cmdp'],$_POST['type'])){
				$login=$_POST['clogin'];
				$mdp= hash("sha256",htmlspecialchars($_POST["cmdp"]));
				$droit=$_POST['type'];

				// insertion
				mysqli_stmt_bind_param($reqprepare,'sss',$login,$mdp,$droit);
				mysqli_stmt_execute($reqprepare);
			}
		}
	}		
}else{ 
	echo "Impossible d'accéder à la table UTILISATEUR !";
}


?>

<?php require_once($fichiersInclude.'footer.html'); #On inclut le pied de page ?>