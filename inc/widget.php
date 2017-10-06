<?php
// register widget
function widget_sideb()
{
    $args = array(
        'name' => 'Sidebar vacature',
        'id' => 'sidebar1',
        'class' => 'sidebar_vacature',
        'description' => 'Sidebar voor de vacatures.',
        'before_widget' => '<span id="%1$s">',
        'after_widget' => '</span>',
        'before_title' => '<span><h2>Sidebar vacature',
        'after_title' => '</h2></span>'
    );
    register_sidebar($args);
}
add_action('init', 'widget_sideb');

// Sidebar sngl vacature
function widget_sideb_singl()
{
    $args = array(
        'name' => 'Sidebar single vacature',
        'id' => 'sidebar_sngl',
        'class' => 'sidebar_vacature',
        'description' => 'Sidebar voor de single vacature.',
        'before_widget' => '<span id="%1$s">',
        'after_widget' => '</span>',
        'before_title' => '<span><h2>Sidebar single vacature',
        'after_title' => '</h2></span>'
    );
    register_sidebar($args);
}
add_action('init', 'widget_sideb_singl');

// Sidebar footer
function widget_sideb_footer()
{
    $args = array(
        'name' => 'Footerbar',
        'id' => 'sidebar_footr',
        'class' => 'sidebar_footr',
        'description' => 'Footerbar.',
        'before_widget' => '<span id="%1$s">',
        'after_widget' => '</span>',
        'before_title' => '<span><h2>Footer bar',
        'after_title' => '</h2></span>'
    );
    register_sidebar($args);
}
add_action('init', 'widget_sideb_footer');

// Create widget class for new widget
class widget_search_vacature extends WP_Widget
{
    function __construct()
    {
        $options = array(
            'clasname' => 'widget_search_vacature',
            'description' => 'Widget Search vacatures.',
        );
        parent::__construct('search_vacature', 'Widget Search Vacature', $options );
    }

    function widget( $args, $instance )
    {
?>
        <form method="post" id="searchform"> 
        <div class='row'>
            <h2 for="sa" class="widget-title">Zoek een vacature op tekst</h2>
            <input type="text" value="" name="sa" id="sa" class="in-txt-half" placeholder="vind..." />
            <div id="searchsubmit_" value="Search" class=""><div class="fa sub-search"></div></div>
        </div>
        <div id='search_div'></div>
        </form>
<?php
    }

    function form()
    {
?>
        <label>Testlabel</label>
<?php
    }
}

// Filter widget
class widget_filter_tax extends WP_Widget
{
    function __construct()
    {
        $constrargs = array(
            'description' => 'Filter de vacatures op taxonomy'
        );
        parent:: __construct('filter_vacature', 'Filter de Vacature', $constrargs);
    }

    function widget( $args, $instance )
    {
        $arr_tax = get_terms('Vacature_tax', array( 'hide_empty' => false));
        $strVal = "";
        $strID;
        $strTotal;
        if($arr_tax != null)
        {
            // First call the ammount (count) of uren
            $arr_tax_cnt = [];
            $i=0;

            // Abstract the tax no's  from get_terms arr
            for ($i=0, $n=sizeof($arr_tax); $i < $n ; $i++) 
            { 
                $arr_tax_cnt[$i] = $arr_tax[$i]->term_id;
            }
            
            // Put vals in array cat for counting call on db
            $arr_cat = count_categories( $arr_tax_cnt, 1 ); // in functions.php // 1 == the taxonomy
            $arr_tax_cnt = null;
            $i = 0;
            if($arr_cat != null )
            {
                foreach( $arr_cat[0] as $key => $val ) 
                {
                    $arr_tax_cnt[$i]['key'] =  str_replace('db_tax', '', $key) ;
                    $arr_tax_cnt[$i]['val'] =  $val ;
                    $i++;
                }
                $i = 0;
            }

            // Then create the ul
            $strTotal .= h2_title('Trefwoorden');
            $strTotal .= "<ul class='ul-filter'>";

            foreach($arr_tax as $tax)
            {
                $strID = $tax->term_taxonomy_id;
                $strVal = $tax->name;
                
                $strTotal .= "<li class='li-filter'><div class='block'>";
                $strTotal .= "<input ident='tax' id='in-Vacature_tax-" . $strID . "' value='" . $strID . "' name='tax_input[Vacature_tax]' type='checkbox'>";
                $strTotal .= "<label for='in-Vacature_tax-" . $strID . "'></label>";
                $strTotal .= "<span class='chk-val'>" . $strVal . "</span>";
                $strTotal .= "<span class='chk-countr'>" . $arr_tax_cnt[$i]['val'] . "</span>";
                $strTotal .= "</div>";

                    $i = $i+1;
                $strTotal .= "</li>";
            }
            $strTotal .= "</ul>";
            // var_dump($arr_tax);
        }
        echo $strTotal;
        $strTotal = "";
    }

