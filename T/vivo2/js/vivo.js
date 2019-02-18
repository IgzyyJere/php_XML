$(document).ready(function(){

$("ul.sf-menu").superfish(); 

$('.topBarContent').hide();
$('.topBarTitle').unbind('mouseover').mouseover( function () {

    $('.topBarContent').hide();
    $(this).next().toggle();
    $('img.topBarClose').unbind('click').click( function () {
        $(this).parent().parent().hide();
    });
    $('.topBarContent').unbind('mouseleave').mouseleave( function () {
        $(this).hide();
    });
});

$('.prikazFormLine').hover(function () {
    $(this).addClass('greenBackgroundLine');
}, function () {
    $(this).removeClass('greenBackgroundLine');
});


// izmjena FORM action="" prilikom povratka na prikaz  /
// kod izmjene podataka                                 /
$('button.buttonSubmitBack').unbind('click').click( function () {
    $("#mainForm[action]").attr('action', '/vivo2/0/0/prikaz/0/');
});

// provjera za brisanje sadržaja       /
// koristi impromptu.js jqUery plugin  /
$("a.deleteContent").unbind('click').click(function (){
    var href = $(this).attr('href');
    function mycallbackfunc(v){
        if ( v ) {
            window.location.href = href;
        }
    }
    $.prompt('Potvrda brisanja podataka',{ buttons: { Obriši: true, Odustani: false }, prefix:'cleanblue', callback: mycallbackfunc });
    return false;
});


// on / off     /
$("a.onOff").unbind('click').bind('click', function (){
    var id = $(this).attr("ref");
    $(this).load("/vivo2/vivoAplikacije/onoff.php", {id: id } );
    return false;
});
// on / off  LOKACIJE   /
$("a.onOffLokacije").unbind('click').bind('click', function (){
    var id = $(this).attr("ref");
    $(this).load("/vivo2/vivoAplikacije/onofflokacije.php", {id: id } );
    return false;
});



// podaci o vlasniku   /
$("a.vlasnik").unbind('click').bind('click', function () {
    var id = $(this).attr("ref");
    var tabela = $(this).attr("rel");
    $.post("/vivo2/vivoAplikacije/podaciVlasnik.php", {id:id, tabela: tabela}, function(data) {
        $.prompt(data,{button:{Ok: true}, prefix:'cleanblue' });
    });
    return false;
});

// printanje podataka
$("a.printajPodatke").unbind('click').click( function () {
    var id = $(this).attr('rel');
    var grupa = $(this).attr('ref');
    var visina = 900;
    var sirina = 650;

    function printajpodatke (v,m,f) {
        if ( v ) {
          window.open("/vivo2/vivoPrint/obrada.php?id="+id+"&grupa="+grupa+"&template="+f.template,null, "height=" + visina + ",width=" + sirina + ",status=no,toolbar=no,menubar=yes,location=no");
        }
    }

    $.post("/vivo2/vivoPrint/izbor.php", {id:id}, function(data) {
        $.prompt(data,{ buttons: {Ok: true, Cancel:false }, prefix:'cleanblue', callback: printajpodatke });
    });
    return false;
});

// dodavanje nekretnine na popis od kojega /
// se radi ponuda koja se šalje mailom     /
$('.dodajNaPopis').unbind('click').click( function () {
    var id = $(this).attr("rel");
    var tabela = $(this).attr("ref");
    $.post("/vivo2/vivoAplikacije/popisZaSlanje.php", {id:id, tabela: tabela}, function(data) {
        $.prompt(data,{button:{Ok: true}, prefix:'cleanblue' });
    });
    return false;
});
$('.dodajNaPopisKlijent').unbind('click').click( function () {
    var id = $(this).attr("rel");
    var idNekretnine = $(this).attr("href");
    var tabela = $(this).attr("ref");
    $.post("/vivo2/vivoAplikacije/popisZaSlanjeKlijent.php", {id:id, tabela: tabela, idNekretnine:idNekretnine}, function(data) {
        $.prompt(data,{button:{Ok: true}, prefix:'cleanblue' });
    });
    return false;
});



/*                                    /
           GEOGRAFSKA PODJELA         /
                                     */

//izmjena zupanija pri promjeni regije
$("select[name=regija]").unbind('change').change( function () {

    var id = $(this).attr("value");
    $.post("/vivo2/vivoAplikacije/dajZupaniju.php", {id:id}, function (data) {

        $("#zupanijaSelect").html(data);
        var id2 = $("select[name=zupanija]:first").attr("value");

        $.post("/vivo2/vivoAplikacije/dajGrad.php", {id:id2}, function (data) {

            $("#gradSelect").html(data);
            var id3 = $("select[name=grad]:first").attr("value");

            $.post("/vivo2/vivoAplikacije/dajKvart.php", {id:id3}, function (data) {

                $("#kvartSelect").html(data);

            });

        });

    });

});
//izmjena gradova pri promjeni županije
$("select[name=zupanija]").unbind('change').change( function () {

    var id = $(this).attr("value");
    $.post("/vivo2/vivoAplikacije/dajGrad.php", {id:id}, function (data) {

        $("#gradSelect").html(data);
        var id3 = $("select[name=grad]:first").attr("value");

        $.post("/vivo2/vivoAplikacije/dajKvart.php", {id:id3}, function (data) {

            $("#kvartSelect").html(data);

        });

    });

});
//izmjena kvarta pri promjeni grada
$("select[name=grad]").unbind('change').change( function () {

    var id = $(this).attr("value");
    $.post("/vivo2/vivoAplikacije/dajKvart.php", {id:id}, function (data) {

        $("#kvartSelect").html(data);

        });

});
//           AJAX SUCCESS               /
$("#mainForm").ajaxSuccess(function(){
//izmjena gradova pri promjeni županije
$("select[name=zupanija]").unbind('change').change( function () {

    var id = $(this).attr("value");
    $.post("/vivo2/vivoAplikacije/dajGrad.php", {id:id}, function (data) {

        $("#gradSelect").html(data);
        var id3 = $("select[name=grad]:first").attr("value");

        $.post("/vivo2/vivoAplikacije/dajKvart.php", {id:id3}, function (data) {

            $("#kvartSelect").html(data);

        });

    });

});
//izmjena kvarta pri promjeni grada
$("select[name=grad]").unbind('change').change( function () {

    var id = $(this).attr("value");
    $.post("/vivo2/vivoAplikacije/dajKvart.php", {id:id}, function (data) {

        $("#kvartSelect").html(data);

        });

});
});
//   KRAJ RADA S LOKACIJAMA   /



// WYSIWYG /
if (!$.browser.msie){
    $('textarea.dodajEditor').wysiwyg({
        css : { fontFamily: 'Arial, Tahoma', fontSize : '12px'}
    });
}



//                            /
//         rad sa opisom      /
//                            /
$('.opisAktivniJezik').unbind('click').click( function (){
    var jezik = $(this).attr('jezik');
    var id = $(this).attr('id');
    var tabela = $(this).attr('tabela');
    $.post( '/vivo2/vivoAplikacije/opisTextarea.php', {jezik:jezik, id:id, tabela:tabela}, function (data) {
        $('#opisObradaTeksta').html(data);
            if (!$.browser.msie){
                $('textarea').wysiwyg({
                    css : { fontFamily: 'Arial, Tahoma', fontSize : '12px'}
                });
            }
    });
    return false;
});

$('#opisTekst').unbind('submit').submit(function () {
    var link = $(this).formSerialize();
    $.post("/vivo2/vivoAplikacije/opisObrada.php", link , function (data) {
        $('#opisObradaTeksta').html(data);
            if (!$.browser.msie){
                $('textarea').wysiwyg({
                    css : { fontFamily: 'Arial, Tahoma', fontSize : '12px'}
                });
            }
    });
    return false;
});
$('#opisObradaTeksta').ajaxSuccess(function(){
    $('#opisTekst').unbind('submit').submit(function () {
        var link = $(this).formSerialize();
        $.post("/vivo2/vivoAplikacije/opisObrada.php", link , function (data) {
            $('#opisObradaTeksta').html(data);

            if (!$.browser.msie){
                $('textarea').wysiwyg({
                    css : { fontFamily: 'Arial, Tahoma', fontSize : '12px'}
                });
            }
        });
        return false;
    });
});



// AJAX loader       /
$("#ajaxLoader").bind("ajaxStart", function(){
    $(this).show();
}).bind("ajaxComplete", function(){
    $(this).hide();
});


//   YouTube       /
$('#youtubeForm').unbind('submit').submit(function () {
    var link = $(this).formSerialize();
    $.post("/vivo2/vivoAplikacije/youtubeObrada.php", link , function (data) {
        var textareaIma = 1;
        $('#youtubePlayer').html(data);
    });
    return false;
});

// spajanje klijenata na nekretninu   /

$("a.spojiNaNekretninu").unbind('click').click ( function () {

    var href = $(this).attr("href");
    var text = 'Unesite ID nekretnine kojoj želite pridodati ovog klijenta <br><input type="text" id="alertName" name="myname" >';

    function mycallbackform (v,m,f){
        if ( v ) {
            var spojeno = m.children('#alertName').val();
            window.location.href = "/vivo2/0/0/0/0/id=" + href + "&spojeno=" + spojeno;
        }
    }

    $.prompt( text,{ buttons: { Ok: true, Cancel: false }, prefix:'cleanblue', callback:mycallbackform });
    return false;

});

// provjera baze za klijente / nekretnine /
// skrivanje / otvaranje podataka         /

$(".klijentZeleno").hide();
$(".klijentZuto").hide();
$(".klijentCrveno").hide();
$(".klijentGore").show();
$(".klijentNaslov").unbind('click').click( function () {
    $(this).children().toggle();
});


// dohvavanje popis mail adresa od klijenata  /
// za slanje ponude                           /

$("#dohvatiEmailKlijenata a").unbind('click').click( function () {

    $(this).parent().load("/vivo2/vivoAplikacije/dohvatiEmailKlijenata.php" );
    return false;

});

// tooltip na nekretninama i kupcima /
$("a.showTooltip").poshytip({
	className: 'tip-twitter',
	showTimeout: 1,
	alignTo: 'target',
	alignX: 'center',
	offsetY: 5,
	allowTipHover: false,
	fade: false,
	slide: false
});


// dodavanje izvještaja kod nekretnina  /
$("a.dodavanjeIzvjestaja").unbind('click').click ( function () {

    var tabela = $(this).attr("ref");
    var id = $(this).attr("rel");
    var text = 'Unesite tekst izvještaja <br><textarea id="dodajIzvjestaj" name="myname" width="300"></textarea>';

    function mycallbackform (v,m,f){
        if ( v ) {
            var tekst = m.children('#dodajIzvjestaj').val();

            $.post("/vivo2/vivoAplikacije/izvjestajUnos.php", {id:id, tekst:tekst, tabela:tabela} , function (data) {
                $.prompt(data,{button:{Ok: true}, prefix:'cleanblue' });
             });
        }
    }

    $.prompt( text,{ buttons: { Ok: true, Cancel: false }, prefix:'cleanblue', callback:mycallbackform });
    return false;

});


// dodavanje ugovora kod nekretnina  /
$("a.dodajUgovor").unbind('click').click ( function () {

    var tabela = $(this).attr("ref");
    var id = $(this).attr("rel");
    var text = 'Ime i prezime kupca:<input type="text" id="ugovorIme" name="ugovorIme"><br><br>Status: <input type="radio" id="ugovorStatus" name="ugovorStatus" value="1" checked>Nepotpisani<input type="radio" id="ugovorStatus" name="ugovorStatus" value="2">Potpisani<br><br>Dan:<input type="text" id="ugovorDan" name="ugovorDan" size="2">Mjesec:<input type="text" id="ugovorMjesec" name="ugovorMjesec" size="2">Godina:<input type="text" id="ugovorGodina" name="ugovorGodina" size="4"><br><br>(ukoliko ne unesete datum, koristi se današnji';

    function mycallbackform (v,m,f){
        if ( v ) {
            var ime = m.children('#ugovorIme').val();
            var status = m.children('#ugovorStatus').val();
            var dan = m.children('#ugovorDan').val();
            var mjesec = m.children('#ugovorMjesec').val();
            var godina = m.children('#ugovorGodina').val();

            $.post("/vivo2/vivoAplikacije/ugovorUnos.php", {id:id, tabela:tabela, ime:ime, status:status, dan:dan, mjesec:mjesec, godina:godina} , function (data) {
                $.prompt(data,{button:{Ok: true}, prefix:'cleanblue' });
             });

        }
    }

    $.prompt( text,{ buttons: { Ok: true, Cancel: false }, prefix:'cleanblue', callback:mycallbackform });
    return false;

});

// unošenje posredničkog dnevnika /
$("a.napraviPosrednicki").unbind('click').click ( function () {

    var browserWidth = $(window).width();
    var browserHeight = $(window).height();

    var id = $(this).attr("rel");
    var tabela = $(this).attr("ref");

    // prvo POSTom sagradim formular koji će se prikazati

    $.post("/vivo2/vivoAplikacije/posrednickiIzradaFormulara.php", {id:id, tabela:tabela, browserWidth:browserWidth, browserHeight:browserHeight } , function (data) {
        $.prompt( data,{ buttons: { Ok: true, Cancel: false }, prefix:'cleanblue', callback:mycallbackform });
             });


    function mycallbackform (v,m,f){
        if ( v ) {

            $.post("/vivo2/vivoAplikacije/posrednickiUnos.php", {oznaka: f.oznaka, zupanija:f.zupanija, grad:f.grad, kvart:f.kvart, ulica:f.ulica, kucniBroj:f.kucniBroj, vrstaNekretnine:f.vrstaNekretnine, povrsina:f.povrsina, sobnost:f.sobnost, katastarskaCestica:f.katastarskaCestica, vrstaVlasnistva:f.vrstaVlasnistva, cijenaUkupnaKune:f.cijenaUkupnaKune, cijenaUkupnaEuro:f.cijenaUkupnaEuro, cijenaKvadrataKune:f.cijenaKvadrataKune, cijenaKvadrataEuro:f.cijenaKvadrataEuro, vrstaUgovora:f.vrstaUgovora, datum:f.datum, vlasnikIme:f.vlasnikIme, vlasnikAdresa:f.vlasnikAdresa, vlasnikTelefon:f.vlasnikTelefon, ZSPNT:f.ZSPNT, idNekretnine:f.idNekretnine } , function (data) {
                $.prompt(data,{button:{Ok: true}, prefix:'cleanblue' });
             });

        }
    }
    $(this).removeClass('napraviPosrednicki').addClass('pokaziPosrednicki');
    $(this).html('<img src="/vivo2/ikone/report_black.png">');
    $(this).attr('title', 'prikaži posrednički dnevnik');
    return false;

});


// formular na početnoj za direktan pristup nekoj nekretnini /
// treba posložiti URL, a kako formular nema action dok se   /
// sve ne izabere, jedini način je to složiti sa JSom        /

$("#brziPrikazNekretnineForm").submit( function () {
    var vrsta = $("select[name=vrsta]").attr("value");
    var id = $("input[name=id]:first").attr("value");

    $.post("/vivo2/vivoAplikacije/brzaPretragaObrada.php", {id:id, vrsta: vrsta}, function (data) {
        window.location.href = data;
    });
    return false;
});


// brzo pretraživanje na početnoj stranici sustava /

$("#pretraziNekretnine").submit( function () {

    var podaci = $(this).formSerialize();
    $.post("/vivo2/vivoAplikacije/brzoPretrazivanje.php", podaci , function (data) {
        $('#brzoPretrazivanjeNekretninaRezultat').html(data);

        // podaci o vlasniku   /
        $("a.vlasnik").unbind('click').bind('click', function () {
            var id = $(this).attr("ref");
            var tabela = $(this).attr("rel");
            $.post("/vivo2/vivoAplikacije/podaciVlasnik.php", {id:id, tabela: tabela}, function(data) {
                $.prompt(data,{button:{Ok: true}, prefix:'cleanblue' });
            });
        return false;
        });

    });
    return false;

});

$("#pretraziNekretnineDodajGrad").unbind('click').click ( function () {

    var id = $("#pretraziNekretnineZupanije").attr("value");
    $.post("/vivo2/vivoAplikacije/pretraziDajGrad.php", {id:id}, function (data) {

        $("#pretraziNekretnineUbaciGrad").html(data);

        });

});


// PROLINK obavijesti, treba prikazati tekst obavijesti u modalu /

$(".prolinkTekst a").unbind('click').click( function () {

    var tekst = $(this).html();
    $.prompt( tekst,{ buttons: { Zatvori: false }, prefix:'cleanblue'} );
    return false;

    });



// prikaz podsjetnika  /

$(".prikaziPodsjetnik").unbind('click').click( function () {

    var id = $(this).attr('ref');
    $.post("/vivo2/vivoAplikacije/prikaziTekstPodsjetnika.php", {id:id}, function(data) {
        $.prompt(data,{button:{Ok: true}, prefix:'cleanblue' });
    });
    return false;

});

// prikaz poruke  /

$(".prikaziPoruku").unbind('click').click( function () {

    var id = $(this).attr('ref');
    $.post("/vivo2/vivoAplikacije/prikaziTekstPoruke.php", {id:id}, function(data) {
        $.prompt(data,{button:{Ok: true}, prefix:'cleanblue' });
    });
    return false;

});

// izmjena grupe unutar iste vrste  /

$(".promjenaGrupe").unbind('click').click( function () {


    var grupa = $(this).attr('rel');
    var id = $(this).attr('ref');
    var tabela = $(this).attr('href');
    $.post("/vivo2/vivoAplikacije/izmjenaGrupeIzPopisa.php", {grupa: grupa} , function (data) {
        $.prompt( data,{ buttons: { Ok: true, Cancel: false }, prefix:'cleanblue', callback:mycallbackform });
             });

    function mycallbackform (v,m,f){
        if ( v ) {
            var novaGrupa = m.children('#novaGrupa').val();

            $.post("/vivo2/vivoAplikacije/izmjenaGrupeIzPopisaObrada.php", {novaGrupa: novaGrupa, id:id, tabela: tabela } , function (data) {
                window.location.href = "/vivo2/0/0/0/0/";
             });

        }
    }

    return false;

});

// rad sa provizijama           /
//      dodavanje provizije     /

$('#unosProvizijeForm').submit( function () {
    var naziv = $("input[name=nazivProvizije]").attr("value");
    $.post("/vivo2/vivoAplikacije/unosProvizije.php", {naziv:naziv } , function (data) {
        $('#popisProvizija').html(data);
        $('.unosProvizijaDiv').submit( function () {
            var text = $("input[name=tekst]").attr("value");
            var id = $("input[name=id]").attr("value");
            var jezik = $("input[name=jezik]").attr("value");
            $.post("/vivo2/vivoAplikacije/unosProvizijeTekst.php", {text:text, id:id, jezik:jezik });
        return false;
        });
    });
    return false;
});
//      izmjena provizije      /
//               naslov           /
$('#izmjenaProvizijeForm').submit( function () {
    var naziv = $("input[name=nazivProvizije]").attr("value");
    var id = $("input[name=id]").attr("value");
    $.post("/vivo2/vivoAplikacije/unosProvizijeIzmjena.php", {naziv:naziv, id:id });
    return false;
});
//            tekst               /
$('.izmjeneProvizijaDiv').submit( function () {
    var podaci = $(this).formSerialize();
    $.post("/vivo2/vivoAplikacije/unosProvizijeTekstIzmjena.php", {podaci:podaci });
    return false;
});

//            definiranje lokacija              /
$('#dodjeljivanjeLokacija').submit( function () {
    var lokacija = $("input[name=lokacija]").attr("value");
    var grad = $("select[name=idgrada]").attr("value");
    $.post("/vivo2/vivoAplikacije/definiranjelokacija.php", {lokacija:lokacija, grad:grad }, function (data) {
        $('.popisDodjeljenihLokacija').html(data);
    });
    return false;
});

$("#addButtons_Excel").unbind('click').click( function () {
    window.open("/vivo2/vivoAplikacije/napraviCSV.php");
    return false;
});

$('a.dajIDnaklik').unbind('click').click( function() {

    var id = $(this).attr("href");
    alert ( 'ID ove nekretnine u bazi podataka je: ' + id );
    return false;

});

//  KRAJ   /
});