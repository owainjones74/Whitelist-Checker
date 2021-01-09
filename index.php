<?php
// Filter search
$searchTerms = isset($_GET['search']) ? $_GET['search'] : NULL;
if ($searchTerms == "") {
    $searchTerms = NULL;
}

?>

<html lang="en">
    <head>
        <title>The XYZ Network Whitelist Job Lookup</title>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/fomantic-ui@2.8.7/dist/semantic.min.css">
        <script src="https://cdn.jsdelivr.net/npm/fomantic-ui@2.8.7/dist/semantic.min.js"></script>
        <link rel="stylesheet" href="css/styles.css?v=1.0">
    </head>

    <body>
        <div class="ui container" style="padding-bottom: 15px;">
            <div class="ui inverted segment" style="text-align: center;">
                Search for a job and see everyone who's whitelisted to it!
            </div>
            <form>
            <div class="ui inverted segment" style="text-align: center;">
                <div class="ui fluid inverted icon input">
                    <input id="search" name="search" type="text" placeholder="Police Officer" <?php if(isset($searchTerms)) { ?> value="<?= $searchTerms ?>" <?php } ?>>
                    <i class="search icon"></i>
                </div>
            </div>
            </form>

            <?php if (isset($searchTerms)) { ?>
            <table class="ui celled inverted table">
                <thead>
                    <tr>
                        <th>Name (SteamID 64)</th>
                        <th>Links</th>
                    </tr>
                </thead>
                <tbody id="table">
                </tbody>
            </table>
            <?php } else { ?>
                <div class="ui inverted segment" style="text-align: center;">
                    Please search for a job in the above text box! Alternatively, the job you entered may not be a valid whitelist!
                </div>
            <?php } ?>

            <div class="ui inverted segment" style="text-align: center;">
                Made with ❤️ by <a href="https://0wain.xyz/">Owain</a>
            </div>
        </div>
    </body>
</html>