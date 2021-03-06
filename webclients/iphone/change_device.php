<?php

// DomotiGa - an open source home automation program
// Copyright (C) Ron Klinkien, The Netherlands.

// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY OR FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General PUBLIC License for more details.

// You should have received a copy of the GNU General PUBLIC License
// along with this program. If not, see <http://www.gnu.org/licenses/>.

$configfile = 'config.php';
if (file_exists($configfile)) {
   include "config.php";
} else {
   echo "<h3>Check contents of config.php.example first, then rename it to config.php!</h3>";
   exit;
}
if (!extension_loaded('xmlrpc')) {
   echo "<h3>PHP xmlrpc module is not found, check your apache/php server setup!</h3>";
   exit;
}
include "functions.php";
$device=$_GET["device"];
$value=$_GET["value"];

if ( $locations ) {
   if(!isset($_GET["location"])) {
      $location="*";
   } else {
      $location=$_GET["location"];
   };
   $data=get_device_list($location);
} else {
   $data=get_device_list("*");
};

$request = xmlrpc_encode_request("device.setdevice",array ($device,$value));
$response = do_xmlrpc($request);
if (is_array($response) && xmlrpc_is_fault($response)) {
   trigger_error("xmlrpc: $response[faultString] ($response[faultCode])");}

if ( $locations ) {
   header('Location: device.php?location='.$location);
} else {
   header('Location: device.php');
}
?>