    function form()
    {

    }
}

class widget_filter_uren extends WP_Widget
{
    function __construct()
    {
        parent::__construct('widget_filter_uren', 'Widget Filter Uren', array('description' => 'Filtert de uren.'));
    }

    function widget( $args, $instance )
    {
        if(arr_uren() != null)
        {
            // First call the ammount (count) of uren
            $arr_uur = [];
            $i=0;
            $arr_cat = count_categories( arr_uren(), 0 ); // in functions.php

            if($arr_cat != null )
            {
                foreach( $arr_cat[0]  as $key => $val )
                {
                    $arr_uur[$i] = $val;
                    $i = $i+1;
                }
                $i = 0;
            }

            $strTotal .= h2_title('Uren');
            $strTotal .= "<ul class='ul-filter'>";
            foreach(arr_uren() as $uren)
            {
                $strTotal .= "<li class='li-filter'><div class='block'>";
                $strTotal .= "<input ident='uren' id='" . $uren . "' value='" . strip_string($uren) . "' name='tax_input[Vacature_tax]' type='checkbox'>";
                $strTotal .= "<label for='" . $uren . "'></label>";
                $strTotal .= "<span class='chk-val'>" . $uren . "</span>";
                $strTotal .= "<span class='chk-countr'>" . $arr_uur[$i] . "</span>";
                $strTotal .= "</div>";

                $i = $i+1;
            }
            $strTotal .= "</ul>";
        }
        echo $strTotal;
    }

    function form()
    {

    }
}

// Widget opleidingen
class widget_filter_opleiding extends WP_Widget
{
    function __construct()
    {
        parent::__construct('widget_filter_opleiding', 'Widget filter Opleiding', array('description' => 'Filter voor de opleidingen'));
    }

    function widget( $args, $instance )
    {
        if(arr_opleiding() != null )
        {
            // First call the ammount (count) of uren
            $arr_opl = [];
            $i=0;
            $arr_cat = count_categories( arr_opleiding(), 0 ); // in functions.php
            
            if($arr_cat != null )
            {
                foreach( $arr_cat[0] as $key => $val )
                {
                    $arr_opl[$i] = $val;
                    $i = $i+1;
                }
                $i = 0;
            }

            $strTotal .= h2_title('Niveau');
            $strTotal .= "<ul class='ul-filter'>";
            foreach(arr_opleiding() as $opleid)
            {
                $strTotal .= "<li class='li-filter'><div class='block'>";
                $strTotal .= "<input ident='opleid' id='" . $opleid . "' value='" . strip_string($opleid) . "' name='tax_input[Vacature_tax]' type='checkbox'>";
                $strTotal .= "<label for='" . $opleid . "'></label>";
                $strTotal .= "<span class='chk-val'>" . $opleid . "</span>";
                $strTotal .= "<span class='chk-countr'>" . $arr_opl[$i] . "</span>";
                $strTotal .= "</div>";

                $i = $i+1;
            }
            $strTotal .= "</ul>";
        }
        echo $strTotal;
    }

    function form()
    {

    }
}

// Widget vakgebied
class widget_list_vakgebied extends WP_Widget
{
    function __construct()
    {
        parent::__construct('widget_list_vakgebied', 'Widget filter vakgebied', array('description'=>'Lijst met vakgebieden.'));
    }

    function widget()
    {
        $arr_vakgebied = get_json("vakgebied.json");
        if($arr_vakgebied != null)
        {
            $strTotal .= h2_title('Vakgebied');

            // NEW MENU
            $strTotal .= "<div ident='vakgeb' class='selct-filter slct-menu wt-sidebr'>
                <div class='slct-menu-start slct-vakgeb'>
                <span class='slct-txt' countr=0 val=''>Selecteer...</span>
                <span class='fa fa-attr-arrow'></span></div>";
            $strTotal .= "<ul class='slct-menu-ul slct-menu-ul-list hide'>";
            for($iC = 0, $n = sizeof($arr_vakgebied["vak"]); $iC<$n; $iC++)
            {
                $strTotal .= "<li class='slct-menu-li' val='" . strip_string( $arr_vakgebied["vak"][$iC] ) . "'>" . $arr_vakgebied["vak"][$iC] . "</li>";
            }
            $strTotal .= "</ul></div>";
        }
        echo $strTotal;
    }

