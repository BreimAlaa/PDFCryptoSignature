<?php
require 'EnhancedPDF.php';

$enhancedPDF = new EnhancedPDF();
$enhancedPDF->load('modified.pdf');
$enhancedPDF->sign(['name' => 'Alaa Breim']);
var_dump($enhancedPDF->verify());