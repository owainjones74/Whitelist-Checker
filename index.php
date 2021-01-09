<?php
require_once "functions/main.php";

// Filter search
$searchTerms = isset($_GET['search']) ? $_GET['search'] : NULL;
if ($searchTerms == "") {
    $searchTerms = NULL;
}
if (isset($searchTerms)) {
    $users = GetWhitelists($searchTerms);
}

// Get active page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
if (!is_numeric($page)) {
    $page = 1;
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

            <?php if(isset($searchTerms) and (isset($users))) { ?>
            <table class="ui celled inverted table">
                <thead>
                    <tr><th>Name (SteamID 64)</th>
                        <th>Links</th>
                    </tr>
                </thead>
                <tbody id="table">
                    <?php
                        $entries = 20;
                        foreach($users as $key => $user) {
                            if ((($key+1) > ($page*$entries)) or (($key+1) <= (($page*$entries) - $entries))) continue;
                            $user = str_replace(" ", "", $user)
                    ?>
                    <tr>
                        <td><?= htmlspecialchars(GetName($user)) ?> (<?= $user ?>)</td>
                        <td style="text-align: center;">
                            <a href="https://thexyznetwork.xyz/profile/<?= $user ?>" class="ui inverted blue button">xSuite</a>
                            <a href="https://thexyznetwork.xyz/lookup/<?= $user ?>" class="ui inverted red  button">Lookup</a>
                            <a href="https://steamcommunity.com/profiles/<?= $user ?>" class="ui inverted grey button">Steam</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <div class="ui basic right aligned segment">
                <?php $lastPage = ceil(count($users)/$entries) ?>
                <?php if ($page > 1) { ?>
                    <a href="<?= BuildGetQuery($searchTerms, $page - 1) ?>">
                        <button class="ui inverted button" type="submit"><</button>
                    </a>
                <?php } ?>
                <button class="ui inverted button"><?= $page ?>/<?= $lastPage ?></button>
                <?php if (!($page == $lastPage)) { ?>
                    <a href="<?= BuildGetQuery($searchTerms, $page + 1) ?>">
                        <button class="ui inverted button" type="submit">></button>
                    </a>
                <?php } ?>
            </div>

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