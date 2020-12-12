<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Test project</title>

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/style.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ mix('/dist/css/app.css') }}">
</head>
<body>

    <div id="app">
        <router-view></router-view>
        <notifications group="common" />
    </div>

    @routes

    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/metisMenu.min.js"></script>
    <script src="/assets/js/jquery.slimscroll.js"></script>
    <script src="/assets/js/waves.min.js"></script>

    <script src="/assets/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>

    <script src="{{ mix('/dist/js/app.js') }}"></script>

</body>
</html>