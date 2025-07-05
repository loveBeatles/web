<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['admin'] != 1) {
    die('<p class="chyba">Prístup zamietnutý</p>');
}
include('db.php');
include('udaje.php');
include('funkcie.php');
hlavicka('Pridaj kyticu');
include('navigacia.php');
?>

<section>
<?php 
if (isset($_POST["posli"])) {
	$data = array();
	if (isset($_POST['nazov'])) $data['nazov'] = osetri($_POST['nazov']); else $data['nazov'] = '';	
	if (isset($_POST['popis'])) $data['popis'] = osetri($_POST['popis']); else $data['popis'] = '';	
	if (isset($_POST['cena'])) $data['cena'] = osetri($_POST['cena']); else $data['cena'] = 0;	
	if (isset($_POST['na_sklade'])) $data['na_sklade'] = osetri($_POST['na_sklade']); else $data['na_sklade'] = 0;	
}

if (isset($_POST['posli']) && nazov_ok($data['nazov']) && popis_ok($data['popis']) && cena_ok($data['cena']) && sklad_ok($data['na_sklade']) ) { 
	// pridanie kytice do DB
	pridaj_kyticu($mysqli, $data);  
} else { 
	if (isset ($_POST['posli'])) echo '<p class="chyba">Nezadali ste všetky údaje!</p>';
?>
	<p>Všetky údaje sú povinné</p>
	<form method="post">
		<p>
		<label for="nazov">Názov kytice (3-100 znakov):</label>
		<input type="text" name="nazov" id="nazov" size="30" value="<?php if (isset($data['nazov'])) echo $data['nazov'] ?>">
		<br>
		<label for="popis">Popis (min. 10 znakov):</label>
		<br>
		<textarea cols="40" rows="4" name="popis" id="popis"><?php if (isset($data['popis'])) echo $data['popis'] ?></textarea>
		<br>
		<label for="cena">Cena (&gt;0):</label>
		<input type="text" name="cena" id="cena" size="5" maxlength="5" value="<?php if (isset($data['cena'])) echo $data['cena'] ?>">
		<br>
		<label for="na_sklade">Počet ks na sklade (&gt;0):</label>
		<input type="text" name="na_sklade" id="na_sklade" size="5" maxlength="5" value="<?php if (isset($data['na_sklade'])) echo $data['na_sklade'] ?>"> <br>
		<input type="submit" name="posli" value="Pridaj kyticu">
		</p>  
	</form>
<?php
}

	echo '<p><strong>K tejto stránke nemáte prístup.</strong></p>'; 
	
?>	
</section>

<?php
include('pata.php');
?>
