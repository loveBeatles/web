<?php
date_default_timezone_set('Europe/Bratislava');

function vypis_select($min, $max, $oznac = -1) {
	for($i = $min; $i <= $max; $i++) {
		echo "<option value='$i'";
		if ($i == $oznac) echo ' selected';
		echo ">$i</option>\n";
	}
}

function hlavicka($nadpis) {
?>
<!DOCTYPE html>
<html lang="sk">
<head>
<meta charset="utf-8">
<title><?php echo $nadpis; ?></title>
<link href="styly.css" rel="stylesheet">
</head>

<body>

<header>
<h1><?php echo $nadpis; ?></h1>
</header>
<?php
}

function vypis_select_kytice($pole, $oznac = -1) {
	if ($oznac === '') { 
		$oznac = -1; 
	}
	foreach($pole as $ind => $hodn) {
		echo "<option value='$ind'";
		if ($ind == $oznac) echo ' selected';
		echo ">" . $hodn['nazov'] . ' (' . $hodn['cena'] . "&euro;)</option>\n";
	}
}

/* kontroluje meno (meno a priezvisko)
vráti TRUE, ak celé meno ($m) obsahuje práve 1 medzeru, pred a za medzerou sú časti aspoň dĺžky 3 znaky
*/
function spravne_meno($m) {
	$meno = explode(' ', $m);
	return (count($meno) == 2) && (strlen($meno[0]) > 2) && (strlen($meno[1]) > 2);
}

// vráti TRUE, ak má adresa aspoň 10 znakov
function spravna_adresa($a) {
  return strlen($a) >= 10;
}

function osetri($co) {
	return trim(strip_tags($co));
}

function vypis_kosik($kvety) {
	echo '<p><strong>Obsah košíka:</strong></p>';
	echo '<p>Adresa doručenia: ' . $_SESSION["adresa"] . '</p>';
	$cena = 0;
	foreach ($_SESSION['kosik'] as $kluc => $hodn) {
		echo "<p>Kytica: <strong>{$kvety[$kluc]['nazov']}</strong> v počte kusov <strong>$hodn</strong></p>"; 
		$cena += ($kvety[$kluc]['cena'] * $hodn); 
	}
	echo '<p>Cena: ' . $cena . ' &euro;</p>';  
?>
	<form method="post">
		<p><input type="submit" name="zrus" value="Zruš obsah košíka"></p>
	</form>
<?php
}

function nazov_ok ($nazov) {
	return strlen($nazov) >= 3 && strlen($nazov) <= 100;
}

function popis_ok ($popis) {
	return strlen($popis) >= 10;
}

function cena_ok ($cena) {
	return (1 * $cena) > 0;
}

function sklad_ok ($sklad) {
	return (1 * $sklad) > 0;
}

// funkcia pridá kyticu do tabuľky - treba jej dať parameter/parametre s údajmi o kytici
function pridaj_kyticu($mysqli, $data) {
	if (!$mysqli->connect_errno) {
		$sql = "INSERT INTO kvety_tovar SET "; // definuj dopyt
		foreach ($data as $key => $val) {
			$sql .= "$key='{$mysqli->real_escape_string($val)}', ";	// apostrofy okolo hodnoty + čiarka + medzera
		}
		// odstránime poslednú čiarku s medzerou
		$sql = substr($sql, 0, -2);

//		echo "sql - $sql";
		if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
			// dopyt sa podarilo vykonať
 	    echo '<p>Kytica s kódom <strong>'. $mysqli->insert_id .'</strong> bola pridaná.</p>'. "\n"; 
		} else {
			// dopyt sa NEpodarilo vykonať!
			echo '<p class="chyba">Nastala chyba pri pridávaní kytice. (' . $mysqli->error . ')</p>';
		}
	}
}	// koniec funkcie

function vypis_kytice_uprav_zrus($mysqli) {
?>
	<p><a href="pridaj.php">pridaj kyticu</a></p>
<?php
	if (!$mysqli->connect_errno) {
		$sql = "SELECT * FROM kvety_tovar ORDER BY nazov ASC";
		if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
			// dopyt sa podarilo vykonať
			echo '<form method="post">';
			echo '<p>'; 
			while ($row = $result->fetch_assoc()) {
				echo "<input type='radio' name='kytica' value='{$row['kod']}' id='kytica{$row['kod']}'><label for='kytica{$row['kod']}'>{$row['nazov']}</label><br>\n";
			} 
			echo '</p>'; 
			echo '<p><input type="submit" name="zrus" value="Zruš kytice"></p>';
			echo '</form>';
			$result->free();
		} else {
			// NEpodarilo sa vykonať dopyt!
			echo '<p class="chyba">Nastala chyba pri získavaní údajov z DB.</p>' . "\n";
		}
	}
}

// zrusi kyticu c. $idk z tabulky kytica_tovar
function zrus_kyticu($mysqli, $idk) {
	if (!$mysqli->connect_errno) {
		$sql="DELETE FROM kvety_tovar WHERE kod='{$mysqli->real_escape_string($idk)}'"; // definuj dopyt
		if ($result = $mysqli->query($sql) && ($mysqli->affected_rows > 0)) {  // vykonaj dopyt
			// dopyt sa podarilo vykonať
			echo "<p>Kytica č. $idk bola zrušená.</p>\n"; 
  	} else {
			// NEpodarilo sa vykonať dopyt!
			echo "<p class='chyba'>Nastala chyba pri rušení kytice č. $idk.</p>\n";
    }
	}
} 	// koniec funkcie

