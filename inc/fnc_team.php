<?php
/**
* Post type Team
*/
// New post type vacatures
function guidoleen_posttype_team()
{
	$label = array(
		'name'                  => 'team',
		'singular_name'         => 'team',
		'menu_name'             => 'team',
		'name_admin_bar'        => 'team',
		'archives'              => 'team_oud',
		'add_new_item'          => 'Voeg nieuw teammember',
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

	register_post_type('post_team', $ptype);
}
add_action('init', 'guidoleen_posttype_team');

/* The Team functies etc. */
// Add metabox functionality
function guidoleen_metbox_team($postval)
{
?>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/admin/guidoleen_admin.css' ?>" ></link>
	<table class="admin_tble" style="width: 100%;">
            <tr>
                <td style="vertical-align: top; width: 30%;">
                    <b>Functie team member</b><br>
                        <?php
                            $tfunctn = get_post_meta($postval->ID, 'team_function');
                        ?>
					<input type="text" name="team_function" value="<?php echo $tfunctn[0]; ?>" />
					<p></p>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 30%;">
                    <b>Email team member</b><br>
                        <?php
                            $temail = get_post_meta($postval->ID, 'team_email');
                        ?>
					<input type="text" name="team_email" value="<?php echo $temail[0]; ?>" />
					<p></p>
                </td>
            </tr>
		</tr><!-- END FISRT ROW -->
		<tr style="height: 300px; vertical-align: top;">
			<td>
                <b>Upload foto team member</b><br>
				<?php 
					
				?>
					<h2 onclick="openiframe();" class="button2 button2-primary button2-green show w-auto" style="width: auto;">Je foto plaatsen....</h2>
			</td>
		</tr>
	</table>
	<div id="container_iframe_img">
		<div id="wrapper_iframe_img">
			<span id="shutiframe" class="shut" onclick="shutiframe();">×</span>
			<iframe id="iframe_img" width="100%" src="<?php echo content_url() . '/themes/guidoleen/inc/fnc_team_photo.php?id=' . $postval->ID  ?>"></iframe> 
		</div>
		<div id="back_iframe_img">
		</div>
	</div>
	<script src="<?php echo get_template_directory_uri() . '/js/teamimg.js' ?>"></script>
<?php
}

// Update the post info
function guidoleen_post_team($postid, $postval)
{
	if( $postval->post_type == 'post_team' )
	{
        // Functie member
		if( isset($_POST['team_function']))
		{
			update_post_meta($postid, 'team_function', $_POST['team_function'] );
        }
        
        // Email member
		if( isset($_POST['team_email']))
		{
			update_post_meta($postid, 'team_email', $_POST['team_email'] );
		}
	}
}
add_action('save_post', 'guidoleen_post_team', 10, 2);

// the metabox
function metbox_team()
{
	add_meta_box('metabox_team',
		'Team member invoer',
		'guidoleen_metbox_team',
		'post_team',
		'normal', 'high'
	);
}
add_action('admin_init', 'metbox_team');

// TEMPLATE > the posts_team in content template on team.php page post_team
function show_team_posts($arr_)
{
	$arr_post_team = $arr_;

	if($arr_ == null)
	{
		die("Geen team members gevonden...");
	}
	else
	{
		$iC = 0;
		while($i<sizeof($arr_))
		{
			?>
			<div class="team-membr" idmem=<?php echo $arr_post_team[$iC]->ID ?>> <!-- onclick="window.location.href='<?php echo $arr_post_team[$iC]->guid ?>'" -->
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php 
						echo sprintf( '<h2 class="vac-title">%s<a href="%s" rel="bookmark"></a></h2>', $arr_post_team[$iC]->post_title, esc_url( $arr_post_team[$iC]->guid )); 
					?>
				</header><!-- .entry-header -->

				<div class="">
					<?php
						$arrPhoto = get_post_meta( absint($arr_post_team[$iC]->ID), 'photo_name', true );
						$arrPhotoShow = "";
						if( !file_exists( IMGDIR_TEAM . "SM" . $arrPhoto[0] ) )
						{
							$arrPhotoShow = "hide";
						}
					?>
					<img class="team-photo-frame <?php echo $arrPhotoShow ?>" src="<?php echo IMGCONT_TEAM . 'SM' . $arrPhoto[0] ?> ">

				</div><!-- .entry-content -->

				<footer class="entry-footer">
					<?php
						
					?>
				</footer><!-- .entry-footer -->
			</article><!-- #post-## -->
			</div>
			<?php
			$i++;
			$iC++;
		}
	}
}

// Get the arr from DB and create teamList for the page
global $wpdb;
$sqlq = "SELECT * FROM wp_posts WHERE wp_posts.post_type = 'post_team' AND wp_posts.post_status = 'publish'";
$arrTeam = $wpdb->get_results($sqlq);
?>