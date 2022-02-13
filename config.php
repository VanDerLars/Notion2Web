<?php

// general settings
$language = 'en';
$page_title = 'Notion2Web';

$template = 'sidebar_light'; // the template name which should be used to render the page. You can define multiple




// set up templating engine
$smarty->setTemplateDir('app/templates');
$smarty->setConfigDir('app/smarty/config');
$smarty->setCompileDir('app/smarty/compile');
$smarty->setCacheDir('app/smarty/cache');
// $smarty->testInstall();
?>