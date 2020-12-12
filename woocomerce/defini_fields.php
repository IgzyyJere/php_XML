<?php
class QueryMain_Context{
var $user = "root";
var $db = "mojecipeleDb";
var $passW = "";


//stock SELECT * FROM `wpdg_postmeta` WHERE meta_key like '%stock'
//post _id


//SELECT * FROM `wpdg_posts` where post_type like 'product_variation' ORDER BY post_date DESC
//vežu se na post_parent kao id product

//https://wordpress.org/support/topic/sku-already-exists-but-there-no-matching-sku-on-site/

///proizvod
var $queryProduct = "SELECT * FROM wpdg_posts
LEFT JOIN wpdg_postmeta ON (wpdg_posts.ID = wpdg_postmeta.post_id)
WHERE  post_type = 'product' AND wpdg_postmeta.meta_key like '_stock'
ORDER BY post_date DESC";


///STANOVI NAJAM
var $queryOglasi2 = "SELECT * FROM wpdg_posts
LEFT JOIN wpdg_term_relationships ON (wpdg_posts.ID = wpdg_term_relationships.object_id)
LEFT JOIN wpdg_term_taxonomy ON (wpdg_term_relationships.term_taxonomy_id = wpdg_term_taxonomy.term_taxonomy_id)
WHERE  wpdg_term_taxonomy.taxonomy = 'property-status'
AND wpdg_term_taxonomy.term_id = 623
ORDER BY post_date DESC";



///POSLOVNI NAJAM
var $queryOglasi3 = "SELECT * FROM wpdg_posts
LEFT JOIN wpdg_term_relationships ON (wpdg_posts.ID = wpdg_term_relationships.object_id)
LEFT JOIN wpdg_term_taxonomy ON (wpdg_term_relationships.term_taxonomy_id = wpdg_term_taxonomy.term_taxonomy_id)
WHERE  wpdg_term_taxonomy.taxonomy = 'property-status'
AND wpdg_term_taxonomy.term_id = 801
ORDER BY post_date DESC";



    //Ured – Office
    var $queryLokalOffice = "
    SELECT * FROM wpdg_posts
    LEFT JOIN wpdg_term_relationships ON (wpdg_posts.ID = wpdg_term_relationships.object_id)
    LEFT JOIN wpdg_term_taxonomy ON (wpdg_term_relationships.term_taxonomy_id = wpdg_term_taxonomy.term_taxonomy_id)
    WHERE  wpdg_term_taxonomy.taxonomy = 'property-type'
    AND wpdg_term_taxonomy.term_id = 789
    ORDER BY post_date DESC";


    //Ulični lokal
    var $queryLokalUli = "
    SELECT * FROM wpdg_posts
    LEFT JOIN wpdg_term_relationships ON (wpdg_posts.ID = wpdg_term_relationships.object_id)
    LEFT JOIN wpdg_term_taxonomy ON (wpdg_term_relationships.term_taxonomy_id = wpdg_term_taxonomy.term_taxonomy_id)
    WHERE  wpdg_term_taxonomy.taxonomy = 'property-type'
    AND wpdg_term_taxonomy.term_id = 799
    ORDER BY post_date DESC";


    //Ugostiteljstvo
    var $queryLokalUgostiteljstvo = "
    SELECT * FROM wpdg_posts
    LEFT JOIN wpdg_term_relationships ON (wpdg_posts.ID = wpdg_term_relationships.object_id)
    LEFT JOIN wpdg_term_taxonomy ON (wpdg_term_relationships.term_taxonomy_id = wpdg_term_taxonomy.term_taxonomy_id)
    WHERE  wpdg_term_taxonomy.taxonomy = 'property-type'
    AND wpdg_term_taxonomy.term_id = 797
    ORDER BY post_date DESC";


    //Hotel
    var $queryLokalHotel = "
    SELECT * FROM wpdg_posts
    LEFT JOIN wpdg_term_relationships ON (wpdg_posts.ID = wpdg_term_relationships.object_id)
    LEFT JOIN wpdg_term_taxonomy ON (wpdg_term_relationships.term_taxonomy_id = wpdg_term_taxonomy.term_taxonomy_id)
    WHERE  wpdg_term_taxonomy.taxonomy = 'property-type'
    AND wpdg_term_taxonomy.term_id = 514 and wpdg_term_taxonomy.term_id = 523
    ORDER BY post_date DESC";




//KUĆE PRODAJA
var $queryKuceProdaja = "SELECT * FROM wpdg_posts
LEFT JOIN wpdg_term_relationships ON (wpdg_posts.ID = wpdg_term_relationships.object_id)
LEFT JOIN wpdg_term_taxonomy ON (wpdg_term_relationships.term_taxonomy_id = wpdg_term_taxonomy.term_taxonomy_id)
WHERE  wpdg_term_taxonomy.taxonomy = 'property-status'
AND wpdg_term_taxonomy.term_id = 881
ORDER BY post_date DESC";


    
    //Stambeno-poslovna
    var $queryKucaStambenoPoslovna = "
    SELECT * FROM wpdg_posts
    LEFT JOIN wpdg_term_relationships ON (wpdg_posts.ID = wpdg_term_relationships.object_id)
    LEFT JOIN wpdg_term_taxonomy ON (wpdg_term_relationships.term_taxonomy_id = wpdg_term_taxonomy.term_taxonomy_id)
    WHERE  wpdg_term_taxonomy.taxonomy = 'property-type'
    AND wpdg_term_taxonomy.term_id = 803
    ORDER BY post_date DESC";


