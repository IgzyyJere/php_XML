<?php
class QueryMain_Context{


//prjašnji query
//  $queryOglasi1 ="
//  select wp_posts.ID, wp_posts.post_title, wp_posts.post_status ,wp_posts.guid ,wp_posts.post_type, wp_posts.post_date, wp_term_taxonomy.term_id, 
//              wp_term_taxonomy.taxonomy, wp_term_taxonomy.description, wp_terms.name, wp_posts.post_content
//              from wp_posts
//              LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
//              LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
//              LEFT JOIN wp_terms ON (wp_term_relationships.term_taxonomy_id = wp_terms.term_id)
//              WHERE wp_posts.post_type = 'property'
//              AND wp_posts.post_status = 'publish'
//              AND wp_terms.name IS NOT NULL
//              ORDER BY post_date DESC";




     //kvart
                                            // $Qkvart = "SELECT wp_term_taxonomy.parent, wp_terms.name, wp_terms.term_id, wp_posts.ID
                                            // from wp_terms
                                            // RIGHT JOIN wp_term_taxonomy on wp_terms.term_id = wp_term_taxonomy.term_id
                                            // LEFT JOIN wp_term_relationships ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
                                            // JOIN wp_posts on wp_posts.ID = wp_term_relationships.object_id
                                            // WHERE wp_posts.ID = ".$row["ID"]."
                                            // AND wp_term_taxonomy.taxonomy = 'property-city'
                                            // GROUP BY wp_term_taxonomy.parent";
                                            // $zupanija = mysqli_query($link, $Qkvart);
                                            // $zupanijaRow = mysqli_fetch_assoc($zupanija);



///stanovi prodaja

// var $queryOglasi1 = "select  wp_posts.ID,  wp_posts.post_content, wp_posts.post_date, wp_posts.post_name,  wp_posts.post_title, wp_posts.guid
// from wp_posts
// WHERE wp_posts.post_type = 'property'
// AND wp_posts.post_status = 'publish'";

var $queryOglasi1 = "SELECT * FROM wp_posts
LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
WHERE  wp_term_taxonomy.taxonomy = 'property-status'
AND wp_term_taxonomy.term_id = 17
ORDER BY post_date DESC";





///stanovi najam
var $queryOglasi2 = "SELECT * FROM wp_posts
LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
WHERE  wp_term_taxonomy.taxonomy = 'property-status'
AND wp_term_taxonomy.term_id = 18
ORDER BY post_date DESC";



///POSLOVNI NAJAM
var $queryOglasi3 = "SELECT * FROM wp_posts
LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
WHERE  wp_term_taxonomy.taxonomy = 'property-status'
AND wp_term_taxonomy.term_id = 22
ORDER BY post_date DESC";


    //Ured – Office
    var $queryLokalOffice = "
    SELECT * FROM wp_posts
    LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
    LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
    WHERE  wp_term_taxonomy.taxonomy = 'property-type'
    AND wp_term_taxonomy.term_id = 23
    ORDER BY post_date DESC";


    //Ulični lokal
    var $queryLokalUli = "
    SELECT * FROM wp_posts
    LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
    LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
    WHERE  wp_term_taxonomy.taxonomy = 'property-type'
    AND wp_term_taxonomy.term_id = 25
    ORDER BY post_date DESC";


        //Ugostiteljstvo
    var $queryLokalUgostiteljstvo = "
    SELECT * FROM wp_posts
    LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
    LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
    WHERE  wp_term_taxonomy.taxonomy = 'property-type'
    AND wp_term_taxonomy.term_id = 26
    ORDER BY post_date DESC";


    //Hotel
    var $queryLokalHotel = "
    SELECT * FROM wp_posts
    LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
    LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
    WHERE  wp_term_taxonomy.taxonomy = 'property-type'
    AND wp_term_taxonomy.term_id = 27
    ORDER BY post_date DESC";




//KUĆE PRODAJA
var $queryKuceProdaja = "SELECT * FROM wp_posts
LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
WHERE  wp_term_taxonomy.taxonomy = 'property-status'
AND wp_term_taxonomy.term_id = 30
ORDER BY post_date DESC";


    
    //Stambeno-poslovna
    var $queryKucaStambenoPoslovna = "
    SELECT * FROM wp_posts
    LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
    LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
    WHERE  wp_term_taxonomy.taxonomy = 'property-type'
    AND wp_term_taxonomy.term_id = 29
    ORDER BY post_date DESC";


       //Stambeno-poslovna
       var $queryKucaSamostojeca = "
       SELECT * FROM wp_posts
       LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
       LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
       WHERE  wp_term_taxonomy.taxonomy = 'property-type'
       AND wp_term_taxonomy.term_id = 31
       ORDER BY post_date DESC";


              //Kuca u nizu
              var $queryKucaNiz = "
              SELECT * FROM wp_posts
              LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
              LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
              WHERE  wp_term_taxonomy.taxonomy = 'property-type'
              AND wp_term_taxonomy.term_id = 32
              ORDER BY post_date DESC";


                 //Dvojni objekt
                 var $queryKucaDvoj = "
                 SELECT * FROM wp_posts
                 LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
                 LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
                 WHERE  wp_term_taxonomy.taxonomy = 'property-type'
                 AND wp_term_taxonomy.term_id = 33
                 ORDER BY post_date DESC";


                           //Roh Bau
                           var $queryKucaRoh = "
                           SELECT * FROM wp_posts
                           LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
                           LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
                           WHERE  wp_term_taxonomy.taxonomy = 'property-type'
                           AND wp_term_taxonomy.term_id = 34
                           ORDER BY post_date DESC";

                                 //Vikendica
                                 var $queryVikendica = "
                                 SELECT * FROM wp_posts
                                 LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
                                 LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
                                 WHERE  wp_term_taxonomy.taxonomy = 'property-type'
                                 AND wp_term_taxonomy.term_id = 34
                                 ORDER BY post_date DESC";





//KUĆE NAJAM
var $queryKuceNajam = "SELECT * FROM wp_posts
LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
LEFT JOIN wp_term_taxonomy ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
WHERE  wp_term_taxonomy.taxonomy = 'property-status'
AND wp_term_taxonomy.term_id = 39
ORDER BY post_date DESC";



}
?>