<?php
include("../../config.php");

if ($_POST['tab']=='ANNUAIRE'){
	$requete="SELECT prenom,nom FROM ".$_POST['tab']." WHERE ".$_POST['cond']." = ".$_POST['id'];

	if ($res = mysqli_query($connexion,$requete)){ //test si la commande est bien exec
		$rowcount=mysqli_num_rows($res);
		
		if ($rowcount == 1) { //test si on a un resultat
			$lig = mysqli_fetch_assoc($res); //récupère la ligne de la table
		}else{ //pas de res
			afficherErreur("<strong>Etudiant</strong> manquant ou incorrect !");
		}
	}

	$txt = "</br>Êtes vous sur de vouloir supprimer ".$lig['prenom']." ".$lig['nom']." ? ";

}
else{
	$txt = "ERREUR cliquer sur 'non'"; 
}

?>
<br/><br/><br/>
<div class="form-control-feedback alert alert-info alert-dismissible fade show" role="alert">

	<span class="text-info align-middle">
		<i class="fa fa-close"></i><strong> Confirmation :</strong> <?php echo $txt; ?>
	</span>
	
	<input type="button" class="btn-outline-secondary" data-dismiss="alert" aria-label="NON" value="Non"
		onclick='informationEtu("<?php echo $_POST['id']; ?>")'/>
	<input type="button" class="btn-outline-secondary " data-dismiss="alert" aria-label="OUI" value="Oui" 
		onclick='ValiderSupprimerLig("<?php echo $_POST['id']; ?>","id","info")'/>
</div> 