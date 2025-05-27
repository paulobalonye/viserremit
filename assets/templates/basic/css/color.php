<?php
header("Content-Type:text/css");
function checkhexcolor($color)
{
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}
if (isset($_GET['color']) and $_GET['color'] != '') {
    $color = "#" . $_GET['color'];
}

if (!$color or !checkhexcolor($color)) {
    $color = "#336699";
}


function hexToRgb($hex, $alpha = false)
{
    $hex      = str_replace('#', '', $hex);
    $length   = strlen($hex);
    $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
    $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
    $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
    if ($alpha) {
        $rgb['a'] = $alpha;
    }
    return $rgb;
}
$rgb = hexToRgb($color);
?>
:root {
--r: <?php echo $rgb['r'] ?>;
--g: <?php echo $rgb['g'] ?>;
--b: <?php echo $rgb['b'] ?>;
}
