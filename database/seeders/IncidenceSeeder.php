<?php

namespace Database\Seeders;

use App\Models\Incidence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncidenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Incidence::create([
            'title' => 'Error en la autenticación',
            'description' => 'Los usuarios no pueden iniciar sesión desde la actualización reciente.',
            'status' => 'todo',
            'user_id' => 2
        ]);

        Incidence::create([
            'title' => 'Problema de carga en la página principal',
            'description' => 'La página principal se carga lentamente cuando se reciben múltiples peticiones.',
            'status' => 'todo',
            'user_id' => 3
        ]);

        Incidence::create([
            'title' => 'Corrección de error en el cálculo de facturación',
            'description' => 'La facturación mensual se calcula incorrectamente debido a una actualización en el sistema.',
            'status' => 'todo',
            'user_id' => 2
        ]);

        Incidence::create([
            'title' => 'Ajuste de permisos de usuario',
            'description' => 'Algunos usuarios tienen acceso a áreas restringidas debido a un problema en los roles.',
            'status' => 'doing',
            'user_id' => 2
        ]);

        Incidence::create([
            'title' => 'Optimización de base de datos',
            'description' => 'Es necesario optimizar consultas en la base de datos para mejorar el rendimiento del sistema.',
            'status' => 'doing',
            'user_id' => 2
        ]);

        Incidence::create([
            'title' => 'Solución de error en reportes',
            'description' => 'El módulo de reportes genera resultados incorrectos en el formato PDF.',
            'status' => 'done',
            'user_id' => 3
        ]);

        Incidence::create([
            'title' => 'Fallo de notificaciones por email',
            'description' => 'Las notificaciones por email no se envían debido a problemas en la configuración del servidor SMTP.',
            'status' => 'todo',
            'user_id' => 3
        ]);

        Incidence::create([
            'title' => 'Actualización de seguridad crítica',
            'description' => 'Aplicar parche de seguridad para cerrar vulnerabilidad en el sistema de autenticación.',
            'status' => 'doing',
            'user_id' => 2
        ]);

        Incidence::create([
            'title' => 'Fallo en el proceso de exportación de datos',
            'description' => 'La exportación de datos a CSV no se completa en algunos registros.',
            'status' => 'todo',
            'user_id' => 2
        ]);

        Incidence::create([
            'title' => 'Análisis de rendimiento del servidor',
            'description' => 'El servidor experimenta alta carga durante el horario pico, afectando el rendimiento del sistema.',
            'status' => 'done',
            'user_id' => 3
        ]);

    }
}
