<?php
include("../../config.php");


if (isset($_POST['NON']) and $_POST['NON'] == 'NON'){
	afficherErreur("Le fichier doit etre un .csv !");
	
}else if (isset($_POST['OK']) and $_POST['OK'] == 'OK'){
	
	if(isset($_FILES["file"],$_POST['separateur'])){
		$file = $_FILES["file"]["tmp_name"];
		if ($_POST['separateur'] == "auto"){
			$separateur = ";";
		}else{
			$separateur = $_POST['separateur'];
		}
		
		//$entete = Array();
		$data = Array();
		//parcours le fichier
		if ($pointeur=fopen($file,"r")){
			//affiche le titre et le blabla
			echo "<hr><h4>Contenue du  fichier :</h4>";
			afficherSucces("Ouverture du fichier réussite !");
			echo "<p>Veulliez choisir pour chaque colonne le type de données corespondant :</p>";
			echo "<form action='scripts/php/addCsvToBdd.php' method='GET'><table border='1' cellpading='1' align='center'> ";
			$i=1;
			//pour chaque ligne du fichier
			while (!feof($pointeur)){
				
				$t=fgets($pointeur,1024);
				$liste = explode($separateur, $t );
				
				if (count($liste) == 1 and $separateur != "," and $_POST['separateur'] == "auto"){
					$separateur = ",";
					$liste = explode($separateur, $t );
				}
				
				/*if (array_empty($liste)){
					continue;
				}*/
				
				
				//si c'est la premiere ligne est qu'il n'y a pas d'entete remplie l'entete avant la boucle
				if ($i == 1 and $_POST['entete_input'] == 'non'){
					echo "<tr>";
					for($x = 0; $x < count($liste); $x++){
						echo "<th width=150 height=20 text-align='center'>
							<select class=\"custom-select\" name=\"".$x."\" id=\"col".$x."\" required>
								<option value=\"\"<i>N/A</i></option>
								<option value=\"nom\">Nom</option>
								<option value=\"prenom\">Prenom</option>
								<option value=\"mail\">Mail</option>
								<option value=\"promotion\">Promotion</option>
								<option value=\"formation\">Formation</option>
								<option value=\"autre\">Autre</option>
							</select></th>";
					}
					echo "</tr>";
				}
				echo "<tr>";
				//affiche les lignes du tableau
				foreach($liste as $key => $value){
					if ($i == 1 and $_POST['entete_input'] == 'oui'){ // premiere ligne entete du csv
						//$entete[$key] = $value;
						echo "<th width=150 height=20 text-align='center'>
							<select class=\"custom-select\" name=\"".$key."\" id=\"col".$key."\" required>
								<option value=\"\"<i>'".$value."'</i></option>
								<option value=\"nom\">Nom</option>
								<option value=\"prenom\">Prenom</option>
								<option value=\"mail\">Mail</option>
								<option value=\"promotion\">Promotion</option>
								<option value=\"formation\">Formation</option>
								<option value=\"autre\">Autre</option>
							</select></th>";
					}else{
						$data[$i][] = $value;
						echo "<td width=50 height=20 align='center'>".$value."</td>";
					}
				}
				
				echo "</tr>";
				$i++;
			}
			echo "</table><br>";
			if (isset($_POST['formation']) and !empty($_POST['formation'])){
				echo '<label for="formation">Formation</label><input id="formation" name="formation" type="text" class="form-control input-md" value="'.$_POST['formation'].'" readonly/>';
			}
			if (isset($_POST['promotion']) and !empty($_POST['promotion'])){
				echo '<label for="promotion">Promotion</label><input id="promotion" name="promotion" type="text" class="form-control input-md" value="'.$_POST['promotion'].'" readonly/>';
			}
			
			//Sauvegarde des données du fichier csv
			$_SESSION['data'] = $data;
			
			echo "<br/><input class='btn btn-outline-secondary btn-right' type='submit' value='Importer' name='importer' /><br/></form>";
			
			//fclose($file);

		}	
	}		



}else{
?>
<hr>
<h4>Importer un fichier : </h4>
	
<form name="ajouterCsv" >

	<div class="form-group">
	
		<div class='row'>
			<div class="col-4">
				<label class="control-label" for="file">CSV</label>  
				<input id="file" name="file" type="file" class="form-control-file input-md" accept=".csv">
			</div>
			
			<div class="col-4">
				<label class="control-label" for="separateur">Type de séparateur</label>  
				<select class="custom-select" name="separateur" id="separateur" required>
					<option value="auto">Automatique</option>
					<option value=",">,</option>
					<option value=";">;</option>
				</select>
			</div>	

			<div class="col-4">
				<label class="control-label" for="entete_input">Entete de CSV</label>  
				<div class="custom-radio-inline">
					<label class="radio-inline mr-3"><input type="radio" name="entete_input" value="oui" id="oui" checked/>OUI</label>
					<label class="radio-inline mr-3"><input type="radio" name="entete_input" value="non" id="non" />NON</label>
				</div>
			</div>	
		</div>
		<br><h4>Information supplémentaire : </h4>

		<div class='row'>	
			<div class="col-6">
				<label class="control-label" for="formation">Formation</label> 
				<input id="formation" name="formation" type="text" placeholder="ex:INFO" class="form-control input-md">
			</div>		
			<div class="col-6">
				<label class="control-label" for="promotion">Promotion</label>  
				<input id="promotion" name="promotion" type="text" placeholder="ex:2019" class="form-control input-md">
			</div>
		</div>
		
	</div>
</form>
	
	
<!-- Button -->
<div class="row">
	<div class="col-6">
		<input class='btn btn-outline-primary' type="button" name='ouvrir' value='Ouvrir' onclick='validerImportation()'/>
	</div>
	<div class="col-6">
		<input type='button' class="btn btn-outline-danger btn-right" name='supp' value='Retour' onclick='clearZone()'/>
	</div>
</div>
<?php
}
?>