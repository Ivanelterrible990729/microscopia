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
            'description' => 'Bacteria que tiene forma de bastoncillo o filamento, que puede ser recto o encorvado, y de más o menos largo.' . 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Fuga reiciendis deserunt exercitationem a possimus veniam dolorum dolorem numquam? Fugit minus impedit minima ullam consequatur earum non dolorem quo sapiente recusandae!',
            'color' => '#064E3B',
        ]);

        Label::create([
            'name' => 'COCOS',
            'description' => 'Microorganismos unicelulares con forma esférica u ovalada. Se pueden encontrar en el ambiente o en los cocoteros.' . 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Fuga reiciendis deserunt exercitationem a possimus veniam dolorum dolorem numquam? Fugit minus impedit minima ullam consequatur earum non dolorem quo sapiente recusandae!',
            'color' => "#FACC15",
        ]);

        Label::create([
            'name' => 'MUSCULO',
            'description' => 'Fibras musculares captadas para la detección de miositis.' . 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Fuga reiciendis deserunt exercitationem a possimus veniam dolorum dolorem numquam? Fugit minus impedit minima ullam consequatur earum non dolorem quo sapiente recusandae!',
            'color' => '#F59E0B', // sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
        ]);
    }
}
