<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usuarios')->insert([
            [
                'nombre' => 'Admin',
                'apellido' => 'User',
                'correo' => 'admin@example.com',
                'contrasena' => Hash::make('password'),
                'rol_id' => 1, // ID de 'admin'
            ],
            [
                'nombre' => 'Cliente',
                'apellido' => 'User',
                'correo' => 'cliente@example.com',
                'contrasena' => Hash::make('password'),
                'rol_id' => 2, // ID de 'cliente'
            ],
            [
                'nombre' => 'Autor',
                'apellido' => 'User',
                'correo' => 'autor@example.com',
                'contrasena' => Hash::make('password'),
                'rol_id' => 3, // ID de 'autor'
            ],
        ]);
    }
}
