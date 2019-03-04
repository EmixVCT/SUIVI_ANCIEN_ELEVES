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
	<form action='mail.php' method='POST' name='selec'>
		<div class="table-responsive table-wrapper-scroll-y table-sm table-condenced ">
			<table class="table table-striped" border=1 align='center'>
				<tr>
					<th width=90 align='center'>NOM</th>
					<th width=90 align='center'>PRENOM</th>
					<!--<th width=90 align='center'>MAIL</th>-->
					<th width=90 align='center'>PROMOTION</th>
					<th width=90 align='center'>FORMATION</th>
					<th width=90 align='center'>LIEU POURSUITE</th>
					<th width=90 align='center'>FORMATION POURSUITE</th>
					<th width=90 align='center'>TYPE POURSUITE</th>
					<td width=90 align='center'>Sélection </br> <input type='checkbox' name='etu' value='tout' onclick="selectAll(this)" /></td>
				</tr>
			<?php
			while ($ligne=mysqli_fetch_row($resultat)) {	
				echo "<tr>";
				foreach($ligne as $k => $val){
					if ($k != 0 and $k !=4 and $k != 3){
						echo '<td width=90 align="center">'. $val.'</td>';
					}
				}
				echo "<td  width=90 align='center'> <input type='checkbox' name='etu[]' value='";
				echo $ligne[0];
				echo "' /> </td>";
				
				echo "</tr>";
			}
		echo "</table>";
	echo "</div>";
	echo "<input class='btn btn-outline-primary' type='submit' name='selectionner' value='sélectionner'/>";
echo "</form>"; ?>
<?php
}
else{
	echo "Aucun resultat trouver !<br/><br/>";
}
?>