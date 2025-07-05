<?php
include('db.php');
include('udaje.php');
include('funkcie.php');
hlavicka('Ponuka');
include('navigacia.php');
?>

<section>
	<form method="post">             
		Zoradiť podľa:<br>
		<input type="radio" name="zoradit" id="zoradit_n1" value="nazov1"<?php if (isset($_POST['zoradit']) && ($_POST['zoradit'] == 'nazov1')) echo ' checked'; ?>>
		<label for="zoradit_n1">názvu (A-Z)</label><br> 
		<input type="radio" name="zoradit" id="zoradit_n2" value="nazov2"<?php if (isset($_POST['zoradit']) && ($_POST['zoradit'] == 'nazov2')) echo ' checked'; ?>>
		<label for="zoradit_n2">názvu (Z-A)</label><br> 
		<input type="radio" name="zoradit" id="zoradit_c1" value="cena1"<?php if (isset($_POST['zoradit']) && ($_POST['zoradit'] == 'cena1')) echo ' checked'; ?>>
		<label for="zoradit_c1">ceny (od najnižšej)</label><br> 
		<input type="radio" name="zoradit" id="zoradit_c2" value="cena2"<?php if (isset($_POST['zoradit']) && ($_POST['zoradit'] == 'cena2')) echo ' checked'; ?>>
		<label for="zoradit_c2">podľa ceny (od najvyššej)</label><br> 
  	<input type="submit" name="posli" value="Zoradiť">
  </form> 
<?php

if (!$mysqli->connect_errno) {
	$sql = "SELECT * FROM kvety_tovar WHERE na_sklade>30 "; // definuj dopyt
	if (isset($_POST['zoradit']) && ($_POST['zoradit'] == 'nazov1')) $sql .= 'ORDER BY nazov ASC'; 
	elseif (isset($_POST['zoradit']) && ($_POST['zoradit'] == 'nazov2')) $sql .= 'ORDER BY nazov DESC'; 
	elseif (isset($_POST['zoradit']) && ($_POST['zoradit'] == 'cena1')) $sql .= 'ORDER BY cena ASC'; 
	else $sql .= 'ORDER BY cena DESC'; // definuj dopyt
	if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
		while ($row = $result->fetch_assoc()) {
			echo '<h2>' . $row['nazov'];
			echo ' (' . $row['cena'] . "&euro;)</h2>\n";
			echo '<p>' . $row['popis'] . "</p>\n";
		}
		$result->free();
	} elseif ($mysqli->errno) {
		echo '<p class="chyba">NEpodarilo sa vykonať dopyt! (' . $mysqli->error . ')</p>';
	}
}

?>
</section>

<?php
include('pata.php');
?>
