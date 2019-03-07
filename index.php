<?php 
  
require_once('config.php'); #On inclut la configuration

#Si on arrive sur cette page alors que l'on est pas connecté 
if (!estConnecte()) { 
    header('Location: connexion.php'); #On redirige vers la page de connexion
    exit;
}
require_once($fichiersInclude.'header.html'); #On inclut l'entête

?>
<body>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<?php require_once($fichiersInclude.'navbar.php'); #On inclut la bar de navigation ?>
	
	<div id='contenue' class='container-fluid'>
		<header>
			<center><h1>Accueil</h1></center>
		</header>
		
		<div class="form-row">
			<div class="form-group col-md-2">
				<label for="historique">Historique des actions </label>
			</div>
			<div class="input-group col-md-9">
				<textarea class="form-control disable" name="historique" rows="10" readonly><?php
				
				$tab = file('historique/actions.txt');
				$tab = array_reverse($tab);
				foreach($tab as $ligne){
				 echo $ligne;
				}
				?>
				</textarea>
			</div>
		</div>
	</div>
</body>
	
<?php
require_once($fichiersInclude.'footer.html'); 
?>