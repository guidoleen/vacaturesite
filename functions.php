<?php
/* Include functions */
include __DIR__ . '/inc/widget.php';
include __DIR__ . '/inc/fnc_team.php';

/* Main inits */
define("PAGE_NR", 5);
define("GOOGLE_KEY", 'AIzaSyCvF9vdnLTOHkKUg4VVX74zva-PT03irXo'); // Google key for differnt API's // CHANGE THIS!!!!!!

/* Team page inits */
define('IMGDIR', 'wp-content/uploads/team/');
define('IMGDIR_TEAM', ABSPATH . IMGDIR);
define('IMGCONT_TEAM', content_url() . '/uploads/team/');
define('IMG_W', 200);
define('IMG_H', 200);

// var_dump( get_intermediate_image_sizes() );
?>
<?php
/**
 * Guido Leen functions and definitions
 */
 // function images URI
 function img_src_uri($strDir)
 {
	 return get_template_directory_uri() . "/images/" . $strDir;
 }

if ( ! function_exists( 'guidoleen_setup' ) ) :
function guidoleen_setup() {
	load_theme_textdomain( 'guidoleen', get_template_directory() . '/languages' );
	// add_theme_support( 'post-thumbnails' );
	// set_post_thumbnail_size( 50, 50 );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'guidoleen' ),
		'social'  => __( 'Social Links Menu', 'guidoleen' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'status',
		'audio',
		'chat',
	) );

	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif; // guidoleen_setup
add_action( 'after_setup_theme', 'guidoleen_setup' );

/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 */
function guidoleen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'guidoleen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'guidoleen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Content Bottom 1', 'guidoleen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'guidoleen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Content Bottom 2', 'guidoleen' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'guidoleen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'guidoleen_widgets_init' );

if ( ! function_exists( 'guidoleen_fontsless_url' ) ) :
/**
 * Register font awsome to the header file
 */
function guidoleen_fontsless_url() 
{
	$fonts_url = '';
	// if ( $fonts ) {
	// 	$fonts_url = add_query_arg( array(), $url)
	return $fonts_url = get_template_directory_uri() . '/css/core.less'; // '/css/font-awesome.less';
}
endif;

function guidoleen_fonts_url() 
{
	$fonts_url = '';
	return $fonts_url = 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700';
}

/**
 * Enqueues scripts and styles.
 */
function guidoleen_scripts() 
{
	// Theme stylesheet.
	// wp_enqueue_style( 'guidoleen_main', get_template_directory_uri() . '/css/main.css');
	// wp_enqueue_style( 'guidoleen_core', get_template_directory_uri() . '/css/core.less');

	// Load the html5 shiv.
	wp_enqueue_script( 'guidoleen-html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3' );
	wp_enqueue_script( 'guidoleen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20160412' );
	// wp_enqueue_script( 'guidoleen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20160412', true );
	wp_enqueue_script( 'less_js', get_template_directory_uri() . '/js/less.min.js');

	// No enque in other pages except the vacaturepage
	$arrUri = get_permalink();
	if( preg_match("/vacatures/", $arrUri))
	{
		wp_enqueue_script( 'filter', get_template_directory_uri() . '/js/filter.js', array('jquery'), '20171605', true);
	}
	wp_enqueue_script( 'search', get_template_directory_uri() . '/js/search.js', array('jquery'), '20172506', true);
}
add_action( 'wp_enqueue_scripts', 'guidoleen_scripts' );


