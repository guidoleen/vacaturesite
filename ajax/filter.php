<?php

require_once('../../../../wp-config.php'); // Before global wpdb can be activated
global $wpdb;

// Get the vals from the querystring and put them in arr for building SQL Query
$arr_Qstr = explode("&", $_SERVER['QUERY_STRING']);
$str_Page = ( $_GET['page'] * PAGE_NR ); // The page numbr
$strStart = $_GET['start']; // If start show post start()
$str_Count = ""; // Count all the records in filter

if($strStart == 0) // $_SERVER['QUERY_STRING'] == null || sizeof($arr_Qstr)<=2 && 
{
    echo show_post_start($str_Page, $_GET['asc_desc'], $_GET['page']);
}
else if(isset($_GET['tax']) || isset($_GET['uren']) || isset($_GET['opleid']) || isset($_GET['vakgeb']) || isset($_GET['search']) )
{
    if($arr_Qstr != null)
    {
        $arr_vals = array();

        $i = 0;
        while($i < sizeof($arr_Qstr))
        {
            parse_str( $arr_Qstr[$i], $arr_vals[$i] );
            $i++;
        }

        // SQL query // SQL_CALC_FOUND_ROWS
        $str_Quer = "";
        $str_Quer = "SELECT DISTINCT
                    wp_postmeta.post_id
                    FROM
                    wp_postmeta
                    WHERE wp_postmeta.meta_value = 'nonsense' "; // First meta_value must be with a value otherwise it gives a wrong select count()

        $str_Quer2 = "";
        $str_QuerF = "";
        $str_ASC = "";

        for( $i = 0, $n = sizeof($arr_vals);  $i < $n; $i++)
        {
            if( $arr_vals[$i]['uren'] )
            {
                $str_Quer .= "OR wp_postmeta.meta_value LIKE '%" . $arr_vals[$i]['uren'] . "%' AND wp_postmeta.meta_key = 'uren'";
            }

            if( $arr_vals[$i]['opleid'] )
            {
                $str_Quer .= "OR wp_postmeta.meta_value LIKE '%" . $arr_vals[$i]['opleid'] . "%' AND wp_postmeta.meta_key = 'opleiding'";
            }

            if( $arr_vals[$i]['vakgeb'] )
            {
                $str_Quer .= "OR wp_postmeta.meta_value LIKE '%" . $arr_vals[$i]['vakgeb'] . "%' AND wp_postmeta.meta_key = 'vakgebied'";
            }

            // Select from taxonomy table
            if( $arr_vals[$i]['tax'] )
            {
                $str_QuerF = "UNION SELECT DISTINCT wp_term_relationships.object_id FROM wp_term_relationships WHERE wp_term_relationships.term_taxonomy_id = '' ";
                $str_Quer2 .= "OR wp_term_relationships.term_taxonomy_id = " . $arr_vals[$i]['tax'] . " ";
            }

            // Select from the title (Search)
            if( $arr_vals[$i]['search'] )
            {
                $str_Quer .= " UNION SELECT DISTINCT wp_posts.ID from wp_posts 
                                WHERE wp_posts.post_status = 'publish' 
                                AND wp_posts.post_type = 'post_vacatures' 
                                AND wp_posts.post_title LIKE '%" . $arr_vals[$i]['search'] . "%'"; // 
            }

            // ASC DESC at the end of query
            if( $arr_vals[$i]['asc_desc'] )
                $str_ASC = $arr_vals[$i]['asc_desc'];

            if( $arr_vals[$i]['page'] )
                $str_Page = 0;
                $str_Page = ( $arr_vals[$i]['page'] * PAGE_NR );
                // $str_Page = ($str_Page * PAGE_NR);
        }

        $str_Quer = $str_Quer . $str_QuerF . $str_Quer2;

            // First count the number of records....
            $str_Count = "SELECT COUNT('post_id') FROM (";
            $str_Count .= $str_Quer;
            $str_Count .= ") AS ICOUNT";

            $arr_Count = $wpdb->get_results($str_Count);

            $countr = 0;
            foreach( $arr_Count[0] as $key => $val)
            {
                $countr = $val;
            }
            // End First count

        $str_Quer .= " ORDER BY post_id ";

        if( !isset($_GET['googl']) ) // if not google for distance measurement
        {
            $str_Quer .= " LIMIT " . $str_Page .  ", " . PAGE_NR;
        }

        // Extend query for google latlong from wp_meta_value LIKE 'latlong'
        $str_xtra = "SELECT DISTINCT pm.meta_value, pm.post_id
                    FROM wp_postmeta AS pm 
                    INNER JOIN
                    (";
            $str_xtra .= $str_Quer; // Put in the orginal Query
        $str_xtra .= ") 
                    AS pm2
                    ON
                    pm.post_id = pm2.post_id
                    WHERE pm.meta_key = 'latlong' 
                    ORDER BY pm.post_id " . $str_ASC;

        $str_Quer = $str_xtra;

        $arr_results = $wpdb->get_results($str_Quer); // DB Call
        $iArr = sizeof($arr_results);

        // Create array for distance comparisment
        if( isset($_GET['googl']) )
        {
            $arr_results = latlong_distnce($arr_results); // Check if the distance is correct and return new array
            
             $countr = sizeof($arr_results);

            $arr_flag = [];
            $iC = ($_GET['page'] * PAGE_NR);
            for ($i = 0, $n = PAGE_NR; $i < $n && $iC < $countr; $i++) // Passing to new array with arrayflag for paging
            {
                $arr_flag[$i] = $arr_results[$iC];
                $iC = ($iC+1);
            }
            $iArr = sizeof($arr_flag);
            pass_arr_posts($iArr, $arr_flag, $countr); // function call >> function below
        }
        else
        {
            pass_arr_posts($iArr, $arr_results, $countr); // function call >> function below
        }
    }
}
else // When no filtering took place except the google filter
{
    if( isset($_GET['googl']) )
    {
        $str_Quer = "SELECT DISTINCT PM.meta_value, PM.post_id FROM wp_postmeta AS PM WHERE meta_key = 'latlong'";
        $arr_results = $wpdb->get_results($str_Quer); // DB Call

        $arr_results = latlong_distnce($arr_results); // Check if the distance is correct and return new array
      
        $countr = sizeof($arr_results);

            $arr_flag = [];
            $iC = ($_GET['page'] * PAGE_NR);
            for ($i = 0, $n = PAGE_NR; $i < $n && $iC < $countr; $i++) // Passing to new array with arrayflag for paging
            {
                $arr_flag[$i] = $arr_results[$iC];
                $iC = ($iC+1);
            }

        $iArr = sizeof($arr_flag);
        pass_arr_posts($iArr, $arr_flag, $countr); // function call >> function below
    }
}

// Function for passing array to posts
function pass_arr_posts($iArr_, $arr_results_, $countr_)
{
    if($iArr_ > 0)
        {
            echo show_bar_vacat( show_post_ammount( $countr_ ) );

            $arr_post_vac = null;
            $iC = 0;
            while($iC < $iArr_)
            {
                $arr_post_vac[$iC] = get_post( $arr_results_[$iC]->post_id ); // Give the results to the array
                    show_the_posts( $arr_post_vac[$iC] ); // call function in the function.php 

                $iC++;
            }

            echo show_bar_vacat( show_post_ammount( $countr_ ) );
            if( !( $arr_vals[$i]['page'] * PAGE_NR ) >= $countr_ )
            {
                echo vacature_pager( $countr_, $_GET['page'] ); // call pager function in function.php and set no start pager
            }
            $iC = 0;
        }
        else
        {
            die( err_no_vac() ); // ERROR message
        }
}

// Function checker if latlong compare to distance
function latlong_distnce($arr_posts)
{
     // Retrieve val from input adress and convert to lat long
    $arr_new = [];
    $arr_latlng_post = [];
    for($i = 0, $n = sizeof($arr_posts); $i<$n; $i++) // put the serialize string from mysql to unserialize
    {
        $arr_latlng_post[$i] = unserialize($arr_posts[$i]->meta_value);
    }

    // The actual comparing distance vs lat long
    $iC = 0;
    $arr_latlong = google_lat_long($_GET['googl']); // Call the latlong function once from google based on the given adress/postal code
    for($i = 0, $n = sizeof($arr_posts); $i<$n; $i++)
    {
        $iLat = $arr_latlng_post[$i][0];
        $iLng = $arr_latlng_post[$i][1];

        // Check if vals from the post adresses are within the distance range and call the function in function.php
        if( comp_cordin_google($arr_latlong['lat'], $arr_latlong['lng'], $iLat, $iLng, $_GET['dist']) )
        {
            $arr_new[$iC] = $arr_posts[$i];
            $iC = ($iC + 1);
        }
    }
    return $arr_new;
}

// SELECT DISTINCT
// wp_postmeta.post_id
// FROM
// wp_postmeta
// WHERE wp_postmeta.meta_value = '' OR wp_postmeta.meta_value LIKE '%db_Minderdan8%' AND wp_postmeta.meta_key = 'uren'OR wp_postmeta.meta_value LIKE '%db_24%' AND wp_postmeta.meta_key = 'uren'OR wp_postmeta.meta_value LIKE '%db_MBO%' AND wp_postmeta.meta_key = 'opleiding'OR wp_postmeta.meta_value LIKE '%db_Bouw%' AND wp_postmeta.meta_key = 'vakgebied'
// UNION SELECT DISTINCT wp_term_relationships.object_id FROM wp_term_relationships WHERE wp_term_relationships.term_taxonomy_id = '' OR wp_term_relationships.term_taxonomy_id = 4 
// UNION SELECT wp_posts.ID from wp_posts WHERE  wp_posts.post_status = 'publish' AND wp_posts.post_type = 'post_vacatures' AND wp_posts.post_title LIKE '%C#%'
?>
            