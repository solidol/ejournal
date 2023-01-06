<?php
$pass = fopen('pass.csv', 'rt');
$out = fopen('out.csv', 'wt');
while($s = fgetcsv($pass,5000,';')){
	

$s[]=password_hash($s[3],PASSWORD_BCRYPT, ['cost' => 10] );
	fputcsv($out,$s,';');
	echo ("<p> $s[0] $s[1] $s[3] $s[7] </p>");
}