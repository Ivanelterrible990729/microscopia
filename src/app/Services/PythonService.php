<?php

namespace App\Services;

class PythonService
{
    /**
     * Convierte arreglo de argumentos en una cadena con pares
     * --nombreArg "valor"
     *
     * @param Array $args
     * @return string
     */
    protected function stringifyArgs($args)
    {
        $str = '';

        foreach ($args as $nombre => $valor) {
            $str .= ("$nombre \"$valor\" ");
        }

        return $str;
    }


    /**
     * Ejecuta el script de Python indicado con los argumentos requeridos
     *
     * @param String $nombre_script
     * @param Array $argumentos
     */
    public function runScript($script, $args)
    {
        $python_exec = config('python.exe');
        $script_directory = config('python.scripts_directory') . $script;
        $args = $this->stringifyArgs($args);

        dd("$python_exec $script_directory $args");
        exec("$python_exec $script_directory $args", $output);

        return $output;
    }
}
