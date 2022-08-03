<?php
class QueryMain_Context{
var $user = "root";
var $db = "mojecipeledb";
var $passW = "";


//stock SELECT * FROM `loxah_postmeta` WHERE meta_key like '%stock'
//post _id


//SELECT * FROM `loxah_posts` where post_type like 'product_variation' ORDER BY post_date DESC
//vežu se na post_parent kao id product

//https://wordpress.org/support/topic/sku-already-exists-but-there-no-matching-sku-on-site/

///proizvod
var $queryProduct = "SELECT * FROM loxah_posts
LEFT JOIN loxah_postmeta ON (loxah_posts.ID = loxah_postmeta.post_id)
WHERE  post_type = 'product' AND loxah_postmeta.meta_key like '_stock'
and post_status like 'publish' 
ORDER BY post_date DESC";
//limit 0,5


}
?>