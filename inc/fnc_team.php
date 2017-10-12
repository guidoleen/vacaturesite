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
	<table class="admin_tble" style="width: 100%;">
            <tr>
                <td style="vertical-align: top; width: 30%;">
                    <b>Functie team member</b><br>
                        <?php
                            $tfunctn = get_post_meta($postval->ID, 'team_function');
                        ?>
                    <input type="text" name="team_function" value="<?php echo $tfunctn[0]; ?>" />
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 30%;">
                    <b>Email team member</b><br>
                        <?php
                            $temail = get_post_meta($postval->ID, 'team_email');
                        ?>
                    <input type="text" name="team_email" value="<?php echo $temail[0]; ?>" />
                </td>
            </tr>
		</tr><!-- END FISRT ROW -->
		<tr>
			<td>
                <b>Upload foto team member</b><br>
				<?php 
					
				?>
					<h2 class="upload-instructions drop-instructions">Je foto plaatsen....</h2>
					<iframe heigth="100%" width="100%" src="<?php echo content_url() . '/themes/guidoleen/inc/fnc_team_photo.php?id=' . $postval->ID  ?>"></iframe> 
			</td>
		</tr>
	</table>
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
?>