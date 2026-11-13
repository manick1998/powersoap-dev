<?php
/* =====================================================================
   thumb.php  —  PRODUCT IMAGE THUMBNAIL PROXY
   ---------------------------------------------------------------------
   PROBLEM:
       products.image la FULL-SIZE phone camera photo irukku.
       Example: https://d8yt9z8a0r4xc.cloudfront.net/userImage/xxx.jpeg
                = 1,292,196 bytes (1.23 MB)  <-- oru image mattum!
       Aana screen-la 50x50 px-la mattum kaaturaanga.

       62 products x ~500 KB avg = ~31 MB image download
       -> 4G-la ~40-60 seconds. Adhu thaan app slow.

   SOLUTION:
       Intha file image-a download panni, server-layey 60x60-ku
       resize panni, disk-la cache pannum.
       1.23 MB  ->  ~3 KB   (**99.7% kammi**)

   USAGE (JS-la):
       thumb.php?w=60&u=<urlencoded cloudfront url>

   SAFETY:
       - CloudFront host mattum thaan allow (SSRF protection)
       - GD extension illa-na -> original URL-ku redirect (fail-safe)
       - Download fail aana -> original URL-ku redirect (fail-safe)
       - Cache 30 naal (browser + disk)
       - w 20..240 range-la clamp

   IDHU BUSINESS LOGIC-A MAATHADHU. Verum image proxy mattum.
   ===================================================================== */

/* ---- config ---- */
$ALLOWED_HOSTS = array(
    'd8yt9z8a0r4xc.cloudfront.net',
);
$CACHE_DIR   = __DIR__ . '/assets/thumbs';
$CACHE_DAYS  = 30;
$JPEG_Q      = 82;
$FETCH_TIMEOUT = 8;

/* ---- 1x1 transparent GIF (fallback padam) ---- */
function send_blank_gif()
{
    header('Content-Type: image/gif');
    header('Cache-Control: public, max-age=86400');
    echo base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');
    exit;
}

/* ---- input ---- */
$w = isset($_GET['w']) ? (int) $_GET['w'] : 60;
if ($w < 20)  $w = 20;
if ($w > 240) $w = 240;

$u = isset($_GET['u']) ? trim($_GET['u']) : '';

if ($u === '') {
    send_blank_gif();
}

/* CloudFront URL-la space irundhaal encode pannanum */
$u = str_replace(' ', '%20', $u);

/* ---- host whitelist (SSRF protection) ---- */
$parts = @parse_url($u);
$host  = ($parts && isset($parts['host'])) ? strtolower($parts['host']) : '';
$scheme = ($parts && isset($parts['scheme'])) ? strtolower($parts['scheme']) : '';

if (!in_array($scheme, array('http', 'https'), true) || !in_array($host, $ALLOWED_HOSTS, true)) {
    send_blank_gif();
}

/* ---- cache path ---- */
$key  = sha1($u) . '_' . $w . '.jpg';
$path = $CACHE_DIR . '/' . $key;

/* ---- cache HIT ---- */
if (is_file($path) && filesize($path) > 0) {
    header('Content-Type: image/jpeg');
    header('Cache-Control: public, max-age=' . ($CACHE_DAYS * 86400));
    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $CACHE_DAYS * 86400) . ' GMT');
    header('Content-Length: ' . filesize($path));
    readfile($path);
    exit;
}

/* ---- GD illa-na original-ku redirect (fail-safe) ---- */
if (!function_exists('imagecreatefromstring')) {
    header('Location: ' . $u, true, 302);
    exit;
}

/* ---- fetch original ---- */
$ctx = stream_context_create(array(
    'http' => array(
        'timeout'       => $FETCH_TIMEOUT,
        'user_agent'    => 'PowerSoapThumb/1.0',
        'ignore_errors' => true,
    ),
    'ssl' => array(
        'verify_peer'      => false,
        'verify_peer_name' => false,
    ),
));

$data = @file_get_contents($u, false, $ctx);

if ($data === false || $data === '') {
    header('Location: ' . $u, true, 302);
    exit;
}

/* ---- resize ---- */
$src = @imagecreatefromstring($data);

if (!$src) {
    header('Location: ' . $u, true, 302);
    exit;
}

$sw = imagesx($src);
$sh = imagesy($src);

/* center square crop (thumbnail 50x50-ku perfect-aa irukkum) */
$side = ($sw < $sh) ? $sw : $sh;
$sx   = (int) (($sw - $side) / 2);
$sy   = (int) (($sh - $side) / 2);

$dst   = imagecreatetruecolor($w, $w);
$white = imagecolorallocate($dst, 255, 255, 255);
imagefill($dst, 0, 0, $white);
imagecopyresampled($dst, $src, 0, 0, $sx, $sy, $w, $w, $side, $side);

/* ---- save to disk cache ---- */
if (!is_dir($CACHE_DIR)) {
    @mkdir($CACHE_DIR, 0755, true);
}
$saved = @imagejpeg($dst, $path, $JPEG_Q);

header('Content-Type: image/jpeg');
header('Cache-Control: public, max-age=' . ($CACHE_DAYS * 86400));
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $CACHE_DAYS * 86400) . ' GMT');

if ($saved && is_file($path) && filesize($path) > 0) {
    /* disk cache-la save aachu -> adhai anuppu */
    header('Content-Length: ' . filesize($path));
    readfile($path);
} else {
    /* disk-la write panna mudiyala (permission) -> memory-la irundhu anuppu */
    imagejpeg($dst, null, $JPEG_Q);
}

imagedestroy($src);
imagedestroy($dst);
exit;