    function form()
    {
        
    }
}

// Widget Postcode filter
class widget_postcode_filter extends WP_Widget
{
    function __construct()
    {
        parent::__construct('widget_postcode_filter', 'Widget filter postcode/afstand', array('description'=>'Filter op adres/postcode google.'));
    }

    function widget()
    {
        $arr_distance = array(
            "5 km" => 5,
            "10 km" => 10,
            "20 km" => 20,
            "30 km" => 30,
            "40 km" => 40,
            "50 km" => 50
        );

        $strTotal .= h2_title('Zoek op adres');

            // NEW MENU
            $strTotal .= "<div class='row mrg-b-15px'><input class='in-txt-half' ident='googl' type='text'name='address' id='address' />
            <div ident='dist' class='slct-menu wt-half'>
                <div class='slct-menu-start selct-distance'>
                    <span class='slct-txt' countr=0 val=''>Afstand...</span>
                    <span class='fa fa-attr-arrow'></span>
                </div>";
            $strTotal .= "<ul class='slct-menu-ul absolute hide'>";
            foreach($arr_distance as $key => $val)
            {
                $strTotal .= "<li class='slct-menu-li' val='" . $val . "'>" . $key . "</li>";
            }
            $strTotal .= "</ul></div></div>";
        echo $strTotal;
    }

    function form()
    {
        
    }
}

// FOOTER Widgets
// Filter widget Social Media
class widget_socialmedia extends WP_Widget
{
    function __construct()
    {
        $constrargs = array(
            'description' => 'Footer Social media buttons'
        );
        parent:: __construct('footer_socialmedia', 'Footer social media buttons', $constrargs);
    }

    public $arr_osm = array(
            "Facebook" => "&#xf230;", 
            "Twitter" => "&#xf099;",
            "LinkedIn" => "&#xf08c;"
        );

    function widget( $args, $instance )
    {
        $iarrC = sizeof( $this->arr_osm );
        $astrTotal = '<div class="footer-col">';

        for($i = 0, $n = $iarrC; $i < $n; $i++)
        {
            $astrTotal .=  "<p><a href='" . $instance['txt' . $i] . "'>";
            $astrTotal .=  "<span class='font-fam-fa'>" . $instance['select' . $i] . "</span> ";
            $astrTotal .=  $instance['key' . $i] . "</a></p>";
        }

        $astrTotal .= "</div>";

        echo $astrTotal;
    }

    function form( $instance )
    {
        $iarrC = sizeof( $this->arr_osm );
        $astrTotal .= '<div id="osm_div">';
        
        $iSelect = 0;
        for($i = 0, $n = $iarrC; $i < $n; $i++)
        {
            $astrTotal .= '<select id="select' . $iSelect . '" name="select' . $iSelect . '">';
                $astrTotal .= osm_row( $this->arr_osm, $instance['key' . $iSelect] ) ;
            $astrTotal .= '</select>';

            $astrTotal .= '<input type="text" name="txt' . $iSelect . '" value="' . $instance['txt' . $iSelect] . '">'; // $astrTotal .= '<input type="text" name="txt' . $iSelect . '">';
            $astrTotal .= '<input type="hidden" name="key' . $iSelect . '" id="key' . $iSelect . '" value="' . $instance['key' . $iSelect] . '">';

            $iSelect = $iSelect + 1;
        }
        
        $astrTotal .= '</div>';

        echo $astrTotal;
    }

    public function update( $old_instance, $new_instance )
    {
        // ( $_POST['txt01']  != "" ) ? $this->str_val01 = $_POST['txt01'] : $this->str_val01 = '';
       // $instance = $old_instance;
    $arr_post;
            $iSelect = 0;
            foreach($this->arr_osm as $key => $val)
            {
                $instance['txt'. $iSelect] = change_url( $_POST['txt' . $iSelect] );

                $arr_post = split(":", $_POST['select' . $iSelect] );

                $instance['select'. $iSelect] = $arr_post[0];
                $instance['key' . $iSelect] = $arr_post[1];
    
                $iSelect = $iSelect + 1;
                $arr_post = null;
            }
        return $instance;
    }
}
// function create select and input
function osm_row( $arr_osm, $str_selct )
{
    $strOption;
    $strSel = '';
    foreach($arr_osm as $key => $val)
    {
        if($str_selct === $key)
        {
            $strSel = 'selected="true"';
        }

        // $strOption .= '<option value="' . htmlentities($val) . '" ' . $strSel . '>' . $key . '</option>';
        $strOption .= '<option value="' . htmlentities($val) . ':' . $key . '" ' . $strSel . '>' . $key . '</option>';
        $strSel = '';
    }
    return $strOption;
}
// function check url adress
function change_url($strUrl)
{
    if( !preg_match("~^(?:f|ht)tps?://~i", $strUrl) )
    {
        return $strUrl = 'https://' . $strUrl;
    }
    else
    {
        return $strUrl;
    }
}

