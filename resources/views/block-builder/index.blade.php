<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="app-base-url" content="{{ rtrim(request()->getSchemeAndHttpHost() . request()->getBaseUrl(), '/') }}">
    <title>3D Grid Tasarım Stüdyosu</title>
    @vite('resources/js/block-builder-page.js')
</head>
<body style="margin:0; background:#06070b; overflow:hidden;">
    <div id="block-builder-page-root"></div>
</body>
</html>
