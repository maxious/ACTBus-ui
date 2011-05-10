<?php
/*
*DISCLAIMER
* http://blog.gmapify.fr/create-beautiful-tiled-heat-maps-with-php-and-gd
*THIS SOFTWARE IS PROVIDED BY THE AUTHOR 'AS IS' AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES *OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT, *INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF *USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT *(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*
*	@author: Olivier G. <olbibigo_AT_gmail_DOT_com>
*	@version: 1.0
*	@history:
*		1.0	creation
*/
	define('PI2', 2*M_PI);

	class HeatMapPoint{
		public $x,$y;
		function __construct($x,$y) {
			$this->x = $x;
			$this->y = $y;
		}
		function __toString() {
			return "({$this->x},{$this->y})";
		}
	}//Point

	class HeatMap{
		//TRANSPARENCY
		public static $WITH_ALPHA = 0;
		public static $WITH_TRANSPARENCY = 1;
		//GRADIENT STYLE
		public static $GRADIENT_CLASSIC = 'classic';
		public static $GRADIENT_FIRE = 'fire';
		public static $GRADIENT_PGAITCH = 'pgaitch';
		//GRADIENT MODE (for heatImage)
		public static $GRADIENT_NO_NEGATE_NO_INTERPOLATE = 0;
		public static $GRADIENT_NO_NEGATE_INTERPOLATE = 1;
		public static $GRADIENT_NEGATE_NO_INTERPOLATE = 2;
		public static $GRADIENT_NEGATE_INTERPOLATE = 3;
		//NOT PROCESSED PIXEL (for heatImage)
		public static $KEEP_VALUE = 0;
		public static $NO_KEEP_VALUE = 1;
		//CONSTRAINTS
		private static $MIN_RADIUS = 2;//in px
		private static $MAX_RADIUS = 50;//in px
		private static $MAX_IMAGE_SIZE = 10000;//in px
		
		//generate an $image_width by $image_height pixels heatmap image of $points
		public static function createImage($data, $image_width, $image_height, $mode=0, $spot_radius = 30, $dimming = 75, $gradient_name = 'classic'){
			$_gradient_name = $gradient_name;
			if(($_gradient_name != self::$GRADIENT_CLASSIC) && ($_gradient_name != self::$GRADIENT_FIRE) && ($_gradient_name != self::$GRADIENT_PGAITCH)){
				$_gradient_name = self::$GRADIENT_CLASSIC;
			}
			$_image_width = min(self::$MAX_IMAGE_SIZE, max(0, intval($image_width)));
			$_image_height = min(self::$MAX_IMAGE_SIZE, max(0, intval($image_height)));
			$_spot_radius = min(self::$MAX_RADIUS, max(self::$MIN_RADIUS, intval($spot_radius)));
			$_dimming = min(255, max(0, intval($dimming)));
			if(!is_array($data)){
				return false;
			}
			$im = imagecreatetruecolor($_image_width, $_image_height);
			$white = imagecolorallocate($im, 255, 255, 255);
			imagefill($im, 0, 0, $white);
			if(self::$WITH_ALPHA == $mode){
				imagealphablending($im, false);
				imagesavealpha($im,true);
			}
			//Step 1: create grayscale image
			foreach($data as $datum){
				if( (is_array($datum) && (count($datum)==1)) || (!is_array($datum) && ('HeatMapPoint' == get_class($datum)))){//Plot points
					if('HeatMapPoint' != get_class($datum)){
						$datum = $datum[0];
					}
					self::_drawCircularGradient($im, $datum->x, $datum->y, $_spot_radius, $_dimming);
				}else if(is_array($datum)){//Draw lines
					$length = count($datum)-1;
					for($i=0; $i < $length; ++$i){//Loop through points
						//Bresenham's algorithm to plot from from $datum[$i] to $datum[$i+1];
						self::_drawBilinearGradient($im, $datum[$i], $datum[$i+1], $_spot_radius, $_dimming);
					}
				}
			}
			//Gaussian filter
			if($_spot_radius >= 30){
				imagefilter($im, IMG_FILTER_GAUSSIAN_BLUR);
			}
			//Step 2: create colored image
			if(FALSE === ($grad_rgba = self::_createGradient($im, $mode, $_gradient_name))){
				return FALSE;
			}
			$grad_size = count($grad_rgba);
			for($x=0; $x <$_image_width; ++$x){
				for($y=0; $y <$_image_height; ++$y){
					$level = imagecolorat($im, $x, $y) & 0xFF;
					if( ($level >= 0) && ($level < $grad_size) ){
						imagesetpixel($im, $x, $y, $grad_rgba[imagecolorat($im, $x, $y) & 0xFF]);
					}
				}
			}
			if(self::$WITH_TRANSPARENCY == $mode){
				imagecolortransparent($im, $grad_rgba[count($grad_rgba)-1]);
			}
			return $im;
		}//createImage

		//Heat an image
		public static function heatImage($filepath, $gradient_name = 'classic', $mode= 0, $min_level=0, $max_level=255, $gradient_interpolate=0, $keep_value=0){
			$_gradient_name = $gradient_name;
			if(($_gradient_name != self::$GRADIENT_CLASSIC) && ($_gradient_name != self::$GRADIENT_FIRE) && ($_gradient_name != self::$GRADIENT_PGAITCH)){
				$_gradient_name = self::$GRADIENT_CLASSIC;
			}
			$_min_level = min(255, max(0, intval($min_level)));
			$_max_level = min(255, max(0, intval($max_level)));

			//try opening jpg first then png then gif format
			if(FALSE === ($im = @imagecreatefromjpeg($filepath))){
				if(FALSE === ($im = @imagecreatefrompng($filepath))){
					if(FALSE === ($im = @imagecreatefromgif($filepath))){
						return FALSE;
					}
				}
			}
			if(self::$WITH_ALPHA == $mode){
				imagealphablending($im, false);
				imagesavealpha($im,true);
			}
			$width = imagesx($im);
			$height = imagesy($im);	
			if(FALSE === ($grad_rgba = self::_createGradient($im, $mode, $_gradient_name))){
				return FALSE;
			}
			//Convert to grayscale
			$grad_size = count($grad_rgba);
			$level_range = $_max_level - $_min_level;
			for($x=0; $x <$width; ++$x){
				for($y=0; $y <$height; ++$y){
					$rgb = imagecolorat($im, $x, $y);
					$r = ($rgb >> 16) & 0xFF;
					$g = ($rgb >> 8) & 0xFF;
					$b = $rgb & 0xFF;
					$gray_level = Min(255, Max(0, floor(0.33 * $r + 0.5 * $g + 0.16 * $b)));//between 0 and 255				
					if( ($gray_level >= $_min_level) && ($gray_level <= $_max_level) ){
						switch($gradient_interpolate){
							case self::$GRADIENT_NO_NEGATE_NO_INTERPOLATE:
								//$_max_level takes related lowest gradient color
								//$_min_level takes related highest gradient color
								$value = 255 - $gray_level;
								break;
							case self::$GRADIENT_NEGATE_NO_INTERPOLATE:
								//$_max_level takes related highest gradient color
								//$_min_level takes related lowest gradient color
								$value = $gray_level;
								break;
							case self::$GRADIENT_NO_NEGATE_INTERPOLATE:
								//$_max_level takes lowest gradient color
								//$_min_level takes highest gradient color
								$value = 255- floor(($gray_level - $_min_level) * $grad_size / $level_range);
								break;
							case self::$GRADIENT_NEGATE_INTERPOLATE:
								//$_max_level takes highest gradient color
								//$_min_level takes lowest gradient color
								$value = floor(($gray_level - $_min_level) * $grad_size / $level_range);
								break;
							default:
						}
						imagesetpixel($im, $x, $y, $grad_rgba[$value]);
					}else{
						if(self::$KEEP_VALUE == $keep_value){
							//Do nothing
						}else{//self::$NO_KEEP_VALUE
							imagesetpixel($im, $x, $y, imagecolorallocatealpha($im,0,0,0,0));
						}
					}
				}
			}			
			if(self::$WITH_TRANSPARENCY == $mode){
				imagecolortransparent($im, $grad_rgba[count($grad_rgba)-1]);
			}
			return $im;
		}//heatImage
		
		private static function _drawCircularGradient(&$im, $center_x, $center_y, $spot_radius, $dimming){
			$dirty = array();
			$ratio = (255 - $dimming) / $spot_radius;
			for($r=$spot_radius; $r > 0; --$r){
				$channel = $dimming + $r * $ratio;
				$angle_step = 0.45/$r; //0.01;
				//Process pixel by pixel to draw a radial grayscale radient
				for($angle=0; $angle <= PI2; $angle += $angle_step){
					$x = floor($center_x + $r*cos($angle));
					$y = floor($center_y + $r*sin($angle));
					if(!isset($dirty[$x][$y])){
						$previous_channel = @imagecolorat($im, $x, $y) & 0xFF;//grayscale so same value
						$new_channel = Max(0, Min(255,($previous_channel * $channel)/255));
						imagesetpixel($im, $x, $y, imagecolorallocate($im, $new_channel, $new_channel, $new_channel));
						$dirty[$x][$y] = 0;
					}
				}
			}
		}//_drawCircularGradient
		
		private static function _drawBilinearGradient(&$im, $point0, $point1, $spot_radius, $dimming){
			if($point0->x < $point1->x){
				$x0 = $point0->x;
				$y0 = $point0->y;
				$x1 = $point1->x;
				$y1 = $point1->y;
			}else{
				$x0 = $point1->x;
				$y0 = $point1->y;
				$x1 = $point0->x;
				$y1 = $point0->y;
			}

			if( ($x0==$x1) && ($y0==$y1)){//check if same coordinates
				return false;
			}
			$steep = (abs($y1 - $y0) > abs($x1 - $x0))? true: false;
			if($steep){
				list($x0, $y0) = array($y0, $x0);//swap
				list($x1, $y1) = array($y1, $x1);//swap
			}
			if($x0>$x1){
				list($x0, $x1) = array($x1, $x0);//swap
				list($y0, $y1) = array($y1, $y0);//swap
			}
			$deltax = $x1 - $x0;
			$deltay = abs($y1 - $y0);
			$error = $deltax / 2;
			$y = $y0;
			if( $y0 < $y1){
				$ystep = 1; 
			}else{
				$ystep = -1;
			}
			$step = max(1, floor($spot_radius/ 3));
			for($x=$x0; $x<=$x1; ++$x){//Loop through x value
				if(0==(($x-$x0) % $step)){
					if($steep){
						self::_drawCircularGradient(&$im, $y, $x, $spot_radius, $dimming);
					}else{ 
						self::_drawCircularGradient(&$im, $x, $y, $spot_radius, $dimming);
					}
				}
				$error -= $deltay;
				if($error<0){
						$y = $y + $ystep;
						$error = $error + $deltax;
				}
			}		
		}//_drawBilinearGradient
		
		private static function _createGradient($im, $mode, $gradient_name){
			//create the gradient from an image
			if(FALSE === ($grad_im = imagecreatefrompng('gradient/'.$gradient_name.'.png'))){
				return FALSE;
			}
			$width_g = imagesx($grad_im);
			$height_g = imagesy($grad_im);
			//Get colors along the longest dimension
			//Max density is for lower channel value
			for($y=$height_g-1; $y >= 0 ; --$y){
					$rgb = imagecolorat($grad_im, 1, $y);
					//Linear function
					$alpha = Min(127, Max(0, floor(127 - $y/2)));
					if(self::$WITH_ALPHA == $mode){
						$grad_rgba[] = imagecolorallocatealpha($im, ($rgb >> 16) & 0xFF, ($rgb >> 8) & 0xFF, $rgb & 0xFF, $alpha);
					}else{
						$grad_rgba[] = imagecolorallocate($im, ($rgb >> 16) & 0xFF, ($rgb >> 8) & 0xFF, $rgb & 0xFF);
					}
			}
			imagedestroy($grad_im);
			unset($grad_im);
			return($grad_rgba);
		}//_createGradient
	}//Heatmap
?>