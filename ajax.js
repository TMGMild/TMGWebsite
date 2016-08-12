

function returnSyncAjax(fileName) { //Synchronous
    $.ajax({
        url: fileName, async: false, success: function (result) {
            return result;
        }
    });
}

function returnAjax(fileName, element) { //ELEMENT is the element whose inner HTML will be set to the response.
    $.ajax({
        url: fileName, success: function (result) {
            $(element).html(result);
        }
    });
}

function sendAjax(fileName, element) {
    $.ajax({
        url: fileName, type: "POST", success: function (result) {
            $(element).html(result);
        }
    });
}

function sendSyncAjax(fileName) {
    $.ajax({
        url: fileName, async: false, type: "POST", success: function (result) {
            return result;
        }
    });
}

function callFunction(name) {
    return returnAjax("functions.php?f=" + name);
}


