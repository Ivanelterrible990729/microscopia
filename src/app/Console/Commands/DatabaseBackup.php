<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Realiza un respaldo de la base de datos del sistema.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = \Carbon\Carbon::now();
        $fecha = $date->toDateString();
        $ruta = storage_path(env('DB_BACKUP', 'storage'));
        $baseDatos = config('database.connections.mysql.database');
        $host = config('database.connections.mysql.host');
        $hora = str_replace(':', '', substr($date->toTimeString(), 0, 5));

        $nombreArchivo = $ruta . $baseDatos . "" . $fecha . "_" . $hora . '.sql';

        exec(
            sprintf(
                'mysqldump --opt --user=%s --password=%s --host=%s %s --result-file="%s" 2>&1',
                config('database.connections.mysql.username'),
                config('database.connections.mysql.password'),
                $host,
                config('database.connections.mysql.database') ,
                $nombreArchivo
            ),
            $output
        );

        $this->comment("\nOutput:");

        echo implode("\n", $output);

        $this->info("\n\nFinalizado");
    }
}
