<?php
class QueryMain_Context{
var $user = "mojecipe_userSh";
var $db = "mojecipe_dbSho_p";
var $passW = "rLwW0wm@4Eh;";





var $queryProduct = "SELECT * FROM loxah_posts
LEFT JOIN loxah_postmeta ON (loxah_posts.ID = loxah_postmeta.post_id)
WHERE  post_type = 'product' AND loxah_postmeta.meta_key like '_stock'
and post_status like 'publish' 
ORDER BY post_date DESC";

var $queryOglasi2 = "SELECT * FROM loxah_posts
LEFT JOIN loxah_term_relationships ON (loxah_posts.ID = loxah_term_relationships.object_id)
LEFT JOIN loxah_term_taxonomy ON (loxah_term_relationships.term_taxonomy_id = loxah_term_taxonomy.term_taxonomy_id)
WHERE  loxah_term_taxonomy.taxonomy = 'property-status'
AND loxah_term_taxonomy.term_id = 623
ORDER BY post_date DESC";




var $queryOglasi3 = "SELECT * FROM loxah_posts
LEFT JOIN loxah_term_relationships ON (loxah_posts.ID = loxah_term_relationships.object_id)
LEFT JOIN loxah_term_taxonomy ON (loxah_term_relationships.term_taxonomy_id = loxah_term_taxonomy.term_taxonomy_id)
WHERE  loxah_term_taxonomy.taxonomy = 'property-status'
AND loxah_term_taxonomy.term_id = 801
ORDER BY post_date DESC";



   
    var $queryLokalOffice = "
    SELECT * FROM loxah_posts
    LEFT JOIN loxah_term_relationships ON (loxah_posts.ID = loxah_term_relationships.object_id)
    LEFT JOIN loxah_term_taxonomy ON (loxah_term_relationships.term_taxonomy_id = loxah_term_taxonomy.term_taxonomy_id)
    WHERE  loxah_term_taxonomy.taxonomy = 'property-type'
    AND loxah_term_taxonomy.term_id = 789
    ORDER BY post_date DESC";


  
    var $queryLokalUli = "
    SELECT * FROM loxah_posts
    LEFT JOIN loxah_term_relationships ON (loxah_posts.ID = loxah_term_relationships.object_id)
    LEFT JOIN loxah_term_taxonomy ON (loxah_term_relationships.term_taxonomy_id = loxah_term_taxonomy.term_taxonomy_id)
    WHERE  loxah_term_taxonomy.taxonomy = 'property-type'
    AND loxah_term_taxonomy.term_id = 799
    ORDER BY post_date DESC";



    var $queryLokalUgostiteljstvo = "
    SELECT * FROM loxah_posts
    LEFT JOIN loxah_term_relationships ON (loxah_posts.ID = loxah_term_relationships.object_id)
    LEFT JOIN loxah_term_taxonomy ON (loxah_term_relationships.term_taxonomy_id = loxah_term_taxonomy.term_taxonomy_id)
    WHERE  loxah_term_taxonomy.taxonomy = 'property-type'
    AND loxah_term_taxonomy.term_id = 797
    ORDER BY post_date DESC";


    //Hotel
    var $queryLokalHotel = "
    SELECT * FROM loxah_posts
    LEFT JOIN loxah_term_relationships ON (loxah_posts.ID = loxah_term_relationships.object_id)
    LEFT JOIN loxah_term_taxonomy ON (loxah_term_relationships.term_taxonomy_id = loxah_term_taxonomy.term_taxonomy_id)
    WHERE  loxah_term_taxonomy.taxonomy = 'property-type'
    AND loxah_term_taxonomy.term_id = 514 and loxah_term_taxonomy.term_id = 523
    ORDER BY post_date DESC";




//KUĆE PRODAJA
var $queryKuceProdaja = "SELECT * FROM loxah_posts
LEFT JOIN loxah_term_relationships ON (loxah_posts.ID = loxah_term_relationships.object_id)
LEFT JOIN loxah_term_taxonomy ON (loxah_term_relationships.term_taxonomy_id = loxah_term_taxonomy.term_taxonomy_id)
WHERE  loxah_term_taxonomy.taxonomy = 'property-status'
AND loxah_term_taxonomy.term_id = 881
ORDER BY post_date DESC";


    
    //Stambeno-poslovna
    var $queryKucaStambenoPoslovna = "
    SELECT * FROM loxah_posts
    LEFT JOIN loxah_term_relationships ON (loxah_posts.ID = loxah_term_relationships.object_id)
    LEFT JOIN loxah_term_taxonomy ON (loxah_term_relationships.term_taxonomy_id = loxah_term_taxonomy.term_taxonomy_id)
    WHERE  loxah_term_taxonomy.taxonomy = 'property-type'
    AND loxah_term_taxonomy.term_id = 803
    ORDER BY post_date DESC";


