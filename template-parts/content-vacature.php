<?php
/**
 * The template part for displaying content
 *
 * @package WordPress
 * @subpackage Guido Leen
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php 
			$arr_post_vac[$iC] = get_post();

			the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); 
			// Date element
			echo guidoleen_postthe_date($arr_post_vac[$iC]->post_date) . "<br>";
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
            $iCount = 30;
            
            echo substr($arr_post_vac[$iC]->post_content, 0, $iCount) . '...';
            echo sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">Iets voor jou?</a></h3>', esc_url( get_permalink() ) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
			
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->


<!--wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentysixteen' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );-->