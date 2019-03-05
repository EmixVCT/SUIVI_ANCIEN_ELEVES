<?php
include("../../config.php");


if (isset($_POST['OK']) and $_POST['OK'] == 'OK'){
	
	
	if(!empty($_POST['promotion']) or !empty($_POST['formation']) or !empty($_POST['lieu_poursuite']) or !empty($_POST['formation_poursuite']) or !empty($_POST['type_poursuite'])){
		$req = "INSERT INTO info (";
		$n = 0;
		if(!empty($_POST['promotion'])){
			$req .= "promotion";
			$n++;
		}
		if(!empty($_POST['formation'])){
			if ($n != 0){$req .= ", ";}
			$req .= "formation";
			$n++;
		}
		if(!empty($_POST['formation_poursuite']) && !empty($_POST['lieu_poursuite']) && !empty($_POST['type_poursuite'])){
			if ($n != 0){$req .= ", ";}
			$req .= "lieu_poursuite,";
			$req .= "formation_poursuite,";
			$req .= "type_poursuite";
			$n++;
		}
		$req .= ') VALUES ( ';
		
		$n = 0;
		if(!empty($_POST['promotion'])){
			$req .= "'".$_POST['promotion']."'";
			$n++;
		}
		if(!empty($_POST['formation'])){
			if ($n != 0){$req .= ", ";}
			$req .= "'".$_POST['formation']."'";
			$n++;
		}
		if(!empty($_POST['formation_poursuite']) && !empty($_POST['lieu_poursuite']) && !empty($_POST['type_poursuite'])){
			if ($n != 0){$req .= ", ";}
			$req .= "'".$_POST['lieu_poursuite']."',";
			$req .= "'".$_POST['formation_poursuite']."',";
			$req .= "'".$_POST['type_poursuite']."'";
			$n++;
		}
		
		$req .= ")";
		mysqli_query($connexion,$req) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));
	}
	//recupération de l'id crée	
	$req = "SELECT max(id) FROM info";
	foreach (mysqli_query($connexion,$req) as $row){
		$idRequete = $row['max(id)'];
	}
	
	
	if(!empty($_POST['nom']) or !empty($_POST['prenom']) or !empty($_POST['mail'])){
		$req = "INSERT INTO annuaire ( ";
		$n = 0;
		if(!empty($_POST['nom'])){
			$req .= "nom";
			$n++;
		}
		if(!empty($_POST['prenom'])){
			if ($n != 0){$req .= ", ";}
			$req .= "prenom";
			$n++;
		}
		if(!empty($_POST['mail'])){
			if ($n != 0){$req .= ", ";}
			$req .= "mail";
		}
		$req .= ',id) VALUES ( ';
		
		$n = 0;
		if(!empty($_POST['nom'])){
			$req .= "'".$_POST['nom']."'";
			$n++;
		}
		if(!empty($_POST['prenom'])){
			if ($n != 0){$req .= ", ";}
			$req .= "'".$_POST['prenom']."'";
			$n++;
		}
		if(!empty($_POST['mail'])){
			if ($n != 0){$req .= ", ";}
			$req .= "'".$_POST['mail']."'";
		}
		
		$req .= ",".$idRequete.")";
		mysqli_query($connexion,$req) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));
	}
	

	
	
}else{
?>

<br/><br/><br/>
<h4>Ajouter un étudiant : </h4>
	
<form name="ajouter" >
	<!-- Text input-->
	<?php
	if(isset($_POST['OK']) and $_POST['OK'] == 'NA'){
		afficherErreur("Des champs requis sont manquants !");
	}
	?>
	<div class="form-group">
		<div class='row'>
			<div class="col-md-6">
				<label class="control-label" for="prenom">Prénom (requis)</label>  
				<input id="prenom" name="prenom" type="text" placeholder="" class="form-control input-md">
			</div>
			
			<div class="col-md-6">
				<label class="control-label" for="nom">Nom (requis)</label>  
				<input id="nom" name="nom" type="text" placeholder="" class="form-control input-md">
			</div>	
		</div>
		
		<div class='row'>	
			<div class="col-md-6">
				<label class="control-label" for="formation">Formation (requis)</label> 
				<input id="formation" name="formation" type="text" placeholder="" class="form-control input-md">
			</div>		
			<div class="col-md-6">
				<label class="control-label" for="promotion">Promotion</label>  
				<input id="promotion" name="promotion" type="text" placeholder="" class="form-control input-md">
			</div>

		</div>
		
		<div class='row'>
			<div class="col-md-12">
				<label class="control-label" for="mail">Adresse email</label> 
				<input id="mail" name="mail" type="email" placeholder="xxx@xxx.x" class="form-control input-md">
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-4">		
				<label class="control-label" for="formation_poursuite">Formation poursuite</label>
				<select class="custom-select" name="formation_poursuite" id="formation_poursuite" required>
					<option value="">N/A</option>
					<option value="Ecole d'ingenieur"> École d'ingénieur</option>
					<option value="Miage"> MIAGE</option>
					<option value="L3"> L3 </option>
					<option value="Licence professionnelle"> Licence professionnelle</option>
					<option value="Bachelor"> Bachelor </option>
					<option value="Aucune"> Aucune</option>
					<option id="autre" value="Autre"> Autre..</option>
				</select>				
				<!--<input id="formation_poursuite" name="formation_poursuite" type="text" placeholder="" class="form-control input-md">-->
			</div>
			
			<div class="col-md-4">	
				<label class="control-label" for="type_poursuite">Type poursuite</label>  
				<select class="custom-select" name="type_poursuite" id="type_poursuite" required>
					<option value="">N/A</option>
					<option value="initiale">Initial</option>
					<option value="alternance">Alternance</option>
				</select>
				<!--<input id="type_poursuite" name="type_poursuite" type="text" placeholder="Alternance ou Initial" class="form-control input-md">-->
			</div>
			
			<div class="col-md-4">
				<label class="control-label" for="lieu_poursuite">Lieu poursuite</label>
				<input id="lieu_poursuite" name="lieu_poursuite" type="text" placeholder="ville / département" class="form-control input-md">
			</div>
		</div>
	</div>
</form>
	
	
<!-- Button -->
<div class="row">
	<div class="col-6">
		<input class='btn btn-outline-primary' type="button" name='add' value='Ajouter' onclick='validerAjout()'/>
	</div>
	<div class="col-6">
		<input type='button' class="btn btn-outline-danger btn-right" name='supp' value='Retour' onclick='clearZone()'/>
	</div>
</div>
<?php
}
?>