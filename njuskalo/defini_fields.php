<?php
class QueryMain_Context{


//prjašnji query
//  $queryOglasi1 ="
//  select uudqv_posts.ID, uudqv_posts.post_title, uudqv_posts.post_status ,uudqv_posts.guid ,uudqv_posts.post_type, uudqv_posts.post_date, uudqv_term_taxonomy.term_id, 
//              uudqv_term_taxonomy.taxonomy, uudqv_term_taxonomy.description, uudqv_terms.name, uudqv_posts.post_content
//              from uudqv_posts
//              LEFT JOIN uudqv_term_relationships ON (uudqv_posts.ID = uudqv_term_relationships.object_id)
//              LEFT JOIN uudqv_term_taxonomy ON (uudqv_term_relationships.term_taxonomy_id = uudqv_term_taxonomy.term_taxonomy_id)
//              LEFT JOIN uudqv_terms ON (uudqv_term_relationships.term_taxonomy_id = uudqv_terms.term_id)
//              WHERE uudqv_posts.post_type = 'property'
//              AND uudqv_posts.post_status = 'publish'
//              AND uudqv_terms.name IS NOT NULL
//              ORDER BY post_date DESC";




     //kvart
                                            // $Qkvart = "SELECT uudqv_term_taxonomy.parent, uudqv_terms.name, uudqv_terms.term_id, uudqv_posts.ID
                                            // from uudqv_terms
                                            // RIGHT JOIN uudqv_term_taxonomy on uudqv_terms.term_id = uudqv_term_taxonomy.term_id
                                            // LEFT JOIN uudqv_term_relationships ON uudqv_term_relationships.term_taxonomy_id = uudqv_term_taxonomy.term_taxonomy_id
                                            // JOIN uudqv_posts on uudqv_posts.ID = uudqv_term_relationships.object_id
                                            // WHERE uudqv_posts.ID = ".$row["ID"]."
                                            // AND uudqv_term_taxonomy.taxonomy = 'property-city'
                                            // GROUP BY uudqv_term_taxonomy.parent";
                                            // $zupanija = mysqli_query($link, $Qkvart);
                                            // $zupanijaRow = mysqli_fetch_assoc($zupanija);



///stanovi prodaja

// var $queryOglasi1 = "select  uudqv_posts.ID,  uudqv_posts.post_content, uudqv_posts.post_date, uudqv_posts.post_name,  uudqv_posts.post_title, uudqv_posts.guid
// from uudqv_posts
// WHERE uudqv_posts.post_type = 'property'
// AND uudqv_posts.post_status = 'publish'";

var $queryOglasi1 = "SELECT * FROM uudqv_posts
LEFT JOIN uudqv_term_relationships ON (uudqv_posts.ID = uudqv_term_relationships.object_id)
LEFT JOIN uudqv_term_taxonomy ON (uudqv_term_relationships.term_taxonomy_id = uudqv_term_taxonomy.term_taxonomy_id)
WHERE  uudqv_term_taxonomy.taxonomy = 'property-status'
AND uudqv_term_taxonomy.term_id = 560
ORDER BY post_date DESC";





///STANOVI NAJAM
var $queryOglasi2 = "SELECT * FROM uudqv_posts
LEFT JOIN uudqv_term_relationships ON (uudqv_posts.ID = uudqv_term_relationships.object_id)
LEFT JOIN uudqv_term_taxonomy ON (uudqv_term_relationships.term_taxonomy_id = uudqv_term_taxonomy.term_taxonomy_id)
WHERE  uudqv_term_taxonomy.taxonomy = 'property-status'
AND uudqv_term_taxonomy.term_id = 623
ORDER BY post_date DESC";



///POSLOVNI NAJAM
var $queryOglasi3 = "SELECT * FROM uudqv_posts
LEFT JOIN uudqv_term_relationships ON (uudqv_posts.ID = uudqv_term_relationships.object_id)
LEFT JOIN uudqv_term_taxonomy ON (uudqv_term_relationships.term_taxonomy_id = uudqv_term_taxonomy.term_taxonomy_id)
WHERE  uudqv_term_taxonomy.taxonomy = 'property-status'
AND uudqv_term_taxonomy.term_id = 801
ORDER BY post_date DESC";