       //Stambeno-poslovna
       var $queryKucaSamostojeca = "
       SELECT * FROM wpdg_posts
       LEFT JOIN wpdg_term_relationships ON (wpdg_posts.ID = wpdg_term_relationships.object_id)
       LEFT JOIN wpdg_term_taxonomy ON (wpdg_term_relationships.term_taxonomy_id = wpdg_term_taxonomy.term_taxonomy_id)
       WHERE  wpdg_term_taxonomy.taxonomy = 'property-type'
       AND wpdg_term_taxonomy.term_id = 880
       ORDER BY post_date DESC";


              //Kuca u nizu
              var $queryKucaNiz = "
              SELECT * FROM wpdg_posts
              LEFT JOIN wpdg_term_relationships ON (wpdg_posts.ID = wpdg_term_relationships.object_id)
              LEFT JOIN wpdg_term_taxonomy ON (wpdg_term_relationships.term_taxonomy_id = wpdg_term_taxonomy.term_taxonomy_id)
              WHERE  wpdg_term_taxonomy.taxonomy = 'property-type'
              AND wpdg_term_taxonomy.term_id = 880
              ORDER BY post_date DESC";


                 //Dvojni objekt
                 var $queryKucaDvoj = "
                 SELECT * FROM wpdg_posts
                 LEFT JOIN wpdg_term_relationships ON (wpdg_posts.ID = wpdg_term_relationships.object_id)
                 LEFT JOIN wpdg_term_taxonomy ON (wpdg_term_relationships.term_taxonomy_id = wpdg_term_taxonomy.term_taxonomy_id)
                 WHERE  wpdg_term_taxonomy.taxonomy = 'property-type'
                 AND wpdg_term_taxonomy.term_id = 880
                 ORDER BY post_date DESC";


                           //Roh Bau
                           var $queryKucaRoh = "
                           SELECT * FROM wpdg_posts
                           LEFT JOIN wpdg_term_relationships ON (wpdg_posts.ID = wpdg_term_relationships.object_id)
                           LEFT JOIN wpdg_term_taxonomy ON (wpdg_term_relationships.term_taxonomy_id = wpdg_term_taxonomy.term_taxonomy_id)
                           WHERE  wpdg_term_taxonomy.taxonomy = 'property-type'
                           AND wpdg_term_taxonomy.term_id = 880
                           ORDER BY post_date DESC";

                                 //Vikendica
                                 var $queryVikendica = "
                                 SELECT * FROM wpdg_posts
                                 LEFT JOIN wpdg_term_relationships ON (wpdg_posts.ID = wpdg_term_relationships.object_id)
                                 LEFT JOIN wpdg_term_taxonomy ON (wpdg_term_relationships.term_taxonomy_id = wpdg_term_taxonomy.term_taxonomy_id)
                                 WHERE  wpdg_term_taxonomy.taxonomy = 'property-type'
                                 AND wpdg_term_taxonomy.term_id = 886
                                 ORDER BY post_date DESC";




                                 

//KUĆE NAJAM
var $queryKuceNajam = "SELECT * FROM wpdg_posts
LEFT JOIN wpdg_term_relationships ON (wpdg_posts.ID = wpdg_term_relationships.object_id)
LEFT JOIN wpdg_term_taxonomy ON (wpdg_term_relationships.term_taxonomy_id = wpdg_term_taxonomy.term_taxonomy_id)
WHERE  wpdg_term_taxonomy.taxonomy = 'property-status'
AND wpdg_term_taxonomy.term_id = 917
ORDER BY post_date DESC";





// ///LOKACIJE







// //LOKACIJA iz WP-a
// var  $ZupanijaWP = "SELECT * from zupanije where zupanije.nazivZupanije like '%".$WPRow["name"]."'";    
// $zupanija_wp = mysqli_query($link, $ZupanijaWP);
// $WPZupRow = mysqli_fetch_assoc($zupanija_wp);
// var $t;
// //ako je ukucana zupanija tada
// if($WPZupRow["id"]>0){
// $t = 1;
// }






//Samo za test i rješavanje buga s lokacijama


var $queryOglasi_test = "SELECT * FROM wpdg_posts
LEFT JOIN wpdg_term_relationships ON (wpdg_posts.ID = wpdg_term_relationships.object_id)
LEFT JOIN wpdg_term_taxonomy ON (wpdg_term_relationships.term_taxonomy_id = wpdg_term_taxonomy.term_taxonomy_id)
WHERE  wpdg_term_taxonomy.taxonomy = 'property-status'
AND wpdg_posts.ID BETWEEN 9154 AND 11529
AND wpdg_term_taxonomy.term_id = 560";




}
?>