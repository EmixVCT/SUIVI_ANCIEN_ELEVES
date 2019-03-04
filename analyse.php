<?php
require_once('config.php'); #On inclut la configuration

#Si on arrive sur cette page alors que l'on est pas connecté / ou que l'on n'est pas un administrateur ni un utilisateur
if (!estConnecte() || ( $_SESSION['droit'] != "user" && $_SESSION['droit'] != "admin")) { 
    header('Location: connexion.php'); #On redirige vers la page de connexion
    exit;
}
	
require_once($fichiersInclude.'header.html'); #On inclut l'entête

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
<script src="scripts/graphique.js" type="text/javascript"></script>

<body>
	<?php require_once($fichiersInclude.'navbar.php'); #On inclut la bar de navigation ?>

	<div id='contenue' class='container-fluid'>
		<header>
			<center><h1>Analyse</h1></center>
		</header>
			
		<?php
		$Ingenieur = 0;$Miage = 0;$L3 = 0;$Licence = 0;$Bachelor = 0;$Autre = 0;$n = 0;$Aucune=0;
		
		$sql = "SELECT formation_poursuite FROM info where formation_poursuite IS NOT NULL";

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
		
		if ($n > 1){
			if ($nb_poursuite > 1){
				echo $n." étudiants ont répondu a l'enquête et ".$nb_poursuite." sont en poursuite d'étude";
			}else{
				echo $n." étudiants ont répondu a l'enquête et ".$nb_poursuite." est en poursuite d'étude";
			}
		}else{
			echo $n." étudiant a répondu a l'enquête et ".$nb_poursuite." est en poursuite d'étude";
		}
		?>
		
		<canvas id="doughnutChart"></canvas>
		<?php echo '<script>show_donuts('.$Ingenieur.','.$Miage.','.$L3.','.$Licence.','.$Bachelor.','.$Autre.');</script>'; ?>
		
	</div>
</body>
<?php
require_once($fichiersInclude.'footer.html'); 
?>