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
                    <p class="panel-title">Setup UUID</p>
                </div>
                <div class="panel-body">
                    <p> To use this web portal to control your WCM Development Kit 1 you will need to enter the last 6 bytes of the UUID.  You can find this as part of the SSID broadcast from the WCM Develoment Kit 1 when it is in AP mode.</p>
                    <p>Please see the <a href="notes.php">release notes</a> page for information on required versions of firmware and applications for this demo.</p>
                    <h4 class="text-center"><strong>NOTE:</strong> This cookie will time out after one (1) hour and you will have to enter it again.</h4>
                    <hr>
                    <?php
                        if ($_POST["input"] == "Set UUID")
                        {
                            echo '
                                <div class="alert alert-danger" role="alert">
                                    <strong>ERROR!</strong> The UUID was not in the correct format when you entered it.  Please try again.
                                </div>
                            ';
                        }
                    ?>
                    <form method="POST" action="/index.php" class="form-horizontal">
                        <div class="form-group">
                            <label for="wcm_dk1_uuid" class="col-sm-3 control-label">WCM DK1 UUID</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="wcm_dk1_uuid" placeholder="UUID" autofocus maxlength="6">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3">
                                <button type="submit" class="btn btn-primary" name="input" value="Set UUID">Set UUID</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>