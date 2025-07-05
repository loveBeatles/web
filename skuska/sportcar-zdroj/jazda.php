<?php
session_start();
include('funkcie.php');
hlavicka('');
include('navigacia.php');
include('akcie.php');
include('db.php')
?>
<section>
<?php 
if (isset($_POST['submit'])){
	rezervuj_jazdu($mysqli, $_GET['idc'], $_SESSION['uid'], $_POST['datum']);
}
?>

	 <form method="post">
			<fieldset>
			<legend>Rezervácia</legend>
			Objednávateľ: <strong><?php echo $_SESSION['meno'] . ' ' . $_SESSION['priezvisko'] ?></strong><br>
			testovacie auto: <strong><?php echo nazov_auta($mysqli, $_GET['idc']) ?></strong><br>
			<label for="datum">dátum testovania:</label>
			
			<select id="datum" name="datum">
				<?php vypis_dat($mysqli, $_GET['idc']); ?>
			</select>
			<br>
			</fieldset>	
			<p><input name="submit" type="submit" id="submit" value="Rezervuj"></p>
   </form>

</section>
<?php
include('pata.php');
?>
