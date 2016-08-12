
function sendUpdate(updaterID, msg)
{
    updater = document.getElementById(updaterID);
    $(updater).slideDown();
    updater.innerHTML = msg;
    setTimeout(function () {
        $(updater).slideUp();
    }, 4000)
}

function addTeam()
{
    var name = document.getElementById('newTeamName').value;
    sendAjax("updateteams.php?mode=0&teamid=0&name=" + name);

    var table = document.getElementById("teams");
    var url = "functions.php?f=getHighestTeamId";
    $.ajax({
        url: url, type: "GET", success: function (response) {
            console.log(response);
            var row = table.insertRow(table.rows.length - 1);
            row.id = response;

            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);

            cell1.innerHTML = name;
            cell2.innerHTML = "<input type='text' oninput='updateCaptain(" + response + ", this.value)'/>";
            cell3.innerHTML = '<a class="red" href="javascript:removeTeam(' + response + ')">Remove</a>';
        }
    })
}

function removeTeam(teamID)
{
    console.log(teamID);
    sendAjax("updateteams.php?mode=1&teamid=" + teamID);

    //remove table row
    $("#" + teamID).slideUp();
    sendUpdate("teamsUpdater", "Team successfully deleted.");
}

function searchUsers(query)
{
    var table = document.getElementById("results");
    if (query.length > 0) {
        returnAjax("userpanel.php?q=" + query, table);
    }
    else {
        table.innerHTML = "";
    }
}

function changeRole(userid, newRole)
{
    var url = "adminfunctions.php?f=changeRole&userid=" + userid + "&newrole=" + newRole;
    sendAjax(url);
}

function toggleColumn(columnName, userid, newValue)
{
    var url = "adminfunctions.php?f=toggleColumn&columnname=" + columnName + "&userid=" + userid + "&newvalue=" + newValue;
    sendAjax(url);
}

function liftSuspension(userid)
{
    var url = "adminfunctions.php?f=liftSuspension&userid=" + userid;
    sendSyncAjax(url);

    var query = document.getElementById('search').value;
    searchUsers(query); //refreshes, so the suspension lift is reflected
}

function suspendUser(userid)
{
    var tableCell = document.getElementById('sus' + userid);
    var select = tableCell.children[0];
    var days = select.value;
    var url = "adminfunctions.php?f=suspendUser2&userid=" + userid + "&days=" + days;

    sendSyncAjax(url);

    var query = document.getElementById('search').value;
    searchUsers(query);
}

function retrieveCategories(id)
{
    var url = "functions.php?f=retrieveCategories&id=" + id;
    var table = document.getElementById("categories");
    returnAjax(url, table);
    document.getElementById("categoryID").value = id;

    var a = document.getElementById("upone");
    if (id != 1)
    {
        getCategoryNameFromId(id.toString().substring(0, id.toString().length - 1), a);
    }
    else
    {
        a.innerHTML = "";
    }
}

function getCategoryNameFromId(id, element)
{
    var url = "functions.php?f=getCategoryNameFromId2&id=" + id;
    returnAjax(url, element);
}

function upCategory()
{
    var id = document.getElementById("categoryID").value;
    id = Number(id.toString().substring(0, id.toString().length - 1));
    retrieveCategories(id);
}

function newCategory()
{
    var newRow = document.getElementById("new");
    newRow.innerHTML =
        `<td>New Category</td>
        <td></td>
        <td>
            <input type='text' id='newName' style='background-color:#222222;' placeholder='Name'>
            <br>
            <input type='text' id='newDesc' style='width:100%;background-color:#222222;' placeholder='Description'>
            <input type='submit' onclick='addCategory()'>
        </td>`;
}

function changeCategory(attr, id, input)
{
    var url;
    var typingTimer;
    var doneTypingInterval = 500;

    if (attr == "name") {
        url = "adminfunctions.php?f=changeCategoryName&id=" + id + "&newname=" + input.value;
        $("#name" + id).html(input.value);
    }
    else { url = "adminfunctions.php?f=changeCategoryDesc&id=" + id + "&newdesc=" + input.value; }

    $(input).on('keyup', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    });

    $(input).on('keydown', function () {
        clearTimeout(typingTimer);
    });

    function doneTyping() {
        $.ajax({
            url: url, type: "post", success: function (result) {
                if (attr == "name") sendUpdate("updater", "Category name successfully changed to " + input.value + ".");
                if (attr == "desc") sendUpdate("updater", "Category description has been successfully updated.");
            }
        })
    }
}

