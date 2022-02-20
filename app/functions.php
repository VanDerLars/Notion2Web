<?php

function getDomain()
{
    return $_SERVER['SERVER_NAME'];
}
if (!function_exists('str_contains')) {
    function str_contains(string $haystack, string $needle): bool
    {
        return '' === $needle || false !== strpos($haystack, $needle);
    }
}

class N2webFolderItem
{
    public int $objectType;
    public $path;
    public $html;
    public $htmlLoaded;
    public $id;
    public $name;
    public $title;
    public $fileName;
    public $children = [];
    public $parent;
    public $exists;

    private $isHTMLFile = false;
    private $searchBody;

    function __construct($path_, $name_, $type_, $loadHtml = false, $parent_ = NULL)
    {
        $this->objectType = $type_; // 0= Directory, 1 = File
        $this->path = $path_;
        $this->fileName = $name_;
        $this->parent = $parent_;
        $this->htmlLoaded = $loadHtml;

        $spl = explode(' ', $this->fileName);
        $this->id = str_replace(".html", "", end($spl));
        $this->subfolderName = str_replace(".html", "", $this->fileName);

        $this->exists = file_exists($path_ . "/" . $name_);

        $this->isHTMLFile = str_contains($this->fileName, '.html');

        array_pop($spl);
        $r = '';
        foreach ($spl as $itm) {
            $r .= $itm . ' ';
        }
        $this->name = $r;

        if ($this->objectType == 1 && $loadHtml == true) {
            $this->loadHTML();
        }
        if ($this->objectType == 1 && ($this->name != "" || $this->id != "")) {
            $this->title = $this->getPageTitle();
        } else {
        }


        // load children when directory
        $childrenWrongOrder = [];
        if ($this->objectType == 0) {
            $ffs = scandir($path_);
            foreach ($ffs as $ff) {
                if ($ff != '.' && $ff != '..' && str_starts_with($ff, '.') == false) {
                    // echo '<br>' . $ff;
                    if (is_dir($this->path . '/' . $ff)) {
                        // directory
                        $newItm = new N2webFolderItem($path_ . '/' . $ff, $ff, 0, false, $this);
                        // $newItm->parent = $this;
                        array_push($childrenWrongOrder, $newItm);
                    } else {
                        // file
                        $newItm = new N2webFolderItem($path_, $ff, 1, true, $this);
                        // $newItm->parent = $this;
                        array_push($childrenWrongOrder, $newItm);
                    }
                }
            }
        } else {
            // file item
        }

        // reverse order for propper display in sidebar
        $this->children = array_reverse($childrenWrongOrder, true);


        if ($this->parent == null && $this->path != '') {
            $pathArr = explode("/", $this->path);
            $parName = array_pop($pathArr) . ".html";

            $parPath = implode('/', $pathArr);

            $this->parent = new N2webFolderItem($parPath, $parName, 1, false, false);
        }
    }

    function loadHTML()
    {
        $location = $this->path . '/' . $this->fileName;
        $location = str_replace('amp%3B', '', $location);
        $location = str_replace('%3B', '', $location);

        if ($this->exists && $this->isHTMLFile) {
            $theHTML = file_get_contents($location);

            $this->html = $this->sanitizeNotionHtml($theHTML);
            $this->htmlLoaded = true;
        } else {
            $this->html = "";
        }
    }

    private function getPageTitle()
    {
        if ($this->exists == false && str_contains($this->fileName, '.html')) {
            return $this->name;
        } else {

            if ($this->html == "") {
                $this->loadHTML();
            }
            $cnt = $this->html;

            preg_match('~(?s)(?<=<h1\ class\=\"page\-title\"\>)(.+?)(?=<\/h1>)~', $cnt, $title_match);
            if (count($title_match) > 0) {
                $sanitizeTitle = preg_replace('~<[^>]*>~', '', $title_match[0]);
                return $sanitizeTitle;
            } else {
                return $this->name;
            }
        }
    }

