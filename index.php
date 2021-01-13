<?php
$domain = "https://" . $_SERVER['HTTP_HOST'] . "/whitelistchecker";

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
                    <div class="ui search">
                        <div class="ui fluid inverted icon input">
                            <input class="prompt" id="search" name="search" type="text" placeholder="Police Officer" <?php if(isset($searchTerms)) { ?> value="<?= $searchTerms ?>" <?php } ?>>
                            <i class="search icon"></i>
                        </div>
                        <div class="results"></div>
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
                    async function showActivity(id) {
                        return $.ajax({
                            url: `<?= $domain ?>/api/activity.php?id=${id}&job=<?= $searchTerms ?>`,
                            type: "GET"
                        });
                    };
                                                        
                    let whitelists = [
                        {category: "Police Department", title: "Police Commissioner"},
                        {category: "Police Department", title: "Police Deputy Commissioner"},
                        {category: "Police Department", title: "Police Assistant Commissioner"},
                        {category: "Police Department", title: "Police District Chief"},
                        {category: "Police Department", title: "Police Deputy District Chief"},
                        {category: "Police Department", title: "Police Major"},
                        {category: "Police Department", title: "Police Superintendent"},
                        {category: "Police Department", title: "Police Captain"},
                        {category: "Police Department", title: "Police Lieutenant"},
                        {category: "Police Department", title: "Police Sergeant Major"},
                        {category: "Police Department", title: "Police Master Sergeant"},
                        {category: "Police Department", title: "Police Sergeant"},
                        {category: "Police Department", title: "Police Corporal"},
                        {category: "Police Department", title: "Police Lance Corporal"},
                        {category: "Police Department", title: "Senior Police Officer"},
                        {category: "Police Department", title: "Police Officer"},
                        {category: "Special Weapons And Tactics", title: "SWAT Colonel"},
                        {category: "Special Weapons And Tactics", title: "SWAT Lieutenant Colonel"},
                        {category: "Special Weapons And Tactics", title: "SWAT Major"},
                        {category: "Special Weapons And Tactics", title: "SWAT Captain"},
                        {category: "Special Weapons And Tactics", title: "SWAT Lieutenant"},
                        {category: "Special Weapons And Tactics", title: "SWAT CTU"},
                        {category: "Special Weapons And Tactics", title: "SWAT Sniper"},
                        {category: "Special Weapons And Tactics", title: "SWAT Marksman"},
                        {category: "Special Weapons And Tactics", title: "SWAT Breacher"},
                        {category: "Special Weapons And Tactics", title: "SWAT Medic"},
                        {category: "Special Weapons And Tactics", title: "SWAT Rifleman"},
                        {category: "Sherriff's Department", title: "Sheriff"},
                        {category: "Sherriff's Department", title: "Undersheriff"},
                        {category: "Sherriff's Department", title: "Sheriff's Department Chief Deputy"},
                        {category: "Sherriff's Department", title: "Sheriff's Department Major"},
                        {category: "Sherriff's Department", title: "Sheriff's Department Captain"},
                        {category: "Sherriff's Department", title: "Sheriff's Department Lieutenant"},
                        {category: "Sherriff's Department", title: "Sheriff's Department Sergeant"},
                        {category: "Sherriff's Department", title: "Sheriff's Department Corporal"},
                        {category: "Sherriff's Department", title: "Sheriff's Department Master Deputy"},
                        {category: "Sherriff's Department", title: "Sheriff's Department Deputy First Class"},
                        {category: "Sherriff's Department", title: "Sheriff's Department Deputy"},
                        {category: "Fire & Rescue", title: "Fire Chief"},
                        {category: "Fire & Rescue", title: "Assistant Chief"},
                        {category: "Fire & Rescue", title: "Deputy Chief"},
                        {category: "Fire & Rescue", title: "Battalion Chief"},
                        {category: "Fire & Rescue", title: "Captain"},
                        {category: "Fire & Rescue", title: "Lieutenant"},
                        {category: "Fire & Rescue", title: "Supervisor"},
                        {category: "Fire & Rescue", title: "Senior Engineer"},
                        {category: "Fire & Rescue", title: "Engineer"},
                        {category: "Fire & Rescue", title: "Senior Firefighter"},
                        {category: "Fire & Rescue", title: "Firefighter"},
                        {category: "Fire & Rescue", title: "Junior Firefighter"},
                        {category: "Fire & Rescue", title: "Candidate Firefighter"},
                        {category: "United States Marshals", title: "Marshal Director"},
                        {category: "United States Marshals", title: "Marshal Deputy Director"},
                        {category: "United States Marshals", title: "Marshal Chief of Staff"},
                        {category: "United States Marshals", title: "Marshal Major"},
                        {category: "United States Marshals", title: "Marshal Captain"},
                        {category: "United States Marshals", title: "Marshal Lieutenant"},
                        {category: "United States Marshals", title: "Marshal Inspector"},
                        {category: "United States Marshals", title: "Marshal Deputy Inspector"},
                        {category: "United States Marshals", title: "Marshal Supervisor"},
                        {category: "United States Marshals", title: "Marshal Senior Deputy"},
                        {category: "United States Marshals", title: "Marshal Deputy"},
                        {category: "Federal Bureau Of Investigation", title: "FBI Director"},
                        {category: "Federal Bureau Of Investigation", title: "FBI Deputy Director"},
                        {category: "Federal Bureau Of Investigation", title: "FBI Chief of Staff"},
                        {category: "Federal Bureau Of Investigation", title: "FBI Associate Deputy Director"},
                        {category: "Federal Bureau Of Investigation", title: "FBI Executive Assistant Director"},
                        {category: "Federal Bureau Of Investigation", title: "FBI Deputy Assistant Director"},
                        {category: "Federal Bureau Of Investigation", title: "FBI Senior Special Agent In-Charge"},
                        {category: "Federal Bureau Of Investigation", title: "FBI Special Agent In-Charge"},
                        {category: "Federal Bureau Of Investigation", title: "FBI Assistant Special Agent In-Charge"},
                        {category: "Federal Bureau Of Investigation", title: "FBI Senior Special Agent"},
                        {category: "Federal Bureau Of Investigation", title: "FBI Special Agent"},
                        {category: "Federal Bureau Of Investigation", title: "FBI Probationary Agent"},
                        {category: "The Mafia", title: "The Mafia Godfather"},
                        {category: "The Mafia", title: "The Mafia Consigliere"},
                        {category: "The Mafia", title: "The Mafia Boss"},
                        {category: "The Mafia", title: "The Mafia Underboss"},
                        {category: "The Mafia", title: "The Mafia Lieutenant"},
                        {category: "The Mafia", title: "The Mafia Caporegime"},
                        {category: "The Mafia", title: "The Mafia Head Sicario"},
                        {category: "The Mafia", title: "The Mafia Senior Sicario"},
                        {category: "The Mafia", title: "The Mafia Sicario"},
                        {category: "The Mafia", title: "The Mafia Junior Sicario"},
                        {category: "The Mafia", title: "The Mafia Head-Associate"},
                        {category: "The Mafia", title: "The Mafia Senior-Associate"},
                        {category: "The Mafia", title: "The Mafia Associate"},
                        {category: "The Mafia", title: "The Mafia Junior Associate"},
                        {category: "Terrorist", title: "Terrorist Leader"},
                        {category: "Terrorist", title: "Terrorist Co Leader"},
                        {category: "Terrorist", title: "Terrorist Chief"},
                        {category: "Terrorist", title: "Terrorist Senior Commander"},
                        {category: "Terrorist", title: "Terrorist Governor"},
                        {category: "Terrorist", title: "Terrorist Executioner"},
                        {category: "Terrorist", title: "Terrorist Insurgent"},
                        {category: "Terrorist", title: "Terrorist Fanatic"},
                        {category: "Terrorist", title: "Terrorist Agitator"},
                        {category: "Terrorist", title: "Terrorsit Recruit"}
                    ];

                    $(".ui.search").search({
                        type: "category",
                        source: whitelists
                    });

                    $.get("<?= $domain ?>/api/job.php?job=<?php echo urlencode($searchTerms) ?>", function(data) {
                        let result = Object.values(data);
                        let table = document.getElementById("table");
                        let loading = document.getElementById("loading");
                        loading.remove();

                        $("table").visibility({
                            once: false,
                            observeChanges: true,
                            onBottomVisible: async function() {
                                async function getName(id) {
                                    return $.ajax({
                                        url: `<?= $domain ?>/api/name.php?id=${id}`,
                                        type: "GET",
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
                                        <button id="activity_${result[0]}" class="ui inverted pink button">Activity</button>
                                    </td>`;

                                    $("#activity_" + result[0]).click(async function() {
                                        $("body").append(`<div id="modal_${steamidCell.innerHTML}" class="ui modal">
                                            <i class="close icon"></i>
                                            <div class="header">User Activity</div>
                                            <div id="modal_${steamidCell.innerHTML}_content" class="scrolling content">
                                                <p >
                                                    <div class="ui active inverted dimmer">
                                                        <div class="ui large text loader">Loading Activity</div>
                                                    </div>
                                                </p>
                                            </div>
                                        </div>`);

                                        $("#modal_" + steamidCell.innerHTML).modal("show");

                                        let userActivity = await showActivity(steamidCell.innerHTML);

                                        if(userActivity.error) {
                                            $(`#modal_${steamidCell.innerHTML}_content`).empty();
                                            $(`#modal_${steamidCell.innerHTML}_content`).html(`<div class="ui negative message">
                                                <div class="header">
                                                    There seems to be an issue!
                                                </div>
                                                <p>${userActivity.error}</p>
                                            </div>`);
                                        } else {
                                            $(`#modal_${steamidCell.innerHTML}_content`).empty();
                                            $(`#modal_${steamidCell.innerHTML}_content`).html(`<table class="ui very basic celled padded table">
                                                <thead>
                                                    <tr>
                                                        <th>Job</th>
                                                        <th>Joined (d/m/y)</th>
                                                        <th>Left (d/m/y)</th>
                                                        <th>Time Played (h/m/s)</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="#modal_${steamidCell.innerHTML}_table">
                                                </tbody>
                                            </table>`);
                                                
                                            userActivity.forEach(function(data) {
                                                let tbl = document.getElementById(`#modal_${steamidCell.innerHTML}_table`);
                                                let row = tbl.insertRow(-1);
                                                let totalPlayed = row.insertCell(0);
                                                let left = row.insertCell(0);
                                                let joined = row.insertCell(0);
                                                let jobName = row.insertCell(0);

                                                jobName.innerHTML = data.job;
                                                joined.innerHTML = new Date(data.join*1000).toLocaleString();
                                                left.innerHTML = new Date(data.leave*1000).toLocaleString();

                                                let total = new Date(0);
                                                total.setSeconds(data.leave-data.join);
                                                totalPlayed.innerHTML = total.toISOString().substr(11, 8);
                                            });
                                        };
                                    });
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