    //Ured – Office
    var $queryLokalOffice = "
    SELECT * FROM uudqv_posts
    LEFT JOIN uudqv_term_relationships ON (uudqv_posts.ID = uudqv_term_relationships.object_id)
    LEFT JOIN uudqv_term_taxonomy ON (uudqv_term_relationships.term_taxonomy_id = uudqv_term_taxonomy.term_taxonomy_id)
    WHERE  uudqv_term_taxonomy.taxonomy = 'property-type'
    AND uudqv_term_taxonomy.term_id = 789
    ORDER BY post_date DESC";


    //Ulični lokal
    var $queryLokalUli = "
    SELECT * FROM uudqv_posts
    LEFT JOIN uudqv_term_relationships ON (uudqv_posts.ID = uudqv_term_relationships.object_id)
    LEFT JOIN uudqv_term_taxonomy ON (uudqv_term_relationships.term_taxonomy_id = uudqv_term_taxonomy.term_taxonomy_id)
    WHERE  uudqv_term_taxonomy.taxonomy = 'property-type'
    AND uudqv_term_taxonomy.term_id = 799
    ORDER BY post_date DESC";


    //Ugostiteljstvo
    var $queryLokalUgostiteljstvo = "
    SELECT * FROM uudqv_posts
    LEFT JOIN uudqv_term_relationships ON (uudqv_posts.ID = uudqv_term_relationships.object_id)
    LEFT JOIN uudqv_term_taxonomy ON (uudqv_term_relationships.term_taxonomy_id = uudqv_term_taxonomy.term_taxonomy_id)
    WHERE  uudqv_term_taxonomy.taxonomy = 'property-type'
    AND uudqv_term_taxonomy.term_id = 797
    ORDER BY post_date DESC";


    //Hotel
    var $queryLokalHotel = "
    SELECT * FROM uudqv_posts
    LEFT JOIN uudqv_term_relationships ON (uudqv_posts.ID = uudqv_term_relationships.object_id)
    LEFT JOIN uudqv_term_taxonomy ON (uudqv_term_relationships.term_taxonomy_id = uudqv_term_taxonomy.term_taxonomy_id)
    WHERE  uudqv_term_taxonomy.taxonomy = 'property-type'
    AND uudqv_term_taxonomy.term_id = 514 and uudqv_term_taxonomy.term_id = 523
    ORDER BY post_date DESC";




//KUĆE PRODAJA
var $queryKuceProdaja = "SELECT * FROM uudqv_posts
LEFT JOIN uudqv_term_relationships ON (uudqv_posts.ID = uudqv_term_relationships.object_id)
LEFT JOIN uudqv_term_taxonomy ON (uudqv_term_relationships.term_taxonomy_id = uudqv_term_taxonomy.term_taxonomy_id)
WHERE  uudqv_term_taxonomy.taxonomy = 'property-status'
AND uudqv_term_taxonomy.term_id = 881
ORDER BY post_date DESC";


    
    //Stambeno-poslovna
    var $queryKucaStambenoPoslovna = "
    SELECT * FROM uudqv_posts
    LEFT JOIN uudqv_term_relationships ON (uudqv_posts.ID = uudqv_term_relationships.object_id)
    LEFT JOIN uudqv_term_taxonomy ON (uudqv_term_relationships.term_taxonomy_id = uudqv_term_taxonomy.term_taxonomy_id)
    WHERE  uudqv_term_taxonomy.taxonomy = 'property-type'
    AND uudqv_term_taxonomy.term_id = 803
    ORDER BY post_date DESC";


