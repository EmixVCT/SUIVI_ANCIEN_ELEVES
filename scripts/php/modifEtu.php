<?php
include("../../config.php");

if (isset($_POST['OK'])){
	if (isset($_POST['mail']) and !empty($_POST['mail']) and verifieDoublonsMail($_POST['mail'],$connexion)){
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
			if(!empty($_POST['formation_poursuite']) && !empty($_POST['lieu_poursuite']) && !empty($_POST['type_poursuite'])){
				if ($n != 0){$req .= ", ";}
				$req .= 'lieu_poursuite = "'.$_POST['lieu_poursuite'].'", ';
				$req .= 'formation_poursuite = "'.$_POST['formation_poursuite'].'", ';
				$req .= "type_poursuite = '".$_POST['type_poursuite']."' ";
				$n++;
			}else if(empty($_POST['formation_poursuite']) || empty($_POST['lieu_poursuite']) || empty($_POST['type_poursuite'])){
				if ($n != 0){$req .= ", ";}
				$req .= 'lieu_poursuite = NULL, ';
				$req .= 'formation_poursuite = NULL, ';
				$req .= 'type_poursuite = NULL';
			}
			
			$req .= " WHERE id = ".$_POST['id'];

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
		afficherErreur("Le mail est deja utilisé par un autre étudiant !");
	}
	
}else{
	//récupère les infos de l'étudiant pour remplir le formulaire de modification
	$identifiant = $_POST['id'];
	$requete="SELECT * FROM ANNUAIRE,INFO WHERE Annuaire.id = INFO.id AND Annuaire.id = ".$identifiant;
	
	if ($res = mysqli_query($connexion,$requete)){ //test si la commande est bien exec
		$rowcount=mysqli_num_rows($res);
		
		if ($rowcount == 1) { //test si on a un resultat
			$lig = mysqli_fetch_assoc($res); //récupère la ligne de la table
		}else{ //pas de res
			afficherErreur("<strong>Etudiant</strong> manquant ou incorrect !");
		}
	}
?>

<br/><br/><br/>
<h4>Modification : </h4>
<form name="modification" >
	<div class="form-group">
		<div class='row'>
			<div class="col-6">
				<label class="control-label" for="prenom">Prénom</label>  
				<input id="prenom" name="prenom" type="text" placeholder="" class="form-control input-md" 
				<?php if (isset($lig['prenom'])){echo "value=\"".$lig['prenom']."\"";} ?> >
			</div>
			
			<div class="col-6">
				<label class="control-label" for="nom">Nom</label>  
				<input id="nom" name="nom" type="text" placeholder="" class="form-control input-md"
				<?php if (isset($lig['nom'])){echo "value=\"".$lig['nom']."\"";} ?> >
			</div>	
		</div>
		
		<div class='row'>	
			<div class="col-6">
				<label class="control-label" for="formation">Formation </label> 
				<input id="formation" name="formation" type="text" placeholder="" class="form-control input-md"
				<?php if (isset($lig['formation'])){echo "value=\"".$lig['formation']."\"";} ?> >
			</div>		
			<div class="col-6">
				<label class="control-label" for="promotion">Promotion</label>  
				<input id="promotion" name="promotion" type="text" placeholder="" class="form-control input-md"
				<?php if (isset($lig['promotion'])){echo "value=\"".$lig['promotion']."\"";} ?> >
			</div>

		</div>
		
		<div class='row'>
			<div class="col-12">
				<label class="control-label" for="mail">Adresse email</label> 
				<input id="mail" name="mail" type="email" placeholder="xxx@xxx.x" class="form-control input-md"
				<?php if (isset($lig['mail'])){echo "value=\"".$lig['mail']."\"";} ?> >
			</div>
		</div>
		
		<div class="row">
			<div class="col-4">		
				<label class="control-label" for="formation_poursuite">Formation poursuite</label>
				<select class="custom-select" name="formation_poursuite" id="formation_poursuite" required>
					<option value=""<?php if(empty($lig['formation_poursuite'])){echo "selected";} ?>>N/A</option>
					<option value="Ecole d'ingenieur" <?php if($lig['formation_poursuite'] == $formations_p[0]){echo "selected";} ?>> École d'ingénieur</option>
					<option value="Miage"<?php if($lig['formation_poursuite'] == $formations_p[1]){echo "selected";} ?>> MIAGE</option>
					<option value="L3"<?php if($lig['formation_poursuite'] == $formations_p[2]){echo "selected";} ?>> L3 </option>
					<option value="Licence professionnelle"<?php if($lig['formation_poursuite'] == $formations_p[3]){echo "selected";} ?>> Licence professionnelle</option>
					<option value="Bachelor"<?php if($lig['formation_poursuite'] == $formations_p[4]){echo "selected";} ?>> Bachelor </option>
					<option value="Aucune"<?php if($lig['formation_poursuite'] == $formations_p[5]){echo "selected";} ?>> Aucune</option>
					<?php
						if (!empty($lig['formation_poursuite']) && !in_array($lig['formation_poursuite'],$formations_p)){
							echo '<option value=\''.$lig['formation_poursuite'].'\' selected >'.$lig['formation_poursuite'].'</option>';
						}else{
							echo '<option id="autre" value="Autre" > Autre..</option>';
						}
					?>
				</select>				
				<!--<input id="formation_poursuite" name="formation_poursuite" type="text" placeholder="" class="form-control input-md">-->
			</div>
			
			<div class="col-4">	
				<label class="control-label" for="type_poursuite">Type poursuite</label>  
				<select class="custom-select" name="type_poursuite" id="type_poursuite" required>
					<option value=""<?php if(empty($lig['type_poursuite'])){echo "selected";} ?>>N/A</option>
					<option value="initiale"<?php if($lig['type_poursuite']=="initiale"){echo "selected";} ?>>Initial</option>
					<option value="alternance"<?php if($lig['type_poursuite']=="alternance"){echo "selected";} ?>>Alternance</option>
				</select>
				<!--<input id="type_poursuite" name="type_poursuite" type="text" placeholder="Alternance ou Initial" class="form-control input-md">-->
			</div>
			
			<div class="col-4">
				<label class="control-label" for="lieu_poursuite">Lieu poursuite</label>
				<input id="lieu_poursuite" name="lieu_poursuite" type="text" placeholder="ville / département" class="form-control input-md"
				<?php if (isset($lig['lieu_poursuite']) && !empty($lig["lieu_poursuite"])){echo "value=\"".$lig['lieu_poursuite']."\"";} ?> >
			</div>
		</div>
	</div>
</form>

<!-- Button -->
<div class="row">
	<div class="col-6">
		<input class="btn btn-outline-primary" name='modifier' type="button" value="modifier" onclick='validerModif("<?php echo $_POST['id'] ?>")'/>
	</div>
	<div class="col-6">
		<input class="btn btn-outline-danger btn-right" name='annuler' type="button" value="annuler" onclick='informationEtu("<?php echo $_POST['id'] ?>")'/>
	</div>
</div>


<?php
}
?>