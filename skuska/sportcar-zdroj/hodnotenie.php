<?php
session_start();
include('funkcie.php');
hlavicka('');
include('navigacia.php');
include('akcie.php');
include('db.php')
?>
<?php
if(isset($_POST['zrus'])){
	zrus_hodnotenie($mysqli, $_SESSION['uid'], $_GET['idc']);
}
if(isset($_POST['hodnot']) && $_POST['body']!='-'){
	uprav_hodnotenie($mysqli, $_SESSION['uid'], $_GET['idc'], (int)$_POST['body']);
}
?>
<section>
<?php
if(isset($_SESSION['uid'])){
?>
	 <form method="post">
			<fieldset>
			<legend>Hodnotíte</legend>
			testovacie auto: <strong><?php echo nazov_auta($mysqli, $_GET['idc']) ?></strong><br>
			<label for="body">hodnotenie:</label>
			<select id="body" name="body">
				<option value="">-</option>
<?php
vypis_select(1, 5, 0);
?>
			</select>
			<br>
			</fieldset>	
			<p><input name="hodnot" type="submit" id="hodnot" value="Pridaj / uprav hodnotenie"></p>
   </form>
	 <form method="post">
			<p><input name="zrus" type="submit" id="zrus" value="Vymaž hodnotenie"></p>
   </form>
<?php }else{echo "Musite sa prihlasit";} ?>
</section>

<?php
include('pata.php');
?>
