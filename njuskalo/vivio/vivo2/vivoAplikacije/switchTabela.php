<?php

switch ( $stranica ) {

      case 'stan_prodaja':
      case 'stan_najam':
      case 'novo_stanovi':
      $tabela = "vivostanovi";
      break;

      case 'novo_poslovni':
      case 'posl_prodaja':
      case 'posl_najam':
      $tabela = "vivoposlovni";
      break;

      case 'kuce_prodaja':
      case 'kuce_najam':
      $tabela = "vivokuce";
      break;

      case 'zem_prodaja':
      case 'zem_najam':
      $tabela = "vivozemljista";
      break;

      case 'turizam_prodaja':
      case 'turizam_najam':
      $tabela = "vivoturizam";
      break;

      case 'novo_ostalo':
      case 'ost_prodaja':
      case 'ost_najam':
      $tabela = "vivoostalo";
      break;

      case "kratki_najam":
      $tabela = "kratkinajam";
      break;

      case "novo_projekti":
        switch ( $akcija ) {

            case "unos":
            case "izmjena":
            case "prikaz":
            $tabela = "novoprojekti";
            break;

            case "dodavanjeObjekta":
            case "izmjenaObjekta":
            $tabela = "novoobjekti";
            break;


        }
      break;

      case "novo_galerije":
      $tabela = "novogalerije";
      break;

      case 'kl_stan_prodaja';
      case 'kl_stan_najam';
      $tabela = "klijentistanovi";
      break;

      case 'kl_posl_prodaja';
      case 'kl_posl_najam';
      $tabela = "klijentiposlovni";
      break;

      case 'kl_kuce_prodaja';
      case 'kl_kuce_najam';
      $tabela = "klijentikuce";
      break;

      case 'kl_zem_prodaja';
      case 'kl_zem_najam';
      $tabela = "klijentizemljista";
      break;

      case 'kl_ost_prodaja';
      case 'kl_ost_najam';
      $tabela = "klijentiostalo";
      break;

      case 'naslovna_galerija';
      $tabela = "naslovnaGalerija";
      break;

      case 'header';
      $tabela = "headerslike";
      break;

      case 'projekti';
      $tabela = "projekti";
      break;

      case 'usluge';
      $tabela = "usluge";
      break;

      case 'ekskluzivna';
      $tabela = "ekskluzivnaZastupnistva";
      break;

      case 'tekstovi';
      $tabela = "tekstovistranica";
      break;

}

?>