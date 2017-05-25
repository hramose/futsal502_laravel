<?php

use Illuminate\Database\Seeder;

use App\App\Entities\Perfil;
use App\App\Entities\User;
use App\App\Entities\Liga;
use App\App\Entities\Campeonato;
use App\App\Entities\Pais;
use App\App\Entities\Persona;
use App\App\Entities\Equipo;
use App\App\Entities\CampeonatoEquipo;
use App\App\Entities\Jornada;
use App\App\Entities\Domo;
use App\App\Entities\Evento;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $perfil = Perfil::create([
    		'descripcion' => 'Super Administrador',
    		'estado' => 'A',
    		'created_by' => 'admin',
        	'updated_by' => 'admin'
    	]);

        $user = User::create([
        	'username' => 'admin',
        	'password' => 'admin',
        	'perfil_id' => $perfil->id,
        	'estado' => 'A',
        	'created_by' => 'admin',
        	'updated_by' => 'admin'
        ]);

        $liga = Liga::create([
        	'descripcion' => 'Liga Mayor',
            'orden' => 1,
            'mostrar_app' => 1,
        	'estado' => 'A',
        	'created_by' => 'admin',
        	'updated_by' => 'admin'
        ]);

        $campeonato = Campeonato::create([
        	'descripcion' => 'Torneo 2017-2018',
        	'fecha_inicio' => '2017-07-04',
        	'fecha_fin' => '2018-05-05',
        	'liga_id' => $liga->id,
            'actual' => 1,
            'mostrar_app' => 1,
            'hashtag' => '#Futsal502',
        	'estado' => 'A',
        	'created_by' => 'admin',
        	'updated_by' => 'admin'
        ]);

        $pais = Pais::create([
        	'descripcion' => 'Guatemala',
        	'estado' => 'A',
        	'created_by' => 'admin',
        	'updated_by' => 'admin'
        ]);

        $jugadores = factory(\App\App\Entities\Persona::class, 20)
                            ->states('jugador')->create();

        $tecnicos = factory(\App\App\Entities\Persona::class, 10)
                            ->states('director_tecnico')->create();

        $arbitros = factory(\App\App\Entities\Persona::class, 10)
                            ->states('arbitro')->create();

        $equipos = array(
                            ['FSC Legendarios','Legendarios','LEG'],
                            ['Glucosoral FSC','Glucosoral','GLU'],
                            ['Deportivo Dynamo','Dynamo','DYN'],
                            ['Hansport','Hansport','HAN'],
                            ['Alianza','Alianza','ALI'],
                            ['Linces Salvavidas','Linces','LIN'],
                            ['Farmaceuticos','Farmaceuticos','FAR'],
                            ['Total Pro','Total Pro','TOT'],
                            ['Tellioz','Tellioz','TEL'],
                            ['Sports Gel','Sports Gel','SPG']
                        );
        foreach($equipos as $equipo){
            $e = Equipo::create([
                    'descripcion' => $equipo[0],
                    'descripcion_corta' => $equipo[1],
                    'siglas' => $equipo[2],
                    'logo' => 'equipos/logo.png',
                    'estado' => 'A',
                    'created_by' => 'admin',
                    'updated_by' => 'admin'
                ]);

            CampeonatoEquipo::create([
                'equipo_id' => $e->id,
                'campeonato_id' => $campeonato->id,
                'created_by' => 'admin',
                'updated_by' => 'admin'
            ]);

        }

        for($i=1;$i<20;$i++)
        {
            Jornada::create([
                'descripcion' => 'Jornada ' . $i,
                'fase' => 'R',
                'numero' => $i,
                'estado' => 'A',
                'created_by' => 'admin',
                'updated_by' => 'admin'
            ]);
        }

        $jornadasFinales = array(
            ['Pre-Semifinales 1',101],
            ['Pre-Semifinales 2',102],
            ['Pre-Semifinales 3',103],
            ['Semifinales 1',201],
            ['Semifinales 2',201],
            ['Semifinales 3',202],
            ['Final',300],
        );

        foreach($jornadasFinales as $jornada)
        {
            Jornada::create([
                'descripcion' => $jornada[0],
                'fase' => 'F',
                'numero' => $jornada[1],
                'estado' => 'A',
                'created_by' => 'admin',
                'updated_by' => 'admin'
            ]);
        }

        Domo::create([
                'descripcion' => 'Domo Polideportivo Zona 13',
                'direccion' => 'Zona 13',
                'imagen' => 'domos/1.png',
                'latitud' => 14.5944239,
                'longitud' => -90.5347653,
                'estado' => 'A',
                'created_by' => 'admin',
                'updated_by' => 'admin'
            ]);

        Domo::create([
                'descripcion' => 'Domo TIGO',
                'direccion' => 'Zona 11',
                'imagen' => 'domos/2.png',
                'latitud' => 14.6160934,
                'longitud' => -90.5525402,
                'estado' => 'A',
                'created_by' => 'admin',
                'updated_by' => 'admin'
            ]);

        Domo::create([
                'descripcion' => 'Teodoro Palacios Flores',
                'direccion' => 'Zona 5',
                'imagen' => 'domos/3.png',
                'latitud' => 14.6231532,
                'longitud' => -90.51203,
                'estado' => 'A',
                'created_by' => 'admin',
                'updated_by' => 'admin'
            ]);

        $eventos = array(
            [1,'Alineacion','editar_alineacion','editar_alineacion','nada.png',0],
            [2,'Inicio Partido','agregar_evento_partido','editar_evento_partido','silbato.png',1],
            [3,'Fin Primer Tiempo','agregar_evento_partido','editar_evento_partido','silbato.png',1],
            [4,'Inicio Segundo Tiempo','agregar_evento_partido','editar_evento_partido','silbato.png',1],
            [5,'Fin de Partido','agregar_evento_partido','editar_evento_partido','silbato.png',1],
            [6,'Gol','agregar_evento_partido_persona','editar_evento_partido_persona','gol.png',1],
            [7,'Autogol','agregar_evento_partido_persona','editar_evento_partido_persona','gol.png',1],
            [8,'Amarilla','agregar_evento_partido_persona','editar_evento_partido_persona','amarilla.png',1],
            [9,'Roja','agregar_evento_partido_persona','editar_evento_partido_persona','roja.png',1],
            [10,'Comentario','agregar_evento_partido','editar_evento_partido','comentario.pn',1],
            [11,'Inicia Primer Tiempo Extra','agregar_evento_partido','editar_evento_partido','silbato.png',1],
            [12,'Fin Primer Tiempo Extra','agregar_evento_partido','editar_evento_partido','silbato.png',1],
            [13,'Inicio Segundo Tiempo Extra','agregar_evento_partido','editar_evento_partido','silbato.png',1]
        );

        foreach($eventos as $evento)
        {
            Evento::create([
                'id'                => $evento[0],
                'descripcion'       => $evento[1],
                'ruta_agregar'      => $evento[2],
                'ruta_editar'       => $evento[3],
                'imagen'            => $evento[4],
                'mostrar_en_vivo'   => $evento[5],
                'estado'            => 'A',
                'created_by'        => 'admin',
                'updated_by'        => 'admin'
            ]);
        }


        
    }
}