/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function guidoleen_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';

	if ( 'page' === get_post_type() ) {
		840 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	} else {
		840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
		600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'guidoleen_content_image_sizes_attr', 10 , 2 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $attr Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function guidoleen_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( 'post-thumbnail' === $size ) {
		is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
		! is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'guidoleen_post_thumbnail_sizes_attr', 10 , 3 );

/**
 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
 *
 * @since Twenty Sixteen 1.1
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array A new modified arguments.
 */
function guidoleen_widget_tag_cloud_args( $args ) {
	$args['largest'] = 1;
	$args['smallest'] = 1;
	$args['unit'] = 'em';
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'guidoleen_widget_tag_cloud_args' );

/**
* Post type Vacatures
*/
// New post type vacatures
function guidoleen_newpost_type()
{
	$label = array(
		'name'                  => 'vacature',
		'singular_name'         => 'vacatures',
		'menu_name'             => 'vacatures',
		'name_admin_bar'        => 'vacatures',
		'archives'              => 'vacatures_oud',
		'add_new_item'          => 'Voeg nieuwe vacature',
		'add_new'               => 'Voeg nieuwe toe',
		'new_item'              => 'Nieuw Item',
		'edit_item'             => 'Edit Item',
		'update_item'           => 'Update Item'
	);
	$ptype = array(
		'labels' => $label,
		'taxonomies' => array( 'category', 'post_tag' ),
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
	);

	register_post_type('post_vacatures', $ptype);
}
add_action('init', 'guidoleen_newpost_type');

/* The Vacature functies etc. */
// Global arrays
function arr_opleiding()
{
	$arr_opleiding = array(
			'MBO',
			'HBO',
			'WO',
			'Post-doc'
		);
	return $arr_opleiding;
}

function arr_uren()
{
	$arr_uren = array(
		'Minder dan 8',
		'8',
		'24',
		'32',
		'40',
		'anders'
	);
	return $arr_uren;
}

// get the json file
function get_json($strFname)
{
	$arr_json = array();
	$strF = __DIR__ . "/json/" . $strFname;

	$F = fopen($strF, "r");
	if($F == NULL) break; 
		$iSize = filesize($strF);
		$arr_json = JSON_decode(fread($F, $iSize), true);
	fclose($F);
	
	return $arr_json;
}

// Google maps key /* CHANGE THE UNIQUE GOOGLE KEY!!!!! */
function google_maps_key()
{
	return '<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=' . GOOGLE_KEY . '&callback=initMap">
    </script>';
}
// Google maps admin part
function guidoleen_google_maps($lat, $lng)
{
?>
	   <style>
       #map {
        height: 400px;
        width: 100%;
       }
    </style>
    <div id="map"></div>
    <script>
      // Globals
      var evLat = 0;
      var evLng = 0;

      // Read out lat and long
      function eventHandle(e)
      {
          evLat = e.latLng.lat();
          evLng = e.latLng.lng();

          document.getElementById("n_lat").value = evLat;
          document.getElementById("n_lng").value = evLng;
      }
      var marker;
      function initMap() 
      {
        var uluru = {lat: 
			<?php echo $lat ?>
		, lng: 
			<?php echo $lng ?>
		};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 12,
          center: uluru
        });
          marker = new google.maps.Marker({
          position: uluru,
          map: map,
          draggable: true
        });

        // Eventlistener calling handler
        marker.addListener('dragend', eventHandle);
      }
    </script>

    <?php echo google_maps_key(); ?>

    <input id="n_lat" name="in_lat" type="hidden"/>
    <input id="n_lng" name="in_lng" type="hidden"/>

<?php
}
	
