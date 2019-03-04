<?php
require_once('config.php');

if (estConnecte()) { #Si on est déjà connecté lorsque on accède à la page
    header('location: index.php');
	exit();
}

if ( (isset($_POST['login']) && isset($_POST['mdp'])) AND !(empty($_POST['login']) && empty($_POST['mdp'])) ) { #On vérifie la validité du formulaire

		$login = htmlspecialchars($_POST["login"]);
		$mdp = hash("sha256",htmlspecialchars($_POST["mdp"]));	
		$req = "SELECT * FROM UTILISATEUR WHERE login like \"$login\" and mdp like \"$mdp\"";
			
		if ($res = mysqli_query($connexion,$req)){ //test si la commande est bien exec
			$rowcount=mysqli_num_rows($res);
			
			if ($rowcount == 1) { //test si on a un resultat
				$lig = mysqli_fetch_assoc($res);
				
				$_SESSION['login'] = $lig['login'];
				$_SESSION['droit'] = $lig['droit'];
				header('location: index.php');
				exit();
				
			}else{ //pas de mdp et login correct trouver (redirection)
				header('Location: connexion.php?erreur='.dec_enc("encrypt",$_POST["login"]));
				exit();
			}
		}else{ //commande mal executer
			echo "Impossible d\'accéder à la table UTILISATEUR !";
		}

		
}else { #Si l'envoi du formulaire est incorrect ou que l'on accède à la page d'une autre façon
    #Sinon on renvoie à la page de connexion
    header('Location: connexion.php?erreur='.dec_enc("encrypt",$_POST["login"]));
    exit();
}

?>
