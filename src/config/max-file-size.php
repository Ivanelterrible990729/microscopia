<?php

/*
|--------------------------------------------------------------------------
| Max File Size
|--------------------------------------------------------------------------
|
| Define el tamaño máximo para cada tipo de archivo.
|
| Nota: El valor máximo por tipo de archivo debe actualizarse en media-library.php en el campo 'max_file_size'.
*/

return [
    /*
     * The maximum file size of an item in bytes.
     * Adding a larger file will result in an exception.
     */
    'profile_photos' => 1024 * 1024 * 10, // 10MB

    /*
     * Description for the maximum file size.
     * Only used for info porpuses.
     */
    'profile_photos_desc' => '10MB',

    /**
     * The maximum file size of an item in bytes.
     * Adding a larger file will result in an exception.
     */
    'images' => 1024 * 1024 * 10, // 10 MB

    /*
     * Description for the maximum file size.
     * Only used for info porpuses.
     */
    'images_desc' => '10MB',

    /**
     * The maximum file size of an item in bytes.
     * Adding a larger file will result in an exception.
     */
    'models' => 1024 * 1024 * 15, // 15 MB.

    /*
     * Description for the maximum file size.
     * Only used for info porpuses.
     */
    'models' => '15MB',
];
