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

    // Include the connection information to the database
    include_once('content/php/connect_defines.php');

    // Define the link to the database
    $link = mysqli_connect(DB_HOST, DB_READ_USER, DB_READ_USER_PW, DB_NAME);
    
    // Test to see if the database has been setup
    if (!$link)
    {
        if ($_POST["input"] == "Setup Database")
        {
            echo '
                <div class="container-fluid">
                    <div class="col-sm-10 col-sm-offset-1 col-lg-8 col-lg-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <p class="panel-title">MySQL Database Setup</p>
                            </div>
                            <div class="panel-body">
            '; // end of the echo -- Body of the panel div
                                echo '<p>Connecting to MySQL database with root access...';
                                $setup_link = mysqli_connect(DB_HOST, $_POST["mysqlRootID"], $_POST["mysqlRootPassword"]);
                                if (!$setup_link)
                                {
                                    die('</p><p>Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error() . '</p>');
                                }
                                echo 'DONE</p>';
                                
                                echo '<p>Creating WCM demo database...';
                                // If for some reason the database exists remove it
                                $sqlString = "DROP DATABASE IF EXISTS " . DB_NAME;
                                if (!mysqli_query($setup_link, $sqlString))
                                {
                                    die('ERROR: SQLSTATE: ' .  mysqli_sqlstate($setup_link) . '</p>');
                                }
                                // Here is where the database is created
                                $sqlString = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
                                if (!mysqli_query($setup_link, $sqlString))
                                {
                                    die('ERROR: SQLSTATE: ' .  mysqli_sqlstate($setup_link) . '</p>');
                                }
                                echo 'DONE</p>';
                                
                                echo '<p>Creating the admin user...';
                                $sqlString = "CREATE USER '" . DB_ADMIN_USER . "'@'" . DB_HOST . "' IDENTIFIED BY '" . DB_ADMIN_USER_PW . "'";
                                if (!mysqli_query($setup_link, $sqlString))
                                {
                                    die($sqlString . ' ERROR: SQLSTATE: ' .  mysqli_sqlstate($setup_link) . '</p>');
                                }
                                echo 'DONE</p>';
                                
                                echo '<p>Granting the admin user rights...';
                                $sqlString = "GRANT ALL ON " . DB_NAME . ".* TO '" . DB_ADMIN_USER . "'@'" . DB_HOST . "'";
                                if (!mysqli_query($setup_link, $sqlString))
                                {
                                    die('ERROR: SQLSTATE: ' .  mysqli_sqlstate($setup_link) . '</p>');
                                }
                                echo 'DONE</p>';
                                
                                echo '<p>Creating the read/write user...';
                                $sqlString = "CREATE USER '" . DB_RW_USER . "'@'" . DB_HOST . "' IDENTIFIED BY '" . DB_RW_USER_PW . "'";
                                if (!mysqli_query($setup_link, $sqlString))
                                {
                                    die('ERROR: SQLSTATE: ' .  mysqli_sqlstate($setup_link) . '</p>');
                                }
                                echo 'DONE</p>';
                                
                                echo '<p>Granting the read/write user rights...';
                                $sqlString = "GRANT ALTER, INSERT, SELECT, UPDATE ON " . DB_NAME . ".* TO '" . DB_RW_USER . "'@'" . DB_HOST . "'";
                                if (!mysqli_query($setup_link, $sqlString))
                                {
                                    die('ERROR: SQLSTATE: ' .  mysqli_sqlstate($setup_link) . '</p>');
                                }
                                echo 'DONE</p>';
                                
                                echo '<p>Creating the read only user...';
                                $sqlString = "CREATE USER '" . DB_READ_USER . "'@'" . DB_HOST . "' IDENTIFIED BY '" . DB_READ_USER_PW . "'";
                                if (!mysqli_query($setup_link, $sqlString))
                                {
                                    die('ERROR: SQLSTATE: ' .  mysqli_sqlstate($setup_link) . '</p>');
                                }
                                echo 'DONE</p>';
                                
                                echo '<p>Granting the read only user rights...';
                                $sqlString = "GRANT SELECT ON " . DB_NAME . ".* TO '" . DB_READ_USER . "'@'" . DB_HOST . "'";
                                if (!mysqli_query($setup_link, $sqlString))
                                {
                                    die('ERROR: SQLSTATE: ' .  mysqli_sqlstate($setup_link) . '</p>');
                                }
                                echo 'DONE</p>';
                                
                                mysqli_close($setup_link);
                                
                                echo '<p>Connecting to the WCM database as admin user...';
                                $setup_link = mysqli_connect(DB_HOST, DB_ADMIN_USER, DB_ADMIN_USER_PW, DB_NAME);
                                if (!$setup_link)
                                {
                                    die('</p><p>Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error() . '</p>');
                                }
                                echo 'DONE</p>';
                                
                                echo '<p>Creating WCM Table...';
                                $sqlString = "CREATE TABLE wcm
                                    (
                                    uuid            VARCHAR(12) NOT NULL,
                                    button1         BOOLEAN     NOT NULL,
                                    button2         BOOLEAN     NOT NULL,
                                    button3         BOOLEAN     NOT NULL,
                                    button4         BOOLEAN     NOT NULL,
                                    led1            BOOLEAN     NOT NULL,
                                    led2            BOOLEAN     NOT NULL,
                                    led3            BOOLEAN     NOT NULL,
                                    led4            BOOLEAN     NOT NULL,
                                    potentiometer   INT         NOT NULL,
                                    time_stamp      TIMESTAMP   NOT NULL
                                    )";
                                if (!mysqli_query($setup_link, $sqlString))
                                {
                                    die('ERROR: SQLSTATE: ' .  mysqli_sqlstate($setup_link) . '</p>');
                                }
                                echo 'DONE</p>';
            echo '          </div>
                        </div>
                    </div>
                </div>
            '; // end of the echo and the panel div
        }
        else
        {
            echo '
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1 col-lg-8 col-lg-offset-2">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <p class="panel-title">MySQL Database Setup</p>
                                </div>
                                <div class="panel-body">
                                    <p> The database for this server have not be setup.  You will need to enter the root user ID and pasword for MySQL to setup the databases.</p>
                                    <hr>
                                    <form method="POST" action="' . $_SERVER['PHP_SELF'] . '" class="form-horizontal">
                                        <div class="form-group">
                                            <label for="mysqlRootID" class="col-sm-3 control-label">MySQL Root User</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="mysqlRootID" placeholder="Root User" autofocus>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="mysqlRootPassword" class="col-sm-3 control-label">Root Password</label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" name="mysqlRootPassword" placeholder="Root Password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-9 col-sm-offset-3">
                                                <button type="submit" class="btn btn-primary" name="input" value="Setup Database">Setup Database</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            '; //end the echo statment
        }
    }
    elseif ($_POST["input"] == "Remove Database")
    {
            echo '
                <div class="container-fluid">
                    <div class="col-sm-10 col-sm-offset-1 col-lg-8 col-lg-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <p class="panel-title">MySQL Database Setup</p>
                            </div>
                            <div class="panel-body">
            '; // end of the echo -- Body of the panel div

                                echo '<p>Connecting to MySQL database with root access...';
                                $setup_link = mysqli_connect(DB_HOST, $_POST["mysqlRootID"], $_POST["mysqlRootPassword"]);
                                if (!$setup_link)
                                {
                                    die('</p><p>Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error() . '</p>
                                         <h2>Please return to the <a href="setup.php">setup page</a></h3>');
                                }
                                echo 'DONE</p>';
                                
                                echo '<p>Removing the WCM database...';
                                $sqlString = "DROP DATABASE IF EXISTS " . DB_NAME;
                                if (!mysqli_query($setup_link, $sqlString))
                                {
                                    die('</p><p>ERROR: Unable to remove database - SQLSTATE: ' .  mysqli_sqlstate($setup_link) . '</p>');
                                }
                                echo 'DONE</p>';
                                
                                echo '<p>Removing the admin user...';
                                $sqlString = "DROP USER '" . DB_ADMIN_USER . "'@'" . DB_HOST . "'";
                                if (!mysqli_query($setup_link, $sqlString))
                                {
                                    die('</p><p>ERROR: Unable to remove admin user - SQLSTATE: ' .  mysqli_sqlstate($setup_link) . '</p>');
                                }
                                echo 'DONE</p>';
                                
                                echo '<p>Removing the read/write user...';
                                $sqlString = "DROP USER '" . DB_RW_USER . "'@'" . DB_HOST . "'";
                                if (!mysqli_query($setup_link, $sqlString))
                                {
                                    die('</p><p>ERROR: Unable to remove read write user - SQLSTATE: ' .  mysqli_sqlstate($setup_link) . '</p>');
                                }
                                echo 'DONE</p>';
                                
                                echo '<p>Removing the read only user...';
                                $sqlString = "DROP USER '" . DB_READ_USER . "'@'" . DB_HOST . "'";
                                if (!mysqli_query($setup_link, $sqlString))
                                {
                                    die('</p><p>ERROR: Unable to remove read user - SQLSTATE: ' .  mysqli_sqlstate($setup_link) . '</p>');
                                }
                                echo 'DONE</p>';

            echo '          </div>
                        </div>
                    </div>
                </div>
            '; // end of the echo and the panel div
    }
    else
    {
        // Close the link to the database
        mysqli_close($link);
            echo '
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1 col-lg-8 col-lg-offset-2">
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    <p class="panel-title">MySQL Database Removal</p>
                                </div>
                                <div class="panel-body">
                                    <p> The database for this server have already been setup.  You can remove them and using this form.  You will need to enter the root user ID and pasword for MySQL to setup the databases.</p>
                                    <h4 class="text-center">NOTE: All data will be lost in the database when this is done.</h4>
                                    <hr>
                                    <form method="POST" action="' . $_SERVER['PHP_SELF'] . '" class="form-horizontal">
                                        <div class="form-group">
                                            <label for="mysqlRootID" class="col-sm-3 control-label">MySQL Root User</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="mysqlRootID" placeholder="Root User">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="mysqlRootPassword" class="col-sm-3 control-label">Root Password</label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" name="mysqlRootPassword" placeholder="Root Password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-9 col-sm-offset-3">
                                                <button type="submit" class="btn btn-danger" name="input" value="Remove Database">Remove Database</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            '; //end the echo statment
    }
?>