<?php
include("../../config.php");

#Si on arrive sur cette page alors que l'on est pas connecté 
if (!estConnecte()) { 
    header('Location: ../../connexion.php'); #On redirige vers la page de connexion
    exit;
}

if (isset($_SESSION['data']) and !empty($_SESSION['data'])){
	
	//debug($_GET);
	//debug($_SESSION['data']);
	
	//pour chaque ligne dans data
	foreach ($_SESSION['data'] as $k => $v){
		$i = 0;
		$insert = Array();
		
		//récupère les données importante
		foreach($v as $name){
			//$_GET[$i] == nom de la colonne et $name == la val de la colonne
			if ($_GET[$i] != 'autre'){
				$name = str_replace("\"", "'", $name);
				$insert[$_GET[$i]] = $name;
			}
			$i = $i + 1;
		}
		//Si il y a deja le meme mail dans la bd ajout pas l'etudiant
		if (isset($insert['mail']) and !verifieDoublonsMail("",$insert['mail'],$connexion)){
			continue;
		}else{
			//vérifie que toute les données soit définie
			if (!array_empty($insert)){ //si toute les données sont complete ajoute a la bd
				//si la promotion est definie par l'utilisateur et qu'elle n'est pas dans le csv
				if (isset($_GET['promotion']) and !empty($_GET['promotion'])){
					if (!array_key_exists("promotion",$insert)){
						//ajoute a la liste
						$insert['promotion'] = $_GET['promotion'];
					}
				}
				//si la formation est definie par l'utilisateur et qu'elle n'est pas dans le csv

				if (isset($_GET['formation']) and !empty($_GET['formation'])){
					if (!array_key_exists("formation",$insert)){
						//ajoute a la liste
						$insert['formation'] = $_GET['formation'];
					}
				}
				
				$req_d_info = "INSERT INTO info ( ";
				$req_f_info = " ) VALUES ( ";
				
				$req_d_annuaire = "INSERT INTO annuaire ( ";
				$req_f_annuaire = " ) VALUES ( ";
				
				$n_info = 0;
				$n_annuaire = 0;
				
				$info = ['promotion','formation'];
				$annuaire = ['nom','prenom','mail'];
				
				foreach($insert as $key => $valeur){
					if (in_array($key,$info)){
						if ($n_info != 0){$req_d_info .= ", ";$req_f_info .= ", ";}
						$req_d_info .= $key;
						$req_f_info .= '"'.$valeur.'"';
						$n_info++;
					}else if (in_array($key,$annuaire)){
						if ($n_annuaire != 0){$req_d_annuaire .= ", ";$req_f_annuaire .= ", ";}
						$req_d_annuaire .= $key;
						$req_f_annuaire .= '"'.$valeur.'"';
						$n_annuaire++;
					}
					
				}
				//requete dans la table info si des element sont a add
				$req_info = $req_d_info . $req_f_info.")";		
				//echo $req_info."<br>";
				if($n_info > 0 && $n_annuaire > 0){
					mysqli_query($connexion,$req_info) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));
				}

				//si on a ajouter des elements dans la table info, recup l'identifiant
				if ($n_info > 0){
					//recupération de l'id crée	
					$req = "SELECT max(id) FROM info";
					foreach (mysqli_query($connexion,$req) as $row){
						$idRequete = $row['max(id)'];
					}
			
					if ($n_annuaire != 0){$req_d_annuaire .= ", ";$req_f_annuaire .= ", ";}
					$req_d_annuaire .= "id";
					$req_f_annuaire .= $idRequete;
				}
				//requete dans la table annuaire si des element sont a add
				$req_annuaire = $req_d_annuaire . $req_f_annuaire.")";
				//echo $req_annuaire;
				if($n_annuaire > 0){
					mysqli_query($connexion,$req_annuaire) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));
				}

				//debug($insert);

			}else{//si les données ne sont pas complete
				echo "ligne incorrect !";
				
			}
		}//FIN DU ELSE (qui ajout si le mail est différent)	
	}//FIN DE FOREACH


	$_SESSION['data'] = "";
	unset($_SESSION['data']);
}else{
	echo "pas de chance !" ;
	
}

header('Location: ../../annuaire.php'); #On redirige vers la page de connexion
exit;



?>