# php_XML

//predložak 
//https://themeselection.com/bootstrap-simple-admin-panel-template-free/


# sql upit
SELECT post_title, post_content, date_format(post_date, '%d-%m-%Y') as datum , kgrdr_terms.name
FROM `kgrdr_posts`
   LEFT JOIN kgrdr_term_relationships ON (kgrdr_posts.ID = kgrdr_term_relationships.object_id)
        LEFT JOIN kgrdr_term_taxonomy ON (kgrdr_term_relationships.term_taxonomy_id = kgrdr_term_taxonomy.term_taxonomy_id)
        LEFT JOIN kgrdr_terms ON (kgrdr_term_relationships.term_taxonomy_id = kgrdr_terms.term_id)
WHERE `post_content` like '%HEP%' 
AND post_status like 'publish' AND post_type like 'post' 
AND post_date BETWEEN '2019-01-01' and '2020-01-01'