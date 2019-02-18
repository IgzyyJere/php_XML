<?php
header('Content-Type: text/xml'); 
echo '<?xml version="1.0" encoding="utf-8"?>';

$link = new mysqli("localhost", "root", "", "nekreninetestwp");
mysqli_set_charset($link,"utf8");

//session_start ();

echo '<ad_list>';

                                                            
 $queryOglasi1 ="
 select wp_posts.ID, wp_posts.post_title, wp_posts.post_status ,wp_posts.guid ,wp_posts.post_type, wp_posts.post_date, wp_term_taxonomy.term_id, 
             wp_term_taxonomy.taxonomy, wp_term_taxonomy.description, wp_terms.name
             from wp_posts
             LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
             LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
             LEFT JOIN wp_terms ON (wp_term_relationships.term_taxonomy_id = wp_terms.term_id)
             AND wp_term_taxonomy.term_id = 2
             WHERE wp_posts.post_type = 'property'
             AND wp_posts.post_status = 'publish'
             AND wp_terms.name IS NOT NULL
             ORDER BY post_date DESC";



$container = mysqli_query($link, $queryOglasi1);
while($row = mysqli_fetch_assoc($container)){

echo '<ad_item class="ad_flats">
    <user_id>444900</user_id>
        <original_id>s-'.$row["ID"].'</original_id>';
        echo '<category_id>9580</category_id>',"\n";

        if ($row['post_title'])  {
            echo '<title>',$row['post_title'],'</title>';
        } else {
            echo '<title>Stan: ';
            $u = "SELECT naziv FROM kvartovi WHERE id = '".$podaci['kvart']."'";
            $o = mysql_query ( $u );
            $p = mysql_result ( $o, 0 );
            echo $p,', ',$podaci['ukupnaPovrsina'],' m2';
            echo '</title>',"\n";
    }



        echo '</ad_item>',"\n"; //end nekretnine


}// KRAJ LOOPa
echo '</ad_list>';

?>