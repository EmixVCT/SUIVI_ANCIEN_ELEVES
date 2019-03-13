<?php 
    function afficherErreur($erreur) { //Affiche une alerte d'erreur
        ?>
        
        <div class="form-control-feedback alert alert-danger alert-dismissible fade show" role="alert">

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>

        <span class="text-danger align-middle">
        <i class="fa fa-close"></i><strong> Erreur :</strong> <?php echo $erreur; ?>
        </span>

        </div> 

        <?php
    }
	
    function verifieDoublonsMail($id,$m,$con) { 
		/*renvoie vrai s'il n'existe pas de mail identique dans la base de donnée*/
		
		//récupère l'identifiant lié au mail 
		//dans le cas ou ont ajoute un nouveau
		if (empty($id)){
			$sql = "SELECT id FROM annuaire where mail like '".$m."'";
		//dans le cas ou ont modifie un existant
		}else{
			$sql = "SELECT id FROM annuaire where mail like '".$m."' and id != ".$id;
		}

		$resultat=mysqli_query($con,$sql);

		$rowcount=mysqli_num_rows($resultat);
		
		if ($rowcount == 0) { //test si on a un resultat
			return True; 
		}else{ 
			return False;
		}

    }
	
    function afficherSucces($message) { //Affiche une alerte de succès
        ?>

            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            <span class="text-success align-middle">
                <i class="fa fa-close"></i><strong> Succès :</strong> <?php echo $message; ?>
            </span>
			</div>

        <?php
    }
    function estConnecte() { //Renvoie vrai si une personne est connectée,faux sinon
        
        $roles = array("admin", "user");
		//si le login existe et si le droit existe
        if (isset($_SESSION['login']) AND isset($_SESSION['droit'])) {
            //si le login est pas vide et si le droit est admin ou user
            if ( (!empty($_SESSION['login'])) AND in_array($_SESSION['droit'], $roles) ) {
                return True;
            }
        }
        return False;
    }
	
	function dec_enc($action, $string) {
		$output = false;
	 
		$encrypt_method = "AES-256-CBC";
		$secret_key = '#IutVelizy#projettutore2018/2019clé';
		$secret_iv = '#IutVelizy#projettutore2018/2019iv';
	 
		//hash
		$key = hash('sha256', $secret_key);
		
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
	 
		if( $action == 'encrypt' ) {
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
		}
		else if( $action == 'decrypt' ){
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}
		
		return $output;
	}
	function debug($x){
		echo "<pre>";
		print_r($x);
		echo "</pre>";
	}
	
	function array_empty($a){
		$res = false;
		
		foreach($a as $k => $v){
			if(empty($v)){
				$res = true;
			}
		}
		return $res;
	}

	function get_historique($utilisateur,$cnx){
		/*renvoie le nom du fichier correspondant à l'utilisateur*/
		$sql = "SELECT droit FROM utilisateur WHERE login like \"".$utilisateur."\"";
		
		$resultat=mysqli_query($cnx,$sql);
		
		$ligne=mysqli_fetch_row($resultat);
		
		$droit = $ligne[0];
		
		if($droit == "user"){
			return "historique/".dec_enc("encrypt",$utilisateur).".txt";
		}else if($droit == "admin"){
			return "historique/".dec_enc("encrypt","actions").".txt";
		}
	}
	
	function set_historique($fichier,$string){
		//rempli l'historique fichier avec la chaine de charactère
		
		$file = fopen($fichier, "a");
		date_default_timezone_set('Europe/Paris');
		$txt = "[".date("d/m/y à H\hi")."] ";
		$txt .= $string;
		$txt .= "\r\n";
		
		fputs ($file, $txt);
		fclose ($file);
		
		$tabFich = file($fichier);
		$nbLignes = count($tabFich);
		
		if ($nbLignes > 50){
			$ptr = fopen($fichier, "r");
			$contenu = fread($ptr, filesize($fichier));

			/* On a plus besoin du pointeur */
			fclose($ptr);

			$contenu = explode(PHP_EOL, $contenu); /* PHP_EOL contient le saut à la ligne utilisé sur le serveur (\n linux, \r\n windows ou \r Macintosh */

			unset($contenu[0]); /* On supprime la ligne 0 */
			$contenu = array_values($contenu); /* Ré-indexe l'array */
			/* Puis on reconstruit le tout et on l'écrit */
			$contenu = implode(PHP_EOL, $contenu);
			$ptr = fopen($fichier, "w");
			fwrite($ptr, $contenu);
			
			
			$file = fopen($fichier, "a");
			$txt = "\r\n";
			fputs ($file, $txt);
			fclose ($file);
		}
	}
		
?>