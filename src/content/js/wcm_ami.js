/*******************************************************************************
© 2014 Microchip Technology Inc. and its subsidiaries.  You may use this
software and any derivatives exclusively with Microchip products.

THIS SOFTWARE IS SUPPLIED BY MICROCHIP "AS IS".  NO WARRANTIES, WHETHER EXPRESS,
IMPLIED OR STATUTORY, APPLY TO THIS SOFTWARE, INCLUDING ANY IMPLIED WARRANTIES
OF NON-INFRINGEMENT, MERCHANTABILITY, AND FITNESS FOR A PARTICULAR PURPOSE, OR
ITS INTERACTION WITH MICROCHIP PRODUCTS, COMBINATION WITH ANY OTHER PRODUCTS, OR
USE IN ANY APPLICATION.

IN NO EVENT WILL MICROCHIP BE LIABLE FOR ANY INDIRECT, SPECIAL, PUNITIVE,
INCIDENTAL OR CONSEQUENTIAL LOSS, DAMAGE, COST OR EXPENSE OF ANY KIND WHATSOEVER
RELATED TO THE SOFTWARE, HOWEVER CAUSED, EVEN IF MICROCHIP HAS BEEN ADVISED OF
THE POSSIBILITY OR THE DAMAGES ARE FORESEEABLE.  TO THE FULLEST EXTENT ALLOWED
BY LAW, MICROCHIP'S TOTAL LIABILITY ON ALL CLAIMS IN ANY WAY RELATED TO THIS
SOFTWARE WILL NOT EXCEED THE AMOUNT OF FEES, IF ANY, THAT YOU HAVE PAID DIRECTLY
TO MICROCHIP FOR THIS SOFTWARE.

MICROCHIP PROVIDES THIS SOFTWARE CONDITIONALLY UPON YOUR ACCEPTANCE OF THESE
TERMS.
********************************************************************************
Author                Date          Comment
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
Stephen Porter        2014-10-14    Initial Release
*******************************************************************************/

// Constance value for the timeout
const UPDATE_RATE = 50;

// function called on press to remove cookie
function deleteCookie() {
    // Remove the value of the cookie and expire the cookie with a past date
    document.cookie = "wcm_uuid_cookie=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
    // Redirect the page to the home page
    window.location = "/index.php";
}

function getCookie(cookieName) {
    // Add the equal sign to the compare string
    var cookieTestString = cookieName + "=";
    // Create and array of cookies
    var cookieArray = document.cookie.split(";");
    // Loop through the array
    for(var i=0; i<cookieArray.length; i++) {
        // Load the the cookie key pair value
        var testCookie = cookieArray[i];
        // Remove any white spaces and make sure a value is seen
        while (testCookie.charAt(0)==" ") {
            testCookie = testCookie.substring(1);
        }
        // Test that there is a value in the test string
        if (testCookie.indexOf(cookieTestString) != -1) {
            // Return the value of the cookie if found
            return testCookie.substring(cookieTestString.length,testCookie.length);
        }
    }
    // If no cookie found for the key name return an empty string
    return "";
}

// This function set the button as colored when called
function setButtonColor(buttonId, buttonValue) {
    // Load which button by DOM ID
    var whichButton = document.getElementById(buttonId);
    // If false, then set to the following values
    if (buttonValue === false) {
        whichButton.style.backgroundColor = "transparent";
        whichButton.style.border = "1px solid #C8C8C8";
    // If true, then set to the following values
    } else if (buttonValue === true) {
        whichButton.style.backgroundColor = "#ff0000";
        whichButton.style.border = "none";
    }
}

// This function will change the led toggle switch to on or off
// This function can be called from reading the database or a button being pressed
function setLedStatus(ledId, ledValue) {
    // If in the false value set the following
    if (ledValue === false) {
        document.getElementById(ledId + "_On").className = "btn btn-default";
        document.getElementById(ledId + "_Off").className = "btn btn-info active";
    // if in the true value set the following
    } else if (ledValue === true) {
        document.getElementById(ledId + "_On").className = "btn btn-success active";
        document.getElementById(ledId + "_Off").className = "btn btn-default";
    }
    // Global variables are needed as changes in DOM can not be read by javascript
    // Set the global values here for the change in button status
    switch (ledId) {
        case "led1":
            pageLed1Status = ledValue;
            break;
        case "led2":
            pageLed2Status = ledValue;
            break;
        case "led3":
            pageLed3Status = ledValue;
            break;
        case "led4":
            pageLed4Status = ledValue;
            break;
    }
}

// This function will set the three values in the DOM that will change the value of the bar and the text value
function setPotentiometerValue(potentiometerValue) {
    var percentValue = Math.round((potentiometerValue * 100) / 1024);
    document.getElementById("potentiometerBarValue").setAttribute("aria-valuenow", percentValue);
    document.getElementById("potentiometerBarValue").style.width = percentValue+"%";
    document.getElementById("potentiometerTextValue").innerHTML = potentiometerValue;
}