    public function getBreadcrumbs()
    {
        $par = $this->parent;
        $ret = '';
        if ($par != NULL) {
            $ret = $par->getBreadcrumbs();
            $dev = '<div class="n2web_breadcrumb_devider"></div>';
            $itm = '<div class="n2web_breadcrumb_item"><a href="?path=' . urlencode($this->path) . '&name=' . urlencode($this->fileName) . '&id=' . $this->id . '">' . $this->title . '</a></div>';

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


    public function getBreadpath()
    {
        $par = $this->parent;
        $ret = '';
        if ($par != NULL) {
            $ret = $par->getBreadpath();
            $itm =  $this->title;
            if ($itm == "") {
                $itm = $this->getPageTitle();
            }
            $itm = '<i>' . $itm . '</i>';
            if ($this->name == '') {
                // prevent a rare problem
                return $ret;
            } else {
                if ($ret == '') {
                    $ret = $itm;
                } else {
                    $ret .= ' → ' . $itm . '';
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
        $allChldrn = $this->children;


        // reorder the array
        $theNewOrder = []; //easter egg :)

        for ($i = 0; $i < count($allChldrn); $i++) {
            if ($allChldrn[$i]->objectType == 0 && $allChldrn[$i + 1]->objectType == 1) {
                array_push($theNewOrder, $allChldrn[$i + 1]);
                array_push($theNewOrder, $allChldrn[$i]);
                $i++;
            } else {
                array_push($theNewOrder, $allChldrn[$i]);
            }
        }



        array_reverse($theNewOrder, true);
        foreach ($theNewOrder as $child) {
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
                    $ret .= '<li class="n2web_file ' . $class_has_children . '" id="' . $child->id . '_file" data-n2webid="' . $child->id . '">' . $div_has_children . '<a href="?path=' . urlencode($child->path) . '&name=' . urlencode($child->fileName) . '&id=' . $child->id . '">' . $child->title . '</a></li>';
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
        $ret .= '<br>exists: ' . file_exists($this->path . "/" . $this->fileName);
        $ret .= '<br>objectType: ' . $this->objectType;
        // $ret .= '<br>html: ' . $this->html;

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
            $html = 'no content: ' . $this->path . '/' . $this->fileName;
        }

        // 2. replace images
        preg_match_all('/src="([^"]*)"/i', $html, $img_match);
        $this_img_match = $img_match[1];
        if ($this_img_match) {
            $arr_length = count($this_img_match);
            $already_replaced = [];
            for ($i = 0; $i < $arr_length; $i++) {
                // for each image in document
                $oldimgUrl = $this_img_match[$i];
                $workimgUrl = urldecode($this_img_match[$i]);

                if (str_starts_with($workimgUrl, 'http') == false) {
                    if (in_array($oldimgUrl, $already_replaced)) {
                        // image wurde schon ersetzt
                    } else {
                        // internal image
                        $newimgurl = ($this->path . "/" . $oldimgUrl);
                        $html = str_replace($oldimgUrl, $newimgurl, $html);
                        array_push($already_replaced, $oldimgUrl);
                    }
                }
            }
        }




        // 3.replace hyperlinks
        preg_match_all('/<a[^>]* href="([^"]*)"/im', $html, $link_match);
        $this_match = $link_match[1];
        $imageFormats = ['.png','.svg','.bmp','.jpg','.jpeg','.webp', '.tif', '.tiff', '.gif', '.eps', '.apng', '.avif', '.jpg', '.jpeg', '.jfif', '.pjpeg', '.pjp', '.ico', '.cur'];
               
        if ($this_match) {
            $arr_length = count($this_match);
            for ($i = 0; $i < $arr_length; $i++) {
                // for each link in document
                $oldUrl = $this_match[$i];
                $workUrl = urldecode($this_match[$i]);

                // check if url is an image
                $isImage = false;
                foreach($imageFormats as $format){
                    if (str_ends_with($workUrl, $format)){
                        $isImage = true;
                    }
                }

                if ($isImage == false) {
                    // no image link
                    if (str_starts_with($workUrl, 'http') == false && str_ends_with($workUrl, '.html') && str_starts_with($workUrl, '#') == false) {
                        // is an internal link
                        $spl = explode('/', $workUrl);
                        $itemName = urldecode(end($spl));

                        array_pop($spl);
                        $r = '';
                        foreach ($spl as $itm) {
                            $r .= $itm . '/';
                        }
                        $itemPath = $r;

                        $item = new N2webFolderItem($itemPath, $itemName, 1);

                        $newUrl = '?path=' . urlencode($this->path . '/' . $item->path) . '&name=' . urlencode($item->fileName) . '&id=' . $item->id;

                        $newUrl = str_replace('amp%3B', '', $newUrl);
                        $newUrl = str_replace('%3B', '', $newUrl);
                        $html = str_replace($oldUrl, $newUrl, $html);
                    } else {
                        // is an external links
                        if ($arr_length > 600) {
                            // to many links -> no class replacement (it is not mandatory)
                            return $html;
                        } else {
                            // external link -> replace target
                            $replaceStr = 'href="' . $oldUrl;

                            if (str_starts_with($workUrl, '#') == false) {
                                $newStr = 'target="_blank" href="' . $oldUrl;
                            } else {
                                $newStr = 'href="' . $oldUrl;
                            }

                            if(str_contains($newStr, 'class="')){
                            $newStr = str_replace('class="', 'class="n2web_external_link ', $newStr);
                            }else{
                                $newStr = str_replace('href="', 'class="n2web_external_link" href="', $newStr);
                            }
                            $html = str_replace($replaceStr, $newStr, $html);
                        }
                    }
                } else {
                    // image link
                }
            }
        }

        return $html;
    }

    function getSearchResults($search_for)
    {
        $ret = [];
        $children = $this->children;

        // test child objects
        foreach ($children as $child) {
            $childRet = $child->getSearchResults($search_for);
            // print_r($childRet);
            $ret = array_merge($ret, $childRet);
            // print_r($ret);
        }


        // test this object
        if ($this->objectType == 1) {
            $searchRank = $this->getSearchRank($search_for);
            // print_r($searchRank);

            if (count($searchRank) > 0) {
                $result = $this->getMySeachResult();
                $result["rank"] = $searchRank[1];

                array_push($ret, $result);
            }
        }
        if (count($ret) > 0) {
            return $ret;
        } else {
            return [];
        }
    }

    private function getSearchRank($search_for)
    {
        if ($this->htmlLoaded == false) {
            $this->loadHTML();
        }
        $searchBody = preg_replace('~<[^>]*>~', ' ', $this->html);
        $this->searchBody = $searchBody;

        $corpus = array(
            1 => strtolower($searchBody),
        );
        $match_results = get_similar_documents(strtolower($search_for), $corpus);

        return $match_results;
    }

    private function getMySeachResult()
    {
        $res = array(
            "id" => $this->id,
            "name" => $this->name,
            "title" => $this->title,
            "fileName" => urlencode($this->fileName),
            "path" => urlencode($this->path),
            "pathFormatted" => ($this->getBreadpath()),
            "excerpt" => substr($this->searchBody, 0, 450) . '...',
        );

        return $res;
    }
}




// --------------------------------------------------
//  END CLASS
// --------------------------------------------------






// search functions
function get_corpus_index($corpus = array(), $separator = ' ')
{

    $dictionary = array();
    $doc_count = array();

    foreach ($corpus as $doc_id => $doc) {
        $terms = explode($separator, $doc);
        $doc_count[$doc_id] = count($terms);

        // tf–idf, short for term frequency–inverse document frequency, 
        // according to wikipedia is a numerical statistic that is intended to reflect 
        // how important a word is to a document in a corpus

        foreach ($terms as $term) {
            if (!isset($dictionary[$term])) {
                $dictionary[$term] = array('document_frequency' => 0, 'postings' => array());
            }
            if (!isset($dictionary[$term]['postings'][$doc_id])) {
                $dictionary[$term]['document_frequency']++;
                $dictionary[$term]['postings'][$doc_id] = array('term_frequency' => 0);
            }

            $dictionary[$term]['postings'][$doc_id]['term_frequency']++;
        }

        //from http://phpir.com/simple-search-the-vector-space-model/

    }

    return array('doc_count' => $doc_count, 'dictionary' => $dictionary);
}

function get_similar_documents($query = '', $corpus = array(), $separator = ' ')
{

    $similar_documents = array();

    if ($query != '' && !empty($corpus)) {

        $words = explode($separator, $query);
        $corpus = get_corpus_index($corpus);
        $doc_count = count($corpus['doc_count']);

        foreach ($words as $word) {
            if (isset($corpus['dictionary'][$word])) {
                // search term found
                $entry = $corpus['dictionary'][$word];
                foreach ($entry['postings'] as $doc_id => $posting) {

                    //get term frequency–inverse document frequency
                    $score = $posting['term_frequency'] * log($doc_count + 1 / $entry['document_frequency'] + 1, 2);

                    if (isset($similar_documents[$doc_id])) {
                        $similar_documents[$doc_id] += $score;
                    } else {
                        $similar_documents[$doc_id] = $score;
                    }
                }
            } else {
                // search term NOT found
                // echo '<br>NOT set';
            }
        }

        // length normalise
        foreach ($similar_documents as $doc_id => $score) {
            $similar_documents[$doc_id] = $score / $corpus['doc_count'][$doc_id];
        }

        // sort fro  high to low
        arsort($similar_documents);
    }
    return $similar_documents;
}



function build_sorter($key)
{
    return function ($a, $b) use ($key) {
        return strnatcmp($a[$key], $b[$key]);
    };
}

function searchBreadcrumbs($searchTerm)
{
    $ret = '<div class="n2web_breadcrumb_item"><a href="/?q=' . $searchTerm . '">Search results</a></div>';
    return $ret;
}
