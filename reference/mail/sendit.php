<?php

$message = '<h1>Heading</h1>'.
'<table>'.
'<tbody>'.
'<tr>'.
'<td>'.
'<p>Hello </p>'.
'<p> </p>'.
'</td>'.
'<td> </td>'.
'<td> </td>'.
'</tr>'.
'<tr>'.
'<td>We are so into coding</td>'.
'<td> </td>'.
'<td>Bless God</td>'.
'</tr>'.
'<tr>'.
'<td> </td>'.
'<td> </td>'.
'<td> </td>'.
'</tr>'.
'<tr>'.
'<td> </td>'.
'<td>Uses table</td>'.
'<td> </td>'.
'</tr>'.
'</tbody>'.
'</table>'.
'<p>see you later</p>';

$Subject ="Hello testing";
$to      ="postmaster@localhost" ;

$headers = "From: admin@localhost";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

mail($to, $Subject, $message, $headers);
