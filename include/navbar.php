	<div class="jumbotrom">
		<img alt='logo UVSQ site Vélizy' src="images/uvsq_iut_velizy_CMJN.jpg" width="250px"/> 
	</div>
	
	<nav class="navbar navbar-expand-md navbar-dark">
	
		<button class="navbar-toggler mt-1 mb-1 ml-3" type="button" data-toggle="collapse" data-target="#barre_de_nav" aria-controls="#barre_de_nav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		
		<div class="collapse navbar-collapse" id="barre_de_nav">
			<ul class="navbar-nav mr-auto" >
				<li class="nav-item active">
					<a class="nav-link" href="index.php">Accueil</a>
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="annuaire.php">Annuaire</a>
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="mail.php">Envoyer un mail</a>
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="analyse.php">Analyses</a>
				</li>
				<?php if ($_SESSION['droit'] == 'admin'){ ?>
						<li class="nav-item active">
							<a class="nav-link" href="admin.php">Administration</a>
						</li>
				<?php } ?>


			</ul>
			<form class="form-inline my-2 my-lg-0 mr-3 ml-2 mb-1" action='logout.php' method='POST'>
				<label for="" class="mr-2"><?php echo $_SESSION['login']; ?></label>
				<button class="btn btn-danger my-2 my-sm-0" action='submit' name='deco' id="deco" >Déconnexion</button>
			</form>
		</div>
	</nav>