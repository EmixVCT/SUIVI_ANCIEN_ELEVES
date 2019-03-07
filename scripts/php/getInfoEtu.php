<?php
include("../../config.php");

#Si on arrive sur cette page alors que l'on est pas connecté 
if (!estConnecte()) { 
    header('Location: ../../connexion.php'); #On redirige vers la page de connexion
    exit;
}

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
<hr>
<h4>Information : <?php if (isset($lig['prenom'])){echo $lig['prenom'];} ?></h4>
<form name="modification" >
	<div class="form-group">
		<div class='row'>
			<div class="col-6">
				<label class="control-label" for="prenom">Prénom</label>  
				<input id="prenom" name="prenom" type="text" placeholder="" class="form-control input-md" 
				<?php if (isset($lig['prenom'])){echo "value=\"".$lig['prenom']."\"";} ?> readonly>
			</div>
			
			<div class="col-6">
				<label class="control-label" for="nom">Nom</label>  
				<input id="nom" name="nom" type="text" placeholder="" class="form-control input-md"
				<?php if (isset($lig['nom'])){echo "value=\"".$lig['nom']."\"";} ?> readonly>
			</div>	
		</div>
		
		<div class='row'>	
			<div class="col-6">
				<label class="control-label" for="formation">Formation </label> 
				<input id="formation" name="formation" type="text" placeholder="" class="form-control input-md"
				<?php if (isset($lig['formation'])){echo "value=\"".$lig['formation']."\"";} ?> readonly>
			</div>		
			<div class="col-6">
				<label class="control-label" for="promotion">Promotion</label>  
				<input id="promotion" name="promotion" type="text" placeholder="" class="form-control input-md"
				<?php if (isset($lig['promotion'])){echo "value=\"".$lig['promotion']."\"";} ?> readonly>
			</div>

		</div>
		
		<div class='row'>
			<div class="col-12">
				<label class="control-label" for="mail">Adresse email</label> 
				<input id="mail" name="mail" type="email" placeholder="xxx@xxx.x" class="form-control input-md"
				<?php if (isset($lig['mail'])){echo "value=\"".$lig['mail']."\"";} ?> readonly>
			</div>
		</div>
		
		<div class="row">
			<div class="col-4">		
				<label class="control-label" for="formation_poursuite">Formation poursuite</label>
				<input id="formation_poursuite" name="formation_poursuite" type="text" placeholder="[Non renseigné]" class="form-control input-md"
				<?php if (isset($lig['formation_poursuite'])){echo "value=\"".$lig['formation_poursuite']."\"";} ?> readonly>
			</div>
			
			<div class="col-4">	
				<label class="control-label" for="type_poursuite">Type poursuite</label>  
				<input id="type_poursuite" name="type_poursuite" type="text" placeholder="[Non renseigné]" class="form-control input-md"
				<?php if (isset($lig['type_poursuite'])){echo "value=\"".$lig['type_poursuite']."\"";} ?> readonly>
			</div>
			
			<div class="col-4">
				<label class="control-label" for="lieu_poursuite">Lieu poursuite</label>
				<input id="lieu_poursuite" name="lieu_poursuite" type="text" placeholder="[Non renseigné]" class="form-control input-md"
				<?php if (isset($lig['lieu_poursuite']) && !empty($lig["lieu_poursuite"])){echo "value=\"".$lig['lieu_poursuite']."\"";} ?> readonly>
			</div>
		</div>
	</div>
</form>

<!-- Button -->
<div class="row">
	<div class="col-8">
		<input type='button' class="btn btn-outline-danger " name='supp' value='supprimer' onclick='supprimerLig("<?php echo $identifiant; ?>","id","ANNUAIRE")'/>

		<input type='button' class="btn btn-outline-primary" name='modif' value='modifier' onclick='modifierEtu("<?php echo $identifiant; ?>")'/>
	</div>
	<div class="col-4">
		<input type='button' class="btn btn-outline-danger btn-right" name='supp' value='Retour' onclick='clearZone()'/>
	</div>
</div>
