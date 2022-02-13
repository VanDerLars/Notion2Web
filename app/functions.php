<?php

use function PHPSTORM_META\type;

function getDomain(){
    return $_SERVER['SERVER_NAME'];
}




class N2webFolderItem{
    public int $objectType;
    public $path;
    public $children = [];

    public $html;

    public $id;
    public $name;
    public $fullName;

    function __construct($path_, $name_, $type_){
        $this->objectType = $type_; // 0= Directory, 1 = File
        $this->path = $path_;
        $this->fullName = $name_;

        $spl = explode(' ', $this->fullName);
        $this->id = end($spl);

        array_pop($spl);
        $r = '';
        foreach($spl as $itm){
            $r .= $itm . ' ';
        }
        $this->name = $r;

        
        // load children when directory
        if ($this->objectType == 0) {
            // read files and directories, first files, then dirs in alphabetical order
            // first files
            $ffs = scandir($path_, 1);
            foreach ($ffs as $ff) {
                if ($ff != '.' && $ff != '..' && str_starts_with($ff, '.') == false) {
                    if (is_dir($this->path . '/' . $ff)) {
                        // directory
                        $newItm = new N2webFolderItem($path_ . '/' . $ff, $ff, 0);
                        array_push($this->children, $newItm);
                    } else {
                        // file
                        $newItm = new N2webFolderItem($path_, $ff, 1);
                        array_push($this->children, $newItm);

                        $this->html = file_get_contents($this->path . "/" . $ff);
                    }
                }
            }
            // // then directories
            // $ffs = scandir($path_);
            // foreach ($ffs as $ff) {
            //     if ($ff != '.' && $ff != '..' && str_starts_with($ff, '.') == false) {
            //         if (is_dir($this->path . '/' . $ff)) {
            //             // directory
            //             $newItm = new N2webFolderItem($path_ . '/' . $ff, $ff, 0);
            //             array_push($this->children, $newItm);
            //         } else {
            //         }
            //     }
            // }
        }else{
            // file item
        }
    }

    public function getFileTree(){
        $ret= '';
        foreach ($this->children as $child){
            if ($child->objectType == 1){
                // file
                if(str_ends_with($child->fullName, '.html') == true){
                    $ret.= '<li class="n2web_file"><a href="' . getDomain() . '?path=' . $child->path . '">' . $child->name . '</a></li>';
                }
            }else{
                // directory
                // $ret.= '<ul class="n2web_group"><li class="n2web_group_headline" id="' . $child->id . '">' . $child->name . '</li>' . $child->getFileTree() . '</ul>';
                $ret.= '<ul class="n2web_group" id="' . $child->id . '">' . $child->getFileTree() . '</ul>';
            }
        }
        return $ret;
    }


    public function __toString(){
        $ret= 'name: ' . $this->name;
        $ret.= '<br>path: ' . $this->path;
        $ret.= '<br>objectType: ' . $this->objectType;

        $ret.= '<br>children: <ul>';
        foreach ($this->children as $child){
            $ret.= '<li>'.$child.'</li>';
        }
        $ret .= '</ul>';
        $ret .= '<hr>';
        return $ret;
    }
}



// -----------------------
// --- DOKU FUNKTIONEN ---
// -----------------------

function getfolder(N2webFolderItem $directory)
{
    $ffs = scandir($directory->path);

    $return = '';

    foreach ($ffs as $ff) {
        if ($ff != '.' && $ff != '..') {
            if (is_dir($directory->path . '/' . $ff)) {
                //Pfad ist ein Verzeichnis
                $newItm = new N2webFolderItem($directory . '/' . $ff, $ff, 0);
                array_push($directory->children, $newItm);

                // $return .= '<option>FOLDER: ' . $directory . '/' . $ff . '/</option>' ;
                $return .= getfolder($newItm);
            } else {
                // Pfad ist Datei
                $newItm = new N2webFolderItem($directory, $ff, 1);
                array_push($directory->children, $newItm);

                // $return .= '<option>FILE: ' . $directory . '/' . $ff . '/</option>' ;
            }
        }
    }
    return $return;
}


function getFolderFiles($directory, $editable)
{
    $ret = '';

    $C = 0;

    $ffs = scandir($directory);
    $ret .= '<div class="menu menu-inner">';
    foreach ($ffs as $ff) {
        $C = $C + 1;
        if ($ff != '.' && $ff != '..') {

            if (is_dir($directory . '/' . $ff)) {
                //Pfad ist ein Verzeichnis

                $ff = str_replace(".md", "", $ff);
                $pos = strrpos($ff, "_", 0);
                $edit_bnt = '';


                if ($editable == 'true') {
                    $edit_bnt = '<a href="cms/delete.php?action=ask&del=' . $directory . '/' . $ff . '" class="edit_mnu_btn btn_delete" data-featherlight="iframe"><i class="fa fa-trash-o fa-1"></i></a>';
                    $edit_bnt .= '<a href="cms?site=' . $directory . '/' . $ff . '" class="edit_mnu_btn btn_edit"><i class="fa fa-pencil fa-1"></i></a>';
                }


                $ret .= $edit_bnt . '<div class="menu menu-outer">'; //.$ff;

                if ($pos == 0) {
                    $ret .= $ff;
                } else {
                    $sn = explode("_", $ff);
                    $ret .= $sn[1];
                }


                getFolderFiles($directory . '/' . $ff, $editable);
                $ret .= '</div>';
            } else {
                //Pfad ist eine Datei

                $ff1 = str_replace(".md", "", $ff);
                $ff2 = str_replace(" ", "_", $ff1);
                $pos = strrpos($ff, "_", 0);
                $edit_bnt = '';


                if ($pos == 0) {
                    $ret .= $edit_bnt . '<a href="?site=' . $directory . '/' . $ff . '&focus=mnu' . $C . $ff2 . '"> <div id="mnu' . $C . $ff2 . '" class="menuitem">' . $ff1 . '</div></a>';
                } else {
                    $sn = explode("_", $ff1);
                    $ret .= $edit_bnt . '<a href="?site=' . $directory . '/' . $ff . '&focus=mnu' . $C . $ff2 . '"> <div id="mnu' . $C . $ff2 . '" class="menuitem">' . $sn[1] . '</div></a>';
                }
            }
        }
    }
    $ret .= '</div>';

    return $ret;
}