// Add metabox functionality >> TODO UREN Laten zien
function guidoleen_metbox_vacatures($postval)
{
	$arr_opleiding = arr_opleiding(); // global function array
	$arr_uren = arr_uren(); // global function array
?>
	<table class="admin_tble" style="width: 100%;">
		<tr>
			<td style="vertical-align: top; width: 30%;">
				<?php echo $strval01 ?>
				<b>Opleidings niveau:</b><br>
				<select name="opleiding">
					<?php
						$str_val01 = get_post_meta($postval->ID, 'opleiding', true);
						foreach($arr_opleiding as $str_opl)
						{
							if( $str_val01 == strip_string( $str_opl ))
							{
								echo "<option selected value=" . strip_string( $str_opl ) . ">" . $str_opl . "</option>";
							}
							else{
								echo "<option value=" . strip_string( $str_opl ) . ">" . $str_opl . "</option>";
							}
						}
					?>
				</select>
			</td>
			<td style="vertical-align: top; width: 30%;">
				<b>Aantal uren:</b><br>
				<?php
					$arr_val01 = get_post_meta($postval->ID, 'uren', true);
					$str_uren = arr_uren();
			
					for($iC=0, $iN=sizeof($str_uren); $iC<$iN; $iC++)
					{
						for($i=0, $n=sizeof($arr_val01); $i<$n; $i++)
						{
							if($arr_val01[$i] == strip_string( $str_uren[$iC] ))
							{
								echo "<input type='checkbox' checked name='uren[]' value='" . strip_string( $str_uren[$iC] ) . "' />" . $str_uren[$iC];
								echo "<br>";
								$iC++;
							}
						}
						echo "<input type='checkbox' name='uren[]' value='" . strip_string( $str_uren[$iC] ) . "' />" . $str_uren[$iC];
						echo "<br>";
					}
				?>
			</td>
			<td style="vertical-align: top; width: 30%;">
				<b>Vakgebied:</b><br>
				<select name="vakgebied">
				<?php
					$arr_vakgebied = get_json("vakgebied.json");
					$str_val02 = get_post_meta($postval->ID, 'vakgebied', true);
					for($iC = 0, $n = sizeof($arr_vakgebied["vak"]); $iC<$n; $iC++)
					{
						if($str_val02 === strip_string( $arr_vakgebied["vak"][$iC] ))
						{
							echo "<option selected value='" . strip_string( $arr_vakgebied["vak"][$iC] ) . "'>" . $arr_vakgebied["vak"][$iC] . "</option>";
						}
						else
						{
							echo "<option value='" . strip_string( $arr_vakgebied["vak"][$iC] ) . "'>" . $arr_vakgebied["vak"][$iC] . "</option>";
						}
					}
				?>
				</select>
			</td>
		</tr><!-- END FISRT ROW -->
		<tr>
			<td>
				
				<?php 
					// Call the google maps
					$startLat = 52;
					$startLng = 5;

					$arr2_latlong = get_post_meta( $postval->ID, 'latlong', true);
					if(!empty($arr2_latlong))
					{
						if($arr2_latlong[0] != "" &&  $arr2_latlong[1] != "")
						{
							guidoleen_google_maps($arr2_latlong[0], $arr2_latlong[1]);	
						}
						if($arr2_latlong[0] == "" &&  $arr2_latlong[1] == "")
						{
							guidoleen_google_maps($startLat , $startLng);
						}
					}
					else
					{
						guidoleen_google_maps($startLat , $startLng);
					}
				?>
			</td>
		</tr>
	</table>
<?php
}

// Update the post info
function guidoleen_post_vacature($postid, $postval)
{
	if( $postval->post_type == 'post_vacatures' )
	{
		// Taxonomies
		if( !empty( $_POST['tax_input'] ))
		{
			$arrTax = [];
			$i = 0;
			$strFlag = "";

			foreach( $_POST['tax_input']['Vacature_tax'] as $key => $val)
			{
				if( $arrTax[$i] != '0' )
				{
					$strFlag = "tax" . $val;
					$arrTax[$i] = strip_string( $strFlag );
					$strFlag = "";
					$i++;
				}
			}

			update_post_meta( $postid, 'taxonomy', $arrTax );
		}

		// Opleiding
		if( isset($_POST['opleiding']))
		{
			update_post_meta($postid, 'opleiding', $_POST['opleiding'] );
		}

		// Uren array
		if( !empty($_POST['uren']))
		{
			$arrUren = $_POST['uren'];
			update_post_meta($postid, 'uren', $arrUren);
		}

		// Vakgebied 
		if( isset($_POST['vakgebied']))
		{
			update_post_meta($postid, 'vakgebied', $_POST['vakgebied']);
		}

		// Google maps
		$arr2_latlong = get_post_meta( $postval->ID, 'latlong', true);

		if( !empty($_POST['in_lat']) && !empty($_POST['in_lng']) )
		{
			$arrLatLong = array(
				$_POST['in_lat'],
				$_POST['in_lng']
				);
			update_post_meta($postid, 'latlong', $arrLatLong);
		}
	}

}
add_action('save_post', 'guidoleen_post_vacature', 10, 2);

// the metabox
function metbox_vacatures()
{
	add_meta_box('metabox_vacatures',
		'Vacature invoer',
		'guidoleen_metbox_vacatures',
		'post_vacatures',
		'normal', 'high'
	);
}
add_action('admin_init', 'metbox_vacatures');

// Add single page for post type
function guidoleen_vac_singlepage($str_uri)
{
	if( get_post_type() == 'post_vacatures' )
		{
			if( is_single() )
			{
				$str_uri = dirname(__FILE__) . '/single-vacature.php';
			}
		}
	return $str_uri;
}
add_filter( 'template_include', 'guidoleen_vac_singlepage', 1 );

