<?php
include("../../config.php");

#Si on arrive sur cette page alors que l'on est pas connecté 
if (!estConnecte()) { 
    header('Location: ../../connexion.php'); #On redirige vers la page de connexion
    exit;
}
		
		$sql = "SELECT count(id),promotion FROM info where formation like '".$_POST['bar']."' group by promotion";

		$resultat=mysqli_query($connexion,$sql);
		
		
		while ($ligne=mysqli_fetch_row($resultat)) {
			$nbetu[] = $ligne[0];
			$annee[] = $ligne[1];
		}
		foreach($nbetu as $k => $v){
			if($k != count($nbetu)-1){
				echo $v.",";
			}else{
				echo $v.";";
			}
		}
		foreach($annee as $k => $v){
			if($k != count($annee)-1){
				echo $v.",";
			}else{
				echo $v.";";
			}
		}


		echo "<div class='row'><div class='col-12'><center>";
			$maxetu= max($nbetu);
			echo "L'année avec le maximum d'étudiants inscrit à l'annuaire est l'année ".$annee[array_search($maxetu, $nbetu)]." avec ".$maxetu." étudiants";
		echo "</center></div></div>";
?>