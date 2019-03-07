<?php
require_once('config.php'); #On inclut la configuration

#Si on arrive sur cette page alors que l'on est pas connecté 
if (!estConnecte()) { 
    header('Location: connexion.php'); #On redirige vers la page de connexion
    exit;
}
	
require_once($fichiersInclude.'header.html'); #On inclut l'entête

?>	
<script src="scripts/showAnnuaire.js" type="text/javascript"></script>

<body>
	<?php require_once($fichiersInclude.'navbar.php'); #On inclut la bar de navigation ?>


	<div id='contenue' class='container-fluid'>
		<header>
			<center><h1>Annuaire</h1></center>
		</header>

		<form name='formulaire'>
		
			<!-- Formulaire trié -->
			<div class='row'>
				<div class='col-sm-12 col-md-6 col-lg-6'>
					<h4>Trier annuaire :</h4>
				</div>
			</div><div class='row'>
				<div class='col-sm-12 col-md-6 col-lg-6'>
				
					<div class="input-group mb-2">
						<div class="input-group-prepend">
							<label class="input-group-text" for="triegroupe">Trier par</label>
						</div>
						<select id='trie' name='trie' class="custom-select" id="triegroupe">
							<option value='nom' >Nom</option>
							<option value='prenom'>Prénom</option>
							<option value='promotion'>Promotion</option>
							<option value='formation'>Formation</option>
						</select>
					</div>				
				</div>
			</div>
			<!-- Formulaire recherche -->
			<br/>
			<div class='row'>
				<div class='col-sm-12 col-md-6 col-lg-6'>
					<h4>Recherche dans annuaire :</h4>
				</div>
			</div>
			
			<div class='row'>
					
				<div class='col-6'>
					<div class="input-group mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text" id="nom_input">Nom</span>
						</div>
						<input type="text" class="form-control" aria-describedby="nom_input" name='nom' id="input_nom">
					</div>
				</div>
				<div class='col-6'>
					<div class="input-group mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text" id="prenom_input">Prénom   </span>
						</div>
						<input type="text" class="form-control" aria-describedby="prenom_input" name='prenom' id="input_prenom">
					</div>
				</div>
				<div class='col-6'>
					<div class="input-group mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text" id="promo_input">Promotion</span>
						</div>
						<input type="text" class="form-control" aria-describedby="promo_input" name='promo' id="input_promo">
					</div>
				</div>
				<div class='col-6'>
					<div class="input-group mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text" id="formation_input">Formation</span>
						</div>
						<input type="text" class="form-control" aria-describedby="formation_input" name='forma' id="input_forma">
					</div>
				</div>
			</div>
		</form>
		
		<br/><br/>
		<div id='table'></div>
		
		<div id='modifEtu'></div>


		<hr><br/><h4>Ajouter étudiant :</h4>
		<input type='button' name='addcsv' value='Importer CSV' onclick='ajoutEtuCsv()' class='btn btn-outline-secondary'/>
		<input type='button' name='addform' value='Ajouter manuellement' onclick='ajoutEtu()' class='btn btn-outline-secondary'/>
	</div>
</body>
<?php
require_once($fichiersInclude.'footer.html'); 
?>
