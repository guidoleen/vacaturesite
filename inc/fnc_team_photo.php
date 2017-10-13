<?php
include('../../../../wp-config.php');
define('IMGDIR', 'wp-content/uploads/team/');
define('IMGDIR_TEAM', ABSPATH . IMGDIR);
define('IMGCONT_TEAM', content_url() . '/uploads/team/');
define('IMG_W', 200);
define('IMG_H', 200);

// https://codex.wordpress.org/Class_Reference/WP_Image_Editor
// https://bhoover.com/wp_image_editor-wordpress-image-editing-tutorial/

    // Id from url parm
    $Id = absint($_GET['id']);

    // Get Image name from metapost
    $ImgName = get_post_meta($Id, 'photo_name', true); // Array
  
    // Image info
    if( file_exists( IMGDIR_TEAM . $ImgName[0] ) )
        $arrFinfo = getimagesize( IMGDIR_TEAM . $ImgName[0] ); // File size etc.
    
    // Start the Photo upload
    $ImgTag = "";

    if($ImgName[0] != "") $ImgTag = IMGCONT_TEAM . $ImgName[0];

    // Start the upload event
    if( isset($_POST['subfileteam']) )
    {
        $Id = $_GET['id']; // Get id from usrId (post id)
        if($Id == null || $Id == "")
        {
            return 0;
        }
        
        $file = $_FILES['fileteam'];
        $arrFiles = Array(
            "image/jpg",
            "image/png",
            "image/jpeg",
            "image/gif"
        );

        $arrFName= Array(
            "jpg",
            "jpeg",
            "png",
            "gif"
        );

        $fileType = "";
        $iC = 0;
        foreach($arrFiles as $arrType)
        {
            if( $file['type'] == $arrType )
            {
                $fileType = substr($arrType, 6, strlen($arrType) );
                $iC = $iC+1;
            }
        }
       
        foreach($arrFName as $arrType)
        {
            $regex = "/" . $arrType . "*$/";
            if( preg_match($regex, strtolower( $file['name'] ) ) )
            {
                $iC = $iC+1;
            }
        }

        if( $file['size'] > 2000000) // Size > 2Mb
            $iC = 0;

        if( $iC == 0 || $file['type'] == "" )
        {
            echo "Geen geldige image file.....";
            return 0;
        }

        if( $file['tmp_name'] != null && $file['error'] == 0)
        {
            $strImgName = strip_str_nospace( get_the_title($Id) ); // Image from title
            if( $strImgName == "" ) $strImgName = "imgteam" . $Id;
            
                $strImgName = $strImgName . "." . $fileType;

            // Remove previous file
            if( file_exists(IMGDIR_TEAM . $strImgName) )
            {
                unlink( IMGDIR_TEAM . $strImgName );
            }

            // Remove previous SM file
            if( file_exists(IMGDIR_TEAM . "SM" . $strImgName) )
            {
                unlink( IMGDIR_TEAM . "SM" . $strImgName );
            }
                        
            if( move_uploaded_file($file['tmp_name'], IMGDIR_TEAM . $strImgName ) )
            {
                echo "Gelukt! Jouw foto is geupload...";
            }
            $arrFinfo = getimagesize( IMGDIR_TEAM . $strImgName ); // File size etc.

             // Do the DB process...
            $arrImgName = Array();
            $iAdd = add_up($arrFinfo[5]);
            array_push( $arrImgName, $strImgName, 0, 0, $arrFinfo[0], $arrFinfo[1], $iAdd ); // Aditional push array

            update_post_meta($Id, 'photo_name', $arrImgName);
        }
    }

// Image editing
function photo_crop($id, $offX, $offY, $imgWidth, $imgHeigth)
{
    if($id == null || $id == 0) return 0;

    // Start the process...
    try
    {
        // Do the Dir process...
        $imgName = get_post_meta($id, 'photo_name', true); // Img name array
        $imgSrc = IMGDIR_TEAM . $imgName[0];

        $arrFinfo = getimagesize( $imgSrc ); // File size etc.

        $img = wp_get_image_editor($imgSrc); // Create imgedit
        $img->resize( absint($imgWidth), absint($imgHeigth), false ); // resize( $max_w, $max_h, $crop = false )

        $regex = '/[px$]/';
        $img->crop( absint(preg_replace($regex , '', $offX)), absint(preg_replace($regex , '', $offY)), IMG_W, IMG_H ); // $img->crop( $src_x, $src_y, $src_w, $src_h, $dst_w, $dst_h, $src_abs );
        $filename = $imgName[0];
        $dirname = IMGDIR_TEAM . "SM" . $filename; // $img->generate_filename( 'final', IMGCONT_TEAM, NULL );
        $img->save($dirname);

        // Do the DB process...
        $arrImgName = Array();
            array_push($arrImgName, $filename, $offX, $offY, $imgWidth, $imgHeigth, $imgName[5]);
        update_post_meta($id, 'photo_name', $arrImgName);

        echo "Jouw foto is klaar voor gebruik....";
        // $img ->stream();
    }
    catch(Exeption $e)
    {
        echo "Niet mogelijk om de image te bewerken....";
    }
    // $img->resize();
}
// function adder
function add_up($iNmr)
{
    if( $iNmr < 10)
        return $iNmr + 1;
    else
        return 0;
}

