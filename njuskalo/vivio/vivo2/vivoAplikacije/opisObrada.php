<?php

include ( '../vivoFunkcije/baza.php' );
mysql_query ("set names utf8");

ini_set('display_errors','0');
ini_set('display_startup_errors','0');
error_reporting (0);

if (get_magic_quotes_gpc()) {
    function stripslashes_gpc(&$value)
    {
        $value = stripslashes($value);
    }
    array_walk_recursive($_GET, 'stripslashes_gpc');
    array_walk_recursive($_POST, 'stripslashes_gpc');
    array_walk_recursive($_COOKIE, 'stripslashes_gpc');
    array_walk_recursive($_REQUEST, 'stripslashes_gpc');
}

/*
foreach ( $_POST as $key => $value ) {

    echo $key,' - ',$value,' <strong> <> </strong>';

}
*/
$id = $_POST['id'];
$tabela = $_POST['tabela'];
$opis = $_POST['opis'];
$jezik = $_POST['jezik'];

// provjeri jel postoji opis za tu nekretninu  /
// na jeziku koji je poslan                    /

$u = "SELECT id FROM tekstovi WHERE spojenoNa = '".$tabela."-".$id."' AND jezik = '".$jezik."'";
$o = mysql_query ( $u );
$opisId = mysql_result ( $o, 0 );

// HTMLpurifier, treba rješiti problem ubacivanja iz Worda   /
// prvo ukljuèiti potrebne datoteke   /

     $opis = nl2br($opis);
     $opis = str_replace("\n", "", $opis);
     $opis = str_replace("\r", "", $opis);
     $newstring = preg_replace("/[\n\r]/","",$subject);
     require_once '../vivoFunkcije/htmlpurifier/library/HTMLPurifier.auto.php';
     $config = HTMLPurifier_Config::createDefault();
     $config->set('HTML.Doctype', 'HTML 4.01 Transitional'); // replace with your doctype
     $purifier = new HTMLPurifier($config);

     $clean = $purifier->purify($opis);
     $opis = mysql_real_escape_string($clean);


// ako postoji, UPDATE sa poslanim  /
if ( $opisId ) {
    $noviUpit = "UPDATE tekstovi SET tekst = '".$opis."' WHERE id = '".$opisId."'";
} else {
    $noviUpit = "INSERT INTO tekstovi ( tekst, spojenoNa, jezik ) VALUES ( '".$opis."', '".$tabela."-".$id."', '".$jezik."' )";
}
mysql_query ( $noviUpit );
$opis = stripslashes($opis);
?>

<form id="opisTekst" name="opisTekst" method="POST">

    <div id="opisTekstArea">

<?php

$u = "SELECT naziv FROM jezici WHERE kratica = '".$jezik."'";
$o = mysql_query ( $u );
$je = mysql_result ( $o, 0 );

?>

                aktivni jezik: <strong><?php echo $je; ?></strong>

                <textarea name="opis" class="dodajEditor"><?php echo $opis; ?></textarea>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="tabela" value="<?php echo $tabela; ?>">
                <input type="hidden" name="jezik" value="<?php echo $jezik; ?>">

            </div>

        <button class="greenButton">unesi opis</button>

        </form>