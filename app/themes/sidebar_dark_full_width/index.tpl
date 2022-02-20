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
                            <input type="text" name="search" placeholder="Search" value="{$searchTerm}">
                        </form>
                    </div>
                </div>
                <div class="n2web_documenttree">
                    {$document_tree}
                </div>

            </div>

            <div class="n2web_content_inner">
                <div id="top"></div>
                <div class="n2web_breadcrumbs">
                {if $is_search eq true}
                    {$searchBreadcrumbs}
                {else}
                    {$breadcrumbs}
                {/if}
                </div>
                <div class="n2web_searchResults">

                    {if $is_search eq true}

                        <h2>Search results for "<i>{$searchTerm}</i>"</h2>

                        <div class="n2web_searchResults_inner">
                            {foreach from=$searchResults key=res item=i}
                                <a href="{$domain}?path={$i.path}&name={$i.fileName}&id={$i.id}">
                                    <div class="n2web_search_result">
                                        <h3 class="n2web_search_result_name">{$i.title}</h3>
                                        <hr>
                                        <small>{$i.pathFormatted}</small>
                                        <br>
                                        <code>Rank: {assign var="rank" value=$i.rank * 100000}
                                            {$rank|string_format:"%.2f"}</code>
                                        <p class="n2web_search_result_excerpt">{$i.excerpt}</p>
                                    </div>
                                </a>
                            {/foreach}
                        </div>
                    </div>

                {else}

                    <div class="n2web_article">
                        {$selectedItem->html}
                    </div>
                {/if}

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