<?php

/*
ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting (E_ALL ^ E_NOTICE);
*/
include ( '../vivoFunkcije/baza.php' );
mysql_query ("set names utf8");


if(isset($_FILES["myfile"])) {

	$error =$_FILES["myfile"]["error"];
	if(!is_array($_FILES["myfile"]["name"])) //single file
	{

 	 	$datoteka = $_FILES["myfile"]["name"];
 		move_uploaded_file($_FILES["myfile"]["tmp_name"], "../../upload/".$datoteka) or die ('Greška kod slanja u /upload');
    	if ( ekstenzijaDatoteke($datoteka) == "jpg" OR ekstenzijaDatoteke($datoteka) == "jpeg" ) {
    		include ( "uploadObradaSlika.php" );
		}

		if ( ekstenzijaDatoteke($datoteka) == "pdf" ) {
    		include ( "uploadObradaDokumenata.php" );
		}

		if ( ekstenzijaDatoteke($datoteka) == "xls" OR ekstenzijaDatoteke($datoteka) == "xlsx") {
    		include ( "uploadObradaDokumenata.php" );
		}

		if ( ekstenzijaDatoteke($datoteka) == "doc" OR ekstenzijaDatoteke($datoteka) == "docx" ) {
    		include ( "uploadObradaDokumenata.php" );
		}

		if ( ekstenzijaDatoteke($datoteka) == "ppt" OR ekstenzijaDatoteke($datoteka) == "pptx" ) {
    		include ( "uploadObradaDokumenata.php" );
		}

		if ( ekstenzijaDatoteke($datoteka) == "flv" ) {
    		include ( "uploadObradaVideo.php" );
		}
	} else  //Multiple files, file[]
	{
	  $fileCount = count($_FILES["myfile"]["name"]);
	  for($i=0; $i < $fileCount; $i++)
	  {

	  	$datoteka = $_FILES["myfile"]["name"][$i];
	  	//check if there is an image with the same name as the one uploading
		move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],"../../upload/".$datoteka);
	  	if ( ekstenzijaDatoteke($datoteka) == "jpg" OR ekstenzijaDatoteke($datoteka) == "jpeg" ) {
    		include ( "uploadObradaSlika.php" );
		}

		if ( ekstenzijaDatoteke($datoteka) == "pdf" ) {
    		include ( "uploadObradaDokumenata.php" );
		}

		if ( ekstenzijaDatoteke($datoteka) == "xls" OR ekstenzijaDatoteke($datoteka) == "xlsx") {
    		include ( "uploadObradaDokumenata.php" );
		}

		if ( ekstenzijaDatoteke($datoteka) == "doc" OR ekstenzijaDatoteke($datoteka) == "docx" ) {
    		include ( "uploadObradaDokumenata.php" );
		}

		if ( ekstenzijaDatoteke($datoteka) == "ppt" OR ekstenzijaDatoteke($datoteka) == "pptx" ) {
    		include ( "uploadObradaDokumenata.php" );
		}

		if ( ekstenzijaDatoteke($datoteka) == "flv" ) {
    		include ( "uploadObradaVideo.php" );
		}
	  }
	
	}

}


// funkcije

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

?>