// Google map on page
function map_on_page($lat, $lng)
{
?>
	<div id="map"></div>
    <script>
      function initMap() 
      {
        var uluru = {lat: 
			<?php echo $lat ?>
		, lng: 
			<?php echo $lng ?>
		};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 12,
          center: uluru
        });
          marker = new google.maps.Marker({
          position: uluru,
          map: map,
          draggable: false
        });
      }
    </script>

<?php echo google_maps_key(); 
}
?>
<?php

/* TAXONOMIES PART */
// create taxonomy, vacature items the post type "vacature"
function create_vacitems_taxonomies() 
{
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => 'Vacature items',
		'singular_name'     => 'Vacature item',
		'search_items'      => 'Zoek items',
		'all_items'         => 'Alle items',
		'parent_item'       => 'Parent item',
		'parent_item_colon' => 'Parent item',
		'edit_item'         => 'Edit item',
		'update_item'       => 'Update item',
		'add_new_item'      => 'Add New vac item',
		'new_item_name'     => 'New vac item naam',
		'menu_name'         => 'Vacature item'
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'vacatureitem' ),
	);

	register_taxonomy('Vacature_tax', array('post_vacatures'), $args);
}
add_action('init', 'create_vacitems_taxonomies');

// Load the taxonomies
function guidoleen_load_tax($id, $ptype, $args)
{
		return $terms = wp_get_post_terms( $id, $ptype, $args );
}

// Post date array
function arr_datetext()
{
	return $arr_datetext = array(
		"vandaag geplaatst",
		"gister geplaatst",
		"dagen"
	);
}

// Post date function
function guidoleen_postthe_date($IdDate)
{
	$IdDate = preg_replace('/-/', "", $IdDate);
	$IdDate = date("Ymd") - $IdDate;

	$arr_datetext = arr_datetext();
	$iArr = sizeof($arr_datetext);

	$re_text = "";
	if($IdDate == 0)
	{
		$re_text = $arr_datetext[0];
	}
	if($IdDate == 1)
	{
		$re_text  = $arr_datetext[1];
	}
	if($IdDate>1)
	{
		$re_text  = $IdDate . " " . $arr_datetext[$iArr-1];
	}

	return $re_text;
}

// TEMPLATE > the posts_vacatures in content template on index.php page
function show_the_posts($arr_)
{
	$arr_post_vac = $arr_;

	if($arr_ == null)
	{
		die("Geen vacatures gevonden...");
	}
	else
	{
		$iC = 0;
		while($i<sizeof($arr_))
		{
			?>
			<div onclick="window.location.href='<?php echo $arr_post_vac->guid ?>'">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php 
						echo sprintf( '<h2 class="vac-title">%s<a href="%s" rel="bookmark"></a></h2>', $arr_post_vac->post_title, esc_url( $arr_post_vac->guid )); 
						
						// Date element, opleiding, hours bar
						$arr_Uren = get_post_meta( $arr_post_vac->ID, 'uren', true ); // Array uren
						echo 	'<ul class="vac-infobar-ul">' .
									'<li class="vac-infobar-li"><span class="fa fa-graduation-cap relative"></span>' .
										strip_string_back( get_post_meta( $arr_post_vac->ID, 'opleiding', true ) ) . '</li>' .
									'<li class="vac-infobar-li"><span class="fa fa-clock-o relative"></span>' . 
										strip_string_custom( $arr_Uren[0], "Minderdan", "< ") . ' uur' . '</li>' .
									'<li class="vac-infobar-li"><span class="fa fa-address-card relative"></span>' . 
										guidoleen_postthe_date($arr_post_vac->post_date) . '</li>' .
								"</ul><br>";
					?>
				</header><!-- .entry-header -->

				<div class="entry-content">
					<?php
						$iCount = 100;
						echo substr($arr_post_vac->post_content, 0, $iCount) . '... ';
						echo sprintf( '<a href="%s" rel="bookmark"> <span class="fa fa-attr-arrowRight relative"></span></a>', $arr_post_vac->guid );
						echo '<br><div class="div-line relative"></div>';
					?>
				</div><!-- .entry-content -->

				<footer class="entry-footer">
					<?php
						
					?>
				</footer><!-- .entry-footer -->
			</article><!-- #post-## -->
			</div>
			<?php
			$i++;
		}
	}
}

