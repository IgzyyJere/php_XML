<label for="email">e-mail adresa</label>
<select name="email">
<?php

include ( "../vivoFunkcije/baza.php" );
mysql_query ("set names utf8");

$upit = "SELECT imeIPrezime, email FROM klijentistanovi
        UNION SELECT imeIPrezime, email FROM klijentiposlovni
        UNION SELECT imeIPrezime, email FROM klijentikuce
        UNION SELECT imeIPrezime, email FROM klijentizemljista
        UNION SELECT imeIPrezime, email FROM klijentiostalo
        ORDER BY imeIPrezime";
$odgovori = mysql_query ( $upit );
while ( $podaci = mysql_fetch_assoc ( $odgovori )) {
  echo '<option value="',$podaci['email'],'">',$podaci['imeIPrezime'],'</option>';
}

/*

$upit = "SELECT imeIPrezime, email FROM klijentiposlovni";
$odgovori = mysql_query ( $upit );
while ( $podaci = mysql_fetch_assoc ( $odgovori )) {
  echo '<option value="',$podaci['email'],'">',$podaci['imeIPrezime'],'</option>';
}

$upit = "SELECT imeIPrezime, email FROM klijentikuce";
$odgovori = mysql_query ( $upit );
while ( $podaci = mysql_fetch_assoc ( $odgovori )) {
  echo '<option value="',$podaci['email'],'">',$podaci['imeIPrezime'],'</option>';
}

$upit = "SELECT imeIPrezime, email FROM klijentizemljista";
$odgovori = mysql_query ( $upit );
while ( $podaci = mysql_fetch_assoc ( $odgovori )) {
  echo '<option value="',$podaci['email'],'">',$podaci['imeIPrezime'],'</option>';
}

$upit = "SELECT imeIPrezime, email FROM klijentiostalo";
$odgovori = mysql_query ( $upit );
while ( $podaci = mysql_fetch_assoc ( $odgovori )) {
  echo '<option value="',$podaci['email'],'">',$podaci['imeIPrezime'],'</option>';
}

*/

?>
</select>