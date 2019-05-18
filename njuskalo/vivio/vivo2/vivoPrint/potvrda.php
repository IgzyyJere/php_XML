<?php

//odredi predložak i tabelu

session_start();  

$upit = "SELECT stranica FROM `kontroler` WHERE idsess='".session_id()."'";
$odgovori = mysql_query ( $upit );
$tabla = mysql_fetch_assoc ( $odgovori );

switch ( $tabla['stranica'] ) {
    
      case 'stan_prodaja':
      $tabela = "vivostanovi";
      $predlozak = "potvrda_prodaja";
      break;      
      
      case 'stan_najam':      
      $tabela = "vivostanovi";
      $predlozak = "potvrda_najam";
      break; 
      
      case 'posl_prodaja':
      $tabela = "vivoposlovni";
      $predlozak = "potvrda_prodaja";
      break;       
      
      case 'posl_najam':
      $tabela = "vivoposlovni";
      $predlozak = "potvrda_zakup";
      break; 
      
      case 'kuce_prodaja':
      $tabela = "vivokuce";
      $predlozak = "potvrda_prodaja";
      break; 
      
      case 'kuce_najam':
      $tabela = "vivokuce";
      $predlozak = "potvrda_najam";
      break; 
      
      case 'zem_prodaja':
      $tabela = "vivozemljista";
      $predlozak = "potvrda_prodaja";
      break;       

      case 'zem_najam':
      $tabela = "vivozemljista";
      $predlozak = "potvrda_najam";
      break; 
      
      case 'ost_prodaja':
      $tabela = "vivoostalo";
      $predlozak = "potvrda_prodaja";
      break;       
      
      case 'ost_najam':
      $tabela = "vivoostalo";
      $predlozak = "potvrda_najam";
      break; 
      
      case 'novo_objekti':
      $tabela = "novoobjekti";
      $predlozak = "potvrda_prodaja";
      break; 
      
      case 'novo_stanovi':
      $tabela = "novostanovi";
      $predlozak = "potvrda_prodaja";
      break; 
      
      case 'novo_poslovni':
      $tabela = "novoposlovni";
      $predlozak = "potvrda_prodaja";
      break; 
      
      case "kratki_najam":
      $tabela = "kratkinajam";
      $predlozak = "potvrda_najam";
      break; 
      
}

$upit = "SELECT * FROM ".$tabela." WHERE id = '".$_GET['id']."'";
$odgovori = mysql_query ( $upit );
$podaci = mysql_fetch_assoc ( $odgovori );

include ( $predlozak.".php" );

session_write_close ();  

?>