       //Stambeno-poslovna
       var $queryKucaSamostojeca = "
       SELECT * FROM loxah_posts
       LEFT JOIN loxah_term_relationships ON (loxah_posts.ID = loxah_term_relationships.object_id)
       LEFT JOIN loxah_term_taxonomy ON (loxah_term_relationships.term_taxonomy_id = loxah_term_taxonomy.term_taxonomy_id)
       WHERE  loxah_term_taxonomy.taxonomy = 'property-type'
       AND loxah_term_taxonomy.term_id = 880
       ORDER BY post_date DESC";


              //Kuca u nizu
              var $queryKucaNiz = "
              SELECT * FROM loxah_posts
              LEFT JOIN loxah_term_relationships ON (loxah_posts.ID = loxah_term_relationships.object_id)
              LEFT JOIN loxah_term_taxonomy ON (loxah_term_relationships.term_taxonomy_id = loxah_term_taxonomy.term_taxonomy_id)
              WHERE  loxah_term_taxonomy.taxonomy = 'property-type'
              AND loxah_term_taxonomy.term_id = 880
              ORDER BY post_date DESC";


                 //Dvojni objekt
                 var $queryKucaDvoj = "
                 SELECT * FROM loxah_posts
                 LEFT JOIN loxah_term_relationships ON (loxah_posts.ID = loxah_term_relationships.object_id)
                 LEFT JOIN loxah_term_taxonomy ON (loxah_term_relationships.term_taxonomy_id = loxah_term_taxonomy.term_taxonomy_id)
                 WHERE  loxah_term_taxonomy.taxonomy = 'property-type'
                 AND loxah_term_taxonomy.term_id = 880
                 ORDER BY post_date DESC";


                           //Roh Bau
                           var $queryKucaRoh = "
                           SELECT * FROM loxah_posts
                           LEFT JOIN loxah_term_relationships ON (loxah_posts.ID = loxah_term_relationships.object_id)
                           LEFT JOIN loxah_term_taxonomy ON (loxah_term_relationships.term_taxonomy_id = loxah_term_taxonomy.term_taxonomy_id)
                           WHERE  loxah_term_taxonomy.taxonomy = 'property-type'
                           AND loxah_term_taxonomy.term_id = 880
                           ORDER BY post_date DESC";

                                 //Vikendica
                                 var $queryVikendica = "
                                 SELECT * FROM loxah_posts
                                 LEFT JOIN loxah_term_relationships ON (loxah_posts.ID = loxah_term_relationships.object_id)
                                 LEFT JOIN loxah_term_taxonomy ON (loxah_term_relationships.term_taxonomy_id = loxah_term_taxonomy.term_taxonomy_id)
                                 WHERE  loxah_term_taxonomy.taxonomy = 'property-type'
                                 AND loxah_term_taxonomy.term_id = 886
                                 ORDER BY post_date DESC";




                                 

//KUĆE NAJAM
var $queryKuceNajam = "SELECT * FROM loxah_posts
LEFT JOIN loxah_term_relationships ON (loxah_posts.ID = loxah_term_relationships.object_id)
LEFT JOIN loxah_term_taxonomy ON (loxah_term_relationships.term_taxonomy_id = loxah_term_taxonomy.term_taxonomy_id)
WHERE  loxah_term_taxonomy.taxonomy = 'property-status'
AND loxah_term_taxonomy.term_id = 917
ORDER BY post_date DESC";









//Samo za test i rješavanje buga s lokacijama


var $queryOglasi_test = "SELECT * FROM loxah_posts
LEFT JOIN loxah_term_relationships ON (loxah_posts.ID = loxah_term_relationships.object_id)
LEFT JOIN loxah_term_taxonomy ON (loxah_term_relationships.term_taxonomy_id = loxah_term_taxonomy.term_taxonomy_id)
WHERE  loxah_term_taxonomy.taxonomy = 'property-status'
AND loxah_posts.ID BETWEEN 9154 AND 11529
AND loxah_term_taxonomy.term_id = 560";




}
?>