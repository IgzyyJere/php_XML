<?php
/* gumbi se definiraju u svakoj datoteci u vivoUnos posebnoa, a      /
   ovdje se rade prema definicijama pripremljenim u tim datotekama  */

?>
<div id="mainButtonBar">

<?php

if ( $glavniGumbi ) {

?>

    <div id="mainButtons">

        <?php

        foreach ( $glavniGumbi as $value ) {

            echo '<a href="/vivo2/0/0/',$value[0],'/0/" class="bigButton greenButton">',$value[1],'</a>';

        }

        ?>

    </div>

<?php

}

if ( $pomocniGumbi ) {


?>

    <div id="additionalButtons">

        <?php

        foreach ( $pomocniGumbi as $value ) {

            echo '<a href="" id="addButtons_',$value[0],'" class="bigButton yellowButton">',$value[1],'</a>';

        }

        ?>

    </div>

<?php

}

?>

</div>
