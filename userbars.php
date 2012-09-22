<?
// By James Holding @ www.cubehouse.org
class UserBars{
	// MAIN FUNCTION: Build userbar
	//	USE:
	//		$text: Text to display on Userbar
	//		$icon: Icon to use on Userbar, default "heart.png" - icon must be in "ico" folder
	//		$grad1: First colour for background gradient
	//		$grad2: Second colour for background gradient
	//		$margin: Distance from left-hand side for text to start (consider the icon width), default 25 pixels
	//		$icon_size: Icon dimensions, default to 16 pixels
	public function create($text, $icon="heart.png", $grad1="#ba0014", $grad2="#480014", $margin=25, $icon_size=16){
		// Create basic background
        $image = $this->build_background($grad1, $grad2, $icon, $icon_size);
		// Write text onto background
		$this->build_text($image, $text, $margin);
		// Return object
		return $image;
    }
	
	// FUNCTION: Creates basic userbar background
	private function build_background($c1, $c2, $icon, $size){
		// Create initial image
		$image = imagecreatetruecolor(450, 19);
		// Build gradient
		$this->build_gradient($image, 0, 0, 19, 450, $this->hex2rgb($c1), $this->hex2rgb($c2));
		// Save alpha
		imagealphablending($image,true);
		// Add background scanlines
		$scanlines = imagecreatefrompng(dirname(__file__)."/scanlines.png");
		imagealphablending($scanlines,true);
		imagecopy($image, $scanlines, 0, 0, 0, 0, 450, 19);
		// Add icon
		$favicon = imagecreatefrompng(dirname(__file__)."/ico/".$icon);
		imagealphablending($favicon,true);
		imagecopy($image, $favicon, 4, 1, 0, 0, $size, $size);
		// Add shine
		$scanlines = imagecreatefrompng(dirname(__file__)."/shine.png");
		imagealphablending($scanlines,true);
		imagecopy($image, $scanlines, 0, 0, 0, 0, 450, 19);
		return $image;
	}
	// FUNCTION: Create gradient image
	private function build_gradient($im, $x1, $y1, $height, $width, $left_color, $right_color){
		// Build initial colours
		$color0=($left_color[0]-$right_color[0])/$width;
		$color1=($left_color[1]-$right_color[1])/$width;
		$color2=($left_color[2]-$right_color[2])/$width;
		// Loop through width
		for ($i=0;$i<=$width;$i++){
			// Get next colour
			$red=$left_color[0]-floor($i*$color0);
			$green=$left_color[1]-floor($i*$color1);
			$blue=$left_color[2]-floor($i*$color2);
			// Draw line of current colour onto image
			$col= imagecolorallocate($im, $red, $green, $blue);
			imageline($im, $x1+$i, $y1, $x1+$i, $y1+$height, $col);
		}
	}
	// FUNCTION: Draws text onto bar
	private function build_text($im, $text, $x=6, $align='left', $y=12){
		// Font size
		$size = 8;
		// Sort out alignment
		if ($align=='right'){
			$dat = imagettfbbox($size, 0, "visitor.ttf", $text);
			$x -= $dat[2];
		}
		// Set up black and white colours
		$color2 = imagecolorallocate($im, 0, 0, 0);
		$color = imagecolorallocate($im, 255, 255, 255);
		// Write text border
		imagettftext($im, $size, 0, $x-1, $y-1, $color2, "visitor.ttf", $text);
		imagettftext($im, $size, 0, $x-1, $y, $color2, "visitor.ttf", $text);
		imagettftext($im, $size, 0, $x-1, $y+1, $color2, "visitor.ttf", $text);
		imagettftext($im, $size, 0, $x, $y+1, $color2, "visitor.ttf", $text);
		imagettftext($im, $size, 0, $x, $y-1, $color2, "visitor.ttf", $text);
		imagettftext($im, $size, 0, $x+1, $y-1, $color2, "visitor.ttf", $text);
		imagettftext($im, $size, 0, $x+1, $y, $color2, "visitor.ttf", $text);
		imagettftext($im, $size, 0, $x+1, $y+1, $color2, "visitor.ttf", $text);
		// Write text
		imagettftext($im, $size, 0, $x, $y, $color, "visitor.ttf", $text);
	}
	// FUNCTION: Converts hex colours into RGB components
	private function hex2rgb($c){
		if(!$c) return false;
		$c = trim($c);
		$out = false;
		// Check for valid colour code
		if(preg_match("/^[0-9ABCDEFabcdef\#]+$/i", $c)){
			// Remove hash
			$c = str_replace('#','', $c);
			// Parse through short colour-code
			$l = strlen($c) == 3 ? 1 : (strlen($c) == 6 ? 2 : false);
			if($l){
				// Grab RGB components
				unset($out);
				$out[0] = $out['r'] = $out['red'] = hexdec(substr($c, 0,1*$l));
				$out[1] = $out['g'] = $out['green'] = hexdec(substr($c, 1*$l,1*$l));
				$out[2] = $out['b'] = $out['blue'] = hexdec(substr($c, 2*$l,1*$l));
			}else{
				$out = false;
			}
		}else{
			$out = false;
		}
		return $out;
	}
}
?>