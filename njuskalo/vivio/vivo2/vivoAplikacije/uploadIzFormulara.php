<?php

$session = $_POST['sID'];


/*
Uploadify v2.1.0
Release Date: August 24, 2009

Copyright (c) 2009 Ronnie Garcia, Travis Nickels

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
	$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];

	// $fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
	// $fileTypes  = str_replace(';','|',$fileTypes);
	// $typesArray = split('\|',$fileTypes);
	// $fileParts  = pathinfo($_FILES['Filedata']['name']);

	// if (in_array($fileParts['extension'],$typesArray)) {
		// Uncomment the following line if you want to make the directory if it doesn't exist
		// mkdir(str_replace('//','/',$targetPath), 0755, true);

		move_uploaded_file($tempFile,$targetFile);
	// } else {
	// 	echo 'Invalid file type.';
	// }


//                            /
//      sad kreæe obrada      /
//                            /

// prvo, odrediti ekstenziju,    /
// vrstu datoteke, pa prema tome /
// nastavit dalje                /

include ( '../vivoFunkcije/baza.php' );
mysql_query ("set names utf8");

$datoteka = strtolower ($_FILES['Filedata']['name']);

function ekstenzijaDatoteke ( $datoteka )
{
    $ime = explode ( '.',  $datoteka );
    $ekst = array_slice ( $ime, count ($ime) -1, 1);
	return strtolower($ekst[0]);
}

function generateRandomString($length = 10, $letters = '1234567890qwertyuiopasdfghjklzxcvbnm')
{
      $s = '';
      $lettersLength = strlen($letters)-1;
      for($i = 0 ; $i < $length ; $i++) {
        $s .= $letters[rand(0,$lettersLength)];
      }
      return $s;
}

if ( ekstenzijaDatoteke($datoteka) == "jpg" OR ekstenzijaDatoteke($datoteka) == "jpeg" ) {
    include ( "uploadObradaSlikaIzFormulara.php" );
}
if ( ekstenzijaDatoteke($datoteka) == "pdf" ) {
    include ( "uploadObradaDokumenataIzFormulara.php" );
}
if ( ekstenzijaDatoteke($datoteka) == "xls" OR ekstenzijaDatoteke($datoteka) == "xlsx") {
    include ( "uploadObradaDokumenataIzFormulara.php" );
}
if ( ekstenzijaDatoteke($datoteka) == "doc" OR ekstenzijaDatoteke($datoteka) == "docx" ) {
    include ( "uploadObradaDokumenataIzFormulara.php" );
}
if ( ekstenzijaDatoteke($datoteka) == "ppt" OR ekstenzijaDatoteke($datoteka) == "pptx" ) {
    include ( "uploadObradaDokumenata.php" );
}
if ( ekstenzijaDatoteke($datoteka) == "flv" ) {
    include ( "uploadObradaVideoIzFormulara.php" );
}

// vrati 1 da je sve OK
echo '1';
}
?>