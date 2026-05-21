<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DeminaContentSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['Agenda', 'agenda', 'event', 'Eventos y programación general de Demina.', '#111111', 1],
            ['Cineclub', 'cineclub', 'event', 'Proyecciones, ciclos y funciones especiales.', '#111111', 2],
            ['Talleres', 'talleres', 'workshop', 'Procesos formativos, laboratorios y talleres.', '#111111', 3],
            ['Exposiciones', 'exposiciones', 'exhibition', 'Muestras individuales, colectivas y experimentales.', '#111111', 4],
            ['Archivo', 'archivo', 'archive', 'Material documental, memoria visual y registros del espacio.', '#111111', 5],
            ['Prensa', 'prensa', 'press', 'Notas, menciones y publicaciones sobre Demina.', '#111111', 6],
            ['Espacios', 'espacios', 'space', 'Áreas físicas y dispositivos del laboratorio.', '#111111', 7],
            ['General', 'general', 'general', 'Contenido general del sitio.', '#111111', 8],
        ];

        foreach ($categories as [$name, $slug, $type, $description, $color, $sortOrder]) {
            DB::table('categories')->updateOrInsert(
                ['slug' => $slug],
                [
                    'name' => $name,
                    'type' => $type,
                    'description' => $description,
                    'color' => $color,
                    'sort_order' => $sortOrder,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $tags = [
            'arte contemporáneo',
            'cine',
            'taller',
            'comunidad',
            'experimental',
            'Acapulco',
            'Guerrero',
            'autogestión',
            'archivo',
            'performance',
            'sonido',
            'cuerpo',
            'territorio',
        ];

        foreach ($tags as $tag) {
            DB::table('tags')->updateOrInsert(
                ['slug' => Str::slug($tag)],
                [
                    'name' => $tag,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $pages = [
            [
                'title' => 'Inicio',
                'slug' => 'inicio',
                'template' => 'home',
                'excerpt' => 'Demina Laboratorio de Artes: espacio autogestionado para creación, exhibición y experimentación contemporánea en Acapulco.',
                'body' => '<p>Demina es un laboratorio de artes, autogestionado para la creación y experimentación de arte contemporáneo. Es galería, cineclub, espacio de encuentro, taller, archivo vivo y plataforma comunitaria.</p>',
                'seo_title' => 'Demina Laboratorio de Artes',
                'seo_description' => 'Laboratorio autogestionado de artes contemporáneas en Acapulco, Guerrero.',
            ],
            [
                'title' => 'Nosotros',
                'slug' => 'nosotros',
                'template' => 'about',
                'excerpt' => 'Un espacio abierto, crítico, experimental, comunitario e irreverente.',
                'body' => '<p>Demina es un espacio independiente en Acapulco dedicado a activar procesos de creación, exhibición, formación, archivo y convivencia alrededor del arte contemporáneo.</p>',
                'seo_title' => 'Nosotros | Demina',
                'seo_description' => 'Conoce qué es Demina Laboratorio de Artes y su trabajo en Acapulco.',
            ],
            [
                'title' => 'Espacios',
                'slug' => 'espacios',
                'template' => 'spaces',
                'excerpt' => 'Galerías, caja negra, azotea, taberna y dispositivos curatoriales.',
                'body' => '<p>Demina se organiza como un conjunto de espacios flexibles para exposiciones, talleres, cine, danza, microteatro, conciertos, catas, encuentros y procesos experimentales.</p>',
                'seo_title' => 'Espacios | Demina',
                'seo_description' => 'Conoce los espacios físicos y dispositivos de Demina Laboratorio de Artes.',
            ],
            [
                'title' => 'Agenda',
                'slug' => 'agenda',
                'template' => 'default',
                'excerpt' => 'Consulta la programación de eventos, talleres, cineclub y exposiciones.',
                'body' => '<p>Agenda de actividades, exposiciones, talleres, cineclub, encuentros y eventos especiales de Demina.</p>',
                'seo_title' => 'Agenda | Demina',
                'seo_description' => 'Programación de actividades de Demina Laboratorio de Artes.',
            ],
            [
                'title' => 'Archivo',
                'slug' => 'archivo',
                'template' => 'archive',
                'excerpt' => 'Memoria visual, registros, documentos y materiales del laboratorio.',
                'body' => '<p>El archivo de Demina reúne registros, imágenes, documentos, prensa, piezas audiovisuales y materiales derivados de sus procesos artísticos y comunitarios.</p>',
                'seo_title' => 'Archivo | Demina',
                'seo_description' => 'Archivo multimedia y documental de Demina Laboratorio de Artes.',
            ],
            [
                'title' => 'Contacto',
                'slug' => 'contacto',
                'template' => 'contact',
                'excerpt' => 'Contacto, ubicación y redes sociales de Demina.',
                'body' => '<p>Escríbenos para propuestas, colaboraciones, visitas, talleres, exposiciones o uso de espacios.</p>',
                'seo_title' => 'Contacto | Demina',
                'seo_description' => 'Contacta a Demina Laboratorio de Artes en Acapulco.',
            ],
        ];

        foreach ($pages as $page) {
            DB::table('pages')->updateOrInsert(
                ['slug' => $page['slug']],
                [
                    'title' => $page['title'],
                    'template' => $page['template'],
                    'excerpt' => $page['excerpt'],
                    'body' => $page['body'],
                    'status' => 'published',
                    'seo_title' => $page['seo_title'],
                    'seo_description' => $page['seo_description'],
                    'published_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}