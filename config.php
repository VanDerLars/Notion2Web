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
$main_logo_light = 'img/VIA_plain_blau S.png';
$main_logo_dark = '';

// $menu = [$link1: "url1",$link2: "url2"];
$menu_left = [
	'Blog ↗' => "https://blog.stadtlandnetz.de",
];
$menu_right = [
	'Support ↗' => "http://localhost:3000/localhost?path=content&name=Wiki+3084aced05f749129552978d659ed9bc.html&id=3084aced05f749129552978d659ed9bc",
	'Stadt.Land.Netz ↗' => "https://stadtlandnetz.de",
	'Third Item ↗' => "https://google.com",
];

$footer_menu_left = [
	'Impressum ↗' => "http://localhost:3000/localhost?path=content&name=Wiki+3084aced05f749129552978d659ed9bc.html&id=3084aced05f749129552978d659ed9bc",
	'Datenschutz ↗' => "https://stadtlandnetz.de",
];
$footer_menu_right = [
	'↑' => "#top",
];


// set up templating engine
$smarty->setTemplateDir('app/templates');
$smarty->setConfigDir('app/smarty/config');
$smarty->setCompileDir('app/smarty/compile');
$smarty->setCacheDir('app/smarty/cache');
// $smarty->testInstall();

?>
