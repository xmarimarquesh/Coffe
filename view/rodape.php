<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Galada&family=Italianno&family=Josefin+Slab&display=swap');

        * {
            font-family: 'Josefin Slab', serif;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            width: 100% !important;
        }

        
        .cor {
            border-radius: 20px 20px 0px 0px;
            background-color: #7C573E;
            width: 100%;
            
        }

        #corpo-rodape{
            margin-top: 10%;
            width: 100%;
        }

        .rodapes img {
            width: 2em;
            height: 2em;
            margin: 0 0px 0 10px;
        }

        .rodapes p {
            font-size: 1.2em;
            margin: 0 10px 0 10px;
            color: white;
        }

        .content {
            flex: 1;
        }
    </style>
</head>

<body>
    <div id="corpo-rodape">
    <section class="border-top text-muted cor">
        <div class="container cor">
            <div class="row py-3 rodapes">
                <div class="col-12 col-md-4 text-center text-md-left">
                    <img src="img/whatsbranco.png" alt="">
                    <p>(41) 9 9624-3287</p>
                </div>
                <div class="col-12 col-md-4 text-center">
                    <p>Todos os direitos reservados a coffesgarden@gmail.com</p>
                </div>
                <div class="col-12 col-md-4 text-center text-md-right">
                    <img src="img/instabranco.png" alt="">
                    <p>@coffesgarden</p>
                </div>
            </div>
        </div>
    </section>
    </div>
</body>

</html>