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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.10/semantic.css" integrity="sha256-8CEI/ltDBxfGb0lev/b4YiRbQSPlllT89ukpFKC3Frg=" crossorigin="anonymous" />
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
                <tbody>
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