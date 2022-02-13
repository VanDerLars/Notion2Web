<?php
    error_reporting(E_ALL);
    require 'vendor/autoload.php';
    $smarty = new Smarty();

    // Config
    include('config.php');
    include('app/functions.php');


    // $document_tree = getfolder('content');
    $document_tree = new N2webFolderItem('content', 'content', 0);

    // echo $document_tree;
    

    // template
    $smarty->assign('name', 'Ned');
    $smarty->assign('language', $language);
    $smarty->assign('page_title', $page_title);
    $smarty->assign('template', $template);
    $smarty->assign('document_tree', $document_tree->getFileTree());
    

    // compile
    $smarty->display('app/templates/'.$template.'/index.tpl');

?>