       //Stambeno-poslovna
       var $queryKucaSamostojeca = "
       SELECT * FROM uudqv_posts
       LEFT JOIN uudqv_term_relationships ON (uudqv_posts.ID = uudqv_term_relationships.object_id)
       LEFT JOIN uudqv_term_taxonomy ON (uudqv_term_relationships.term_taxonomy_id = uudqv_term_taxonomy.term_taxonomy_id)
       WHERE  uudqv_term_taxonomy.taxonomy = 'property-type'
       AND uudqv_term_taxonomy.term_id = 880
       ORDER BY post_date DESC";


              //Kuca u nizu
              var $queryKucaNiz = "
              SELECT * FROM uudqv_posts
              LEFT JOIN uudqv_term_relationships ON (uudqv_posts.ID = uudqv_term_relationships.object_id)
              LEFT JOIN uudqv_term_taxonomy ON (uudqv_term_relationships.term_taxonomy_id = uudqv_term_taxonomy.term_taxonomy_id)
              WHERE  uudqv_term_taxonomy.taxonomy = 'property-type'
              AND uudqv_term_taxonomy.term_id = 880
              ORDER BY post_date DESC";


                 //Dvojni objekt
                 var $queryKucaDvoj = "
                 SELECT * FROM uudqv_posts
                 LEFT JOIN uudqv_term_relationships ON (uudqv_posts.ID = uudqv_term_relationships.object_id)
                 LEFT JOIN uudqv_term_taxonomy ON (uudqv_term_relationships.term_taxonomy_id = uudqv_term_taxonomy.term_taxonomy_id)
                 WHERE  uudqv_term_taxonomy.taxonomy = 'property-type'
                 AND uudqv_term_taxonomy.term_id = 880
                 ORDER BY post_date DESC";


                           //Roh Bau
                           var $queryKucaRoh = "
                           SELECT * FROM uudqv_posts
                           LEFT JOIN uudqv_term_relationships ON (uudqv_posts.ID = uudqv_term_relationships.object_id)
                           LEFT JOIN uudqv_term_taxonomy ON (uudqv_term_relationships.term_taxonomy_id = uudqv_term_taxonomy.term_taxonomy_id)
                           WHERE  uudqv_term_taxonomy.taxonomy = 'property-type'
                           AND uudqv_term_taxonomy.term_id = 880
                           ORDER BY post_date DESC";

                                 //Vikendica
                                 var $queryVikendica = "
                                 SELECT * FROM uudqv_posts
                                 LEFT JOIN uudqv_term_relationships ON (uudqv_posts.ID = uudqv_term_relationships.object_id)
                                 LEFT JOIN uudqv_term_taxonomy ON (uudqv_term_relationships.term_taxonomy_id = uudqv_term_taxonomy.term_taxonomy_id)
                                 WHERE  uudqv_term_taxonomy.taxonomy = 'property-type'
                                 AND uudqv_term_taxonomy.term_id = 886
                                 ORDER BY post_date DESC";




                                 

//KUĆE NAJAM
var $queryKuceNajam = "SELECT * FROM uudqv_posts
LEFT JOIN uudqv_term_relationships ON (uudqv_posts.ID = uudqv_term_relationships.object_id)
LEFT JOIN uudqv_term_taxonomy ON (uudqv_term_relationships.term_taxonomy_id = uudqv_term_taxonomy.term_taxonomy_id)
WHERE  uudqv_term_taxonomy.taxonomy = 'property-status'
AND uudqv_term_taxonomy.term_id = 917
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


var $queryOglasi_test = "SELECT * FROM uudqv_posts
LEFT JOIN uudqv_term_relationships ON (uudqv_posts.ID = uudqv_term_relationships.object_id)
LEFT JOIN uudqv_term_taxonomy ON (uudqv_term_relationships.term_taxonomy_id = uudqv_term_taxonomy.term_taxonomy_id)
WHERE  uudqv_term_taxonomy.taxonomy = 'property-status'
AND uudqv_posts.ID BETWEEN 9154 AND 11529
AND uudqv_term_taxonomy.term_id = 560";




}
?>