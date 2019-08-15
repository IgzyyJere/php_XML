<?php

//odredi predložak i tabelu

session_start();  

$upit = "SELECT stranica FROM `kontroler` WHERE idsess='".session_id()."'";
$odgovori = mysql_query ( $upit );
$tabla = mysql_fetch_assoc ( $odgovori );

switch ( $tabla['stranica'] ) {
    
      case 'stan_prodaja':
      $tabela = "vivostanovi";
      $predlozak = "prodaja_stanovi";
      break;      
      
      case 'stan_najam':      
      $tabela = "vivostanovi";
      $predlozak = "najam_stanovi";
      break; 
      
      case 'posl_prodaja':
      $tabela = "vivoposlovni";
      $predlozak = "prodaja_poslovni";
      break;       
      
      case 'posl_najam':
      $tabela = "vivoposlovni";
      $predlozak = "najam_poslovni";
      break; 
      
      case 'kuce_prodaja':
      $tabela = "vivokuce";
      $predlozak = "prodaja_kuce";
      break; 
      
      case 'kuce_najam':
      $tabela = "vivokuce";
      $predlozak = "najam_kuce";
      break; 
      
      case 'zem_prodaja':
      $tabela = "vivozemljista";
      $predlozak = "prodaja_zemljista";
      break;       

      case 'zem_najam':
      $tabela = "vivozemljista";
      $predlozak = "najam_zemljista";
      break; 
      
      case 'ost_prodaja':
      $tabela = "vivoostalo";
      $predlozak = "prodaja_ostalo";
      break;       
      
      case 'ost_najam':
      $tabela = "vivoostalo";
      $predlozak = "najam_ostalo";
      break; 
      
      case 'novo_objekti':
      $tabela = "novoobjekti";
      $predlozak = "novo_objekti";
      break; 
      
      case 'novo_stanovi':
      $tabela = "novostanovi";
      $predlozak = "novo_stanovi";
      break; 
      
      case 'novo_poslovni':
      $tabela = "novo_poslovni";
      $predlozak = "novo_poslovni";
      break; 
      
      case "kratki_najam":
      $tabela = "kratkinajam";
      $predlozak = "kratki_najam_stanovi";
      break; 
      
}

$upit = "SELECT * FROM ".$tabela." WHERE id = '".$_GET['id']."'";
$odgovori = mysql_query ( $upit );
$podaci = mysql_fetch_assoc ( $odgovori );

include ( $predlozak.".php" );

session_write_close ();  

?>