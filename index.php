<?php
    get_header();
?>
<!-- <div id="content"> -->
    <div id="content-index">
        <h2 class="widget-title">Zoek je vacature...</h2>
        <div class="row mrg-b-15px">
            <form method="post" id="searchform">
                    <div class="row">
                    
                        <div class="row">
                            <input value="" name="sea_text" id="sea_text" class="in-txt-half" placeholder="Vacaturetitel..." type="text">
                        </div>
                        <div class="row">
                            <input class="in-txt-half" ident="googl" name="address" id="indx_address" placeholder="Plaats/postcode..." type="text">
                        </div>
                        <div class="row">
                            <div ident="dist" class="slct-menu wt-half">
                                <div class="slct-menu-start indx-selct-distance">
                                    <span class="slct-txt" countr="0" val="">Afstand...</span>
                                    <span class="fa fa-attr-arrow"></span>
                                </div>
                                <ul class="slct-menu-ul absolute hide">
                                    <li class="slct-menu-li" val="5">5 km</li><li class="slct-menu-li" val="10">10 km</li><li class="slct-menu-li" val="20">20 km</li><li class="slct-menu-li" val="30">30 km</li><li class="slct-menu-li" val="40">40 km</li><li class="slct-menu-li" val="50">50 km</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div id="searchsubmit_index" value="Search_index" class="">
                                    <div class="fa sub-search"></div>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>
  <div class="videobg">
        <div class="videobg-width">
        <div class="videobg-aspect">
            <div class="videobg-make-height">
            <div class="videobg-hide-controls">
                <iframe src="https://player.vimeo.com/video/208157579?background=1" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            </div>
            </div>
        </div>
        </div>
    </div>
        <!-- https://player.vimeo.com/video/208157579?background=1 -->
    <div style="background: #005500; heigth: 500px; width: 100%;">
                    TEST DIV
    </div>
<!-- </div> -->

<?php 
    wp_footer();
    get_footer(); 
?>