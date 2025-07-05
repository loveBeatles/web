<?php
session_start();
include('funkcie.php');
hlavicka('');
include('navigacia.php');
include('akcie.php');
include('db.php');
?>
<section>

<table>
	<?php vypis_aut($mysqli); ?>
</table>

</section>
<?php
include('pata.php');
?>
