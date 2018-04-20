<!DOCTYPE html>
<html>
    <head>
        <title>PHP Developer Assignment</title>
        <link rel="stylesheet" type="text/css" href="/public/css/nwt.css">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="/public/js/nwt.js"></script>
    </head>
    <body>
        <div class="center">
            <h1>Compare two github repositories</h1>
            <h3>Format: organization/repository</h3>
            <div class="input">
                <input type="text" id="first" />
                <img id="icon" src="/public/compare_icon_dark.png" />
                <input type="text" id="second" />
                &nbsp;
            </div>
            <button id="compare">Compare</button>
            <div id="result" />
        </div>
    </body>
</html>