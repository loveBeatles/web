<?php
session_start();
include('funkcie.php');
hlavicka('');
include('navigacia.php');
include('akcie.php');
include('db.php');

?>
<section>
<?php
if(isset($_POST['odhlas'])){
	$_SESSION['uid'] = null;
	$_SESSION['username'] = null;
	$_SESSION['meno'] = null;
	$_SESSION['priezvisko'] = null;
	$_SESSION['admin'] = null;
}
if(isset($_POST['submit']) && isset($_POST['username']) && isset($_POST['heslo']) && $user = over_pouzivatela($mysqli, $_POST['username'], $_POST['heslo'])){
	$_SESSION['uid'] = $user['uid'];
	$_SESSION['username'] = $user['username'];
	$_SESSION['meno'] = $user['meno'];
	$_SESSION['priezvisko'] = $user['priezvisko'];
	$_SESSION['admin'] = $user['admin'];
}



if (isset($_SESSION['uid'])){
?>
<p>Vitaj v systéme, <?php echo $_SESSION['meno'] . ' ' . $_SESSION['priezvisko']?></p>
<form method="post"> 
  <p> 
    <input name="odhlas" type="submit" id="odhlas" value="Odhlás ma"> 
  </p> 
</form> 
<?php
}
else{
?>
<form method="post">
<fieldset>
	<legend>Prihlásenie</legend>
	<label for="username">prihlasovacie meno:</label>
	<input name="username" type="text" id="username" value="" size="20" maxlength="20">
	<br>
	<label for="heslo">heslo:</label>
	<input name="heslo" type="password" id="heslo" size="20" maxlength="20">
	<br>
</fieldset>
<p><input name="submit" type="submit" id="submit" value="Prihlás"></p>
</form>

<?php } ?>


</section>
<?php
include('pata.php');
?>
