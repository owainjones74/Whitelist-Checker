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
                        <th>Username</th>
                        <th>SteamID 64</th>
                        <th>Links</th>
                    </tr>
                </thead>
                <tbody id="table">
                </tbody>
            </table>
            <div class="ui segment inverted" style="background-color: #2b2b2b; height: 600px;" id="loading">
                <div class="ui active text loader">Loading Data</div>
            </div>
            <div id="error">
            </div>
            <?php } else { ?>
                <div class="ui inverted segment" style="text-align: center;">
                    Please search for a job in the above text box! Alternatively, the job you entered may not be a valid whitelist!
                </div>
            <?php } ?>

            <script>
                $(document).ready(function() {
                    $.get("https://0wain.xyz/whitelistchecker/api/job.php?job=<?php echo urlencode($searchTerms) ?>", function(data) {
                        let result = Object.values(data);
                        let table = document.getElementById("table");
                        let loading = document.getElementById("loading");
                        loading.remove();
                        $('table').visibility({
                            once: false,
                            observeChanges: true,
                            onBottomVisible: async function() {
                                async function getName(id) {
                                    return $.ajax({
                                        url: `https://0wain.xyz/whitelistchecker/api/name.php?id=${id}`,
                                        type: 'GET',
                                    });
                                };

                                if(result[0] === "No job found with this name") {
                                    let error = document.getElementById("error");
                                    error.innerHTML = `<div class="ui negative message">
                                        <div class="header">
                                            There is no whitelist with that name!
                                        </div>
                                        <p>Please try searching for a job with a different name.</p>
                                    </div>`;
                                };

                                for(i = 0; i < 20; i++) {
                                    if(!result[0]) break;
                                    if(result[0] === "No job found with this name") break;
                                    let username = await getName(result[0]);
                                    if(!result[0]) break;
                                    let row = table.insertRow(-1);
                                    let nameCell = row.insertCell(0);
                                    let steamidCell = row.insertCell(1);
                                    let linkCell = row.insertCell(2);
                                    nameCell.innerHTML = username
                                    steamidCell.innerHTML = result[0];
                                    linkCell.innerHTML = `<td style="text-align: center;">
                                        <a href="https://thexyznetwork.xyz/profile/${result[0]}" class="ui inverted blue button">xSuite</a>
                                        <a href="https://thexyznetwork.xyz/lookup/${result[0]}" class="ui inverted red  button">Lookup</a>
                                        <a href="https://steamcommunity.com/profiles/${result[0]}" class="ui inverted grey button">Steam</a>
                                    </td>`;
                                    result.shift();
                                };
                            }
                        });
                    });
                });
            </script>

            <div class="ui inverted segment" style="text-align: center;">
                Made with ❤️ by <a href="https://0wain.xyz/">Owain</a> & <a href="https://tomsci.team/">Tomsci</a>
            </div>
        </div>
    </body>
</html>