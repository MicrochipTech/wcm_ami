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

    // Set the JSON string that will be decode from the body of the post
    $data = json_decode(file_get_contents('php://input'), true);

    // Get the device-type and the uuid of the data sent
    $device_type = $data['mchp']['device']['device-type'];
    $uuid        = $data['mchp']['device']['uuid'];

    // Including database parameters
    include_once('content/php/connect_defines.php');

    // This function is needed as PHP converts a Boolean false to a null value
    function bool2Value($inputValue)
    {
        if ($inputValue == null)
        {
            return 0;
        }
        return 1;
    }

    // Connecting to the WCM database with read/write access
    $link = mysqli_connect(DB_HOST, DB_RW_USER, DB_RW_USER_PW, DB_NAME);

    // Select record based on uuid
    $sqlString = "SELECT * FROM wcm WHERE uuid='" . $uuid . "'";

    // Check sql query results, store in $results
    if ($results = mysqli_query($link, $sqlString))
    {
        if (mysqli_num_rows($results))
        {
            // Read the data from the database
            // $row = mysqli_fetch_array($results);
            switch ($device_type)
            {
                case WCM_DEVICE: // This is the data from the WCM that will be posted to the database
                    $sqlString = "UPDATE wcm SET button1='" . bool2Value($data['mchp']['device']['data']['button1']) . "'," .
                                                "button2='" . bool2Value($data['mchp']['device']['data']['button2']) . "'," . 
                                                "button3='" . bool2Value($data['mchp']['device']['data']['button3']) . "'," .
                                                "button4='" . bool2Value($data['mchp']['device']['data']['button4']) . "'," . 
                                                "potentiometer='" . $data['mchp']['device']['data']['potentiometer'] . "' WHERE uuid='" . $uuid . "'";
                    if (!mysqli_query($link, $sqlString))
                    {
                        // Output error message
                        outputMsg(SERVER_ERROR, NO_MESSAGE_CODE, $data);
                    }
                    else
                    {
                        // Output message
                        outputMsg(OK, NO_MESSAGE_CODE, $data);
                    }
                    break;
                case AWS_SERVER:
                case IPHONE_DEVICE:
                case ANDRIOD_DEVICE:
                    $sqlString = "UPDATE wcm SET led1='" . bool2Value($data['mchp']['device']['data']['led1']) . "'," .
                                                "led2='" . bool2Value($data['mchp']['device']['data']['led2']) . "'," .
                                                "led3='" . bool2Value($data['mchp']['device']['data']['led3']) . "'," .
                                                "led4='" . bool2Value($data['mchp']['device']['data']['led4']) . "' WHERE uuid='" . $uuid . "'";
                    if (!mysqli_query($link, $sqlString))
                    {
                        // Output error message
                        outputMsg(SERVER_ERROR, NO_MESSAGE_CODE, $data);
                    }
                    else
                    {
                        // Output message
                        outputMsg(OK, NO_MESSAGE_CODE, $data);
                    }
                    break;
                default:
                    // Output error message
                    outputMsg(BAD_REQUEST, BAD_DEVICE_TYPE, $data);
            }
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