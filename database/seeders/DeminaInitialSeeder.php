<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DeminaInitialSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('site_settings')->updateOrInsert(
            ['id' => 1],
            [
                'site_name' => 'Demina Laboratorio de Artes',
                'tagline' => 'Laboratorio autogestionado para la creación y experimentación de arte contemporáneo',
                'description' => 'Demina es un espacio independiente en Acapulco dedicado a exposiciones, cineclub, talleres, archivo, encuentros y experimentación artística.',
                'city' => 'Acapulco',
                'state' => 'Guerrero',
                'country' => 'México',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $activityTypes = [
            ['Cineclub', 'Proyecciones semanales y programación especial de cine.', true, 1],
            ['Taller', 'Procesos formativos impartidos por talleristas externos o colaboradores.', true, 2],
            ['Exposición', 'Muestras individuales, colectivas o experimentales.', true, 3],
            ['Teatro', 'Obras escénicas y microteatro.', false, 4],
            ['Danza', 'Presentaciones, laboratorios y acciones corporales.', false, 5],
            ['Conversatorio', 'Charlas, diálogos y encuentros críticos.', false, 6],
            ['Conferencia', 'Presentaciones académicas, artísticas o culturales.', false, 7],
            ['Concierto', 'Presentaciones musicales en vivo.', false, 8],
            ['Cena', 'Encuentros gastronómicos y cenas especiales.', false, 9],
            ['Cata', 'Catas de vino, mezcal u otras experiencias de degustación.', false, 10],
            ['Fiesta / Encuentro', 'Eventos sociales, fiestas y encuentros comunitarios.', false, 11],
        ];

        foreach ($activityTypes as [$name, $description, $isRecurring, $sortOrder]) {
            DB::table('activity_types')->updateOrInsert(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => $description,
                    'is_recurring' => $isRecurring,
                    'sort_order' => $sortOrder,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $spaces = [
            ['Galería Primer Piso', 'Espacio abierto para exposiciones y encuentros.', 'Primer piso', true, true, 1],
            ['Casa Canera Cuata', 'Réplica 1:1 y dispositivo curatorial dentro de Demina.', 'Primer piso', false, true, 2],
            ['Galería Piso 2', 'Segundo nivel expositivo del edificio.', 'Segundo piso', true, true, 3],
            ['Caja Negra', 'Espacio oscuro para cine, danza, proyección y microteatro.', 'Segundo piso', true, true, 4],
            ['Azotea', 'Terraza multifuncional para cine, conciertos, catas y encuentros.', 'Azotea', true, true, 5],
            ['Espacio Neutral', 'Área flexible para talleres, reuniones y actividades experimentales.', 'Variable', true, true, 6],
            ['La Taberna', 'Bar pequeño y punto de encuentro en la azotea.', 'Azotea', true, true, 7],
        ];

        foreach ($spaces as [$name, $subtitle, $floorLevel, $rental, $barter, $sortOrder]) {
            DB::table('spaces')->updateOrInsert(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'subtitle' => $subtitle,
                    'floor_level' => $floorLevel,
                    'rental_available' => $rental,
                    'barter_available' => $barter,
                    'is_active' => true,
                    'sort_order' => $sortOrder,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $equipment = [
            ['Sistema de bocinas', 'Equipo general de audio para eventos.', 1, true],
            ['Proyector general', 'Proyector móvil para distintos espacios.', 1, true],
            ['Proyector Caja Negra', 'Proyector propio de la Caja Negra.', 1, false],
            ['Bocina Bluetooth grande', 'Bocina portátil para actividades diversas.', 1, true],
            ['Sillas', 'Sillas disponibles para eventos, talleres y proyecciones.', 1, true],
            ['Iluminación', 'Equipo básico de iluminación.', 1, true],
            ['Pantalla', 'Pantalla para proyecciones.', 1, true],
            ['Barra', 'Barra para servicio en actividades.', 1, true],
            ['Mesas', 'Mesas de apoyo para talleres, cenas y eventos.', 1, true],
            ['Cocina equipada', 'Cocina disponible para cenas y actividades gastronómicas.', 1, true],
            ['Ventiladores', 'Ventiladores para uso general.', 1, true],
            ['Wifi', 'Conexión inalámbrica a internet.', 1, true],
        ];

        foreach ($equipment as [$name, $description, $quantity, $isGeneral]) {
            DB::table('equipment')->updateOrInsert(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => $description,
                    'quantity' => $quantity,
                    'is_general' => $isGeneral,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}