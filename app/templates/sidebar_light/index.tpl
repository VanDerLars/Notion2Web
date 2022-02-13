{* Smarty *}

<!DOCTYPE html>
<html lang="{$language}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{$page_title}</title>
    <link rel="stylesheet" href="app/css/normalize.css">
    <link rel="stylesheet" href="app/css/skeleton.css">
    <link rel="stylesheet" href="app/css/n2web.css">
    <link rel="stylesheet" href="app/templates/{$template}/theme.css">
    
    <script src="app/js/featherlight.js"></script>
    <script src="app/templates/{$template}/theme.js"></script>
</head>

<body>

<div class="n2web_header">
  <h1>Notion2Web</h1>
</div>

<div class="n2web_sidebar">
  {* {$document_tree} *}
  {$document_tree}

</div>
<div class="n2web_content">
</div>
<div class="n2web_footer">
</div>

</body>

</html>