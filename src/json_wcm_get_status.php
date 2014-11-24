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
    header('Content-Type: application/json');           // Type of data to send

    // Include the return message function
    include_once('json_wcm_return.php');

    // Get the query value for the uuid
    $uuid = $_GET['uuid'];

    // Including DB connection info
    include_once('content/php/connect_defines.php');

    function value2bool($inputValue)
    {
        if ($inputValue == "0") return false;
        else if ($inputValue == "1") return true;
        else return $inputValue;
    }

    // Connecting to the database
    $link = mysqli_connect(DB_HOST, DB_READ_USER, DB_READ_USER_PW, DB_NAME);

    // Select record based on uuid
    $sqlString = "SELECT * FROM wcm WHERE uuid=\"" . $uuid . "\"";

    // Check SQL query results, store in $results
    if ($results = mysqli_query($link, $sqlString))
    {
        if (mysqli_num_rows($results))
        {
            // Read the data from the database
            $row = mysqli_fetch_array($results);

            // Build the array that will form the JSON data
            $output = array("mchp" => [
                                "device" => [
                                    "device-type" => AWS_SERVER,
                                    "uuid" => $row['uuid'],
                                    "status" => "",
                                    "message" => "",
                                    "data" => [
                                        "button1" => value2bool($row['button1']),
                                        "button2" => value2bool($row['button2']),
                                        "button3" => value2bool($row['button3']),
                                        "button4" => value2bool($row['button4']),
                                        "led1" => value2bool($row['led1']),
                                        "led2" => value2bool($row['led2']),
                                        "led3" => value2bool($row['led3']),
                                        "led4" => value2bool($row['led4']),
                                        "potentiometer" => (int)$row['potentiometer']
                                    ]
                                ]
                            ]);
            // Output message
            outputMsg(OK, NO_MESSAGE_CODE, $output);
        }
        else
        {
            // Output message that UUID does not match
            outputMsg(BAD_REQUEST, BAD_UUID, $data);
        }
    }
    else
    {
        // Output message that UUID does not match
        outputMsg(SERVER_ERROR, NO_MESSAGE_CODE, $data);
    }

    // Close the connection to the database
    mysqli_close($link);
?>