<?php
include('db.php');

function vypis_select($zac, $kon, $default = 0) {
	for($i = $zac; $i <= $kon; $i++) {
		echo "<option value='$i'";
		if ($i == $default) echo ' selected';
		echo ">$i</option>\n";
	}
}

function hlavicka($nadpis) {
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php if ($nadpis == '') $nadpis = 'UWT sportcar'; echo $nadpis; ?></title>
<link href="styly.css" rel="stylesheet">
</head>
<body>
  <div id="dekoracne_obr">
  <img src="obrazky/m_Maserati-GT-Stradale.jpg" alt="Maserati-GranTurismo-MC-Stradale" title="Maserati-GranTurismo-MC-Stradale" height="59" width="150"> <img src="obrazky/m_Ferrari-458.jpg" alt="Ferrari-458-Italia" title="Ferrari-458-Italia" height="64" width="150"> <img src="obrazky/m_Aston-Martin.jpg" alt="Aston-Martin-DBSCoupe" title="Aston-Martin-DBSCoupe" height="63" width="150"> <img src="obrazky/m_Lamborghini-Gallardo.jpg" alt="Lamborghini-Gallardo-LP-570-4-Superleggera" title="Lamborghini-Gallardo-LP-570-4-Superleggera" height="66" width="150">
  </div>
<div id="main">
	<header>
		<h1><?php echo $nadpis; ?></h1>
	</header>
<?php
}

function over_pouzivatela($mysqli, $username, $heslo){
	if(!$mysqli->connect_errno){
		$sql = "SELECT * FROM sportcar_pouzivatelia WHERE username='$username' AND heslo=MD5('$heslo')";
		if (($result = $mysqli->query($sql)) && ($result->num_rows>0)){
			$row = $result->fetch_assoc();
			$result->free();
			return $row;
		}
		else{
			return false;
		}
	}
	else{
		return false;
	}
}

function vypis_aut($mysqli){
	if(!$mysqli->connect_errno){
		$sql = "SELECT * FROM sportcar_auta ORDER BY nazov ASC";
		if($result = $mysqli->query($sql)){
			echo "<tr><th>auto</th><th>výkon</th><th>max. rýchlosť</th><th>foto</th><th>hodnotenie</th><th>&nbsp;</th><th>&nbsp;</th></tr>";
			while($row = $result->fetch_assoc()){
				if (isset($_SESSION['uid'])){
					echo "<tr><td>" . $row['nazov'] . "</td><td>" . $row['vykon'] . "</td><td>350 km/h</td><td><img src='obrazky/" . $row['idc'] .".jpg' alt=". $row['nazov'] ." width='150'></td><td class='centruj'>" . vyhodnot_auto($mysqli, $row['idc']) . "</td><td><a href='hodnotenie.php?idc=" . $row['idc'] . "'>hodnoť</a></td><td><a href='jazda.php?idc=" . $row['idc'] . "'>rezervuj jazdu</a></td></tr>";
				}
				else{
					echo "<tr><td>" . $row['nazov'] . "</td><td>" . $row['vykon'] . "</td><td>350 km/h</td><td><img src='obrazky/" . $row['idc'] .".jpg' alt=". $row['nazov'] ." width='150'></td><td class='centruj'>" . vyhodnot_auto($mysqli, $row['idc']) . "</td></tr>";
				}
				echo "</tr>\n";
			}
			$result->free();
		}
		else{
			echo '<p class="chyba">NEpodarilo sa získať údaje z databázy</p>';
		}
	}
}

function vyhodnot_auto($mysqli, $idc){
	if(!$mysqli->connect_errno){
		$sql = "SELECT AVG(body) as hodnota FROM sportcar_hodnotenie WHERE sportcar_hodnotenie.idc = '$idc'";
		if ($result = $mysqli->query($sql)){
			if($row = $result->fetch_assoc()){
				return round($row['hodnota'], 1);
			}
			else{
				return 0;
			}
		}
		else{
			return 0;
		}
	}
}
function zrus_hodnotenie($mysqli, $uid, $idc){
	if(!$mysqli->connect_errno){
		$sql = "DELETE FROM sportcar_hodnotenie WHERE uid='$uid' AND idc='$idc'";
		if($result = $mysqli->query($sql)){
			echo "Hodnotenie bolo zrusene";
		}
		else{
			echo "Chyba zrusenia";
		}
	}
	else{
		echo "Chyba pripojenia";
	}
}
function uprav_hodnotenie($mysqli, $uid, $idc, $body){
	if(!$mysqli->connect_errno){
		$sql = "UPDATE sportcar_hodnotenie SET body='$body' WHERE uid='$uid' AND idc='$idc'";
		if($result = $mysqli->query($sql) && $mysqli->affected_rows > 0){
			echo "Hodnotenie bolo zmenene";
		}
		else{
			$sql = "INSERT INTO sportcar_hodnotenie SET body='$body', uid='$uid', idc='$idc'";
			if($result = $mysqli->query($sql)){
				echo "Hodnotenie bolo pridane";
			}
			else{
				echo "Chyba hodnotenia";
			}
		}
	}
	else{
		echo "Chyba pripojenia";
	}
}
function nazov_auta($mysqli, $idc){
	if(!$mysqli->connect_errno){
		$sql = "SELECT * FROM sportcar_auta WHERE idc='$idc'";
		if($result = $mysqli->query($sql)){
			if($row = $result->fetch_assoc()){
				return $row['nazov'];
			}
			else{
				return '-';
			}
		}
		else{
			return '-';
		}
	}
	else{
		return '-';
	}
}

function vypis_dat($mysqli, $idc){
	if(!$mysqli->connect_errno){
		$sql = "SELECT * FROM sportcar_terminy WHERE uid=0 AND idc='$idc'";
		if($result = $mysqli->query($sql)){
			while($row = $result->fetch_assoc()){
				echo "<option value=" . $row['idt'] . ">". $row['datum'] ."</option>";
			}
		}
	}
}

function rezervuj_jazdu($mysqli, $idc, $uid, $idt){
	if(!$mysqli->connect_errno){
		$sql = "UPDATE sportcar_terminy SET uid='$uid' WHERE idc='$idc' AND idt='$idt'";
		if($result = $mysqli->query($sql)){
			echo "Uspesne rezervovanie";
		}
	}
}

?>
