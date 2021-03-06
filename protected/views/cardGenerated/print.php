<?php

$src = Yii::getPathOfAlias('application') . '/assets/images/cardprint-print.png';

error_reporting(E_ALL);
$session = new CHttpSession;
$session['count'] = $session['count'] + 1;
// clean up the input
$model = Visit::model()->findByPk($_GET['id']);
$cardType = CardType::$CARD_TYPE_LIST[$model->card_type];

$visitorName = $visitorModel->first_name . ' ' . $visitorModel->last_name;
$tenant = User::model()->findByPk($visitorModel->tenant);
$companyTenant = Company::model()->findByPk($tenant->company);
$card = CardGenerated::model()->findByPk($model->card);
$visitorName = wordwrap($visitorName, 13, "\n", true);



    $company = Company::model()->findByPk($tenant->company);
    $companyName = $company->name;
    $companyLogoId = $company->logo;
    $companyCode = $company->code;

    $cardCode = isset($card->card_number)?$card->card_number:"";


if ($companyLogoId == "") {
    $companyLogo = Yii::app()->getBaseUrl(true) . '/uploads/card_generated/nologoavailable.jpg';
} else {
    $companyLogo =  Photo::model()->returnCompanyPhotoRelativePath($tenant->company);
}

if (Visitor::model()->findByPk($model->visitor)->photo == "") {
    $userPhoto = Yii::app()->getBaseUrl(true) . '/uploads/card_generated/nophoto.png';
} else {
    $userPhoto = Photo::model()->returnVisitorPhotoRelativePath($model->visitor);
}

if (Visitor::model()->findByPk($model->visitor)->photo == "") {
    $userPhoto = Yii::app()->getBaseUrl(true) . '/uploads/card_generated/nophoto.png';
} else {
    $userPhoto = Photo::model()->returnVisitorPhotoRelativePath($model->visitor);
}

$src2 = $companyLogo;
$src3 = $userPhoto;
$dateExpiry = date('d M y');
if ($model->card_type != CardType::SAME_DAY_VISITOR) {
    $dateExpiry = date("d M y", strtotime($model->date_out));
}

$text = $companyCode . "\n" . $dateExpiry . "\n" . $visitorName . "\n" . $cardCode."\n";


if (empty($text)) {
    fatal_error('Error: Text not properly formatted.');
}

// customizable variables
$font_file = Yii::getPathOfAlias('application')  . '/assets/css/arialbd.ttf'; // arial bold
$font_size = 16; // font size in pts
$font_color = '#000';

// x and y for the bottom right of the text
// so it expands like right aligned text
$x_finalpos = 171;
$y_finalpos = 253;


// trust me for now...in PNG out PNG
$mime_type = 'image/png';
$extension = '.png';
$s_end_buffer_size = 4096;

// check for GD support
if (!function_exists('ImageCreate'))
    fatal_error('Error: Server does not support PHP image generation');

// check font availability;
if (!is_readable($font_file)) {
    fatal_error('Error: The server is missing the specified font.');
}

// create and measure the text
$font_rgb = hex_to_rgb($font_color);
$box = @ImageTTFBBox($font_size, 0, $font_file, $text);

$text_width = abs($box[2] - $box[0]);
$text_height = abs($box[5] - $box[3]);

$image = imagecreatefrompng($src);
if (!$image || !$box) {
    fatal_error('Error: The server could not create this image.');
}

// allocate colors and measure final text position
$font_color = ImageColorAllocate($image, $font_rgb['red'], $font_rgb['green'], $font_rgb['blue']);

$image_width = imagesx($image);

//$put_text_x = $image_width - $text_width - ($image_width - $x_finalpos);
$put_text_y = $y_finalpos;
// Write the text
$angle = 0;
$dimensions = imagettfbbox($font_size, $angle, $font_file, $text);
$textWidth = abs($dimensions[4] - $dimensions[0]);
$x = imagesx($image) - $textWidth - 10;
imagettftext($image, $font_size, 0, $x, 250, $font_color, $font_file, $text);



