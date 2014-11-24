<?php
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

    // Set the header info for the page to not cache
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");   // Date in the past

    // This function will scrub the input for only 6 char hex values
    function testUUID($uuidInput)
    {
        // Test the input and see if it matches
        if (!preg_match("/^([0-9a-fA-F]{6})$/", $uuidInput))
        {
            // Return false if it does not
            return false;
        }
        // Return true if the uuid is valid
        return true;
    }

    // Include the connect defines
    include_once("content/php/connect_defines.php");

    // Test to see if the database is setup, if not goto the setup tab
    $link = mysqli_connect(DB_HOST, DB_READ_USER, DB_READ_USER_PW, DB_NAME);
    if (!$link)
    {
        // Close the link to the database
        mysqli_close($link);
        // Go to the setup page to setup the databases
        header("Location: /setup.php");
    }
    // If the database is setup check to see if the cookie value is in the database
    elseif (isset($_COOKIE["wcm_uuid_cookie"]))
    {
        if (testUUID($_COOKIE["wcm_uuid_cookie"]))
        {
            // Link to the database
            $link = mysqli_connect(DB_HOST, DB_RW_USER, DB_RW_USER_PW, DB_NAME);
            // The SQL string to select records based on cookie
            $sqlString = "SELECT * FROM wcm WHERE uuid=\"" . $_COOKIE["wcm_uuid_cookie"] . "\"";
            // Check SQL query results, store in $results
            if ($results = mysqli_query($link, $sqlString))
            {
                // If no records are returned, add the cookie as a new record
                if (mysqli_num_rows($results) == 0)
                {
                    // SQL string to set a default value
                    $sqlString = "INSERT INTO wcm (uuid, button1, button2, button3, button4, led1, led2, led3, led4, potentiometer) 
                                  VALUES ('" . strtoupper($_COOKIE["wcm_uuid_cookie"]) . "', 0, 0, 0, 0, 0, 0, 0, 0, 0)";
                    if (!mysqli_query($link, $sqlString))
                    {
                        // Error out if there are any issues
                        die('Unable to create new record in database!!  SQL string: ' . $sqlString);
                    }
                    // Close the link to the database
                    mysqli_close($link);
                    // This is required to refresh the page after the database update, or you will end up in a loop
                    header('Location: /index.php');
                }
            }
        }
    }

    // Set the UUID and create a database entry for it.
    if ($_POST["input"] == "Set UUID")
    {
        if (testUUID($_POST["wcm_dk1_uuid"]))
        {
            // create a cookie that will last one (1) hour
            setcookie("wcm_uuid_cookie", strtoupper($_POST["wcm_dk1_uuid"]), time()+3600);
            // Link to the database
            $link = mysqli_connect(DB_HOST, DB_RW_USER, DB_RW_USER_PW, DB_NAME);
            // The SQL string to select records based on cookie from the posted data
            $sqlString = "SELECT * FROM wcm WHERE uuid=\"" . $_COOKIE["wcm_uuid_cookie"] . "\"";
            // Check sql query results, store in $results
            if ($results = mysqli_query($link, $sqlString))
            {
                // If no records are returned, add the cookie as a new record
                if (mysqli_num_rows($results) == 0)
                {
                    // SQL string to set a default value
                    $sqlString = "INSERT INTO wcm (uuid, button1, button2, button3, button4, led1, led2, led3, led4, potentiometer) 
                                  VALUES ('" . $_COOKIE["wcm_uuid_cookie"] . "', 0, 0, 0, 0, 0, 0, 0, 0, 0)";
                    if (!mysqli_query($link, $sqlString))
                    {
                        // Error out if there are any issues
                        die('Unable to create new record in database!!  SQL string: ' . $sqlString);
                    }
                }
            }
            // Close the link to the database
            mysqli_close($link);
            // This is required to refresh the page after the database update, or you will end up in a loop
            header('Location: /index.php');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Include the items common to each page -->
        <?php include "content/php/header.php" ?>
    </head>
    <body>
        <!-- Include each module that makes up each page -->
        <?php include "content/php/site_tabs.php" ?>
        <?php include "content/php/logo_header.php" ?>
        <!-- Load the rest of the page contents based on status of cookie -->
        <?php
            if (isset($_COOKIE["wcm_uuid_cookie"]))
            {
                // These items will be included if the cookie is set
                include "content/php/buttons.php";
                include "content/php/leds.php";
                include "content/php/potentiometer.php";
            }
            else
            {
                // This file will create a post back to this page with the value of the UUID
                include "content/php/enter_uuid.php";
            }
        ?>
        <!-- Include the javascript for the page -->
        <script src="content/js/jquery-1.11.1.min.js"></script>
        <script src="content/js/bootstrap.min.js"></script>
        <script src="content/js/wcm_ami.min.js"></script>
    </body>
    <footer>
        <!-- Include the copyright at the bottom of the page -->
        <?php include "content/php/footer.php" ?>
    </footer>
</html>