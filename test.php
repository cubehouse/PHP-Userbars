<?
include("userbars.php");
$generator = new UserBars();
$image = $generator->create("Test bar! :: ".date("r"));
//	Function arguments:
//		1: Text to display on Userbar [required]
//		2: Icon to use on Userbar, default "heart.png" - icon must be in "ico" folder
//		3: First colour for background gradient - in #aaaaaa format
//		4: Second colour for background gradient - in #aaaaaa format
//		5: Distance from left-hand side for text to start (consider the icon width), default 25 pixels
//		6: Icon dimensions, default to 16 pixels


header('Content-type: image/png'); 
imagepng($image);
?>