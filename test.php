<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram latest post</title>
    <style>
    	.ig-post--link {}
    	.ig-post--img {}
    	.ig-post--txt {}
    </style>
</head>
<body>

    <?php

	require('./instagram-latest-post/functions.php');

	// debug
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
	//error_reporting(E_ALL);

	refreshToken();
	echo(renderLastImage());

	?>

</body>
</html>