function addCategory()
{
    var updater = document.getElementById("updater");
    var name = document.getElementById("newName").value;
    var desc = document.getElementById("newDesc").value;
    updater.style.display = "block";
    updater.innerHTML = "Creating category..."

    var parentCategory = document.getElementById("categoryID").value;
    $.ajax({
        url: "addcategory.php?f=addCategory&id=" + parentCategory + "&name=" + name + "&desc=" + desc, type: "post", success: function (result) {
            $(updater).fadeOut();
            retrieveCategories(parentCategory);
        }
    })
}

function removeCategory(id)
{
    if (confirm('Are you sure you want to remove this category and ALL of its contents, including subcategories and posts?'))
    {
        var updater = document.getElementById("updater");
        updater.style.display = "block";
        updater.innerHTML = "Deleting category..."

        $.ajax({
            url: "removecategory.php?c=1&id=" + id, type: "post", success: function (result) {
                $(updater).fadeOut();
                retrieveCategories(document.getElementById("categoryID").value);
            }
        })
    }
}

function deleteReport(id)
{
    var updater = document.getElementById("updater");
    updater.style.display = "block";
    updater.innerHTML = "Dismissing report...";
    $("#" + id).hide();
    $.ajax({
        url: "deletereport.php?id=" + id, type: "post", success: function () {
            $(updater).fadeOut();
            $("#" + id).hide();
        }
    })
}

function act(reportid, time)
{
    var updater = document.getElementById("updater");
    var url = "act.php?reportid=" + reportid + "&time=" + time;
    updater.style.display = "block";
    updater.innerHTML = "Deleting post and suspending user for " + time + " days...";
    $("#" + reportid).hide();
    $.ajax({
        url: url, type: "post", success: function () {
            deleteReport(reportid);
            $(updater).fadeOut(2000);
            $("#" + reportid).hide();
        }
    })
}

function toggleFormatting()
{
    if ($("#formatting").is(":visible"))
    {
        $("#formatting").slideUp();
        //$("#formatting").hide();
    }
    else
    {
        //$("#formatting").show();
        $("#formatting").slideDown();
    }
}

function updateRoster(position, newUsername)
{
    var url = "functions.php?f=userExistsByUsername&username=" + newUsername;
    $.ajax({
        url: url, type: "GET", success: function (result) {
            if (result == "false")
            {
                document.getElementById(position).style.backgroundColor = "#ff6666";
                document.getElementById(position).style.color = "white";
            }
            else
            {
                document.getElementById(position).style.backgroundColor = "#39e600";
                document.getElementById(position).style.color = "black";
                var url = "updateroster.php?pos=" + position + "&player=" + newUsername;
                $.ajax({
                    url: url, type: "GET", success: function (response) {
                        sendUpdate("teamUpdater", response);
                        document.getElementById(position).style.backgroundColor = "inherit";
                        document.getElementById(position).style.color = "white";
                    }
                })
            }
        }
    })
}

function toggleMove(id)
{
    var span = $("#" + id);
    if ($(span).is(":visible"))
    {
        $(span).slideUp();
    }
    else
    {
        $(span).slideDown();
    }
}

function updateCaptain(teamID, newUsername) {
    /*newCaptain = document.getElementById('captain' + teamID).value;
    var url = "updateteams.php?mode=2&teamid=" + teamID + "&captain=" + newCaptain;
    sendAjax(url);
    sendUpdate('teamsUpdater', 'Captain has been successfully changed to ' + newCaptain + '.');*/

    var url = "functions.php?f=userExistsByUsername&username=" + newUsername;
    $.ajax({
        url: url, type: "GET", success: function (result) {
            if (result == "false") {
                document.getElementById(teamID).style.backgroundColor = "#ff6666";
                document.getElementById(teamID).style.color = "white";
            }
            else {
                document.getElementById(teamID).style.backgroundColor = "#39e600";
                document.getElementById(teamID).style.color = "black";
                var url = "updateteams.php?mode=2&teamid=" + teamID + "&captain=" + newUsername;
                console.log(url);
                $.ajax({
                    url: url, type: "POST", success: function (response) {
                        sendUpdate("teamsUpdater", "Captain successfully updated.");
                        document.getElementById(teamID).style.backgroundColor = "inherit";
                        document.getElementById(teamID).style.color = "white";
                    }
                })
            }
        }
    })
}