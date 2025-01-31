<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Alias de python para llamarlo como ejecutable desde el servidor.
    |--------------------------------------------------------------------------
    |
    */
    'exe' => env("PYTHON_EXE", 'python3'),

    /*
    |--------------------------------------------------------------------------
    | Directorio en donde se encuentran los scripts de python.
    |--------------------------------------------------------------------------
    |
    */
    'scripts_directory' => base_path("resources/python/"),
];
