<!DOCTYPE html>
<html xml:lang="en" lang="en">
<head>
   <title><?php print isset($title) ? $title : 'PAL';?></title>
   <?= $_scripts ?>
   <?= $_styles ?>
</head>
<body>

   <div id="content">
      <?php print $content ?>
   </div>


</body>
</html>