<?php
// Declaration; 
$use_image_light_boxes;
global $open_external_links_in_new_browser_tab;

// general settings
$language = 'en';
$page_title = 'Notion2Web';

// display settings
$template = 'sidebar_light'; // the template name which should be used to render the page. You can define multiple


// main menu settings
$main_logo_light = '';
$main_logo_dark = '';

// $menu = [$link1: "url1",$link2: "url2"];



// set up templating engine
$smarty->setTemplateDir('app/templates');
$smarty->setConfigDir('app/smarty/config');
$smarty->setCompileDir('app/smarty/compile');
$smarty->setCacheDir('app/smarty/cache');
// $smarty->testInstall();

?>
