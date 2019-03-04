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
		if(!empty($_POST['lieu_poursuite'])){
			if ($n != 0){$req .= ", ";}
			$req .= "lieu_poursuite";
			$n++;
		}
		if(!empty($_POST['formation_poursuite'])){
			if ($n != 0){$req .= ", ";}
			$req .= "formation_poursuite";
			$n++;
		}
		if(!empty($_POST['type_poursuite'])){
			if ($n != 0){$req .= ", ";}
			$req .= "type_poursuite";
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
		if(!empty($_POST['lieu_poursuite'])){
			if ($n != 0){$req .= ", ";}
			$req .= "'".$_POST['lieu_poursuite']."'";
			$n++;
		}
		if(!empty($_POST['formation_poursuite'])){
			if ($n != 0){$req .= ", ";}
			$req .= "'".$_POST['formation_poursuite']."'";
			$n++;
		}
		if(!empty($_POST['type_poursuite'])){
			if ($n != 0){$req .= ", ";}
			$req .= "'".$_POST['type_poursuite']."'";
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
			<div class="col-md-3">
				<label class="control-label" for="prenom">Prénom (requis)</label>  
				<input id="prenom" name="prenom" type="text" placeholder="" class="form-control input-md">
			</div>
			
			<div class="col-md-3">
				<label class="control-label" for="nom">Nom (requis)</label>  
				<input id="nom" name="nom" type="text" placeholder="" class="form-control input-md">
			</div>
			
			<div class="col-md-6">
				<label class="control-label" for="lieu_poursuite">Lieu poursuite</label>
				<input id="lieu_poursuite" name="lieu_poursuite" type="text" placeholder="ville / département" class="form-control input-md">
			</div>
		</div>
		<div class='row'>
			<div class="col-md-6">
				<label class="control-label" for="mail">Adresse email</label> 
				<input id="mail" name="mail" type="email" placeholder="xxx@xxx.x" class="form-control input-md">
			</div>
			
			<div class="col-md-6">	
				<label class="control-label" for="type_poursuite">Type poursuite</label>  
				<input id="type_poursuite" name="type_poursuite" type="text" placeholder="Alternance ou Initial" class="form-control input-md">
			</div>
		</div>
		<div class='row'>		
			<div class="col-md-3">
				<label class="control-label" for="promotion">Promotion</label>  
				<input id="promotion" name="promotion" type="text" placeholder="" class="form-control input-md">
			</div>

			<div class="col-md-3">
				<label class="control-label" for="formation">Formation (requis)</label> 
				<input id="formation" name="formation" type="text" placeholder="" class="form-control input-md">
			</div>
			
			<div class="col-md-6">		
				<label class="control-label" for="formation_poursuite">Formation poursuite</label>  
				<input id="formation_poursuite" name="formation_poursuite" type="text" placeholder="" class="form-control input-md">
			</div>
		
		</div>
	</div>
</form>
	<div class='row'>	
		<div class="col-md-12">
			<input class='btn btn-outline-primary' type="button" name='add' value='Ajouter' onclick='validerAjout()'/>
		</div>	
	</div>
<?php
}
?>