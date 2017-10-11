<?php
include('../../../../wp-config.php');
define('IMGDIR', 'wp-content/uploads/team/');
define('IMGDIR_TEAM', ABSPATH . IMGDIR);
define('IMGCONT_TEAM', content_url() . '/uploads/team/');

// https://codex.wordpress.org/Class_Reference/WP_Image_Editor
// https://bhoover.com/wp_image_editor-wordpress-image-editing-tutorial/

    // Upload photo
    $Id = $_GET['id'];

    // Get Image name from metapost
    $ImgName = get_post_meta($Id, 'photo_name');
    
    // Imgae info
    $arrFinfo = getimagesize( IMGCONT_TEAM . $ImgName[0] ); // File size etc.

    // Start the Photo upload
    $ImgTag = "";
    if($ImgName != "") $ImgTag = IMGCONT_TEAM . $ImgName[0];

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
            $strImgName = strip_str_nospace( get_the_title($Id) );
            if( $strImgName == "" ) $strImgName = "imgteam" . $Id;
            
                $strImgName = $strImgName . "." . $fileType;
            
            if( move_uploaded_file($file['tmp_name'], IMGDIR_TEAM . $strImgName ) )
            {
                update_post_meta($Id, 'photo_name', $strImgName );
                echo "Gelukt!";
            }
        }
    }
?>
<html>
    <head></head>
        <body>
        <style>
            #cont_team_show
            {
                border: solid #005500 1px;
                float:left;
            }
            #img_team_show
            {
                border-radius: 100px;width: 200px;height: 200px;overflow: hidden; float:left;
                border: 1px solid #005500;
                cursor: pointer;
                background-position-x: 0;
                background-repeat: no-repeat;
                /* background-size: 100%; */
            }
        </style>
        <form action="<?php echo 'fnc_team_photo.php?id=' . $Id ?>"  method="post" enctype="multipart/form-data">
            <input type="file" name="fileteam" id="fileteam" class="button insert-media add_media" />
            <input type="submit" name="subfileteam" id="subfileteam" value="upload..." class="button insert-media add_media" />
        </form>

        <!-- <div id="cont_team_show">
            <img src="<?php echo $ImgTag ?>"> />
        </div> -->
        <div id="img_team_show" style="background-image: url( <?php echo $ImgTag ?> )"></div>
        <input id="offX" type="hidden" value="0" />
        <input id="offY" type="hidden" value="0" />
        <input id="imgWidth" type="hidden" value="<?php echo $arrFinfo[0] ?>" />
        <input id="imgHeigth" type="hidden" value="<?php echo $arrFinfo[1] ?>" />
    
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