// vypise tabulku vsetkych objednavok s odkazom na podrobne udaje o konkretnej objednavke
function vypis_objednavky($mysqli) {
	if (!$mysqli->connect_errno) {
		$sql = "SELECT * FROM kvety_objednavky ORDER BY id ASC"; // definuj dopyt
//		echo "sql = $sql <br>";
		if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
			// dopyt sa podarilo vykonať
			echo '<table>';
			echo '<tr><th>číslo objednávky</th><th>meno a priezvisko</th><th>dátum doručenia</th><th>cena</th></tr>';
			while ($row = $result->fetch_assoc()) {
				echo '<tr><td><a href="administracia.php?kod=' . $row['id'] . '">' . $row['id'] . '</a></td><td>' . $row['meno'] . '</td><td>' . $row['datum'] . '</td><td>' . $row['cena_spolu'] . '&euro;</td>';
				echo "</tr>\n";
			}
			echo '</table>';
			$result->free();
		} else {
			// dopyt sa NEpodarilo vykonať!
			echo '<p class="chyba">NEpodarilo sa získať údaje z databázy</p>';
		}
	}
}

function vypis_objednavku($mysqli, $id) {
	// do premennej $row treba priradiť jednotlivé položky objednávky $id 
	if (!$mysqli->connect_errno) {
		$id = $mysqli->real_escape_string($id);
		$sql = "SELECT * FROM kvety_objednavky, kvety_tovar WHERE kvety_objednavky.kytica = kvety_tovar.kod AND kvety_objednavky.id='$id'"; // definuj dopyt
//		echo "sql = $sql <br>";
		if (($result = $mysqli->query($sql)) && ($row = $result->fetch_assoc()) ) {  // vykonaj dopyt
			echo '<table>';
			echo "<tr><th>číslo objednávky</th><td>{$row['id']}</td></tr>\n";
			echo "<tr><th>meno a priezvisko</th><td>{$row['meno']}</td></tr>\n";
			echo "<tr><th>adresa doručenia</th><td>{$row['adresa']}</td></tr>\n";
			echo "<tr><th>názov kytice</th><td>{$row['nazov']}</td></tr>\n";
			echo "<tr><th>počet ks</th><td>{$row['pocet']}</td></tr>\n";
			echo "<tr><th>dátum doručenia</th><td>{$row['datum']}</td></tr>\n";
			echo "<tr><th>doprava</th><td>{$row['doprava']}</td></tr>\n";
			echo "<tr><th>cena</th><td>{$row['cena_spolu']} &euro;</td></tr>\n";
			echo '</table>';
		} else {
			// dopyt sa NEpodarilo vykonať!
			echo '<p class="chyba">NEpodarilo sa získať údaje z databázy, resp. objednávka neexistuje</p>' . $mysqli->error ;
		}
	}
}

function over_pouzivatela($mysqli, $username, $pass) {
    if (!$mysqli->connect_errno) {
        $u = $mysqli->real_escape_string($username);
        $h = md5($pass);

        $sql = "SELECT uid, prihlasmeno, meno, priezvisko, admin 
                FROM kvety_pouzivatelia 
                WHERE prihlasmeno = '$u' AND heslo = '$h' LIMIT 1";

        if (($result = $mysqli->query($sql)) && ($result->num_rows > 0)) {
            $row = $result->fetch_assoc();
            $result->free();
            return $row;
        }
    }
    return false;
}


function zmen_heslo($mysqli, $id, $pass) {
    if (!$mysqli->connect_errno) {
        $uid = (int)$id;
        $h = md5($pass);
        $sql = "UPDATE kvety_pouzivatelia SET heslo = '$h' WHERE uid = $uid";
        if ($mysqli->query($sql)) {
            echo '<p>Heslo bolo zmenené.</p>';
        } else {
            echo '<p class="chyba">Nastala chyba pri zmene hesla.</p>';
        }
    } else {
        echo '<p class="chyba">NEpodarilo sa spojiť s databázovým serverom!</p>';
    }
}	// koniec funkcie

// funkcia by mala dostať vstupy (prihlasovacie meno, heslo, meno, priezvisko, admin) buď samostatne, alebo ako pole
function pridaj_pouzivatela($mysqli, $prihlasmeno, $heslo, $meno, $priezvisko, $admin) {
//function pridaj_pouzivatela($mysqli, $data) {
	if (!$mysqli->connect_errno) {
		$sql = ""; // definuj dopyt
		if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
			// dopyt sa podarilo vykonať
	    echo '<p>Používateľ bol pridaný.</p>'. "\n"; 
			return true;
	 	} else {
			// NEpodarilo sa vykonať dopyt!
			echo '<p class="chyba">Nastala chyba pri pridávaní používateľa';
			// kontrola, či nenastala duplicita kľúča (číslo chyby 1062) - prihlasovacie meno už existuje
			if ($mysqli->errno == 1062) echo ' (zadané prihlasovacie meno už existuje)';
			echo '.</p>' . "\n";
			return false;
	  }
	} else {
		// NEpodarilo sa spojiť s databázovým serverom alebo vybrať databázu!
		echo '<p class="chyba">NEpodarilo sa spojiť s databázovým serverom!</p>';
		return false;
	}
}	// koniec funkcie

?>