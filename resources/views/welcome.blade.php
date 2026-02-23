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

                <!-- Email Verification Success Message -->
                @if (session('verified'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start">
                        <svg class="w-5 h-5 text-green-600 mt-0.5 mr-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="text-green-800 font-medium">¡Email verificado correctamente!</p>
                            <p class="text-green-700 text-sm mt-1">Tu cuenta está lista para usar.</p>
                        </div>
                    </div>
                @endif

                <!-- Email Verification Resent Message -->
                @if (session('resent'))
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 5v14a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-2 0H4v14h12V5z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="text-blue-800 font-medium">Email de verificación reenviado</p>
                            <p class="text-blue-700 text-sm mt-1">Revisa tu bandeja de entrada para completar la verificación.</p>
                        </div>
                    </div>
                @endif

                <p class="flex items-center mb-8 w-full max-w-xl">
                    <img src="/images/tiempo-rapido.png" alt="timer" class="w-20 mr-6">
                    <span>
                        Este es un API sencillo para el control del tiempo en proyectos.
                    </span>
                </p>
                <dile-card title="Documentación" class="w-full max-w-xl">
                    <p class="mb-6">La documentación del API la puedes ver en:
                        <ul>
                            <li class="flex items-center">
                                <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#66dddd"><path d="M382-240 154-468l57-57 171 171 367-367 57 57-424 424Z"/></svg>
                                <a href="https://github.com/EscuelaIt/time-register/">Modelo de dominio y casos de uso</a>
                            </li>
                            <li class="flex items-center">
                                <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#66dddd"><path d="M382-240 154-468l57-57 171 171 367-367 57 57-424 424Z"/></svg>
                                <a href="/api/documentation">Documentación de los endpoints del API</a>
                            </li>
                        </ul>
                </dile-card>

                <dile-info-box class="mt-8 w-full max-w-xl">
                    Para el mantenimiento de la base de datos se resetearán todas las tablas a las 6:00 AM, horario de Madrid.
                </dile-info-box>
                
            </section>
        </div>
    </body>
</html>
