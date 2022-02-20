<?php
error_reporting(E_ALL);
require 'vendor/autoload.php';
$smarty = new Smarty();

// Config
include('config.php');
include('app/functions.php');

// $document_tree = getfolder('content');
$document_tree = new N2webFolderItem('content', 'content', 0);

// URL-Parameter
$selectedPath;
$selectedName;
$selectedItem;

if (isset($_GET['path']) && isset($_GET['name'])) {
    $selectedPath = urldecode($_GET['path']);
    $selectedName = urldecode($_GET['name']);
} else {
    $selectedPath = "";
    $selectedName = "";
}

if ($selectedPath != "") {
    $selectedItem = new N2webFolderItem($selectedPath, $selectedName, 1, true);
} else {
    $firstItem = $document_tree->children[1];

    $selectedItem = new N2webFolderItem($firstItem->path, $firstItem->fileName, 1, true);
}

$breadcrumbs = $selectedItem->getBreadcrumbs();

// themes

// header and basic informations
$smarty->assign('language', $language);
$smarty->assign('page_title', $page_title);
$smarty->assign('seo_title', $seo_title);
$smarty->assign('seo_description', $seo_description);
$smarty->assign('seo_robots', $seo_robots);
$smarty->assign('domain', getDomain());
$smarty->assign('theme', $theme);

// the page contents
$smarty->assign('document_tree', $document_tree->getFileTree());
$smarty->assign('selectedItem', $selectedItem);
$smarty->assign('selectedItemPath', $selectedItem->path . "/" . $selectedItem->fileName);
$smarty->assign('selectedId', $selectedItem->id);
$smarty->assign('breadcrumbs', $breadcrumbs);

// the menus
$smarty->assign('menu_left', $menu_left);
$smarty->assign('menu_right', $menu_right);
$smarty->assign('footer_menu_left', $footer_menu_left);
$smarty->assign('footer_menu_right', $footer_menu_right);
$smarty->assign('main_logo_light', $main_logo_light);
$smarty->assign('main_logo_dark', $main_logo_dark);


// compile
if (isset($_POST["search"]) || isset($_GET['q'])) {
    // search was made->get results
    $searchString = '';
    if (isset($_POST["search"])){
        //search over post object (search field)
        $searchString = $_POST["search"];
    }
    if (isset($_GET['q'])){
        //search over parameter
        $searchString = $_GET["q"];
    }
    
    $search = $document_tree->getSearchResults($searchString);

    $rank = array_column($search, 'rank');

    array_multisort($rank, SORT_DESC, $search);

    $smarty->assign('is_search', true);
    $smarty->assign('searchResults', $search);
    $smarty->assign('searchTerm', $searchString);
    $smarty->assign('searchBreadcrumbs', searchBreadcrumbs($searchString));
} else {
    // normal page call
    $smarty->assign('searchTerm', '');
    $smarty->assign('is_search', false);
}

$smarty->display('app/themes/' . $theme . '/index.tpl');
