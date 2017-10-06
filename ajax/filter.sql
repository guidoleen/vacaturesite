SELECT DISTINCT
                    wp_postmeta.post_id
                    FROM
                    wp_postmeta
                    WHERE wp_postmeta.meta_value = '' OR wp_postmeta.meta_value LIKE '%db_Minderdan8%' AND wp_postmeta.meta_key = 'uren'OR wp_postmeta.meta_value LIKE '%db_24%' AND wp_postmeta.meta_key = 'uren'OR wp_postmeta.meta_value LIKE '%db_MBO%' AND wp_postmeta.meta_key = 'opleiding'OR wp_postmeta.meta_value LIKE '%db_Bouw%' AND wp_postmeta.meta_key = 'vakgebied'
                    UNION SELECT DISTINCT wp_term_relationships.object_id FROM wp_term_relationships WHERE wp_term_relationships.term_taxonomy_id = '' OR wp_term_relationships.term_taxonomy_id = 4 
                    UNION SELECT wp_posts.ID from wp_posts WHERE  wp_posts.post_status = 'publish' AND wp_posts.post_type = 'post_vacatures' AND wp_posts.post_title LIKE '%C#%'



////

SELECT DISTINCT pm.meta_value, pm.post_id
                    FROM wp_postmeta AS pm 
                    INNER JOIN
                    (SELECT DISTINCT
                    wp_postmeta.post_id
                    FROM
                    wp_postmeta
                    WHERE wp_postmeta.meta_value = '' OR wp_postmeta.meta_value LIKE '%db_HBO%' AND wp_postmeta.meta_key = 'opleiding'OR wp_postmeta.meta_value LIKE '%db_WO%' AND wp_postmeta.meta_key = 'opleiding'UNION SELECT DISTINCT wp_term_relationships.object_id FROM wp_term_relationships WHERE wp_term_relationships.term_taxonomy_id = '' OR wp_term_relationships.term_taxonomy_id = 2 OR wp_term_relationships.term_taxonomy_id = 3  ORDER BY post_id ) 
                    AS pm2
                    ON
                    pm.post_id = pm2.post_id
                    WHERE pm.meta_key = 'latlong' 
                    ORDER BY pm.post_id DESC
