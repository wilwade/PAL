<!DOCTYPE html>
<html xml:lang="en" lang="en">
<head>
   <title><?php print isset($title) ? $title : 'PAL';?></title>
   <base href="<?php print base_url();?>index.php/" />
   <?php print $_scripts; ?>
   <?php print $_styles; ?>
</head>
<body>

   <div id="content">
      <?php print $content; ?>
   </div>


</body>
</html>