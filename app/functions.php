<?php

// use function PHPSTORM_META\type;

function getDomain()
{
    return $_SERVER['SERVER_NAME'];
}




class N2webFolderItem
{
    public int $objectType;
    public $path;
    public $children = [];

    public $html;

    public $id;
    public $name;
    public $fullName;

    function __construct($path_, $name_, $type_)
    {
        $this->objectType = $type_; // 0= Directory, 1 = File
        $this->path = $path_;
        $this->fullName = $name_;

        $spl = explode(' ', $this->fullName);
        $this->id = str_replace(".html", "", end($spl));
        $this->subfolderName = str_replace(".html", "", $this->fullName);

        array_pop($spl);
        $r = '';
        foreach ($spl as $itm) {
            $r .= $itm . ' ';
        }
        $this->name = $r;
        if ($this->objectType == 1) {
            $this->html = $this->sanitizeNotionHtml(file_get_contents($path_ . "/" . $name_));
        }

        // load children when directory
        if ($this->objectType == 0) {
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
                    }
                }
            }
        } else {
            // file item
        }
    }

    public function getFileTree()
    {
        $ret = '';
        foreach ($this->children as $child) {
            if ($child->objectType == 1) {
                // file
                if (str_ends_with($child->fullName, '.html') == true) {
                    $ret .= '<li class="n2web_file" id="' . $child->id . '"><a href="' . getDomain() . '?path=' . urlencode($child->path) . '&name=' . urlencode($child->fullName) . '#' . $child->id . '">' . $child->name . '</a></li>';
                }
            } else {
                // directory
                // $ret.= '<ul class="n2web_group"><li class="n2web_group_headline" id="' . $child->id . '">' . $child->name . '</li>' . $child->getFileTree() . '</ul>';
                $ret .= '<ul class="n2web_group" id="' . $child->id . '">' . $child->getFileTree() . '</ul>';
            }
        }
        return $ret;
    }


    public function __toString()
    {
        $ret = 'name: ' . $this->name;
        $ret = 'id: ' . $this->id;
        $ret = 'fullname: ' . $this->fullName;
        $ret .= '<br>path: ' . $this->path;
        $ret .= '<br>objectType: ' . $this->objectType;
        $ret .= '<br>hml: ' . $this->html;

        $ret .= '<br>children: <ul>';
        foreach ($this->children as $child) {
            $ret .= '<li>' . $child . '</li>';
        }
        $ret .= '</ul>';
        $ret .= '<hr>';
        return $ret;
    }

    function sanitizeNotionHtml($html){
        // 1. get rid of the page style and only the content in the body
        preg_match('/<body[^>]*>((.|[\n\r])*)<\/body>/im', $html, $match);
        if ($match){
            $html = $match[0];
        }

        // 2. replace images
        $html = str_replace(' src="',' src="' . str_replace(" ", "%20", $this->path . "/"), $html);

        // 3.replace hyperlinks
        preg_match_all('/<a[^>]* href="([^"]*)"/im', $html, $link_match);
        $this_match = $link_match[0];

        if ($this_match){
            $arr_length = count($this_match);
            for($i = 0; $i < $arr_length; $i++) { 
                $oldUrl = $this_match[$i];

                $spl = explode('/', $oldUrl);
                $itemName = end($spl);

                array_pop($spl);
                $r = '';
                foreach ($spl as $itm) {
                    $r .= $itm . '/';
                }
                $itemPath = $r;

                $newUrl = getDomain() . '?path=' . $itemPath . '&name=' . $itemName ;
                $html = str_replace($oldUrl, $newUrl, $html);
            }
        }

        // $html = str_replace(' href="',' href="' . getDomain() . '?path=' . $this->path . "/", $html);

        return $html;
    }
}

file:///Users/larslehmann/Projects/GithubDesktop/notion_website_converter/content/Wiki%203084aced05f749129552978d659ed9bc/Orga%20f9b2d2cb50b340c6a79843291772fac2.html