<?php
require_once('config.php'); #On inclut la configuration

#Si on arrive sur cette page alors que l'on est pas connecté / ou que l'on n'est pas un administrateur
if (!estConnecte() || $_SESSION['droit'] != "admin") { 
    header('Location: connexion.php'); #On redirige vers la page de connexion
    exit;
}

require_once($fichiersInclude.'header.html'); #On inclut l'entête

?>	
<script src="scripts/showtable.js" type="text/javascript"></script>
		
<body>
	<?php require_once($fichiersInclude.'navbar.php'); #On inclut la bar de navigation ?>
	
	<div id='contenue' class='container-fluid'>
		<header>
			<center><h1>Administration</h1></center>
		</header>
		

		<?php
		/** Test si on modifie un compte *********/
		if (isset($_GET['act']) and $_GET['act'] == "mod"){
		
			//Si pas confirmer affiche le formulaire de modification
			if (!isset($_GET['conf'])){ ?>
				<h3>Modification <?php echo $_GET["log"]; ?>:</h3>
				
				<form action='admin.php?act=mod&log=<?php echo $_GET["log"]; ?>&conf=OK' method='POST'><table align='center'><tr>
					<tr><td>Nouveau mot de passe :</td><td><input class="form-control" type='password' maxsize='10' name='nmdp' ></td></tr>					
					<tr><td>Droit :</td><td> <select class="custom-select" name="ntype">
										  <option value="user">user</option>
										  <option value="admin">admin</option>
										</select></td></tr>
				
					<tr><td>&nbsp;</td><td><input class='btn btn-outline-secondary' type='submit' name='modifier' value='Modifier'>
					<input class='btn btn-outline-secondary' type='submit' name='annuler' value='Annuler'></td></tr></table>

				</form></table>
				
			
			<?php
			//CLIQUE SUR MODIFIER, modifie dans la base de donnée
			}else if (isset($_POST['modifier'])){ 
				
				if (isset($_POST["nmdp"])){
					$mdp = hash("sha256",htmlspecialchars($_POST["nmdp"]));
				}
				// lancement de la requête
				$reqinsert = "UPDATE UTILISATEUR SET ";
				if (isset($_POST['nmdp'])) {$reqinsert = $reqinsert. "mdp='".$mdp."', ";} 
				if (isset($_POST['ntype'])) {$reqinsert = $reqinsert. "droit='".$_POST['ntype']."' ";}
				$reqinsert = $reqinsert. "WHERE login ='".$_GET['log']."'";
				
				// on exécute la requête (mysql_query) et on affiche un message au cas où la requête ne se passait pas bien (or die)
				mysqli_query($connexion,$reqinsert) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));
				header('location: admin.php');
			}
			//clique sur annuler
			else{
				header('location: admin.php');
			}
		}else{ ?>

			<!-- Formulaire de création de compte-->
			<h3>Crée un nouveau compte</h3>
			
			<form action='' method='POST'><table align='center'><tr>
				<tr><td>LOGIN : </td><td><input class="form-control" type='text' maxsize='10' name='clogin' <?php
						if (isset($_POST['clogin'])){
							echo "value="."'".$_POST['clogin']."'";
						}?> required></td></tr>
				<tr><td>MDP :</td><td><input class="form-control" type='password' maxsize='10' name='cmdp' required ></td></tr>
				<tr><td>MDP (confirmation):</td><td><input class="form-control" type='password' maxsize='10' name='cmdpconf' required ></td></tr>
				
				<tr><td>type :</td><td> <select class="custom-select" name="ctype">
										  <option value="user" <?php if (isset($_POST['ctype']) && $_POST['ctype']=="user") echo "selected" ?> >user</option>
										  <option value="admin" <?php if (isset($_POST['ctype']) && $_POST['ctype']=="admin") echo "selected" ?> >admin</option>
										</select></td></tr>
				
				<tr><td>&nbsp;</td><td><input class='btn btn-outline-secondary' type='submit' name='plus' value='Créé'></td></tr></table>
			</form></table>
			<br/>
			<?php
			
			//Test si form d'ajout est remplie
			if (isset($_POST["clogin"],$_POST["cmdp"],$_POST["cmdpconf"],$_POST["ctype"]) and $_POST["cmdp"] == $_POST["cmdpconf"]){
				$reqinsert="INSERT into UTILISATEUR(login,mdp,droit)";
				$reqinsert.="VALUES(?,?,?)";

				$reqprepare=mysqli_prepare($connexion,$reqinsert);

				//liaison des parametres :
				if (isset($_POST['cmdp'],$_POST['cmdp'],$_POST['ctype'])){
					$login=$_POST['clogin'];
					$mdp= hash("sha256",htmlspecialchars($_POST["cmdp"]));
					$droit=$_POST['ctype'];

					// insertion
					mysqli_stmt_bind_param($reqprepare,'sss',$login,$mdp,$droit);
					mysqli_stmt_execute($reqprepare);
					unset($_POST['clogin']);
				}
			//Si le formulaire est remplie et les mots de passe sont different affiche une erreur
			}else if(isset($_POST["clogin"],$_POST["cmdp"],$_POST["cmdpconf"],$_POST["ctype"]) and $_POST["cmdp"] != $_POST["cmdpconf"]){
				echo "Les mots de passes doivent etre identique !";
			}
			
			//test si suppression
			if (isset($_GET['act']) and $_GET['act'] == "sup" and $_GET['log'] != $_SESSION['login']){
				if (!isset($_GET['conf'])){
					echo "Confirmer la suppression de ".$_GET['log']." ? ";
					echo "<a href='admin.php?act=sup&log=".$_GET['log']."&conf=OK'>OUI</a>";
					echo " <a href='admin.php'>NON</a><br/>";
				}else{
					// lancement de la requête
					$reqsuppr = "DELETE from UTILISATEUR where login = '".$_GET['log']."'";
					// on exécute la requête (mysql_query) et on affiche un message au cas où la requête ne se passait pas bien (or die)
					mysqli_query($connexion,$reqsuppr) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($connexion));
					
					header('location: admin.php');
				}

			}else if (isset($_GET['log']) and $_GET['log'] == $_SESSION['login']){ //exeption si supp le compte connecter
				echo "Vous ne pouvez pas supprimer votre compte !";
				
			}
		}
		?>
		<!-- Liste des comptes -->
		<br/><h3>Liste des comptes :</h3><br/>
		<?php
		//requete sql de type SELECT ... from
		$requete="SELECT * FROM UTILISATEUR ORDER BY droit";
		//requete passee dans la commande  mysql_query
		$resultat=mysqli_query($connexion,$requete);
		//affichage du resultat utilisation de la commande mysql_fetch_row
		?>
		<div class='tab-petit'>
			<table border=1 align='center' class='table table-striped'>
				<tr>
					<th width=90 align='center'>LOGIN</th>
					<th width=90 align='center'>DROIT</th>
				</tr>
			<?php
			while ($ligne=mysqli_fetch_row($resultat)) {	
				echo "<tr>";
				foreach($ligne as $k => $val){
					if ($k != 1){
						echo '<td width=90 align="center">'. $val.'</td>';
					}
				}
				echo "<td  width=90 align='center'> <a href=";
				echo "admin.php?act=sup&log=".$ligne[0];
				echo "> supprimer </a> </td>";
				
				echo "<td  width=90 align='center'> <a href=";
				echo "admin.php?act=mod&log=".$ligne[0];
				echo "> modifier </a> </td>";
				
				echo "</tr>";
			}
			echo "</table>";
			?>
		</div>

		<!-- Liste des comptes -->
		<br/><h3>Ensemble des tables de la base de données :</h3><br/>

		<?php

		$req = "show tables";
		$result=mysqli_query($connexion,$req);

		echo "<label>Selectionnez la table : </label>";
		echo "<select  class='custom-select' id='tables'>";
		while ($ligne=mysqli_fetch_array($result))
		{
			echo "<option name='tb' value='".$ligne[0]."'>".$ligne[0]."</option>";
			
		}
		echo "</select><br/>";

		?>
		<br/>
		<div id="table"></div>
	
	</div>
</body>

<?php
require_once($fichiersInclude.'footer.html'); 
?>