// Widget adress bar
class widget_adressbar extends WP_Widget
{
    function __construct()
    {
        $constrargs = array(
            'description' => 'Footer adress'
        );
        parent:: __construct('footeradress', 'Footer adress', $constrargs);
    }

    function widget( $args, $instance )
    {
        $astrTotal = '<div class="footer-col">';
            $astrTotal .= "<p>" . $instance['name'] . "</p>";
            $astrTotal .= "<p>" . $instance['street'];
            $astrTotal .= "<p>" . $instance['zip'];
            $astrTotal .= " " . $instance['place'] . "</p>";
            $astrTotal .= "<p>" . $instance['tel'] . "</p>";
            $astrTotal .= "<p>" . $instance['email'] . "</p>";
        $astrTotal .= '</div>';

        echo $astrTotal;
    }

    function form( $instance )
    {
        $formTotal = "<span>Naam:</span><br>";
        $formTotal .= "<input type='text' value='" . $instance['name'] . "' name='name'><br>";
        $formTotal .= "<span>Straat:</span><br>";
        $formTotal .= "<input type='text' value='" . $instance['street'] . "' name='street'><br>";
        $formTotal .= "<span>Postcode:</span><br>";
        $formTotal .= "<input type='text' value='" . $instance['zip'] . "' name='zip'><br>";
        $formTotal .= "<span>Plaats:</span><br>";
        $formTotal .= "<input type='text' value='" . $instance['place'] . "' name='place'><br>";
        $formTotal .= "<span>Telefoon:</span><br>";
        $formTotal .= "<input type='text' value='" . $instance['tel'] . "' name='tel'><br>";
        $formTotal .= "<span>Email:</span><br>";
        $formTotal .= "<input type='text' value='" . $instance['email'] . "' name='email'><br>";

        echo $formTotal;
    }

    function update( $old_instance, $new_instance )
    {
       $instance = $old_instance;
       $instance['name'] = $_POST['name'];
       $instance['street'] = $_POST['street'];
       $instance['zip'] = $_POST['zip'];
       $instance['place'] = $_POST['place'];
       $instance['tel'] = $_POST['tel'];
       $instance['email'] = $_POST['email'];

       return $instance;
    }
}

// Widget footer posts
class widget_footer_post extends WP_Widget
{
    function __construct()
    {
        $args = array(
            'description' => 'Footer widget posts'
        );
        parent:: __construct('footer_posts', 'Footer posts', $args);
    }

    function widget( $args, $instance )
    {
        $postTotal = '<div class="footer-col">';

            $arr_post = wp_query_post( array('post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 5) );

            for($i = 0, $n = sizeof($arr_post); $i<$n; $i++)
            {
                $postTotal .= "<p><a href='" . $arr_post[$i]->guid . "'>" . $arr_post[$i]->post_title . "</a></p>";
            }

        $postTotal .= '</div>';

        echo $postTotal;
    }

    function form( $instance )
    {

    }

    function update( $old_instance, $new_instance )
    {

        return $instance;
    }
}
// function wp query posts
function wp_query_post( $strQ )
{
    $arrResult = null;
    $wp_Q = new WP_Query( $strQ );
    $i = 0;
    if( $wp_Q->have_posts() )
    {
        while( $wp_Q->have_posts() )
        {
            $wp_Q->the_post();
            $arrResult[$i] = get_post();
            $i++;
        }
    }
    
    return $arrResult;
}

// Register the widgets
function fu_widget_vacature()
{
    register_widget('widget_search_vacature');
    register_widget('widget_filter_tax');
    register_widget('widget_filter_uren');
    register_widget('widget_filter_opleiding');
    register_widget('widget_list_vakgebied');
    register_widget('widget_postcode_filter');
    register_widget('widget_socialmedia');
    register_widget('widget_adressbar');
    register_widget('widget_footer_post');
}
add_action('widgets_init', 'fu_widget_vacature');

// aditional functions
function h2_title($strtxt)
{
    return '<h2 class="widget-title">' . $strtxt . '</h2>';
}
?>