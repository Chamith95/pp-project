<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AfterSchool Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <link rel="stylesheet" href="https://unpkg.com/@clr/ui/clr-ui.min.css">
    <script src="main.js"></script>
</head>

<body>
    <header class="header-6">
        <div class="branding">
            <a href="-" class="nav-link">
                <span class="title">AfterSchool</span>
            </a>
        </div>
        <div class="header-actions">
            <?php
            foreach ($actions as $action_name => $action_act) {
                echo "<a href=\"$action_act\" class=\"nav-link nav-text\">$action_name</a>";
            }
            ?>
        </div>
    </header> 
