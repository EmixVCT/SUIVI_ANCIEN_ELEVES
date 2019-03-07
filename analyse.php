<?php
require_once('config.php'); #On inclut la configuration

#Si on arrive sur cette page alors que l'on est pas connecté 
if (!estConnecte()) { 
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
		
		<div class='row'>
			<div class="col-md-6">
				<center><h4>Pourcentage de poursuite d'étude par formation</h4></center>
					<?php
					$req = "SELECT distinct formation from info";
					$result=mysqli_query($connexion,$req);

					echo "<label><i>Sélectionnez la formation : </i></label>";
					echo "<select  class='custom-select' id='donus_affichage'>";
					while ($ligne=mysqli_fetch_array($result)){
						echo "<option name='donus_affichage' value='".$ligne[0]."'>".$ligne[0]."</option>";	}
					echo "</select><br/>";

					?>
				
				<canvas id="doughnutChart"></canvas><br/>
				<div id="phraseDonuts"></div>
				
			</div>
			<div class="col-md-6">
				<center><h4>Nombre d'étudiants dans l'annuaire par année</h4></center>
					<?php
					$req = "SELECT distinct formation from info";
					$result=mysqli_query($connexion,$req);

					echo "<label><i>Sélectionnez la formation : </i></label>";
					echo "<select  class='custom-select' id='bar_affichage'>";
					while ($ligne=mysqli_fetch_array($result)){
						echo "<option name='bar_affichage' value='".$ligne[0]."'>".$ligne[0]."</option>";	}
					echo "</select><br/>";

					?>
				<canvas id="barChart"></canvas><br/>
				<div id="phraseBar"></div>
			</div>
		</div>
		<br/>
		<?php
		
		?>

		
	</div>
	<!--<script>show_donuts(1,2,3,4,5,6)</script>-->
</body>
<?php
require_once($fichiersInclude.'footer.html'); 
?>