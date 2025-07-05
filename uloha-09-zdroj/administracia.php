<?php
session_start();
include('db.php');
include('udaje.php');
include('funkcie.php');

// Zobrazuj chyby počas vývoja (odporúčané len počas testovania)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Odhlásenie
if (isset($_POST['odhlas'])) {
    session_destroy();
    header('Location: administracia.php');
    exit;
}

// Prihlásenie
if (isset($_POST['submit']) && isset($_POST['prihlasmeno']) && isset($_POST['heslo'])) {
    $user = over_pouzivatela($mysqli, $_POST['prihlasmeno'], $_POST['heslo']);
    if ($user) {
        $_SESSION['user'] = [
            'uid'         => $user['uid'],
            'prihlasmeno' => $user['prihlasmeno'],
            'meno'        => $user['meno'],
            'priezvisko'  => $user['priezvisko'],
            'admin'       => $user['admin']
        ];
    } else {
        $login_error = 'Nesprávne prihlasovacie údaje.';
    }
}

// Stav prihlásenia
$loggedIn = isset($_SESSION['user']);
$isAdmin  = $loggedIn && $_SESSION['user']['admin'] == 1;

hlavicka('Administrácia');
include('navigacia.php');
?>

<section>

<?php if (!$loggedIn): ?>
    <?php if (isset($login_error)) echo "<p class='chyba'>$login_error</p>"; ?>
    <form method="post">
        <p>
            <label for="prihlasmeno">Prihlasovacie meno:</label>
            <input name="prihlasmeno" type="text" size="30" maxlength="30" id="prihlasmeno"
                   value="<?= isset($_POST['prihlasmeno']) ? htmlspecialchars($_POST['prihlasmeno']) : '' ?>">
        </p>
        <p>
            <label for="heslo">Heslo:</label>
            <input name="heslo" type="password" size="30" maxlength="30" id="heslo">
        </p>
        <p>
            <input name="submit" type="submit" value="Prihlás ma">
        </p>
    </form>

<?php else: ?>

    <p>Vitajte v systéme <strong><?= htmlspecialchars($_SESSION['user']['meno'] . ' ' . $_SESSION['user']['priezvisko']) ?></strong>.</p>
    <p>Ak chceš, môžeš si <a href="zmen_heslo.php">zmeniť heslo</a>.</p>

    <form method="post">
        <p>
            <input name="odhlas" type="submit" value="Odhlás ma">
        </p>
    </form>

    <?php if ($isAdmin): ?>
        <p>Máš práva administrátora. Môžeš <a href="pridaj_pouzivatela.php">pridať nového používateľa</a>.</p>

        <?php
            if (isset($_POST['zrus']) && isset($_POST['kytica'])) {
                zrus_kyticu($mysqli, $_POST['kytica']);
            }

            if (isset($_GET['kod']) && ((int)$_GET['kod'] > 0)) {
                vypis_objednavku($mysqli, $_GET['kod']);
            } else {
                vypis_kytice_uprav_zrus($mysqli);
                vypis_objednavky($mysqli);
            }
        ?>

    <?php else: ?>
        <p>Nemáš práva administrátora.</p>
    <?php endif; ?>

<?php endif; ?>

</section>

<?php include('pata.php'); ?>
