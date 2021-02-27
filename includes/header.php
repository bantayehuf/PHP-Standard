<?php
# Checking if title is provided
$page_title = $page_title ?? APP_NAME;

echo <<<HTML
<!DOCTYPE html>
<html lang="en">

<head>
    <title>{$page_title}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Here your styles links to include -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    
</head>

<body> 
  <h2>Here your Header body</h2>

HTML;