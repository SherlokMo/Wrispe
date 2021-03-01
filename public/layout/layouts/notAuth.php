<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="layout/css/master.css?version=1.0.4">
    <link rel="stylesheet" href="layout/css/login.css?version=1.0.2">
    <link rel="stylesheet" href="layout/css/form.css?version=1.0.0">
    <script src="https://kit.fontawesome.com/98d3e6df54.js" crossorigin="anonymous"></script>
    <title><?= $this->title  // from Core\Render ?></title>
</head>
<body>
    <div class="root flex-r justify-center">
        {{content}}
    </div>
</body>
</html>