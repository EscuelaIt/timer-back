<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>API de gestión del tiempo</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="antialiased">
        <div class="navcontainer">
            <dile-nav class="mx-auto max-w-2xl">
                <h1 slot="title">API de gestión del tiempo</h1>
            </dile-nav>
        </div>
        <div class="mx-auto max-w-2xl">
            <section class="my-8 mx-6">

                <p class="flex items-center mb-8 w-full max-w-xl">
                    <img src="/images/tiempo-rapido.png" alt="timer" class="w-20 mr-6">
                    <span>
                        Este es un API sencillo para el control del tiempo en proyectos.
                    </span>
                </p>
                <dile-card title="Documentación" class="w-full max-w-xl">
                    <p class="mb-6">La documentación del API se encuentra en el siguiente enlace:</p>
                    <a href="/api/documentation">https://timer.escuelait.com/api/documentation</a>
                </dile-card>
            </section>
        </div>
    </body>
</html>
