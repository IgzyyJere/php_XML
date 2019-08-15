<?
//    ova skripta prikazuje tečajnu listu za dani dan
//    tako da se spoji na službenu stranicu HNB-a i tamo uzima podatke
//    o listi




error_reporting(0);
// file u kojem se nalazi tečajna lista
$danas=date("dmy");
$filof="http://www.hnb.hr/tecajn/f".$danas.".dat";

if ( !file($filof) ) {

    for ( $i = 0; $i < 10; $i ++ ) {
     
    $danas =  date ("dmy", strtotime ("-$i days"));
    $filof="http://www.hnb.hr/tecajn/f".$danas.".dat";

    if ( file($filof) ) {
        
        $fajl=file($filof);
        break;
        
    }
    
    }

} else {
    
 
    $fajl=file($filof);
    
}

// vađenje datuma
// 0 => dan
// 1 => mjesec
// 2 =>godina

// vađenje datuma sa file iz liste
$datum["dan"]=substr($fajl[0], 3, 2); 
$datum["mjesec"]=substr($fajl[0], 5, 2);
$datum["godina"]=substr($fajl[0], 7, 4);




// broj valuta tečajne liste
$broj_valuta=substr($fajl[0],19,2);




// popis šifri valuti

/*
Australija      036  AUD
Kanada          124  CAD
Češka Repub.    203  CZK
Danska          208  DKK
Mađarska        348  HUF
Japan           392  JPY
Norveška        578  NOK
Slovačka Rep.   703  SKK
Slovenija       705  SIT
Švedska         752  SEK
Švicarska       756  CHF
Vel. Britanija  826  GBP
SAD             840  USD
EMU             978  EUR
Poljska         985  PLN
*/


// valute koje me zanimaju
$valute=array(
    0 => "978EUR001"
);

$i=0;

foreach ($fajl as $file_key=>$file_value){
    foreach ($valute as $valute_key=>$valute_value){
    
        if ($trazeni=strstr($file_value,$valute_value)){
            $nadene_linije[$i]=explode("  ",$file_value);
            //echo "<b>nasao</b> u kljucu $file_key<br>";
            
            // pronađena je valuta, izbacivanje nepotrebnih elmenata niza
            // i spremanje u sređeni niz
            
            
            //  0 => šifra valute
            //  1 => ime valute
            //  2 => jedinica
            //  3 => kupovni za devize
            //  4 => srednji za devize
            //  5 => prodajni za devize
            
            $j=0;
            foreach ($nadene_linije[$i] as $nadene_key=>$nadene_value){
                if (!$nadene_value==""){
                 switch ($j){
                     case 0:
                        $tecajna[$i][0]=substr($nadene_value,0,3);
                        $tecajna[$i][1]=substr($nadene_value,3,3);
                        $tecajna[$i][2]=substr($nadene_value,6,3);
                    break;
                    case 1:
                        $tecajna[$i][3]=$nadene_value;
                    break;
                    case 2:
                         $tecajna[$i][4]=$nadene_value;
                    break;
                    case 3:
                        $tecajna[$i][5]=$nadene_value;
                        $i++;
                    break;
                 }
                 $j++;
                }
            }
        }
    }

}

function ispisiListu($lista){
    global $datum;
    ?>
    <table width="250" border="0" cellspacing="2" cellpadding="2" align="center">
        <tr>
            <td colspan="5" align="center"><b>Tečajna lista za <?=$datum['dan'] . ".".$datum['mjesec'] . ".".$datum['godina'];?></b></td>
        </tr>
        <tr>
            <td width="15%" align="center">Valuta</td>
            <td width="15%" align="center">Jed</td>
            <td width="20%" align="center">Kupovni</td>
            <td width="20%" align="center">Srednji</td>
            <td width="20%" align="center">Prodajni</td>
        </tr>
    <?
      foreach ($lista as $key=>$value){
        echo "<tr>\n";
            ?>
            <td width="15%" align="center"><?=$value[1]?></td>
            <td width="15%" align="center"><?=$value[2]?></td>
            <td width="20%" align="center"><?=$value[3]?></td>
            <td width="20%" align="center"><?=$value[4]?></td>
            <td width="20%" align="center"><?=$value[5]?></td>
            <?
        echo "</tr>\n";
       }
    
    ?>
    <tr>
        <td colspan="5" align="center">Sve vrijednosti su izražene u Kunama</td>
    </tr>
    </table><br /><br />
    <?
}

ispisiListu($tecajna);

if ( !$fajl ) {
    
        echo '<br /><b>Hrvatska Narodna Banka još nije izdala tečajnu listu za današnji dan.<br />Probajte kasnije.</b><br /><br />';
        
}
  
echo '<div id="izmjenaTecaja">';

if ( $_POST['tecaj'] ) {
    $upit = "UPDATE tecaj SET tecaj = '".$_POST['tecaj']."'";
    mysql_query ( $upit );
}


$upit = "SELECT tecaj FROM tecaj";
$odgovori = mysql_query ( $upit );
$tecaj = mysql_fetch_assoc( $odgovori );

echo 'Trenutno unesena vrijednost tečaja Eura : <b>',$tecaj['tecaj'],'</b><br /><br />';
echo '<form action="/vivo2/0/0/0/0/" id="tecaj" method="POST">Unesi novu vrijednost tečaja : <input type="text" name="tecaj" size ="4"> <button type="submit" class="greenButton"> izmijeni </button></form></div>';
  
  
?>