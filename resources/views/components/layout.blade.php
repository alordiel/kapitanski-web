<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/app.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li>Home</li>
                <li>Main</li>
                <li>Rest</li>
            </ul>
        </nav>
    </header>

    <main>
        {{$slot}}
    </main>
    
    <footer>
        <p style="text-align:center">all right reserved</p>
    </footer>
</body>
</html>