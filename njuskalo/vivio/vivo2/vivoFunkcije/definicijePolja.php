<?php

function dajPolje ( $naziv ) 
{

switch ( $naziv ){
    
    case "Stan u":
    case "stanU":
    $vrati = array ( 0 => "-", 1 => "Privatnoj kući", 2 => "Urbanoj vili", 3 => "Stambenoj zgradi", 4 => "Stambeno poslovnoj zgradi" );
    break;
    
    case "Kat":
    case "kat":
    case "katValue":
    $vrati = array ( 0 => "-", 1 => "Suteren", 2 => "Prizemlje", 3 => "Visoko prizemlje", 4 => "Razizemlje", 5 => "Potkrovlje");
    break;
    
    case "Broj etaža":
    case "brojEtaza":
    $vrati = array ( 0 => "-", 1 => "1", 2 => "2", 3 => "3" );
    break;

    case "Grijanje":
    case "grijanje":
    $vrati = array ( 0 => "Nema grijanje", 1 => "Centralno, toplana", 2 => "Plinsko etažno", 3 => "Etažno", 4 => "Kotlovnica", 5 => "Plinska peć", 6 => "Klasično grijanje", 7 => "Radijatori na struju" ); 
    break;
    
    case "Stanje":
    case "stanje":
    $vrati = array ( 0 => "-", 1 => "Potrebna adaptacija", 2 => "Prosječno", 3 => "Dobro", 4 => "Novouređeno", 5 => "Novogradnja", 6 => "Luksuzno", 7=> "Roh bau" ); 
    break;
    
    case "Godina izgradnje":
    case "godinaIzgradnje":
    case "godinaIzgradnjeOption":
    $vrati = array ( 0 => "-", 1 => "Starogradnja", 2 => "Novogradnja" );
    break;
    
    case "Useljenje":
    case "useljenje":
	case "Mogućnost useljenja":
    $vrati = array (  1 => "Odmah po isplati", 2 => "Po dogovoru");     
    break;
    
    case "Stolarija":
    case "stolarija":
    $vrati = array ( 0 => "-", 1 => "PVC", 2 => "ALU", 3 => "Drvena", 4 => "Kombinacija");  
    break;
    
    case "Namještaj":
    case "namjestaj":
    $vrati = array ( 0 => "Ne", 1 => "U cijeni", 2 => "Po dogovoru", 3 => "Po dogovoru uz nadoplatu");  
    break;
    
    case "Šupa":
    case "supa":
    $vrati = array ( 0 => "Nema", 1 => "Podrum", 2 => "Prizemlje", 3 => "Tavan", 4 => "Potkrovlje", 5 => "U stanu", 6 => "U kući", 7 => "U objektu" );
    break;
    
    case "Parking":
    case "parking":
    $vrati = array ( 0 => "Nema", 1 => "Jedno mjesto", 2 => "Dva mjesta", 3 => "Više mjesta", 4 => "Niz ulicu", 5 => "Oko zgrade", 6 => "Garažno mjesto");
    break;
    
    case "Vlasnički list":
    case "vlasnickiList":
    $vrati = array ( 0 => "-", 1 => "Uredan", 2 => "Uredan s teretom", 3 => "U postupku");  
    break;
    
    case "Građevinska dozvola":
    case "gradevinska":
    $vrati = array ( 0 => "Nema (ne vidi se)", 1 => "Ima", 2 => "U postupku", 3 => "Nema");
    break;
    
    case "Uporabna dozvola":
    case "uporabna":
    $vrati = array ( 0 => "Nema (ne vidi se)", 1 => "Ima", 2 => "U postupku", 3 => "Nema"); 
    break;
    
    case "Garaža":
    case "garaza":
    case "garazaOption":
    $vrati = array ( 0 => "Nema", 1 => "Ima", 2 => "Moguće uz nadoplatu" );
    break;
    
    case "Prijevoz":
    case "prijevoz":
    $vrati = array ( 0 => "-----", 1 => "Zona tramvaja", 2 => "Autobus", 3 => "Vlak", 4 => "Samo osobni prijevoz" );
    break;
    
    case "Oprema":
    case "oprema":
    $vrati = array ( 0 => "-", 1 => "Nenamješteno", 2 => "Polunamješteno", 3 => "Namješteno", 4 => "Luksuzno", 5 => "Po dogovoru" ); 
    break;
    
    case "Plaćanje najma":
    case "placanjeNajma":
    $vrati = array ( 0 => "-", 1 => "mjesečno", 2 => "tromjesečno", 3 => "polugodišnje", 4 => "godišnje" ); 
    break;
    
    case "Tip objekta":
    case "tipObjekt":
    $vrati = array ( 0 => "-", 1 => "Stambeno-poslovna", 2 => "Samostojeća", 3 => "Kuća u nizu", 4 => "Dvojni objekt", 5 => "Roh-bau", 6 => "Vikendica" );  
    break;
    
    case "Vrsta zemljišta":
    case "vrstaZemljista":
    $vrati = array ( 0 => "-", 1 => "Građevinsko", 2 => "Poljoprivredno", 3 => "Zelena zona", 4=> "Kombinacija", 5=>"Ostalo" ); 
    break;
    
    case "Lokacijska dozvola":
    case "lokacijska":
    $vrati = array ( 0 => "Ne", 1 => "da", 2 => "U postupku");   
    break;
    
    case "Broj etaža kuće":
    case "brojEtazaKuca":
    $vrati = array ( 0 => "-", 1 => "Prizemnica", 2 => "Visoka prizemnica", 3 => "Katnica", 4 => "Dvokatnica", 5 => "Višekatnica" ) ;
    break;
    
    case "Pristup":
    case "pristup":
    $vrati = array ( 0 => "-", 1 => "Osobni automobil", 2 => "Kombi", 3 => "Kamion" ); 
    break;
    
    case "Vrsta pos. prostora":
	case "Vrsta poslovnog prostora";
    case "vrstaPP":
    $vrati = array ( 0 => "-", 1 => "ured", 2 => "ulični lokal", 3 => "trgovina", 4 => "kafić", 5 => "tihi obrt", 6 => "proizvodnja", 7 => "mini hotel", 8 => "skladište", 9 => "restoran", 10 => "club", 11 => "hala", 12 => "kozmetički salon" ); 
    break;
    
    case "ppU":
    case "Pos. prostor u":
    case "Poslovni prostor u":
    $vrati = array ( 0 => "-", 1 => "Privatnoj kući", 2 => "Poslovnoj zgradi", 3 => "Stambenoj zgradi", 4 => "Stambeno poslovnoj zgradi" );
    break;

    case "fazaGradnje":
    case "Faza izgradnje":
    $vrati = array ( 0 => "-", 1 => "U pripremi", 2 => "U izgradnji", 3 => "Useljivo" );
    break;

    case "statusProdaje":
    case "Status prodaje":
    $vrati = array ( 0 => "-", 1 => "za prodaju", 2 => "rezerviran", 3 => "prodan" );
    break;

    case "keramika":
    case "Keramika":
    $vrati = array ( 0 => "-", 1 => "Ekstra klasa", 2 => "Prva klasa", 3 => "Druga klasa" );
    break;

    case "sanitarnaOprema":
    case "Sanitarna oprema":
    $vrati = array ( 0 => "-", 1 => "Ekstra klasa", 2 => "Prva klasa", 3 => "Druga klasa" );
    break;

    case "sanitarnaArmatura":
    case "Sanitarna armatura":
    $vrati = array ( 0 => "-", 1 => "Ekstra klasa", 2 => "Prva klasa", 3 => "Druga klasa" );
    break;

    case "parket":
    case "Parket":
    $vrati = array ( 0 => "-", 1 => "Ekstra klasa", 2 => "Prva klasa", 3 => "Druga klasa" );
    break;

    case "opremaStanova":
    case "Oprema stanova":
    $vrati = array ( 0 => "-", 1 => "Vrhunska kvaliteta", 2 => "Visoka kvaliteta", 3 => "Srednja kvaliteta", 4 => "Niska kvaliteta" );
    break;

    case "opremaPoslovnih":
    case "Oprema poslovnih prostora":
    $vrati = array ( 0 => "-", 1 => "Vrhunska kvaliteta", 2 => "Visoka kvaliteta", 3 => "Srednja kvaliteta", 4 => "Niska kvaliteta" );
    break;

    case "vrstaGalerije":
    $vrati = array ( 0 => "-", 1 => "Vizualizacija", 2 => "Stanje na gradilištu", 3 => "Lokacija" );
    break;

    case "polog":
    case "Polog":
    $vrati = array ( 0 => "Nema", 1 => "Ima", 2 => "Po dogovoru" );
    break;

    case "vr1":
    case "vr2":
    case "vr3":
    case "vr4":
    $vrati = array ( 0 => "Nije određeno", 1 => "Euro", 2 =>"m2" );
    break;

    case "poKvadraturi":
    $vrati = array ( 1 => "Manje", 2 => "Veće" );
    break;

    case "poVrijednosti":
    $vrati = array ( 1 => "Jeftinije", 2 => "Skuplje" );
    break;

    case "balkonOption":
    case "loggiaOption":
    case "vrtOption":
    case "terasaOption":
    case "sirinaPristupaOption":
    case "balkon":
    case "loggia":
    case "vrt":
    case "terasa":
    case "Balkon":
    case "Vrt":
    case "Loggia":
    case "Terasa":
	case "Laminat":
    case "laminat":
    case "izlog":
    case "Izlog":
    case "Protuprovalna vrata";
    case "Pogled na more":
    case "sirinaPristupa":
    $vrati = array ( 0 => "Nema", 1 => "Ima");
    break;
    
    case "Alarm":
    case "alarm":
    case "Klima": 
    case "Klima uređaj":
    case "klima":
    case "kabel":
	case "Kabel":
    case "Kabelski priključak":
    case "Satelitski priključak":
    case "satelit":
    case "Satelit":
    case "Internetski priključak":
    case "internet":
    case "Internet":
    case "telefon":
    case "Telefonski priključak":
    case "Osnovno posuđe":
    case "osPosude":
    case "perilica":
    case "Perilica rublja":
    case "Perilica suđa":
    case "perilica posuđa":
    case "perilicaSuda":
	case "Perilica posuđa":
    case "mozdaPoslovni":
    case "skladiste":
    case "Skladište":
    case "Računalna mreža":
    case "Mreža":
    case "mreza":
    $vrati = array ( 0 => "Nema", 1 => "Ima", 2 => "Moguće");
    break;
    
    
}

return $vrati;

}

       
?>
