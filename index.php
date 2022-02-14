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
    if (isset($_GET['path']) && isset($_GET['name'])) {
        $selectedPath = urldecode($_GET['path']);
        $selectedName = urldecode($_GET['name']);
    } else {
        $selectedPath = "";
    }

    $selectedItem;
    if ($selectedPath != ""){
        $selectedItem = new N2webFolderItem($selectedPath, $selectedName, 1);
    }else{
        $selectedItem = $document_tree->children[0];
    }
    


    

    // template
    $smarty->assign('name', 'Ned');
    $smarty->assign('language', $language);
    $smarty->assign('page_title', $page_title);
    $smarty->assign('template', $template);
    $smarty->assign('document_tree', $document_tree->getFileTree());
    $smarty->assign('selectedItem', $selectedItem);
    $smarty->assign('selectedItemPath', $selectedItem->path . "/" . $selectedItem->fullName);
    $smarty->assign('selectedId', $selectedItem->id);
    // echo $selectedItem;
    

    // compile
    $smarty->display('app/templates/'.$template.'/index.tpl');

?>
