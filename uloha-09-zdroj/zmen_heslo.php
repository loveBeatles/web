<?php
session_start();
include('db.php');
include('udaje.php');
include('funkcie.php');

// Povoliť len prihláseným používateľom
if (!isset($_SESSION['user'])) {
    header('Location: administracia.php');
    exit;
}

// Pre vývoj: zapni chybové hlásenia
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

hlavicka('Zmena hesla');
include('navigacia.php');
?>

<section>
<?php
if (isset($_POST['submit'])) {
    $uid    = $_SESSION['user']['uid'];
    $login  = $_SESSION['user']['prihlasmeno'];
    $old    = $_POST['stare_heslo'] ?? '';
    $new    = $_POST['heslo'] ?? '';
    $new2   = $_POST['heslo2'] ?? '';
    $errors = [];

    // Overenie pôvodného hesla
    if (!over_pouzivatela($mysqli, $login, $old)) {
        $errors[] = 'Pôvodné heslo je nesprávne.';
    }

    // Overenie nového hesla
    if ($new !== $new2) {
        $errors[] = 'Nové heslá sa nezhodujú.';
    }

    if (!nazov_ok($new)) {
        $errors[] = 'Nové heslo musí mať aspoň 3 znaky.';
    }

    if (empty($errors)) {
        zmen_heslo($mysqli, $uid, $new);
    } else {
        echo '<p class="chyba"><strong>Chyby:</strong><br>' . implode('<br>', $errors) . '</p>';
    }
}
?>

    <form method="post">
        <p> 
            <label for="stare_heslo">Pôvodné heslo:</label><br>
            <input name="stare_heslo" type="password" size="30" maxlength="30" id="stare_heslo"><br> 
            
            <label for="heslo">Nové heslo:</label><br>
            <input name="heslo" type="password" size="30" maxlength="30" id="heslo"><br> 
            
            <label for="heslo2">Nové heslo (znovu):</label><br>
            <input name="heslo2" type="password" size="30" maxlength="30" id="heslo2"><br> 
        </p>
        <p>
            <input name="submit" type="submit" value="Zmeniť heslo">
        </p>
    </form>
</section>

<?php include('pata.php'); ?>
