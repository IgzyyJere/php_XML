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


}
?>