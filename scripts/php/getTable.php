 <?php

include("../../config.php");

#Si on arrive sur cette page alors que l'on est pas connecté 
if (!estConnecte()) { 
    header('Location: ../../connexion.php'); #On redirige vers la page de connexion
    exit;
}

//echo "<div class='table-responsive table-wrapper-scroll-y table-sm table-condenced'>";
echo "<div class='tab-petit'><table border = 1 class='table table-striped'>";


$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS where TABLE_NAME='".$_POST['tb']."' and TABLE_SCHEMA='".$bd."'";

$resultat=mysqli_query($connexion,$sql);
while ($ligne=mysqli_fetch_row($resultat)) {
	foreach($ligne as $k => $val){
		echo '<th width=90 align="center">'. $val.'</th>';
	}
}


$sql = "SELECT * FROM ".$_POST['tb'];
$resultat=mysqli_query($connexion,$sql);

while ($ligne=mysqli_fetch_row($resultat)) {	
	echo "<tr>";
	foreach($ligne as $k => $val){
		echo '<td width=90 align="center">'. $val.'</td>';
	}
	echo "</tr>";
}
echo "</table></div></div>";

?>