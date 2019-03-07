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
	
    function verifieDoublonsMail($m,$con) { 
		/*renvoie vrai s'il n'existe pas de mail identique dans la base de donnée*/
		//récupère l'identifiant lié au mail
		$sql = "SELECT id FROM annuaire where mail like '".$m."'";

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
    function estConnecte() { //Renvoie si une personne est connectée ou non
        
        $roles = array("admin", "user");
		
        if (isset($_SESSION['login']) AND isset($_SESSION['droit'])) {
            
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

?>