// Function for vacature posts FIRST TIME >> functions.php
function show_post_start($str_Page, $str_order, $page_nr)
{
            if( ! have_posts())
            {
                $iC = 0;
				$iCount = new WP_Query();
				$iCount = $iCount->query( 'post_type=post_vacatures&post_status=publish');
				$iCount = count( $iCount );

				echo show_bar_vacat( show_post_ammount( $iCount ) );
				
                $arrvac = array('post_type' => 'post_vacatures', 'posts_per_page' => PAGE_NR, 'offset' => $str_Page, 'order' => $str_order);
                $wploop = new WP_Query( $arrvac );
                while($wploop->have_posts()) : $wploop->the_post();
                {
                        $arr_post_vac[$iC] = get_post();
                        	show_the_posts( $arr_post_vac[$iC] ); // pass the array through show post call
                    $iC++;
                }
                endwhile;

				echo show_bar_vacat( show_post_ammount( $iCount ) );
				echo vacature_pager( $iCount, $page_nr );
            }
            else
            {
                $arr_post_vac[0] = "No milk today";
            }
}

// function Pager vacature posts
function vacature_pager($iCount, $iPagenr)
{
	$str_pager = "";
	$iMAX_PGR = 5;

	if($iCount > PAGE_NR)
	{
		$str_pager = '<div id="vac-pager"><ul class="vac-pager">';

			// Check if page is first page or not >> show the backward button or not
			if($iPagenr != 0)
			{
				$str_pager .= '<li class="vac-page-li"><div class="vac-prev" onclick="page_nr(' . ($iPagenr-1) . ', this.id);" > < </div></li>';
			}
			else
			{
				$str_pager .= ''; // Show empty button
			}
			
			// Building the pager
			$str_actv = "";
			$iN = ceil($iCount/PAGE_NR);

			for($i=$iPagenr, $iC=0, $n = $iN , $l = $iMAX_PGR; $i<$n && $iC<$l; $i++, $iC++)
			{	
				// $str_pager .= '<li class="vac-page-li"><span id="p' . $i . '" class="vac-page" pager="' . ( (int)($i) ) . '">' . ( (int)($i) +1) . '</span></li>';
				$str_actv = "";
				( $iPagenr == $i ) ? $str_actv = " page-active " : $str_actv = "";
				$str_pager .= '<li class="vac-page-li '. $str_actv . '"><div id="p' . $i . '" onclick="page_nr(' . $i . ', this.id);" class="vac-page" pager="' . ( (int)($i) +1) . '">' . ( (int)($i) +1) . '</div></li>';
			}
			// The last pagenr
			if($iN > PAGE_NR)
			{
				$str_pager .= '<li class="vac-page-li "><div class="vac-page">...</div></li>';
				$str_pager .= '<li class="vac-page-li '. $str_actv . '"><div id="p' . ( $iN-1 ) . '" onclick="page_nr(' . ( $iN-1 ) . ', this.id);" class="vac-page" pager="' . ( (int)(( $iN-1 )) +1) . '">' . ( (int)(( $iN-1 )) +1) . '</div></li>';
			}
			
			// Check if page is last page or not >> show the forward button or not
			if( ($iPagenr+1) != $n )
			{
				$str_pager .= '<li class="vac-page-li"><div class="vac-next" onclick="page_nr(' . ($iPagenr+1) . ', this.id);" > > </div></li>';
			}
		$str_pager .= "</ul></div>";
	}
 	return $str_pager;
}

// Function Asc desc filter
function filter_asc_desc()
{
	return	"<div ident='asc_desc' class='slct-menu wt-half absolute'>
                <div class='slct-menu-start selct-ascdesc'>
                    <span class='slct-txt' countr=0 val=''>Boven/Beneden</span>
                    <span class='fa fa-attr-arrow'></span>
                </div>
				<ul class='slct-menu-ul absolute hide'>
					<li class='slct-menu-li' val='DESC'> Recente </li>
					<li class='slct-menu-li' val='ASC'> Laatste </li>
				</ul>
			</div>";
}

