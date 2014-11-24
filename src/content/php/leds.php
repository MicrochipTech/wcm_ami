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
                    <p class="panel-title">LEDs</p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-6 col-sm-3 text-center">
                            <div class="btn-group btn-toggle"> 
                                <button id="led1_On" class="btn btn-default" onclick="onLedPress('led1', true)">ON</button>
                                <button id="led1_Off" class="btn btn-info active" onclick="onLedPress('led1', false)">OFF</button>
                            </div>
                            <div>
                                <h4>D1</h4>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-3 text-center">
                            <div class="btn-group btn-toggle"> 
                                <button id="led2_On" class="btn btn-default" onclick="onLedPress('led2', true)">ON</button>
                                <button id="led2_Off" class="btn btn-info active" onclick="onLedPress('led2', false)">OFF</button>
                            </div>
                            <div>
                                <h4>D2</h4>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-3 text-center">
                            <div class="btn-group btn-toggle"> 
                                <button id="led3_On" class="btn btn-default" onclick="onLedPress('led3', true)">ON</button>
                                <button id="led3_Off" class="btn btn-info active" onclick="onLedPress('led3', false)">OFF</button>
                            </div>
                            <div>
                                <h4>D3</h4>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-3 text-center">
                            <div class="btn-group btn-toggle"> 
                                <button id="led4_On" class="btn btn-default" onclick="onLedPress('led4', true)">ON</button>
                                <button id="led4_Off" class="btn btn-info active" onclick="onLedPress('led4', false)">OFF</button>
                            </div>
                            <div>
                                <h4>D4</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>