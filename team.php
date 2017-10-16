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
        <div class="row mrg-b-15px">
            <?php echo show_team_posts($arrTeam); ?>
        </div>
    </div>
<!-- </div> -->

<?php 
    wp_footer();
    get_footer(); 
?>