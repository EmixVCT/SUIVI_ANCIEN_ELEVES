 <?php

include("../../config.php");

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

$requete = $requete."ORDER BY ".$_POST['trie'];
//requete passee dans la commande  mysql_query
$resultat = mysqli_query($connexion,$requete);

//affichage du resultat utilisation de la commande mysql_fetch_row si il y a au moins 1 ligne
if (mysqli_num_rows($resultat) != 0){ ?>
<div class="row">
	<table id='annuaire' border=1 align='center' class="table table-striped table-fixed table-sm">
		<thead><tr>
			<th class="col-3">PRENOM</th>
			<th class="col-3">NOM</th>
			<th class="col-2">PROMOTION</th>
			<th class="col-2">FORMATION</th>
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
		?>
		<td align='center' class="col-2"> <input type='button' class="btn btn-outline-primary" name='information' value='En savoir +' onclick='informationEtu("<?php echo $ligne[0]; ?>")'/></td>
		</tr>
		<?php
	}
	echo "</tbody></table>"; ?>
</div>
<?php
}
else{
	echo "Aucun résultat trouvé !<br/><br/>";
}
?>