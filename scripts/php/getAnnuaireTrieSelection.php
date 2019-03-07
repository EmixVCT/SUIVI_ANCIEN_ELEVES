<?php

include("../../config.php");

#Si on arrive sur cette page alors que l'on est pas connecté 
if (!estConnecte()) { 
    header('Location: ../../connexion.php'); #On redirige vers la page de connexion
    exit;
}

$requete="SELECT Annuaire.id,prenom,nom,promotion,formation FROM ANNUAIRE,INFO WHERE Annuaire.id = INFO.id ";

if (!empty($_POST['nom'])){
	$requete = $requete."AND nom like '%".$_POST['nom']."%' ";
}
if (!empty($_POST['prenom'])){
	$requete = $requete."AND prenom like '%".$_POST['prenom']."%' ";
}
if (!empty($_POST['promo'])){
	$requete = $requete."AND promotion like '%".$_POST['promo']."%' ";
}
if (!empty($_POST['forma'])){
	$requete = $requete."AND formation like '%".$_POST['forma']."%' ";
}
if(isset($_POST["check"]) && $_POST["check"] == "ok"){
	$requete .= "AND formation_poursuite IS NULL ";
}


$requete = $requete."ORDER BY ".$_POST['trie'];

//requete passee dans la commande  mysql_query
$resultat = mysqli_query($connexion,$requete);

//affichage du resultat utilisation de la commande mysql_fetch_row si il y a au moins 1 ligne
if (mysqli_num_rows($resultat) != 0){ ?>
<form action='mail.php' method='POST' name='selec'>
	<div class="row">
		<table id='annuaire' border=1 align='center' class="table table-striped table-fixed table-sm">
			<thead><tr>
				<th class="col-3">PRENOM</th>
				<th class="col-3">NOM</th>
				<th class="col-2">PROMOTION</th>
				<th class="col-2">FORMATION</th>
				<th class="col-2" align='center'><input type='checkbox' name='etu' value='tout' onclick="selectAll(this)" /></th>
			</tr></thead>
		<tbody>
		<?php
		while ($ligne=mysqli_fetch_row($resultat)) {	
			echo "<tr>";
			foreach($ligne as $k => $val){
				if ($k != 0){
					if($k<3){
						echo '<td class="col-3">'. $val.'</td>';
					}else{
						echo '<td class="col-2">'. $val.'</td>';
					}
				}
			}
			echo "<td class='col-2' align='center'> <input type='checkbox' name='etu[]' value='";
			echo $ligne[0];
			echo "' /> </td>";	
			echo "</tr>";
		}
		echo "</tbody></table>"; ?>
	</div>
<!-- Button -->
<div class="row">
	<div class="col-6">
		<input class='btn btn-outline-primary' type='submit' name='selectionner' value='sélectionner'/>
		</form> 
	</div>
	<div class="col-6">
		<form action='mail.php' method='POST'>
			<input class="btn btn-outline-danger btn-right" type='submit' name='retour' value='Retour'/>
		</form>
	</div>
</div>
<?php
}
else{
	echo "Aucun resultat trouver !<br/><br/>";
}
?>