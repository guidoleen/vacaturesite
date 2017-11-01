<?php
/**
 * The template for displaying all single posts and attachments
 */
get_header(); 
// wp_head();
?>

<div id="singl-team" class="content-area"> ggggggggg
	<main id="main" class="site-main" role="main">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();
        ?>
            <h2 class='vac-title'><?php the_title() ?></h2>
			<?php

				// First get the ID
				$theID = get_the_ID();

				// Date element, opleiding, hours bar
				$arr_Uren = get_post_meta( $theID, 'uren', true ); // Array uren
				echo 	'<ul class="vac-infobar-ul">' .
							'<li class="vac-infobar-li"><span class="fa fa-graduation-cap relative"></span>' .
								strip_string_back( get_post_meta( $theID, 'opleiding', true ) ) . '</li>' .
							'<li class="vac-infobar-li"><span class="fa fa-clock-o relative"></span>' . 
								strip_string_custom( $arr_Uren[0], "Minderdan", "< ") . ' uur' . '</li>' .
							'<li class="vac-infobar-li"><span class="fa fa-address-card relative"></span>' . 
								guidoleen_postthe_date( get_post()->post_date ) . '</li>' .
						"</ul>";

				// Post navigation
				if ( is_singular( 'post_vacatures' ) ) 
				{
					echo page_prev_next(); // functions.php
				}
			?>
			
                <h3>De werkzaamheden:</h3>
            <?php
                the_content();

				if( is_singular('post_vacatures'))
				{
					// Post navigation
					echo page_prev_next(); // functions.php
				}
		endwhile;
		?>

	</main><!-- .site-main -->
</div><!-- .content-area -->

<?php 
wp_footer();
get_footer(); 
?>