// Posting the avatar
if( isset($_POST['savecrop']) )
{
    $offX = $_POST['offX'];
    $offY = $_POST['offY'];
    $imgWidth = $_POST['imgWidth'];
    $imgHeigth = $_POST['imgHeigth'];

    photo_crop($Id, $offX, $offY, $imgWidth, $imgHeigth); // Call the function
}

?>
<html>
    <head>
        <link rel="stylesheet" href="<?php echo admin_url() . 'css/wp-admin.min.css' ?>" ></link>
    </head>
        <body>
        <style>
            #cont_team_show
            {
                border: solid #005500 1px;
                float:left;
            }
            #img_team_show
            {
                border-radius: 100px;
                overflow: hidden;
                float:left;
                border: 1px solid #005500;
                cursor: pointer;
                background-position-x: 0;
                background-repeat: no-repeat;
                /* background-size: 100%; */
            }
        </style>
        <form action="<?php echo 'fnc_team_photo.php?id=' . $Id ?>"  method="post" enctype="multipart/form-data">
            <input type="file" name="fileteam" id="fileteam" class="button insert-media add_media" />
            <input type="submit" name="subfileteam" id="subfileteam" value="Bewaar foto..." class="button insert-media add_media" />
        </form>

        <!-- <div id="cont_team_show">
            <img src="<?php echo $ImgTag ?>"> />
        </div> -->
        <div id="img_team_show" 
            style="background-image: url( <?php echo $ImgTag ?> ); 
            width:<?php echo IMG_W ?>; 
            height:<?php echo IMG_H ?>;
            background-size: <?php echo $ImgName[3] . "px " . $ImgName[4] . "px" ?>;
            background-position-x: <?php echo $ImgName[1] ?>;
            background-position-y: <?php echo $ImgName[2] ?>;
        ">
        </div>

        <input type="range" id="rngPerc" min="0" max="100" step="1" list="tickmarks" start="100" />
            <datalist id="tickmarks">
            <option value="0" label="0%">
            <option value="10">
            <option value="20">
            <option value="30">
            <option value="40">
            <option value="50" label="50%">
            <option value="60">
            <option value="70">
            <option value="80">
            <option value="90">
            <option value="100" label="100%">
            </datalist>
        
        <form action="<?php echo 'fnc_team_photo.php?id=' . $Id ?>"  method="post" enctype="multipart/form-data">
            <input type="submit" id="savecrop" name="savecrop"  value="Bewaar Avatar" class="button button-primary button-large"/>
            <input id="offX" name="offX" type="hidden" value="0" />
            <input id="offY" name="offY" type="hidden" value="0" />
            <input id="imgWidth" name="imgWidth" type="hidden" value="<?php echo $arrFinfo[0] ?>" />
            <input id="imgHeigth" name="imgHeigth" type="hidden" value="<?php echo $arrFinfo[1] ?>" />
        </form>
    
        <script src="<?php echo get_template_directory_uri() . '/js/teamimg.js' ?>"></script>
    </body>
</html>

<!-- array (size=5)
  'name' => string 'fake300x300.jpg' (length=15)
  'type' => string 'image/jpeg' (length=10)
  'tmp_name' => string '/private/var/tmp/phpgPZVEG' (length=26)
  'error' => int 0
  'size' => int 16964 -->

  <!-- array (size=7)
  0 => int 1280
  1 => int 960
  2 => int 2
  3 => string 'width="1280" height="960"' (length=25)
  'bits' => int 8
  'channels' => int 3
  'mime' => string 'image/jpeg' (length=10) -->

  <!-- // array (size=1)
        // 0 => 
        //   array (size=5)
        //     0 => string 'NicolettevanPutten.jpeg' (length=23)
        //     1 => string '-44px' (length=5)
        //     2 => string '-1px' (length=4)
        //     3 => string '294.40000000000003' (length=18)
        //     4 => string '220.8' (length=5)
        //      5 => int 1 -->