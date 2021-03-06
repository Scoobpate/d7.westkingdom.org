<?php 
/**
 * @file
 * Alpha's theme implementation to display the basic html structure of a single
 * Drupal page.
 */


/**
 * Given a path to a directory and a regular expression,
 * return a random matching file from that directory, or
 * FALSE if there are no matching files.
 */
function _wk_zen2_select_random($dirpath, $pattern) {
  $result = FALSE;
  $dp = opendir(dirname(__FILE__) . '/' . $dirpath);
  if ($dp) {
    $files = array();
    while (($file = readdir($dp)) !== false) {
      $file = trim($file);
      if (preg_match('/\.png/', $file))
	$files[] = $file;
    }
    closedir($dp);
    if (!empty($files)) {
      $result = $files[array_rand($files)];
    }
  }
  return $result;
}

/**
 * Given a css selector and the path to a folder with images,
 * emit a css style that uses one random image selected from that
 * folder as the background picture.
 */
function _wk_zen2_insert_random_background($css_selector, $image_path, $image_base, $bg_attributes = 'no-repeat') {
  // _wk_zen2_select_random takes paths relative to this file, which is
  // in 'templates', but the css background style is given relative to the
  // css directory.
  $result = _wk_zen2_select_random('../css/' . $image_path, '/\.png/');
  
  if ($result) {
    $img = "/$image_base/$image_path/$result";
    print("      #$css_selector { background: url('$img') $bg_attributes; }\n");
  }
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN"
  "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" version="XHTML+RDFa 1.0" dir="<?php print $language->dir; ?>"<?php print $rdf_namespaces; ?>>
<head profile="<?php print $grddl_profile; ?>">
  <?php print $head; ?>
  <title><?php print $head_title; ?></title>
  <?php print $styles; ?>
  <?php print $scripts; ?>
    <style type="text/css">
<?php
      _wk_zen2_insert_random_background('supporter_l', 'wk_img/supporters_l', "$directory/css", "no-repeat");
      _wk_zen2_insert_random_background('supporter_r', 'wk_img/supporters_r', "$directory/css", "100% 0% no-repeat");
      _wk_zen2_insert_random_background('header-figures', 'wk_img/header_figures', "$directory/css", "no-repeat right top");
?>
    </style>
</head>
<body<?php print $attributes;?>>
  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>
</body>
</html>
