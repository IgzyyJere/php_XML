<div class="formTitle">Opis nekretnine</div>
<div id="opisContainer">

    <div id="opisPopisJezika">

        <?php

        //pro�itaj jezike iz baze i prika�i ih

        $upit = "SELECT * FROM jezici WHERE aktivno=1";
        $odgovori = mysql_query ( $upit );
        while ( $podaci = mysql_fetch_assoc ( $odgovori )) {

            echo '<a href="" jezik="',$podaci['kratica'],'" id="',$id,'" tabela="',$tabela,'" class="opisAktivniJezik">',$podaci['naziv'],'</a>';

        }

        ?>


    </div>


    <div id="opisObradaTeksta">

            <?

            include ( "opisTextarea.php" );

            ?>

    </div>

</div>