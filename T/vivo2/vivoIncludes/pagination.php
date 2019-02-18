<?php

if ( $paginacija ) {

?>

<div id="mainPaginationBar">

<?php

if ($ukupnoPodataka > 0) {

    $ukupnoStranica = ceil ($ukupnoPodataka / $poStranici);
	// prva stranica
	if (($_GET['kreni'] == 1)) {
	    echo '<b>1</b>';
	} else {
	    echo '<a href="/vivo2/0/0/0/0/kreni=1">1</a>';
	}

	// lijevi dio
	if (($_GET['kreni'] - $padding) > 1) {
	    echo "...";

		$lowerLimit = $_GET['kreni'] - $padding;

		for ($i = $lowerLimit; $i < $_GET['kreni']; $i++) {
		    echo '<a href="/vivo2/0/0/0/0/kreni=',$i,'">'.$i.'</a>';
		}
	} else {

	    for ($i = 2; $i < $_GET['kreni']; $i++) {
		    echo '<a href="/vivo2/0/0/0/0/kreni=',$i,'">'.$i.'</a>';
		}
	}

	// trenutna stranica
	if (($_GET['kreni'] != 0) && ($_GET['kreni'] != 1) && ($_GET['kreni'] != $ukupnoStranica)) {
	    echo '<b>' . $_GET['kreni'] . '</b>';
	}

	// desni dio
	if (($_GET['kreni'] + $padding) < $ukupnoStranica) {

	    $upperLimit = $_GET['kreni'] + $padding;
		for ($i = ($_GET['kreni']+1); $i <= $upperLimit; $i++) {
		    echo '<a href="/vivo2/0/0/0/0/kreni=',$i,'">'.$i.'</a>';
		}
		echo "...";
	} else {
	    for ($i= ($_GET['kreni'] + 1); $i < $ukupnoStranica; $i++) {
		    echo '<a href="/vivo2/0/0/0/0/kreni=',$i,'">'.$i.'</a>';
		}
	}
	// zadnja stranica - ispisuje samo ako su barem dvije stranice
	if ($_GET['kreni'] == $ukupnoStranica) {
	    echo '<b>' . $ukupnoStranica . '</b>';

	} elseif ( $ukupnoStranica > 1  ){
	    echo '<a href="/vivo2/0/0/0/0/kreni=',$ukupnoStranica,'">'.$ukupnoStranica.'</a>';
	}
}
?>


</div>

<?php

}

?>