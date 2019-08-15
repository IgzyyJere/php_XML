<form id="opisTekst" name="opisTekst" method="POST">

    <div id="opisTekstArea">

<?php

ini_set('display_errors','0');
ini_set('display_startup_errors','0');
error_reporting (0);

if ( $_POST['jezik'] ) {
    $jezik = $_POST['jezik'];
    include ( '../vivoFunkcije/baza.php' );
    mysql_query ("set names utf8");
} else {
    if ( isset($osnovniJezikOpisa)) {
        $jezik = $osnovniJezikOpisa;
    } else {
    $jezik = "hr";
    }
}

if ( $_POST['tabela'] ) {
    $tabela = $_POST['tabela'];
}

if ( $_POST['id'] ) {
    $id = $_POST['id'];
}

$u = "SELECT naziv FROM jezici WHERE kratica = '".$jezik."'";
$o = mysql_query ( $u );
$je = mysql_result ( $o, 0 );

$u = "SELECT tekst FROM tekstovi WHERE spojenoNa = '".$tabela."-".$id."' AND jezik = '".$jezik."'";
$o = mysql_query ( $u );
$opis = mysql_result ( $o, 0 );

?>

                aktivni jezik: <strong><?php echo $je; ?></strong>

                <textarea name="opis" class="dodajEditor"><?php echo $opis; ?></textarea>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="tabela" value="<?php echo $tabela; ?>">
                <input type="hidden" name="jezik" value="<?php echo $jezik; ?>">

            </div>

        <button class="greenButton">unesi opis</button>

        </form>
