<?php
/*
    Template Name: team
*/
?>

<?php
    get_header();
?>
<!-- <div id="content"> -->
    <div id="content-team">
        <h2 class="widget-title">Ons team...</h2>
        <?php
            while( have_posts() ): the_post()
        ?>
                <?php echo the_content(); ?>
        <?php
            endwhile;
        ?>

        <!-- The People -->
        <div class="row mrg-b-15px">
            <?php echo show_team_posts($arrTeam); ?>
        </div>
        <!-- End The People -->
    </div>

    <!-- Info Member -->
    <div id="team_info_membr" style="width:0px;">
        <span id="shutidiv" class="shut">×</span>
        <div id="t_info_title"></div>
        <div id="t_info_funct"></div>
        <div id="t_info_cont"></div>
        <div id="t_info_email"></div>

        <article id="post-32" class="post-32 page type-page status-publish hentry">
				<header class="entry-header">
					<h2 class="vac-title">Nicolette van Putten<a href="http://localhost/guido/lokaal/?post_type=post_team&amp;p=44" rel="bookmark"></a></h2>				</header><!-- .entry-header -->

				<div class="">
						<img class="team-photo-frame " src="http://localhost/guido/lokaal/wp-content/uploads/team/NicolettevanPutten0.jpeg ">

				</div><!-- .entry-content -->

                <div class="entry-content">
                    Zorg voor een goed salaris! Wist je dat werken in de zorg als thuishulp één van de best betaalde b... 
                    <a href="http://localhost/guido/lokaal/?post_type=post_vacatures&amp;p=18" rel="bookmark"> <span class="fa fa-attr-arrowRight relative"></span></a><br>
               </div>	
				
			</article>
    </div>
    <form>
        <input id="tmpUri" type="hidden" value="<?php echo get_template_directory_uri() ?>" />
    </form>
     <!-- End Info Member -->
<!-- </div> -->
<script src="<?php echo get_template_directory_uri() . '/js/team.js'?>"></script>
<?php 
    wp_footer();
    get_footer(); 
?>