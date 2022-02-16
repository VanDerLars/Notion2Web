<?php

function getDomain()
{
    return $_SERVER['SERVER_NAME'];
}

class N2webFolderItem
{
    public int $objectType;
    public $path;
    public $html;
    public $id;
    public $name;
    public $fileName;
    public $children = [];
    public $parent;

    function __construct($path_, $name_, $type_, $loadHtml = false, $parent_ = NULL)
    {
        $this->objectType = $type_; // 0= Directory, 1 = File
        $this->path = $path_;
        $this->fileName = $name_;
        $this->parent = $parent_;

        $spl = explode(' ', $this->fileName);
        $this->id = str_replace(".html", "", end($spl));
        $this->subfolderName = str_replace(".html", "", $this->fileName);

        array_pop($spl);
        $r = '';
        foreach ($spl as $itm) {
            $r .= $itm . ' ';
        }
        $this->name = $r;

        if ($this->objectType == 1 && $loadHtml == true) {
            $location = $this->path . '/' . $this->fileName;
            $location = str_replace('amp%3B', '', $location);
            $location = str_replace('%3B', '', $location);
            $this->html = $this->sanitizeNotionHtml(file_get_contents($location));
        }

        // load children when directory
        if ($this->objectType == 0) {
            $ffs = scandir($path_, 1);
            foreach ($ffs as $ff) {
                if ($ff != '.' && $ff != '..' && str_starts_with($ff, '.') == false) {
                    if (is_dir($this->path . '/' . $ff)) {
                        // directory
                        $newItm = new N2webFolderItem($path_ . '/' . $ff, $ff, 0, false, $this);
                        // $newItm->parent = $this;
                        array_push($this->children, $newItm);
                    } else {
                        // file
                        $newItm = new N2webFolderItem($path_, $ff, 1, false, $this);
                        // $newItm->parent = $this;
                        array_push($this->children, $newItm);
                    }
                }
            }
        } else {
            // file item
        }

        if ($this->parent == null && $this->path != '') {
            $pathArr = explode("/", $this->path);
            $parName = array_pop($pathArr) . ".html";

            $parPath = implode('/', $pathArr);

            $this->parent = new N2webFolderItem($parPath, $parName, 1, false, false);
        }
    }

    public function getBreadcrumbs()
    {
        $par = $this->parent;
        $ret = '';
        if ($par != NULL) {
            $ret = $par->getBreadcrumbs();
            $dev = '<div class="n2web_breadcrumb_devider"></div>';
            $itm = '<div class="n2web_breadcrumb_item"><a href="' . getDomain() . '?path=' . urlencode($this->path) . '&name=' . urlencode($this->fileName) . '&id=' . $this->id . '">' . $this->name . '</a></div>';

            if ($this->name == '') {
                // prevent a rare problem
                return $ret;
            } else {

                if ($ret == '') {
                    $ret = $itm;
                } else {
                    $ret .= $dev . $itm;
                }
            }
            return $ret;
        } else {
            // root reached
            return '';
        }
    }

    public function subDirPath()
    {
        return $this->path . '/' . $this->name . $this->id;
    }
    public function hasSubDir()
    {
        return is_dir($this->subDirPath());
    }
    public function hasSubItems()
    {
        if ($this->hasSubDir()) {
            $ffs = scandir($this->subDirPath(), 1);
            foreach ($ffs as $ff) {
                if ($ff != '.' && $ff != '..' && str_starts_with($ff, '.') == false) {
                    if (is_dir($this->path . '/' . $ff)) {
                        // directory
                        return true;
                    } else {
                        // file
                        if (str_contains($ff, '.html')) {
                            return true;
                        }
                    }
                }
            }
        } else {
            return false;
        };
    }

    public function getFileTree()
    {
        $ret = '';
        foreach ($this->children as $child) {
            if ($child->objectType == 1) {
                // file
                if (str_ends_with($child->fileName, '.html') == true) {
                    $class_has_children = '';
                    $div_has_children = '';
                    if ($child->hasSubItems()) {
                        $class_has_children = 'has_children';
                        $div_has_children = '<div class="n2web_show_children" data-n2webid="' . $child->id . '"></div>';
                    } else {
                        $class_has_children = 'no_children';
                    }
                    $ret .= '<li class="n2web_file ' . $class_has_children . '" id="' . $child->id . '_file" data-n2webid="' . $child->id . '">' . $div_has_children . '<a href="' . getDomain() . '?path=' . urlencode($child->path) . '&name=' . urlencode($child->fileName) . '&id=' . $child->id . '">' . $child->name . '</a></li>';
                }
            } else {
                // directory
                $ret .= '<ul class="n2web_group" id="' . $child->id . '_dir" data-n2webid="' . $child->id . '">' . $child->getFileTree() . '</ul>';
            }
        }
        $ret .= '';
        return $ret;
    }


