<?php
include ('../include/common.inc.php');
$debugOkay = Array(); // disable debugging output even on dev server

/*
*DISCLAIMER
*  http://blog.gmapify.fr/create-beautiful-tiled-heat-maps-with-php-and-gd
*THIS SOFTWARE IS PROVIDED BY THE AUTHOR 'AS IS' AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES *OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT, *INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF *USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT *(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*
*	@author: Olivier G. <olbibigo_AT_gmail_DOT_com>
*	@version: 1.0
*	@history:
*		1.0	creation
*/
	set_time_limit(120);//2mn
	ini_set('memory_limit', '256M');
error_reporting(E_ALL ^ E_DEPRECATED);
	require_once ($labsPath . 'lib/GoogleMapUtility.php');
	require_once ($labsPath . 'lib/HeatMap.php');

	//Root folder to store generated tiles
	define('TILE_DIR', 'tiles/');
	//Covered geographic areas
	define('MIN_LAT', -35.48);
	define('MAX_LAT', -35.15);
	define('MIN_LNG', 148.98);
	define('MAX_LNG', 149.25);
	define('TILE_SIZE_FACTOR', 0.5);
	define('SPOT_RADIUS', 30);
	define('SPOT_DIMMING_LEVEL', 50);
	
	//Input parameters
	if(isset($_GET['x']))
		$X = (int)$_GET['x'];
	else
		exit("x missing");
	if(isset($_GET['y']))
		$Y = (int)$_GET['y'];
	else
		exit("y missing");
	if(isset($_GET['zoom']))
		$zoom = (int)$_GET['zoom'];
	else
		exit("zoom missing");
if ($zoom < 12) { //enforce minimum zoom
			header('Content-type: image/png');
			echo file_get_contents(TILE_DIR.'empty.png');
}
	$dir = TILE_DIR.$zoom;
	$tilename = $dir.'/'.$X.'_'.$Y.'.png';
	//HTTP headers  (data type and caching rule)
	header("Cache-Control: must-revalidate");
	header("Expires: " . gmdate("D, d M Y H:i:s", time() + 86400) . " GMT");
	if(!file_exists($tilename)){
		$rect = GoogleMapUtility::getTileRect($X, $Y, $zoom);
		//A tile can contain part of a spot with center in an adjacent tile (overlaps).
		//Knowing the spot radius (in pixels) and zoom level, a smart way to process tiles would be to compute the box (in decimal degrees) containing only spots that can be drawn on current tile. We choose a simpler solution by increeasing  geo bounds by 2*TILE_SIZE_FACTOR whatever the zoom level and spot radius.
		$extend_X = $rect->width * TILE_SIZE_FACTOR;//in decimal degrees
		$extend_Y = $rect->height * TILE_SIZE_FACTOR;//in decimal degrees
		$swlat = $rect->y - $extend_Y;
		$swlng = $rect->x - $extend_X;
		$nelat = $swlat + $rect->height + 2 * $extend_Y;
		$nelng = $swlng + $rect->width + 2 * $extend_X;

		if( ($nelat <= MIN_LAT) || ($swlat >= MAX_LAT) || ($nelng <= MIN_LNG) || ($swlng >= MAX_LNG)){
			//No geodata so return generic empty tile
			echo file_get_contents(TILE_DIR.'empty.png');
			exit();
		}

		//Get McDonald's spots
		$spots = fGetPOI('Select * from stops where
				(stop_lon > '.$swlng.' AND stop_lon < '.$nelng.')
			AND (stop_lat < '.$nelat.' AND stop_lat > '.$swlat.')', $im, $X, $Y, $zoom, SPOT_RADIUS);

		
		if(empty($spots)){
			//No geodata so return generic empty tile
			header('Content-type: image/png');
			echo file_get_contents(TILE_DIR.'empty.png');
		}else{
			if(!file_exists($dir)){
				mkdir($dir, 0705);
			}
			//All the magics is in HeatMap class :)
			$im = HeatMap::createImage($spots, GoogleMapUtility::TILE_SIZE, GoogleMapUtility::TILE_SIZE, heatMap::$WITH_ALPHA, SPOT_RADIUS, SPOT_DIMMING_LEVEL, HeatMap::$GRADIENT_FIRE);
			//Store tile for reuse and output it
			header('content-type:image/png;');
			imagepng($im, $tilename);
			echo file_get_contents($tilename);
			imagedestroy($im);
			unset($im);
		}
	}else{
		//Output stored tile
		header('content-type:image/png;');
		echo file_get_contents($tilename);
	}
	/////////////
	//Functions//
	/////////////
	function fGetPOI($query, &$im, $X, $Y, $zoom, $offset){
            global $conn;
		$nbPOIInsideTile = 0;

        $spots = Array();
	$query = $conn->prepare($query);
	$query->execute();
	if (!$query) {
		databaseError($conn->errorInfo());
		return Array();
	}
	foreach( $query->fetchAll() as $row){
				$point = GoogleMapUtility::getOffsetPixelCoords($row['stop_lat'], $row['stop_lon'], $zoom, $X, $Y);
				//Count result only in the tile
				if( ($point->x > -$offset) && ($point->x < (GoogleMapUtility::TILE_SIZE+$offset)) && ($point->y > -$offset) && ($point->y < (GoogleMapUtility::TILE_SIZE+$offset))){
					$spots[] = new HeatMapPoint($point->x, $point->y);
				}
				
			}//while
		return $spots;
	}//fAddPOI
?>

