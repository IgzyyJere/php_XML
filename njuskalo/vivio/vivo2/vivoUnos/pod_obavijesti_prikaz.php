<div id="brziPrikazJedneNkeretnineTraka"></div>


<div id="prolinkVijesti">
    <div id="prolinkVijestiNaslov">Važne obavijesti</div>

<?php

$ch = curl_init("http://www.prolink.hr/vivonews.php");
curl_exec($ch);
curl_close($ch);

?>

</div>

<div id="brziPrikazNekretnine">

    <form name="brziPrikazNekretnineForm" id="brziPrikazNekretnineForm" method="POST" action="">

        <label for="id">ID nekretnine:</label>
            <input type="text" name="id" size="8">

        <label for="id">Prikaz:</label>
            <select name="vrsta">
                <option value="1">traka sa podacima</option>
                <option value="2">izmjena podataka</option>
            </select>

        <button type="sumbit" class="greenButton">pošalji</button>


    </form>

</div>

<div id="brzoPretrazivanjeNekretnina">

    <form name="pretraziNekretnine" id="pretraziNekretnine" method="POST" action="">

<?php

// treba dodati lokacijsko pretraživanje, pa po grupama, pa po veličini i cijeni
// sagradi se upit prema gore navedenim kriterijima (isti ko pretraživač na stranici, samo kaj se određuju i grupe)
// izbaci se sve vam se prikazNekretnine ();

?>

<div class="pretraziNekretnineDodajGradDiv">
<select name="pretraziZupanija" id="pretraziNekretnineZupanije">

<?php

$upit = "SELECT * FROM zupanije ORDER BY id";
$odgovori = mysql_query ( $upit );

while ( $podaci = mysql_fetch_assoc($odgovori)){

    echo '<option value="',$podaci['id'],'">',$podaci['nazivZupanije'],'</option>';

}

?>

</select>
<span id="pretraziNekretnineDodajGrad" class="greenButton smallButtonLong">dodaj grad</span>
</div>
<div id="pretraziNekretnineUbaciGrad"></div>

<div class="pretraziNekretnineDodajGradDiv">
        <label for="tabela">Izaberite vrstu nekretnine</label>
            <select name="tabela">
                <option value="vivostanovi">stanovi</option>
                <option value="vivokuce">kuće</option>
                <option value="vivoposlovni">poslovni</option>
                <option value="vivozemljista">zemljista</option>
                <option value="vivoturizam">turizam</option>
                <option value="vivoostalo">otalo</option>
            </select>
            <select name="navigacija">
                <option value="prodaja">prodaja</option>
                <option value="najam">najam</option>
            </select>


                <div class="formPart">
                <label for="povrsinaOd">Površina&nbsp;&nbsp;&nbsp;&nbsp;od</label>
				<input type="text" name="povrsinaOd" id="povrsinaOd" />

				<label for="povrsinaDo">&nbsp;&nbsp;do</label>
                <input type="text" name="povrsinaDo" id="povrsinaDo" />(m<span class="super">2</span>)
                </div>

                <div class="formPart">
                <label for="cijenaOd">Cijena&nbsp;&nbsp;&nbsp;&nbsp;od</label>
                <input type="text" name="cijenaOd" id="cijenaOd" />

                <label for="cijenaDo">&nbsp;&nbsp;do</label>
                <input type="text" name="cijenaDo" id="cijenaDo" />(&euro;)

                </div>

                <div class="formSubmit">
                <button class="buttonClear" name="reset" type="reset">Isprazni</button>
                <button class="buttonSubmit greenButton" name="submit" type="submit">Pretraži</button>
                </div>

    </from>
</div
</div>
<div id="brzoPretrazivanjeNekretninaRezultat">
</div>



