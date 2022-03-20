<?php
// ----------------------------------------------------
// general settings
// ----------------------------------------------------
$language = 'en'; // gives the clients browser the information about the used language
$page_title = ''; //displayed in the main menu (depends on the theme). Empty as standard, since the logo tells the name
$seo_title = 'Notion2Web - the Notion website builder'; // displayed in google and in the browser tab
$seo_description = 'Notion2Web turns your Notion HTML export into a fully functional static website in no time.';
$seo_robots = 'index, follow';
$hide_from_navigation_with_prefix = ['__', '??']; // hides paage from the navigation, where the name start with the given text
$remove_beginning_numbers = true; // remove numbers from the beginning of a page name '01 start page" -> 'start page'


// ----------------------------------------------------
// access code
// ----------------------------------------------------
$restrictAccess = true; // if set to true, then the site is blocked until you have an URL-Parameter with the accessKey like 'https://youn2website.com?accesskey=PutYourAccesKeyHere
$accessKey = 'PutYourAccesKeyHere'; // the accesskey
$saveInBrowser = true; // tells if n2web should set a cookie to save the information, that the user is authenticated
$saveInBrowserForRestart = false; // set to true, if you want to save the login also if the users browsers was restarted. Saves the cookie for 30 days
$cookieName = 'myNotionPageName'; // if you allow to save authentication to cookies, then we have to make sure that it is only for you instance
$noAccessMessage = '
	<h1>
		✋ The access is restricted by the page owner
	</h1>
	<p>
		Sorry,<br><br>you need special access rights to enter this page. 
		<br>Please contact the page owner for more informations.
	</p>
';


// ----------------------------------------------------
// display settings
// ----------------------------------------------------

$theme = 'sidebar_light';
// $theme = 'onepage_light'; // the theme name which should be used to render the page.
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




// ----------------------------------------------------
// END OF CHANGEABLE THINGS 
// ----------------------------------------------------

// set up templating engine
$smarty->setTemplateDir('app/themes');
$smarty->setConfigDir('app/smarty/config');
$smarty->setCompileDir('app/smarty/compile');
$smarty->setCacheDir('app/smarty/cache');
