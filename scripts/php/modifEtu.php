<?php
include("../../config.php");

if (isset($_POST['OK'])){
	if(!empty($_POST['promotion']) or !empty($_POST['formation']) or !empty($_POST['lieu_poursuite']) or !empty($_POST['formation_poursuite']) or !empty($_POST['type_poursuite'])){
		$req = "UPDATE info set ";
		$n = 0;
		if(!empty($_POST['promotion'])){
			$req .= "promotion = '".$_POST['promotion']."' ";
			$n++;
		}
		if(!empty($_POST['formation'])){
			if ($n != 0){$req .= ", ";}
			$req .= 'formation = "'.$_POST['formation'].'" ';
			$n++;
		}
		if(!empty($_POST['lieu_poursuite'])){
			if ($n != 0){$req .= ", ";}
			$req .= 'lieu_poursuite = "'.$_POST['lieu_poursuite'].'" ';
			$n++;
		}
		if(!empty($_POST['formation_poursuite'])){
			if ($n != 0){$req .= ", ";}
			$req .= 'formation_poursuite = "'.$_POST['formation_poursuite'].'" ';
			$n++;
		}
		if(!empty($_POST['type_poursuite'])){
			if ($n != 0){$req .= ", ";}
			$req .= "type_poursuite = '".$_POST['type_poursuite']."' ";
		}
		
		$req .= "WHERE id = ".$_POST['id'];
		
		mysqli_query($connexion,$req) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));
	}
	
	if(!empty($_POST['nom']) or !empty($_POST['prenom']) or !empty($_POST['mail'])){
		$req = "UPDATE annuaire set ";
		$n = 0;
		if(!empty($_POST['nom'])){
			$req .= "nom = '".$_POST['nom']."' ";
			$n++;
		}
		if(!empty($_POST['prenom'])){
			if ($n != 0){$req .= ", ";}
			$req .= "prenom = '".$_POST['prenom']."' ";
			$n++;
		}
		if(!empty($_POST['mail'])){
			if ($n != 0){$req .= ", ";}
			$req .= "mail = '".$_POST['mail']."' ";
		}
		
		$req .= "WHERE id = ".$_POST['id'];
		
		mysqli_query($connexion,$req) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));
	}
	
}else{
?>


<h4>Modification : </h4>
	
<form name="modification" class="form-horizontal">
	<!-- Text input-->
	<div class="form-group">
		<label class="col-md-4 control-label" for="prenom">Prénom</label>  
		<div class="col-xs-1 col-sm-6 col-md-4 col-lg-4">
			<input id="prenom" name="prenom" type="text" placeholder="" class="form-control input-md">
		</div>
	</div>

	<!-- Text input-->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="nom">Nom</label>  
	  <div class="col-xs-1 col-sm-6 col-md-4 col-lg-4">
	  <input id="nom" name="nom" type="text" placeholder="" class="form-control input-md">
		
	  </div>
	</div>

	<!-- Text input-->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="mail">Adresse email</label>  
	  <div class="col-xs-1 col-sm-6 col-md-4 col-lg-4">
	  <input id="mail" name="mail" type="email" placeholder="xxx@xxx.x" class="form-control input-md">
		
	  </div>
	</div>

	<!-- Text input-->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="promotion">Promotion</label>  
	  <div class="col-xs-1 col-sm-6 col-md-4 col-lg-4">
	  <input id="promotion" name="promotion" type="text" placeholder="" class="form-control input-md">
		
	  </div>
	</div>

	<!-- Text input-->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="formation">Formation</label>  
	  <div class="col-xs-1 col-sm-6 col-md-4 col-lg-4">
	  <input id="formation" name="formation" type="text" placeholder="" class="form-control input-md">
		
	  </div>
	</div>

	<!-- Text input-->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="lieu_poursuite">Lieu poursuite</label>  
	  <div class="col-xs-1 col-sm-6 col-md-4 col-lg-4">
	  <input id="lieu_poursuite" name="lieu_poursuite" type="text" placeholder="ville / département" class="form-control input-md">
		
	  </div>
	</div>

	<!-- Text input-->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="formation_poursuite">Formation poursuite</label>  
	  <div class="col-xs-1 col-sm-6 col-md-4 col-lg-4">
	  <input id="formation_poursuite" name="formation_poursuite" type="text" placeholder="" class="form-control input-md">
		
	  </div>
	</div>

	<!-- Text input-->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="type_poursuite">Type poursuite</label>  
	  <div class="col-xs-1 col-sm-6 col-md-4 col-lg-4">
		<input id="type_poursuite" name="type_poursuite" type="text" placeholder="Alternance ou Initial" class="form-control input-md">
	  </div>
	</div>

	<!-- Button -->
	<div class="col-xs-1 col-sm-6 col-md-4 col-lg-4">
		<input class="btn btn-outline-primary" name='modifier' type="button" value="modifier" onclick='validerModif("<?php echo $_POST['id'] ?>")'/>
	</div>

</form>


<?php
}
?>