// Error message for no vacatures
function err_no_vac()
{
	return show_bar_vacat( "Helaas geen vacatures gevonden...." );
}

// Function show ammount posts
function show_post_ammount($i)
{
	return ' Er ' . ( ($i > 1) ? 'zijn ' : 'is ' ) . $i . ' vacature' . ( ($i > 1) ? 's' : '' ) . ' gevonden:';
}

// function show bar top of vacatures
function show_bar_vacat($strVal)
{
	return '<div class="post-ammount"><div class="post-amount-txt"> ' . $strVal .'</div></div>';
}

// Function google maps geocode to lat long
function google_lat_long($strval)
{
	$strErr = err_no_vac();
	try
	{
		$arr_google = json_decode( file_get_contents( 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($strval) . '&key=' . GOOGLE_KEY ), true );
		if($arr_google == null) die( $strErr );
	}
	catch(Exeption $e)
	{
		// $e
		$strErr;
	}

	return $arr_latlong = array(
		"lat" => $arr_google['results'][0]['geometry']['location']['lat'],
		"lng" => $arr_google['results'][0]['geometry']['location']['lng']
	);
}

// Function compare geocode coordinates based on distance
function comp_cordin_google($iLatBase, $iLngBase, $iLat, $iLng, $dist)
{
	$iLat_ = check_i_negative( $iLatBase - $iLat );
	$iLng_sin = sin( (pi() / 180) * $iLat );

	$iLat_ = ($iLat_ * $iLat_);
	$iLng_ = check_i_negative( $iLngBase - $iLng );
	$iLng_ = ($iLng_ * $iLng_);

	$iTotal = ( sqrt( $iLat_ + $iLng_ ) * 111.136 ); // 360 part of the total earth's circumference of 40009 km

	// Compare the values
	if($iTotal <= $dist) return true;

return false;
}

// Function check if no is negative
function check_i_negative($iN)
{
	return ($iN < 0) ? ($iN * -1) : $iN;
}

// Function strip values for database
function strip_string($str)
{
    return 'db_' . str_replace(' ', '', $str);
}

function strip_string_back($str)
{
    return str_replace('db_', '', $str);
}

function strip_string_custom($str, $strRep, $strNew)
{
	$str_ = strip_string_back($str);
	$str_ = str_replace($strRep, $strNew, $str_);
	return $str_;
}

function strip_to_underscore($str)
{
	return str_replace('-', '_', $str);
}

function strip_str_tax($str)
{
	return 'db_tax' . str_replace(' ', '', $str);
}

function strip_str_nospace($str)
{
	return str_replace(' ', '', $str);
}

//function for counters next to categories
function count_categories( $arr, $tax )
{
	if( is_array($arr) )
	{
		if($arr != null)
		{
			$str_query = 'SELECT';
			for ($i=0, $n=sizeof($arr); $i < $n; $i++) 
			{ 
				if($tax == 1)
				{
					$str_query .= " sum(wp_postmeta.meta_value LIKE '%" . strip_str_tax( $arr[$i] ) . "%') AS " . strip_to_underscore( strip_str_tax( $arr[$i] ) );
				}
				else
				{
					$str_query .= " sum(wp_postmeta.meta_value LIKE '%" . strip_string( $arr[$i] ) . "%') AS " . strip_to_underscore( strip_string( $arr[$i] ) );
				}
				$str_query .= ($i != ($n-1)) ? ',' : '';
			}
			$str_query .= ' FROM wp_postmeta';

			global $wpdb;
			$arr_count = $wpdb->get_results($str_query);

			return $arr_count;
		}
	}
	return null;
}

// SINGLE PAGE FUNCTIONS
// Function page prev next
function page_prev_next()
{
	$previous = get_previous_post_link(
        '%link',
        '<li class="vac-page-li">' . '<div class="vac-page"> << </div>' . '</li> '
    );

	$next = get_next_post_link(
        '%link',
        '<li class="vac-page-li">' . '<div class="vac-page"> >> </div>' . '</li> '
    );

	return '<div id="vac-pager"><ul class="vac-pager">' . $previous . $next . '</ul></div>';
}

// function li cloudtags
function li_cloud_tag($str)
{
	return  '<li class="vac-page-licloudt">' . $str . '</li> ';
}
?>