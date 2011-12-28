<!DOCTYPE html>
<html xml:lang="en" lang="en">
	<head>
		<title><?php print isset($title) ? $title : 'PAL'; ?></title>
		<base href="<?php print base_url(); ?>" />
		<meta name="author" content="Wil Wade" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<link rel="stylesheet" href="assets/css/default.css" />
		<?php print $_scripts; ?>
		<?php print $_styles; ?>

	</head>
	<body>

		<div id="content">
			<?php print $content; ?>
		</div>


	</body>
</html>