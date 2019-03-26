<?php
    session_start(); //Permet de démarrer les sessions sur toutes les pages
	
	//Variables globales
	$formations_p = Array("Ecole d'ingenieur","Miage","L3","Licence professionnelle","Bachelor","Aucune","");
	$fichiersInclude = "include/";
	$serveur = "localhost";
	$login = "root";
	$mdp = "";
	
	//SMTP
	$SMTPOptions = array('ssl' => array('verify_peer' => false,'verify_peer_name' => false,'allow_self_signed' => true));
	$Host = 'smtp.gmail.com'; // Spécifier le serveur SMTP
	$SMTPAuth = true; // Activer authentication SMTP
	$Username = 'suivi.etudiant.vlz@gmail.com'; // Votre adresse email d'envoi
	$Password = '#IUT@Velizy#'; // Le mot de passe de cette adresse email
	$SMTPSecure = 'tls'; // Accepter SSL
	$Port = 587;
	$Host = 'tls://smtp.gmail.com:587';

	$From = '[IUT Velizy] Suivi des anciennes promotion'; // Personnaliser l'envoyeur

	//connexion au serveur mysql (ici localhost)
	$connexion=mysqli_connect($serveur,$login,$mdp) 
	or die("Connexion impossible au serveur $serveur pour $login");


	//nom de la base de donnees
	$bd="ANCIENS_ETUDIANTS";

	//connexion à la base de donnees
	mysqli_select_db($connexion,$bd)
	or die("Impossible d'accèder à la base de données");
	
	require_once('fonctions.php');


?>