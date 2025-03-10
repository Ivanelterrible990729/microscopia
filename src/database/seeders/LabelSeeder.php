<?php

namespace Database\Seeders;

use App\Models\Label;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Label::exists()) {
            $this->command->comment('- Ya hay registros en la base de datos. Seeder suspendido [Database\Seeders\LabelSeeder.php].');
            return;
        }

        Label::create([
            'name' => 'BACILOS',
            'description' => 'Bacteria que tiene forma de bastoncillo o filamento, que puede ser recto o encorvado, y de más o menos largo.',
            'color' => '#064E3B',
        ]);

        Label::create([
            'name' => 'COCOS',
            'description' => 'Microorganismos unicelulares con forma esférica u ovalada. Se pueden encontrar en el ambiente o en los cocoteros.',
            'color' => "#FACC15",
        ]);

        Label::create([
            'name' => 'FIBRAS MUSCULARES',
            'description' => 'Fibras musculares captadas para la detección de miositis.',
            'color' => '#F59E0B',
        ]);
    }
}
