<?php

// general settings
$language = 'en'; // gives the clients browser the information about the used language
$page_title = ''; //displayed in the main menu (depends on the theme). Empty as standard, since the logo tells the name
$seo_title = 'Notion2Web - the Notion website builder'; // displayed in google and in the browser tab
$seo_description = 'Notion2Web turns your Notion HTML export into a fully functional static website in no time.';
$seo_robots = 'index, follow';

// display settings
$theme = 'sidebar_light'; // the theme name which should be used to render the page.
// $theme = 'sidebar_light_full_width'; 
// $theme = 'sidebar_dark'; 
// $theme = 'sidebar_dark_full_width';

// menu settings
$main_logo_light = 'img/logo_light.png';
$main_logo_dark = 'img/logo_dark.png';

$menu_left = [
	'Blog ↗' => "https://blog.stadtlandnetz.de",
];
$menu_right = [
	'internal Item' => "/localhost?path=content%2FNotion2Web+373b5&name=02+The+N2W+0131e.html&id=0131e",
	'Stadt.Land.Netz ↗' => "https://stadtlandnetz.de",
];

$footer_menu_left = [
	'Imprint ↗' => "https://an-url.com",
	'Data privacy ↗' => "https://another-url.com",
];
$footer_menu_right = [
	'↑' => "#top",
];


// END OF CHANGEABLE THINGS

// set up templating engine
$smarty->setTemplateDir('app/themes');
$smarty->setConfigDir('app/smarty/config');
$smarty->setCompileDir('app/smarty/compile');
$smarty->setCacheDir('app/smarty/cache');

?>
