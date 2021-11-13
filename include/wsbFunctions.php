<?php
function wsb_result($res, $row, $field=0) {
    $res->data_seek($row);
    $datarow = $res->fetch_array();
    return $datarow[$field];
}
function connect_db()
{
    $host = 'localhost';
    $user = 'root';
    $pass = 'devonian';
    $db = 'wells';
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);
    return $mysqli;
}
function connect_outboard()
{
    $host = 'localhost';
    $user = 'root';
    $pass = 'devonian';
    $db = 'outboard';
    $mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);
    return $mysqli;
}
function connect_wellnotes()
{
    $host = 'localhost';
    $user = 'root';
    $pass = 'devonian';
    $db = 'wellNotes';
    $mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);
    return $mysqli;
}
function connect_cpnotes()
{
    $host = 'localhost';
    $user = 'root';
    $pass = 'devonian';
    $db = 'wells_pipeline_notes';
    $mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);
    return $mysqli;
}
function connect_noper()
{
    $host = 'localhost';
    $user = 'root';
    $pass = 'devonian';
    $db = 'noper';
    $mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);
    return $mysqli;
}
function truncate($value)
{
    if ($value < 0)
    {
        return ceil((string)($value * 100)) / 100;
    }
    else
    {
        return floor((string)($value * 100)) / 100;
    }
}
function truncateCoordinates($number, $decimals)
{
  $point_index = strrpos($number, '.'); 
  return substr($number, 0, $point_index + $decimals+ 1);
}
if(!function_exists('mime_content_type')) {

    function mime_content_type($filename) {

        $mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $ext = strtolower(array_pop(explode('.',$filename)));
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
        elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        }
        else {
            return 'application/octet-stream';
        }
    }
}
Function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}
Function Slug($string, $slug = '_', $extra = null)
	{
		return strtolower(trim(preg_replace('~[^0-9a-z' . preg_quote($extra, '~') . ']+~i', $slug, Unaccent($string)), $slug));
	}
Function Unaccent($string)
	{
		if (extension_loaded('intl') === true)
		{
			$string = Normalizer::normalize($string, Normalizer::FORM_KD);
		}

		if (strpos($string = htmlentities($string, ENT_QUOTES, 'UTF-8'), '&') !== false)
		{
			$string = html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|caron|cedil|circ|grave|lig|orn|ring|slash|tilde|uml);~i', '$1', $string), ENT_QUOTES, 'UTF-8');
		}

		return $string;
	}