    public function __toString()
    {
        $ret = 'name: ' . $this->name;
        $ret .= '<br>subfolder: ' . $this->subfolderName;
        $ret .= '<br>id: ' . $this->id;
        $ret .= '<br>fileName: ' . $this->fileName;
        $ret .= '<br>path: ' . $this->path;
        $ret .= '<br>objectType: ' . $this->objectType;
        $ret .= '<br>html: ' . $this->html;

        $ret .= '<br>children: <ul>';
        foreach ($this->children as $child) {
            $ret .= '<li>' . $child . '</li>';
        }
        $ret .= '</ul>';
        $ret .= '<hr>';
        return $ret;
    }

    function sanitizeNotionHtml($html)
    {
        // 1. get rid of the page style and only the content in the body
        preg_match_all('/^[\s\S]*<body[^\>]*>([\s\S]*)<\/body>[\s\S]*$/im', $html, $body_match);
        $this_body_match = $body_match[1];
        if ($this_body_match) {
            $html = $this_body_match[0];
        } else {
            $html = 'no content';
        }

        // 2. replace images
        preg_match_all('/src="([^"]*)"/i', $html, $img_match);
        $this_img_match = $img_match[1];
        if ($this_img_match) {
            $arr_length = count($this_img_match);
            for ($i = 0; $i < $arr_length; $i++) {
                // for each image in document
                $oldimgUrl = $this_img_match[$i];
                $workimgUrl = urldecode($this_img_match[$i]);

                if (str_starts_with($workimgUrl, 'http') == false) {
                    $newimgurl = ($this->path . "/" . $oldimgUrl);
                    $html = str_replace($oldimgUrl, $newimgurl, $html);
                }
            }
        }

        // 3.replace hyperlinks
        preg_match_all('/<a[^>]* href="([^"]*)"/im', $html, $link_match);
        $this_match = $link_match[1];

        if ($this_match) {
            $arr_length = count($this_match);
            for ($i = 0; $i < $arr_length; $i++) {
                // for each link in document
                $oldUrl = $this_match[$i];
                $workUrl = urldecode($this_match[$i]);
                if (str_ends_with($workUrl, '.png') == false) {
                    // no image link
                    if (str_starts_with($workUrl, 'http') == false && str_starts_with($workUrl, '#') == false) {
                        //only replace internal links
                        $spl = explode('/', $workUrl);
                        $itemName = urldecode(end($spl));

                        array_pop($spl);
                        $r = '';
                        foreach ($spl as $itm) {
                            $r .= $itm . '/';
                        }
                        $itemPath = $r;

                        $item = new N2webFolderItem($itemPath, $itemName, 1);

                        $newUrl = getDomain() . '?path=' . urlencode($this->path . '/' . $item->path) . '&name=' . urlencode($item->fileName) . '&id=' . $item->id;

                        $newUrl = str_replace('amp%3B', '', $newUrl);
                        $newUrl = str_replace('%3B', '', $newUrl);
                        $html = str_replace($oldUrl, $newUrl, $html);
                    } else {
                        // external link -> replace target
                        $replaceStr = 'href="' . $oldUrl;

                        if ( str_starts_with($workUrl, '#') == false) {
                            $newStr = 'target="_blank" href="' . $oldUrl;
                        }else{
                            $newStr = 'href="' . $oldUrl;
                        }
                        
                        $newStr = str_replace('class="', 'class="n2web_external_link ', $newStr);
                        $html = str_replace($replaceStr, $newStr, $html);
                    }
                } else {
                    // image link
                    $replaceStr = 'href="' . $oldUrl;
                    $newStr = 'data-featherlight="image" href="' . $oldUrl;
                    $html = str_replace($replaceStr, $newStr, $html);
                }
            }
        }

        return $html;
    }
}
