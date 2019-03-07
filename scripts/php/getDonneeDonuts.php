<?php
include("../../config.php");

#Si on arrive sur cette page alors que l'on est pas connecté 
if (!estConnecte()) { 
    header('Location: ../../connexion.php'); #On redirige vers la page de connexion
    exit;
}

//debug($_POST);

$Ingenieur = 0;$Miage = 0;$L3 = 0;$Licence = 0;$Bachelor = 0;$Autre = 0;$n = 0;$Aucune=0;
		
		$sql = "SELECT formation_poursuite FROM info where formation_poursuite IS NOT NULL and formation like '".$_POST['donuts']."'";

		$resultat=mysqli_query($connexion,$sql);
		while ($ligne=mysqli_fetch_row($resultat)) {
			foreach($ligne as $k => $val){
				switch($val){
					case("Ecole d'ingenieur"):
						$Ingenieur += 1;
						break;
					case("Miage"):
						$Miage += 1;
						break;
					case("L3"):
						$L3 += 1;
						break;
					case("Licence professionnelle"):
						$Licence += 1;
						break;
					case("Bachelor"):
						$Bachelor += 1;
						break;
					case('Aucune'):
						$Aucune += 1;
						break;
					default:
						$Autre += 1;
						break;
				}
				$n++;
			}
		}
		$nb_poursuite = $n - $Aucune;
		
		
		
		echo $Ingenieur.','.$Miage.','.$L3.','.$Licence.','.$Bachelor.','.$Autre.',';
		
		echo "<div class='row'><div class='col-12'><center>";
		if ($n > 1){
			if ($nb_poursuite > 1){
				echo $n." étudiants ont répondu à l'enquête et ".$nb_poursuite." sont en poursuite d'étude";
			}else{
				echo $n." étudiants ont répondu à l'enquête et ".$nb_poursuite." est en poursuite d'étude";
			}
		}else{
			echo $n." étudiant a répondu à l'enquête et ".$nb_poursuite." est en poursuite d'étude";
		}
		echo "</center></div></div>";
?>