//////////////////////////////////////////////////////////////
header("Pragma-directive: no-cache");
header("Cache-directive: no-cache");
header("Cache-control: no-cache");
header("Pragma: no-cache");
header("Expires: 0");
header('Content-type:image/png');
if (exif_imagetype($src2) == IMAGETYPE_PNG) {
    $watermark = imagecreatefrompng($src2);
} elseif(exif_imagetype($src2) == IMAGETYPE_GIF){
    $watermark = imagecreatefromgif($src2);
}
else{
    $watermark = imagecreatefromjpeg($src2);
}

if (exif_imagetype($src3) == IMAGETYPE_PNG) {
    $watermark2 = imagecreatefrompng($src3);
} elseif(exif_imagetype($src3) == IMAGETYPE_GIF){
    $watermark2 = imagecreatefromgif($src3);
}
else {
    $watermark2 = imagecreatefromjpeg($src3);
}

$watermark_width = imagesx($watermark);
$watermark_width2 = imagesx($watermark2);

$watermark_height = imagesy($watermark);
$watermark_height2 = imagesy($watermark2);

$image = imagecreatetruecolor($watermark_width, $watermark_height);
$image = imagecreatetruecolor($watermark_width2, $watermark_height2);

$image = imagecreatefrompng($src);

$size = getimagesize($src);

$dest_x = $size[0] - $watermark_width - 5;

$dest_y = $size[1] - $watermark_height - 5;
imagettftext($image, $font_size, 0, $x, 225, $font_color, $font_file, $text);

imagecopyresampled($image, $watermark, 17, 333, 0, 0, 61, 40, $watermark_width, $watermark_height);
imagecopyresampled($image, $watermark2, 17, 7, 0, 0, 147, 191, $watermark_width2, $watermark_height2);


$usernameHash = hash('adler32', $visitorModel->email);
$uniqueFileName = 'card' . $usernameHash . '-' . time() . ".png";
$path = "uploads/card_generated/" . $uniqueFileName;
imagepng($image);
imagepng($image, $path);

imagedestroy($image);
imagedestroy($watermark);

exit;

function fatal_error($message) {
    // send an image
    if (function_exists('ImageCreate')) {
        $width = ImageFontWidth(5) * strlen($message) + 10;
        $height = ImageFontHeight(5) + 10;
        if ($image = ImageCreate($width, $height)) {
            $background = ImageColorAllocate($image, 255, 255, 255);
            $text_color = ImageColorAllocate($image, 0, 0, 0);
            ImageString($image, 5, 5, 5, $message, $text_color);
            header('Content-type: image/png');
            ImagePNG($image);
            ImageDestroy($image);
            exit;
        }
    }

    // send 500 code
    header("HTTP/1.0 500 Internal Server Error");
    print($message);
    exit;
}

/*
  decode an HTML hex-code into an array of R,G, and B values.
  accepts these formats: (case insensitive) #ffffff, ffffff, #fff, fff
 */

function hex_to_rgb($hex) {
    // remove '#'
    if (substr($hex, 0, 1) == '#')
        $hex = substr($hex, 1);

    // expand short form ('fff') color to long form ('ffffff')
    if (strlen($hex) == 3) {
        $hex = substr($hex, 0, 1) . substr($hex, 0, 1) .
                substr($hex, 1, 1) . substr($hex, 1, 1) .
                substr($hex, 2, 1) . substr($hex, 2, 1);
    }

    if (strlen($hex) != 6)
        fatal_error('Error: Invalid color "' . $hex . '"');

    // convert from hexidecimal number systems
    $rgb['red'] = hexdec(substr($hex, 0, 2));
    $rgb['green'] = hexdec(substr($hex, 2, 2));
    $rgb['blue'] = hexdec(substr($hex, 4, 2));

    return $rgb;
}
?>

