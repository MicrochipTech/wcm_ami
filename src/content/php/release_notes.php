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
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-lg-8 col-lg-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p class="panel-title">Release Notes</p>
                </div>
                <div class="panel-body">
                    <h4>Version 2.00</h4>
                    <p><strong>NOTE:</strong> This version of the WCM Development Kit 1 AMI requires the follow versions of firmware or software.</p>
                    <table class="table table-striped">
                        <tr>
                            <th>Device</th>
                            <th>Version</th>
                        </tr>
                        <tr>
                            <td><a href="http://www.microchip.com/pagehandler/en-us/products/internet-of-things/iot-demos.html">WCM Development Kit 1 firmware</a></td>
                            <td>1.00 or greater</td>
                        </tr>
                        <tr>
                            <td><a href="https://itunes.apple.com/us/app/wcm-development-kit-1/id918194935?mt=8">iPhone App</a></td>
                            <td>1.00 or greater</td>
                        </tr>
                    </table>
                    <p> WCM Development Kit 1 AMI changes include the following:</p>
                    <ul>
                        <li>Updated to use a single JSON data object for all communications</li>
                        <li>Database setup has been changed to follow new data types used in the JSON data object</li>
                        <li>The AMI is now based on Bootstrap 3 framework for a response design</li>
                        <li>jQuery has been updated to version 1.11.1</li>
                        <li>Removed js code for double tap on mobile devices as this is part of Bootstrap 3</li>
                        <li>The overall design changed to support many WCM Development Kit 1 to a single server as records are now uuid based</li>
                        <li>Changed code to be modular for each of the functions panels on the web interface</li>
                        <li>Moved all of the javascript to a single file</li>
                        <li>Update to the title image</li>
                    </ul>
                    <hr>
                    <h4>Version 1.04</h4>
                    <ul>
                        <li>Updated bash (4.3-7ubuntu1.4) security patches for Shellshock</li>
                    </ul>
                    <hr>
                    <h4>Version 1.03</h4>
                    <ul>
                        <li>Updated based Ubuntu Server 14.04 LTS</li>
                        <ul>
                            <li>Please see the updates on Ubuntu's website for detailed change information</li>
                            <li>Changes include the following:</li>
                            <ul>
                                <li>Upgrade Apache to version 2.4 from 2.2</li>
                                <li>Upgrade PHP to version 5.5 from 5.3</li>
                                <li>Upgrade OpenSSL to version 1.0.1f with heartbleed patch</li>
                            </ul>
                        </ul>
                        <li>Enabling the apache site for wcm-ssl (port 443)</li>
                        <li>Adding a self signed cert to demo SSL on port 443</li>
                    </ul>
                    <hr>
                    <h4>Version 1.02</h4>
                    <ul>
                        <li>Updated openssl (1.0.1-4ubuntu5.12) to fix security issue heartbleed</li>
                    </ul>
                    <hr>
                    <h4>Version 1.01</h4>
                    <ul>
                        <li>Disabled iPad zoom when you double tapped on the screen too quickly to click the button</li>
                        <li>Included jQuery for support functions</li>
                        <li>Adding release notes to configure page</li>
                        <li>Fixed LED button transition effect, previously had a bouncing glitch on animation</li>
                        <li>Fixed update issue with Internet Explorer 10</li>
                        <li>Removed blue border around logo on Internet Explorer 10</li>
                        <li>Fixed scroll bars on release notes for Internet Explorer 10</li>
                        <li>Force IE10 to reload webpage instead of using cached data</li>
                    </ul>
                    <hr>
                    <h4>Version 1.00</h4>
                    <ul>
                        <li>This is the initial release of the AMI for the WCM Demo</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>