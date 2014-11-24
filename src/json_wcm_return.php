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

    // Defines the device-types
    define("WCM_DEVICE", 1);
    define("AWS_SERVER", 2);
    define("IPHONE_DEVICE", 3);
    define("ANDRIOD_DEVICE", 4);

    // Defines the HTTP response Type
    define("OK", 200);
    define("BAD_REQUEST", 400);
    define("SERVER_ERROR", 500);

    // Defines the sub-message code
    define("NO_MESSAGE_CODE", 0);
    define("BAD_DEVICE_TYPE", 1);
    define("BAD_UUID", 2);
    define("BAD_PAYLOAD", 3);

    // This function is called to send the json data object back
    function outputMsg($statusCode, $msgCode, $data)
    {
        // Set which code is passed to the function
        switch ($statusCode)
        {
            case OK:
                $statusMsg = "Request has been accepted and processed successfully";
                break;
            case BAD_REQUEST:
                // Set the value of the HTTP response
                http_response_code(BAD_REQUEST);
                // Set which error code type in the message body
                switch ($msgCode)
                {
                    case BAD_DEVICE_TYPE:
                        $statusMsg = "Device-type not supported";
                        break;
                    case BAD_UUID:
                        $statusMsg = "UUID does not match any record in database";
                        break;
                    case BAD_PAYLOAD:
                        $statusMsg = "Bad Payload Syntax";
                        break;
                    default:
                        $statusMsg = "Something went really wrong";
                }
                break;
            case SERVER_ERROR:
                // Set the value of the HTTP response
                http_response_code(SERVER_ERROR);
                $statusMsg = "Database Error";
                break;
            default:
        }
        
        // Build the json output with the data that was provide to the GET or POST
        $output = array("mchp" => [
                            "device" => [
                                "device-type" => AWS_SERVER,
                                "uuid" => $data['mchp']['device']['uuid'],
                                "status" => $statusCode,
                                "message" => $statusMsg,
                                "data" => [
                                    "button1" => $data['mchp']['device']['data']['button1'],
                                    "button2" => $data['mchp']['device']['data']['button2'],
                                    "button3" => $data['mchp']['device']['data']['button3'],
                                    "button4" => $data['mchp']['device']['data']['button4'],
                                    "led1" => $data['mchp']['device']['data']['led1'],
                                    "led2" => $data['mchp']['device']['data']['led2'],
                                    "led3" => $data['mchp']['device']['data']['led3'],
                                    "led4" => $data['mchp']['device']['data']['led4'],
                                    "potentiometer" => $data['mchp']['device']['data']['potentiometer']
                                ]
                            ]
                        ]);
        
        // Return the results back to the requesting client
        echo json_encode($output);
    }
?>