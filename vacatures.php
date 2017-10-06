<?php
/*
    Template Name: vacatures
*/
?>

<?php
    get_header();

    // Set for the pagination to work in de vacature part
    echo '<input id="page-nr" type="hidden" value="">';
?>
<!-- <div id="content"> -->
    <div id="content-main">
        <?php echo filter_asc_desc(); ?> <!-- The asc/desc filter -->
            <div id="vacatures" class="vacatures">
            <!-- Vacatures from functions.php >> filter.php >> filter.js -->
        </div>
        <div id="pagina"></div>
    </div>
    <div id="sidebar-filtr">
        <?php
            dynamic_sidebar('sidebar1'); 
            // call_search_vac("search-ul", "search-li"); // First show the widgetbar than call the search function
        ?>
        <h2 class="widget-title">Salaris</h2>
        <div class="wt-sidebr">
            <span class="rng-val">0</span>
            <input id="rng-salaris" type="range" steps="5" ident="salaris" value="0" />
        </div>
        
        <div id="closefilter" class="">
            <div class="fa sub-clear-filter">
                <p>Clear filter &nbsp;<p><p class='close'>&#xf00d;<p>
            </div>
        </div>
    </div>
<!-- </div> -->

<?php 
    wp_footer();
    get_footer(); 
?>