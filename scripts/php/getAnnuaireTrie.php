 <?php

include("../../config.php");

$requete="SELECT * FROM ANNUAIRE,INFO WHERE Annuaire.id = INFO.id ";

if (!empty($_POST['nom'])){
	$requete = $requete."AND nom like '%".$_POST['nom']."%' ";
}
else if (!empty($_POST['prenom'])){
	$requete = $requete."AND prenom like '%".$_POST['prenom']."%' ";
}
else if (!empty($_POST['promo'])){
	$requete = $requete."AND promotion like '%".$_POST['promo']."%' ";
}
else if (!empty($_POST['forma'])){
	$requete = $requete."AND formation like '%".$_POST['forma']."%' ";
}

$requete = $requete."ORDER BY ".$_POST['trie'];

//requete passee dans la commande  mysql_query
$resultat = mysqli_query($connexion,$requete);

//affichage du resultat utilisation de la commande mysql_fetch_row si il y a au moins 1 ligne
if (mysqli_num_rows($resultat) != 0){ ?>
	<div class="table-responsive table-wrapper-scroll-y table-sm table-condenced ">
		<table id='annuaire' border=1 align='center' class="table table-striped">
			<thead><tr>
				<th>NOM</th>
				<th>PRENOM</th>
				<th>MAIL</th>
				<th>PROMOTION</th>
				<th>FORMATION</th>
				<th>LIEU POURSUITE</th>
				<th>FORMATION POURSUITE</th>
				<th>TYPE POURSUITE</th>
				<th></th><th></th>
			</tr></thead>
		<tbody>
		<?php
		while ($ligne=mysqli_fetch_row($resultat)) {	
			echo "<tr>";
			foreach($ligne as $k => $val){
				if ($k != 0 and $k !=4){
					echo '<td>'. $val.'</td>';
				}
			}
			?>
			<td> <input type='button' class="btn btn-outline-danger" name='supp' value='supprimer' onclick='supprimerLig("<?php echo $ligne[0]; ?>","id","info")'/></td>
			<td> <input type='button' class="btn btn-outline-primary" name='modif' value='modifier' onclick='modifierEtu("<?php echo $ligne[0]; ?>")'/></td>
			
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