{* Smarty *}

<!DOCTYPE html>
<html lang="{$language}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{$seo_title}</title>
    <meta name="description" content="{$seo_description}">
    <meta name="robots" content="{$seo_robots}">

    <link rel="stylesheet" href="app/css/n2web.css">
    <link rel="stylesheet" href="app/themes/{$theme}/theme.css">
    <link rel="stylesheet" href="app/themes/{$theme}/theme_mobile.css">

    <script src="app/js/jquery-3.6.0.min.js"></script>
    <script src="app/themes/{$theme}/theme.js"></script>
</head>

<body>
    <div class="n2web_header">
        <div class="n2web_header_inner">
            <div class="n2web_header_main_logo">
                <a href="/">
                    <img src="{$main_logo_light}" alt="">
                    <div class="n2web_header_main_title">
                        <h1>{$page_title}</h1>
                    </div>
                </a>
            </div>
            <div class="n2web_header_mobile_menu_button n2web_menu_item">
                ☰
            </div>
            <div class="n2web_header_menu menu_left">
                {foreach from=$menu_left item=link key=caption}
                    <a href="{$link}">
                        <div class="n2web_menu_item">{$caption}</div>
                    </a>
                {/foreach}

            </div>
            <div class="n2web_header_menu menu_right">
                {foreach from=$menu_right item=link key=caption}
                    <a href="{$link}">
                        <div class="n2web_menu_item">{$caption}</div>
                    </a>
                {/foreach}

            </div>
        </div>
    </div>
    <div class="n2web_structure">
        <div class="n2web_content">
            <div class="n2web_sidebar">
                <div class="n2web_search">
                    <div class="n2web_search_box">
                        <form action="index.php" method="post">
                            <input type="text" name="search" placeholder="Search" value="">
                        </form>
                    </div>
                </div>
                <div class="n2web_documenttree">

                </div>

            </div>

            <div class="n2web_content_inner">
                <div id="top"></div>

                <div class="n2web_article">
                    {$noAccessMessage}
                </div>

            </div>
        </div>
    </div>
    <div class="n2web_footer">
        <div class="footer_menu menu_left">
            {foreach from=$footer_menu_left item=link key=caption}
                <a href="{$link}">
                    <div class="n2web_menu_item">{$caption}</div>
                </a>
            {/foreach}
        </div>
        <div class="footer_menu menu_right">
            {foreach from=$footer_menu_right item=link key=caption}
                <a href="{$link}">
                    <div class="n2web_menu_item">{$caption}</div>
                </a>
            {/foreach}
        </div>
    </div>
</body>

</html>