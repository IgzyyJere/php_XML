<?php

function dajImePolja ( $naziv ) 
{

switch ( $naziv ){
    
    case "stanU":
    $vrati = "Stan u";
    break;
    
    case "Kat":
    case "kat":
    case "katOption":
    case "katValue":
    $vrati = "Kat";
    break;
    
    case "brojEtaza":
    $vrati = "Broj etaža";
    break;
    
    case "grijanje":
    $vrati = "Grijanje"; 
    break;

    case "stanje":
    $vrati = "Stanje";
    break;
    
    case "Godina izgradnje":
    case "godinaIzgradnje":
    case "godinaIzgradnjeOption":
    $vrati = "Godina izgradnje";
    break;
    
    case "useljenje":
    $vrati = "Useljenje";   
    break;
    
    case "stolarija":
    $vrati = "Stolarija";
    break;
    
    case "namjestaj":
    $vrati = "Namještaj";  
    break;
    
    case "supa":
    $vrati = "Šupa";
    break;
    
    case "parking":
    $vrati = "Parking";
    break;
    
    case "vlasnickiList":
    $vrati = "Vlasnički list";  
    break;
    
    case "gradevinska":
    $vrati = "Građevinska dozvola";
    break;
    
    case "uporabna":
    $vrati = "Uporabna dozvola"; 
    break;
    
    case "garaza":
    $vrati = "Garaža";
    break;
    
    case "prijevoz":
    $vrati = "Prijevoz";
    break;
    
    case "oprema":
    $vrati = "Oprema";
    break;
    
    case "placanjeNajma":
    $vrati = "Plaćanje najma"; 
    break;
    
    case "tipObjekt":
    $vrati = "Tip objekta";  
    break;
    
    case "vrstaZemljista":
    $vrati = "Vrsta zemljišta";
    break;
    
    case "lokacijska":
    $vrati = "Lokacijska dozvola"; 
    break;
    
    case "brojEtazaKuca":
    $vrati = "Broj etaža";
    break;
    
    case "pristup":
    $vrati = "Pristup";
    break;
    
    case "vrstaPP":
    $vrati = "Vrsta pos. prostora";
    break;
    
    case "balkonOption":
    $vrati = "Balkon";
    break;

    case "loggiaOption":
    $vrati = "Loggia";
    break;
    
    case "vrtOption":
    $vrati = "Vrt";
    break;
    
    case "terasaOption":
    $vrati = "Terasa";
    break;
    
    case "sirinaPristupaOption":
    $vrati = "Širina pristupnog puta"; 
    break;
    
    case "alarm":
    $vrati = "Alarm";
    break;
    
    case "klima":
    $vrati = "Klima";
    break;
    
    case "kabel":
    $vrati = "Kabelski priključak";
    break;
    
    case "satelit":
    $vrati = "Satelitski priključak";
    break;
    
    case "internet":
    $vrati = "Internet";
    break;
    
    case "telefon": 
    $vrati = "Telefonski priključak";
    break;
    
    case "osPosude":
    $vrati = "Osnovno posuđe";
    break;

    case "brojSoba":
    $vrati = "Broj soba";
    break;
    
    case "perilica":
    $vrati = "Preilica rublja";
    break;
    
    case "perilicaSuda":
    $vrati = "Perilica suđa";
    break;
    
    case "mozdaPoslovni":
    $vrati = "Može poslovni";
    break;
    
    case "skladiste":
    $vrati = "Skladište";
    break;
    
    case "mreza":
    $vrati = "Mreža";
    break;
    
    case "morePogled":
    $vrati = "Pogled na more";
    break;
    
    case "moreUdaljenost":
    $vrati = "Udaljenost od mora";
    break;
    
}

return $vrati;

}

       
?>
