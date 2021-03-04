
<div class="container center">
	<div class="logo">
	  <img src="<?php echo BASE_DIR; ?>assets/images/logo-login.png" alt="Logo" class="image-res" />
	  <h1>MVC-<span>Test</span></h1>
	</div>

	<div id="login">
	  <form action="<?php echo BASE_DIR; ?>auta/login" method="post">
		<input type="text" name="email" placeholder="Email" />
		<input type="text" name="pass" placeholder="Heslo" />
		<div id="forgot"><a href="#"><span>Zabudnuté heslo</span></a></div>

		<?php 

	    //vypis chyby pokial su dostupne...
	    if(function_exists('showValidErr')){
	    	echo '<ul class="err">';
	    	echo showValidErr('<li>','</li>');
	    	echo '</ul>';
	    }
	   
		?>

		<div class="shadow"><input type="submit" name="submit" value="Prihlásiť" /></div>
	  </form>

	  <div id="about">
		<a href="#">
		  <span>Icon</span>
		  Čo je to za projekt?
		</a>
	  </div>
	</div>
</div>