// This function is called on a timer and updates the status of the web page if there are changes in the database
function updateAMIStatus() {
    // First check to make sure the cookie has not expired
    var uuid = getCookie("wcm_uuid_cookie");
    if (uuid === "") {
        // If the cookie has expired, reload the index page to force the entry of a new cookie value
        window.location = "/index.php";
        return;
    }
    // Set a variable for requesting data from the server
    var getDatabaseValues = new XMLHttpRequest();
    // Setup the location for th data to be called and pass in the uuid based on the cookie value
    getDatabaseValues.open("GET", "json_wcm_get_status.php?uuid=" + uuid, true);
    // Kick off the GET request
    getDatabaseValues.send();
    // Wait for request to hit level 4 (Ready for processing)
    getDatabaseValues.onreadystatechange = function() {
        if (getDatabaseValues.readyState === 4) {
            // Parse the json data into an array
            var currentValues = JSON.parse(getDatabaseValues.response);
            // Check to see if the return status was an "OK" or 200
            if ((currentValues.mchp.device.status === 200) && (buttonPressed === false)) {
                // If it is "OK" and there has not been a button pressed on the webpage,
                // then set the buttons, LEDs, and Pot value based on the data
                setButtonColor("button1", currentValues.mchp.device.data.button1);
                setButtonColor("button2", currentValues.mchp.device.data.button2);
                setButtonColor("button3", currentValues.mchp.device.data.button3);
                setButtonColor("button4", currentValues.mchp.device.data.button4);
                setLedStatus("led1", currentValues.mchp.device.data.led1);
                setLedStatus("led2", currentValues.mchp.device.data.led2);
                setLedStatus("led3", currentValues.mchp.device.data.led3);
                setLedStatus("led4", currentValues.mchp.device.data.led4);
                setPotentiometerValue(currentValues.mchp.device.data.potentiometer);
            }
        }
    };
}

// This function will be called when a LED button is pressed
function onLedPress(ledId, ledValue) {
    // Clear the timer for the page refresh
    clearInterval(pageTimer);
    // Set the global value for button press status
    buttonPressed = true;
    // Check to make sure the cookie has not expired
    var uuid = getCookie("wcm_uuid_cookie");
    if (uuid === "") {
        // If the cookie has expired, reload the index page to force the entry of a new cookie value
        window.location = "/index.php";
        return;
    }
    // Change the display of the button value and set global value for LEDs status
    setLedStatus(ledId, ledValue);
    // Build the json data object that will be set to the server
    var jsonDataArray = JSON.stringify ( {"mchp":
                                            {"device":
                                                {"device-type":2,
                                                 "uuid":uuid,
                                                 "status":200,
                                                 "message":"Sending Data",
                                                 "data":
                                                    {"button1":null,
                                                     "button2":null,
                                                     "button3":null,
                                                     "button4":null,
                                                     "led1":pageLed1Status,
                                                     "led2":pageLed2Status,
                                                     "led3":pageLed3Status,
                                                     "led4":pageLed4Status,
                                                     "potentiometer":null
                                                    }
                                                }
                                            }
                                        });
    // Set a variable for sending data from the server
    var sendDatabaseValues = new XMLHttpRequest();
    // Setup the location for th data to be sent too
    sendDatabaseValues.open("POST", "json_wcm_post_status.php", true);
    // Let the server know the data will be json format
    sendDatabaseValues.setRequestHeader("Content-type","application/json");
    // Send the data to the server
    sendDatabaseValues.send(jsonDataArray);
    // Wait for request to hit level 4 (Ready for processing)
    sendDatabaseValues.onreadystatechange = function() {
        if (sendDatabaseValues.readyState === 4) {
            // Set the global value for button press status
            buttonPressed = false;
            // Parse the json data into an array
            var responseData = JSON.parse(sendDatabaseValues.response);
            // Check to see if the return status was an "OK" or 200
            if (responseData.mchp.device.status === 200) {
                // If it is "OK" then start the timer back up
                // updateAMIStatus();
                pageTimer = setInterval(updateAMIStatus, UPDATE_RATE);
            } else {
                // If not, load a dialog box
                alert("Database write error");
            }
        }
    };
}

// This function is called when the page loads
window.onload = function () {
    // First find out what page you are on
    var whichPage = location.pathname;
    // Select the function for that page
    switch(whichPage) {
        // if in the root directory or the index.php page
        case "/":
        case "/index.php":
            // Set the nav bar to show what page you are on
            $('.navbar-nav').find('li:eq(0)').addClass('active');
            // Check to make sure the cookie is set
            var cookieUUID = getCookie("wcm_uuid_cookie");
            if (cookieUUID != "") {
                // Set the global value for button press status
                buttonPressed = false;
                // If the cookie is set, update the page data and start timer
                updateAMIStatus();
                pageTimer = setInterval(updateAMIStatus, UPDATE_RATE);
            }
            break;
        case "/notes.php":
            // Set the nav bar to show what page you are on
            $('.navbar-nav').find('li:eq(1)').addClass('active');
            break;
        case "/setup.php":
            // Set the nav bar to show what page you are on
            $('.navbar-nav').find('li:eq(2)').addClass('active');
            break;
    }
    // Set the value of the cookie to to the text in the nav bar for the user to see
    var uuid = getCookie("wcm_uuid_cookie");
    if (uuid != "") {
        $('.navbar-text').text('WCM UUID: ' + uuid);
    }
};