<?php
require_once('../../../../wp-config.php'); // Before global wpdb can be activated

// Call the search function
echo call_search_vac("search-ul", "search-li"); 

// Search function Caller
function call_search_vac($clsUl, $clsLI)
{
	if(isset($_GET['vactxt']) && !empty($_GET['vactxt'])) return search_vacature($_GET['vactxt'], $clsUl, $clsLI);
}

// Search vacature
function search_vacature($str_, $clsUl, $clsLI)
{
	// Search query
	$sqlq = "SELECT SQL_CALC_FOUND_ROWS  
	wp_posts.ID, wp_posts.post_title FROM wp_posts  WHERE 1=1  
	AND (((wp_posts.post_title LIKE '%$str_%') 
	OR (wp_posts.post_excerpt LIKE '%$str_%') 
	OR (wp_posts.post_content LIKE '%$str_%')))  
	AND wp_posts.post_type = 'post_vacatures' 
	AND ((wp_posts.post_status = 'publish'))  
	ORDER BY wp_posts.post_title LIKE '%$str_%' 
	DESC, wp_posts.post_date DESC LIMIT 0, 10";

	// call to the db
	global $wpdb;
	$search = $wpdb->get_results($sqlq);

	$strresult;
	$strId = " id='search-id' ";
    $strjsCall = "onclick=search_close('search-id');";
	$strclose = "<li " .  $strjsCall . " class='search-li-close'><span class='fa fa-attr-close'></span></li>";
	if( $search != null )
	{
		// readout the vals
		$strresult = "<ul" . $strId . " class='" . $clsUl . "'>";
		foreach($search as $strval)
		{
			$strresult .= "<li class='" . $clsLI . "'><a href='" . get_permalink($strval->ID) . "'>" . $strval->post_title . "</a></li>";
		}
		$strresult .= $strclose . "</ul>";
	}
	else
	{
		$strresult = "<ul" . $strId . " class='" . $clsUl . "'><li class='" . $clsLI . "'>";
			$strresult .= "Helaas geen resultaten";
		$strresult .= "</li>" . $strclose . "</ul>";

	}
	return $strresult;
}
?>