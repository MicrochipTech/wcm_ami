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
        <?php include "content/php/release_notes.php" ?>
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