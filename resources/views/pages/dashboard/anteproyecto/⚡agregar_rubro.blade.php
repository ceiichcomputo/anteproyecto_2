<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Livewire\Traits\WithPermissions;
use Livewire\Attributes\Validate;
use App\Models\TAnteproyectos;
use App\Models\CatEjercicio;
use App\Models\TAnteproyectosRubro;
use App\Models\CatRubro;
use App\Models\CatCategoria;
use App\Models\CatSubcategoria;
use App\Models\CatTipoFinanciamiento;
use App\Models\CatTipoSolicitudes;
use App\Models\CatCategoriaAcademicas;
use App\Models\CatPais;
use App\Models\CatEstado;
use App\Models\TAnteproyectosRubrosBecarios;
use App\Models\TAnteproyectosRubrosComputos;
use App\Models\TAnteproyectosRubrosEventos;
use App\Models\TAnteproyectosRubrosFinExts;
use App\Models\TAnteproyectosRubrosInvitados;
use App\Models\TAnteproyectosRubrosOtrPets;
use App\Models\TAnteproyectosRubrosPromos;
use App\Models\TAnteproyectosRubrosViajes;
use App\Services\AnteproyectoRubroService;

new class extends Component
{
    use WithPermissions;
    use WithPagination;


    public $objAnteproyectoRubro;

    public $objAnteproyecto;
    public $ejercicio;

    public $catRubros = [];
    public $selectedRubro = '';

    public $catCategorias= [];
    public $selectedCategoria = '';

    public $catSubCategorias = [];
    public $selectedSubCategoria = '';
    public $objSubcategoriaAnterior = '';
    public $objSubcategoria = '';
    public $objSubcategoriaAEditar = '';

    public $modificar_monto_estimado = false;
    public $pueden_editar = true;
    public $cat_tipo_financiamientos = [];
    public $cat_tipo_solicitudes = [];
    public $cat_categoria_academicas = [];
    public $catPaises = [];
    public $catEstados = [];

    public function mount(?int $anteproyecto_id = null, ?int $rubro_id = null)
    {
        $this->checkPermission('anteproyecto.listar');

        if($anteproyecto_id){

            $this->objAnteproyecto = TAnteproyectos::findOrFail($anteproyecto_id);

            if($this->objAnteproyecto->id_usuario != auth()->id()){

                session()->flash('error', 'Por alguna razón, este Anteproyecto no te pertenece.');
                return $this->redirect('/dashboard');
            }

            $this->ejercicio = $this->objAnteproyecto->ejercicio->ejercicio;
            $this->cat_tipo_financiamientos = CatTipoFinanciamiento::orderBy('tipo_financiamiento', 'asc')->get();
            $this->cat_tipo_solicitudes = CatTipoSolicitudes::orderBy('tipo_solicitud', 'asc')->get();
            $this->cat_categoria_academicas = CatCategoriaAcademicas::orderBy('categoria_academica', 'asc')->get();
            $this->catRubros = CatRubro::orderBy('titulo', 'asc')->get();
            $this->catPaises = CatPais::orderBy('pais', 'asc')->get();

            // Inicialmente vacío
            $this->catCategorias = collect();

            ///BAMS TODO
            ///Si ya existe un rubro, buscar la subcategoría seleccionada y cargar su presupuesto estimado
            ///A partir de la subcategoría, seleccionar la categoria de la lista.
            if($rubro_id){
                $this->objAnteproyectoRubro = TAnteproyectosRubro::findOrFail($rubro_id);
                $this->selectedSubCategoria = $this->objAnteproyectoRubro->id_cat_subcategoria;
                $this->monto_estimado = $this->objAnteproyectoRubro->monto_estimado;
                $this->modificar_monto_estimado = $this->objAnteproyectoRubro->modificar_monto_estimado;

                $categoria = CatCategoria::findOrFail($this->objAnteproyectoRubro->subcategoria->id_categoria);
                $this->selectedCategoria = $categoria->id;

                $rubro = CatRubro::findOrFail($categoria->id_rubro);
                $this->selectedRubro = $rubro->id;

                // Cargar categorías y subcategorías para que se muestren en los select
                $this->catCategorias = CatCategoria::where('id_rubro', $rubro->id)->orderBy('categoria')->get();

                
                // Consultar subcategorías
                $this->catSubCategorias =
                    CatSubcategoria::where(
                        'id_categoria',
                        $this->selectedCategoria
                    )
                    ->orderBy('subcategoria')
                    ->get();


                $this->objSubcategoriaAEditar = CatSubcategoria::findOrFail($this->selectedSubCategoria);


                // Consultar subcategorías para obtener si se puede editar
                $this->objSubcategoriaAnterior = CatSubcategoria::findOrFail($this->selectedSubCategoria);
                $this->modificar_monto_estimado = $this->objSubcategoriaAnterior->modificar_monto_estimado;


                try{

                    switch ($this->selectedRubro) {

                        case '1': //Becarios
                
                            $this->obj_ant_rubro_becario = TAnteproyectosRubrosBecarios::where('id_anteproyecto_rubros', $rubro_id)->first();
                            $this->actividades_a_desarrollar = $this->obj_ant_rubro_becario->actividades_a_desarrollar;
                            $this->nombre_becario = $this->obj_ant_rubro_becario->nombre_becario;
                            $this->fecha_inicio = $this->obj_ant_rubro_becario->fecha_inicio_becario;
                            $this->fecha_final = $this->obj_ant_rubro_becario->fecha_fin_becario;
                            break;
                        case '2': //Computo
                            $this->obj_ant_rubro_computo = TAnteproyectosRubrosComputos::where('id_anteproyecto_rubros', $rubro_id)->first();
                            $this->justificacion_objeto_comprar = $this->obj_ant_rubro_computo->justificacion_objeto_comprar;
                            break;  
                        case '3': //Eventos
                            $this->obj_ant_rubro_evento = TAnteproyectosRubrosEventos::where('id_anteproyecto_rubros', $rubro_id)->first();
                            $this->nombre_evento = $this->obj_ant_rubro_evento->nombre_evento;
                            $this->descripcion_evento = $this->obj_ant_rubro_evento->descripcion_evento;
                            $this->fecha_inicio_evento = $this->obj_ant_rubro_evento->fecha_inicio_evento;
                            $this->fecha_fin_evento = $this->obj_ant_rubro_evento->fecha_fin_evento;
                            break;  
                        case '4': //Financiamiento externo
                            $this->obj_ant_rubro_fin_ext = TAnteproyectosRubrosFinExts::where('id_anteproyecto_rubros', $rubro_id)->first();
                            $this->id_tipo_financiamiento = $this->obj_ant_rubro_fin_ext->id_tipo_financiamiento;
                            $this->titulo_proyecto = $this->obj_ant_rubro_fin_ext->titulo_proyecto;
                            $this->nombre_dependencia = $this->obj_ant_rubro_fin_ext->nombre_dependencia;
                            $this->fecha_inicio_evento = $this->obj_ant_rubro_fin_ext->fecha_inicio_evento;
                            $this->fecha_fin_evento = $this->obj_ant_rubro_fin_ext->fecha_fin_evento;
                            $this->selected_tipo_financiamiento = $this->obj_ant_rubro_fin_ext->id_tipo_financiamiento;
                            break; 
                        case '5': //Invitados
                            $this->obj_ant_rubro_invitados = TAnteproyectosRubrosInvitados::where('id_anteproyecto_rubros', $rubro_id)->first();
                            $this->actividades_a_desarrollar = $this->obj_ant_rubro_invitados->actividades_a_desarrollar;
                            $this->descripcion_evento = $this->obj_ant_rubro_invitados->descripcion_evento;
                            $this->nombre_invitado = $this->obj_ant_rubro_invitados->nombre_invitado;
                            $this->procedencia_invitado = $this->obj_ant_rubro_invitados->procedencia_invitado;
                            $this->fecha_inicio_evento = $this->obj_ant_rubro_invitados->fecha_inicio_evento;
                            $this->fecha_fin_evento = $this->obj_ant_rubro_invitados->fecha_fin_evento;
                            break; 
                        case '6': //Otras peticiones
                            $this->obj_ant_rubro_otr_pets = TAnteproyectosRubrosOtrPets::where('id_anteproyecto_rubros', $rubro_id)->first();
                            $this->peticion = $this->obj_ant_rubro_otr_pets->peticion;
                            break; 
                        case '7': //Promociones
                            $this->obj_ant_rubro_promos = TAnteproyectosRubrosPromos::where('id_anteproyecto_rubros', $rubro_id)->first();
                            $this->id_tipo_solicitud = $this->obj_ant_rubro_promos->id_tipo_solicitud;
                            $this->id_categoria_academica = $this->obj_ant_rubro_promos->id_categoria_academica;
                            $this->descripcion_promocion = $this->obj_ant_rubro_promos->descripcion_promocion;
                            $this->fecha_inicio_promocion = $this->obj_ant_rubro_promos->fecha_inicio_promocion;
                            $this->fecha_fin_promocion = $this->obj_ant_rubro_promos->fecha_fin_promocion;
                            $this->selected_tipo_solicitud = $this->obj_ant_rubro_promos->id_tipo_solicitud;
                            $this->selected_categoria_academica = $this->obj_ant_rubro_promos->id_categoria_academica;
                            break; 
                        case '8': //Viajes
                            $this->obj_ant_rubro_viajes = TAnteproyectosRubrosViajes::where('id_anteproyecto_rubros', $rubro_id)->first();
                            $this->id_cat_estado = $this->obj_ant_rubro_viajes->id_cat_estado;
                            $this->lugar_institucion = $this->obj_ant_rubro_viajes->lugar_institucion;
                            $this->fecha_inicio_viaje = $this->obj_ant_rubro_viajes->fecha_inicio_viaje;
                            $this->fecha_fin_viaje = $this->obj_ant_rubro_viajes->fecha_fin_viaje;
                            $this->selected_estado = $this->obj_ant_rubro_viajes->id_estado;
                            break; 
                        }
                } catch (\Exception $e) {
                    dd($e->getMessage());
                    report($e->getMessage());

                    session()->flash(
                        'error',
                        'Ocurrió un error al Leer el Rubro, por favor intenta nuevamente.'
                    );
                }
                


            }

        }
    }

    public function updatedSelectedRubro()
    {
        // Resetear categoría
        $this->selectedCategoria = '';
        // Resetear subcategoría
        $this->selectedSubCategoria = '';
        $this->catSubCategorias = collect();

        // Si no seleccionó categoría
        if (!$this->selectedRubro) {
            $this->catCategorias = collect();
            return;
        }

        // Consultar categorías
        $this->catCategorias =
            CatCategoria::where(
                'id_rubro',
                $this->selectedRubro
            )
            ->orderBy('categoria')
            ->get();
        $this->modificar_monto_estimado = false;

    }

    public function updatedSelectedCategoria()
    {
        // Resetear subcategoría
        $this->selectedSubCategoria = '';

        // Si no seleccionó categoría
        if (!$this->selectedCategoria) {
            $this->catSubCategorias = collect();
            return;
        }

        // Consultar subcategorías
        $this->catSubCategorias =
            CatSubcategoria::where(
                'id_categoria',
                $this->selectedCategoria
            )
            ->orderBy('subcategoria')
            ->get();

        $this->monto_estimado = 0;
        $this->modificar_monto_estimado = false;

    }
    
    public function updatedSelectedSubCategoria()
    {
        // Si no seleccionó categoría
        if (!$this->selectedSubCategoria) {
            $this->monto_estimado = 0;
            return;
        }        

        // Consultar subcategorías
        $this->objSubcategoria = CatSubcategoria::findOrFail($this->selectedSubCategoria);

        $this->monto_estimado = $this->objSubcategoria->monto_estimado;
        $this->modificar_monto_estimado = $this->objSubcategoria->modificar_monto_estimado;
    }

    public function updatedSelectedPais()
    {
        // Resetear selectec_estado
        $this->selectedEstado = '';
        $this->catEstados = collect();

        // Si no seleccionó categoría
        if (!$this->selectedPais) {
            return;
        }

        // Consultar Estados
        $this->catEstados =
            CatEstado::where(
                'id_pais',
                $this->selectedPais
            )
            ->orderBy('estado')
            ->get();

    }

    
        /*
    |--------------------------------------------------------------------------
    | General
    |--------------------------------------------------------------------------
    */

    #[Validate('required', message: 'Favor de ingresar un presupuesto estimado')]
    #[Validate('numeric', message: 'El presupuesto estimado debe ser un número')]
    public $monto_estimado = 0;
    public $validacion = false;
   
        /*
    |--------------------------------------------------------------------------
    | Becarios
    |--------------------------------------------------------------------------
    */
    public $actividades_a_desarrollar;
    public $nombre_becario;
    public $fecha_inicio;
    public $fecha_final;

    public $obj_ant_rubro_becario;

        /*
    |--------------------------------------------------------------------------
    | Computo
    |--------------------------------------------------------------------------
    */

    public $justificacion_objeto_comprar;

    public $obj_ant_rubro_computo;

         /*
    |--------------------------------------------------------------------------
    | Eventos
    |--------------------------------------------------------------------------
    */
    public $nombre_evento;
    public $descripcion_evento;
    public $fecha_inicio_evento;
    public $fecha_fin_evento;

    public $obj_ant_rubro_evento;

        /*
    |--------------------------------------------------------------------------
    | Financiamiento externo
    |--------------------------------------------------------------------------
    */
    public $id_tipo_financiamiento;
    public $titulo_proyecto;
    public $nombre_dependencia;
    //public $fecha_inicio_evento;
    //public $fecha_fin_evento;

    public $selected_tipo_financiamiento = '';
    public $obj_ant_rubro_fin_ext;

    /*
    |--------------------------------------------------------------------------
    | Invitados
    |--------------------------------------------------------------------------
    */
    // public $actividades_a_desarrollar;
    // public $descripcion_evento;
    public $nombre_invitado;
    public $procedencia_invitado;
    //public $fecha_inicio_evento;
    //public $fecha_fin_evento;

    public $obj_ant_rubro_invitados;

    /*
    |--------------------------------------------------------------------------
    | Otras peticiones
    |--------------------------------------------------------------------------
    */
    public $peticion;

    public $obj_ant_rubro_otr_pets;

    /*
    |--------------------------------------------------------------------------
    | Promociones
    |--------------------------------------------------------------------------
    */
    public $id_tipo_solicitud;
    public $id_categoria_academica;
    public $descripcion_promocion;
    public $fecha_inicio_promocion;
    public $fecha_fin_promocion;

    public $selected_tipo_solicitud = '';
    public $selected_categoria_academica = '';
    public $obj_ant_rubro_promos;

    /*
    |--------------------------------------------------------------------------
    | Viajes
    |--------------------------------------------------------------------------
    */
    public $id_estado;
    public $lugar_institucion;
    public $fecha_inicio_viaje;
    public $fecha_fin_viaje;

    public $selectedPais = '';
    public $selectedEstado = '';
    public $obj_ant_rubro_viajes;


    function submit() {

        if(!$this->validaciones()){
                return;
        }

                    
        try{

            switch ($this->selectedRubro) {

                case '1': //Becarios


                    if($this->objAnteproyectoRubro){

                        DB::transaction(function () {
                            $this->objAnteproyectoRubro->update([
                                'id_cat_subcategoria' => $this->selectedSubCategoria,
                                'monto_estimado' => $this->monto_estimado,
                                'usuario_mod' => auth()->id()
                            ]);

                            $this->obj_ant_rubro_becario->update([
                                'actividades_a_desarrollar' => $this->actividades_a_desarrollar,
                                'nombre_becario' => $this->nombre_becario,
                                'fecha_inicio_becario' => $this->fecha_inicio,
                                'fecha_fin_becario' => $this->fecha_final
                            ]);

                            $this->mensaje = 'Rubro de Becarios actualizado correctamente';
                        });

                    }else{

                        DB::transaction(function () {

                            $this->objAnteproyectoRubro = TAnteproyectosRubro::create([
                                'id_anteproyecto' => $this->objAnteproyecto->id,
                                'id_cat_subcategoria' => $this->selectedSubCategoria,
                                'devengado' => false,
                                'monto_estimado' => $this->monto_estimado,
                                'usuario_ins' => auth()->id()
                            ]);

                            TAnteproyectosRubrosBecarios::create([
                                'id_anteproyecto_rubros' => $this->objAnteproyectoRubro->id,
                                'actividades_a_desarrollar' => $this->actividades_a_desarrollar,
                                'nombre_becario' => $this->nombre_becario,
                                'fecha_inicio_becario' => $this->fecha_inicio,
                                'fecha_fin_becario' => $this->fecha_final
                            ]);

                            $this->mensaje = 'Rubro de Becarios creado correctamente';
                        });

                    }                     

                    break;

                case '2': //Computo
                    if($this->objAnteproyectoRubro){

                        DB::transaction(function () {
                            $this->objAnteproyectoRubro->update([
                                'id_cat_subcategoria' => $this->selectedSubCategoria,
                                'monto_estimado' => $this->monto_estimado,
                                'usuario_mod' => auth()->id()
                            ]);

                            $this->obj_ant_rubro_computo->update([
                                'justificacion_objeto_comprar' => $this->justificacion_objeto_comprar,
                            ]);

                            $this->mensaje = 'Rubro de Computo actualizado correctamente';
                        });

                    }else{

                        DB::transaction(function () {

                            $this->objAnteproyectoRubro = TAnteproyectosRubro::create([
                                'id_anteproyecto' => $this->objAnteproyecto->id,
                                'id_cat_subcategoria' => $this->selectedSubCategoria,
                                'devengado' => false,
                                'monto_estimado' => $this->monto_estimado,
                                'usuario_ins' => auth()->id()
                            ]);

                            TAnteproyectosRubrosComputos::create([
                                'id_anteproyecto_rubros' => $this->objAnteproyectoRubro->id,
                                'justificacion_objeto_comprar' => $this->justificacion_objeto_comprar
                            ]);

                            $this->mensaje = 'Rubro de Computo creado correctamente';
                        });

                    }          

                    break;

                case '3': //Eventos


                    if($this->objAnteproyectoRubro){

                        DB::transaction(function () {
                            $this->objAnteproyectoRubro->update([
                                'id_cat_subcategoria' => $this->selectedSubCategoria,
                                'monto_estimado' => $this->monto_estimado,
                                'usuario_mod' => auth()->id()
                            ]);

                            $this->obj_ant_rubro_evento->update([
                                'nombre_evento' => $this->nombre_evento,
                                'descripcion_evento' => $this->descripcion_evento,
                                'fecha_inicio_evento' => $this->fecha_inicio_evento,
                                'fecha_fin_evento' => $this->fecha_fin_evento
                            ]);

                            $this->mensaje = 'Rubro de Eventos actualizado correctamente';
                        });

                    }else{

                        DB::transaction(function () {

                            $this->objAnteproyectoRubro = TAnteproyectosRubro::create([
                                'id_anteproyecto' => $this->objAnteproyecto->id,
                                'id_cat_subcategoria' => $this->selectedSubCategoria,
                                'devengado' => false,
                                'monto_estimado' => $this->monto_estimado,
                                'usuario_ins' => auth()->id()
                            ]);

                            TAnteproyectosRubrosEventos::create([
                                'id_anteproyecto_rubros' => $this->objAnteproyectoRubro->id,
                                'nombre_evento' => $this->nombre_evento,
                                'descripcion_evento' => $this->descripcion_evento,
                                'fecha_inicio_evento' => $this->fecha_inicio_evento,
                                'fecha_fin_evento' => $this->fecha_fin_evento
                            ]);

                            $this->mensaje = 'Rubro de Eventos creado correctamente';
                        });

                    }                     

                    break;

                case '4': //Financiamiento externo

                    if($this->objAnteproyectoRubro){

                        DB::transaction(function () {
                            $this->objAnteproyectoRubro->update([
                                'id_cat_subcategoria' => $this->selectedSubCategoria,
                                'monto_estimado' => $this->monto_estimado,
                                'usuario_mod' => auth()->id()
                            ]);

                            $this->obj_ant_rubro_fin_ext->update([
                                'id_tipo_financiamiento' => $this->selected_tipo_financiamiento,
                                'titulo_proyecto' => $this->titulo_proyecto,
                                'nombre_dependencia' => $this->nombre_dependencia,
                                'fecha_inicio_evento' => $this->fecha_inicio_evento,
                                'fecha_fin_evento' => $this->fecha_fin_evento
                            ]);

                            $this->mensaje = 'Rubro de Eventos actualizado correctamente';
                        });

                    }else{

                        DB::transaction(function () {

                            $this->objAnteproyectoRubro = TAnteproyectosRubro::create([
                                'id_anteproyecto' => $this->objAnteproyecto->id,
                                'id_cat_subcategoria' => $this->selectedSubCategoria,
                                'devengado' => false,
                                'monto_estimado' => $this->monto_estimado,
                                'usuario_ins' => auth()->id()
                            ]);

                            TAnteproyectosRubrosFinExts::create([
                                'id_anteproyecto_rubros' => $this->objAnteproyectoRubro->id,
                                'id_tipo_financiamiento' => $this->selected_tipo_financiamiento,
                                'titulo_proyecto' => $this->titulo_proyecto,
                                'nombre_dependencia' => $this->nombre_dependencia,
                                'fecha_inicio_evento' => $this->fecha_inicio_evento,
                                'fecha_fin_evento' => $this->fecha_fin_evento
                            ]);

                            $this->mensaje = 'Rubro de Financiamiento externo creado correctamente';
                        });

                    }                     

                    break;

                case '5':   //Invitados

                    if($this->objAnteproyectoRubro){

                        DB::transaction(function () {
                            $this->objAnteproyectoRubro->update([
                                'id_cat_subcategoria' => $this->selectedSubCategoria,
                                'monto_estimado' => $this->monto_estimado,
                                'usuario_mod' => auth()->id()
                            ]);

                            $this->obj_ant_rubro_invitados->update([
                                'actividades_a_desarrollar' => $this->actividades_a_desarrollar,
                                'descripcion_evento' => $this->descripcion_evento,
                                'nombre_invitado' => $this->nombre_invitado,
                                'procedencia_invitado' => $this->procedencia_invitado,
                                'fecha_inicio_evento' => $this->fecha_inicio_evento,
                                'fecha_fin_evento' => $this->fecha_fin_evento
                            ]);

                            $this->mensaje = 'Rubro de Invitados actualizado correctamente';
                        });

                    }else{

                        DB::transaction(function () {

                            $this->objAnteproyectoRubro = TAnteproyectosRubro::create([
                                'id_anteproyecto' => $this->objAnteproyecto->id,
                                'id_cat_subcategoria' => $this->selectedSubCategoria,
                                'devengado' => false,
                                'monto_estimado' => $this->monto_estimado,
                                'usuario_ins' => auth()->id()
                            ]);

                            TAnteproyectosRubrosInvitados::create([
                                'id_anteproyecto_rubros' => $this->objAnteproyectoRubro->id,
                                'actividades_a_desarrollar' => $this->actividades_a_desarrollar,
                                'descripcion_evento' => $this->descripcion_evento,
                                'nombre_invitado' => $this->nombre_invitado,
                                'procedencia_invitado' => $this->procedencia_invitado,
                                'fecha_inicio_evento' => $this->fecha_inicio_evento,
                                'fecha_fin_evento' => $this->fecha_fin_evento
                            ]);

                            $this->mensaje = 'Rubro de Invitados creado correctamente';
                        });

                    }                     

                    break;

                case '6':   //Otras peticiones

                    if($this->objAnteproyectoRubro){

                        DB::transaction(function () {
                            $this->objAnteproyectoRubro->update([
                                'id_cat_subcategoria' => $this->selectedSubCategoria,
                                'monto_estimado' => $this->monto_estimado,
                                'usuario_mod' => auth()->id()
                            ]);

                            $this->obj_ant_rubro_otr_pets->update([
                                'peticion' => $this->peticion
                            ]);

                            $this->mensaje = 'Rubro de Otras Peticiones actualizado correctamente';
                        });

                    }else{

                        DB::transaction(function () {

                            $this->objAnteproyectoRubro = TAnteproyectosRubro::create([
                                'id_anteproyecto' => $this->objAnteproyecto->id,
                                'id_cat_subcategoria' => $this->selectedSubCategoria,
                                'devengado' => false,
                                'monto_estimado' => $this->monto_estimado,
                                'usuario_ins' => auth()->id()
                            ]);

                            TAnteproyectosRubrosOtrPets::create([
                                'id_anteproyecto_rubros' => $this->objAnteproyectoRubro->id,
                                'peticion' => $this->peticion
                            ]);

                            $this->mensaje = 'Rubro de Otras Peticiones creado correctamente';
                        });

                    }                     

                    break;

                case '7': //Promociones

                    if($this->objAnteproyectoRubro){

                        DB::transaction(function () {
                            $this->objAnteproyectoRubro->update([
                                'id_cat_subcategoria' => $this->selectedSubCategoria,
                                'monto_estimado' => $this->monto_estimado,
                                'usuario_mod' => auth()->id()
                            ]);

                            $this->obj_ant_rubro_promos->update([
                                'id_tipo_solicitud' => $this->selected_tipo_solicitud,
                                'id_categoria_academica' => $this->selected_categoria_academica,
                                'descripcion_promocion' => $this->descripcion_promocion,
                                'fecha_inicio_promocion' => $this->fecha_inicio_promocion,
                                'fecha_fin_promocion' => $this->fecha_fin_promocion
                            ]);

                            $this->mensaje = 'Rubro de Promociones actualizado correctamente';
                        });

                    }else{

                        DB::transaction(function () {

                            $this->objAnteproyectoRubro = TAnteproyectosRubro::create([
                                'id_anteproyecto' => $this->objAnteproyecto->id,
                                'id_cat_subcategoria' => $this->selectedSubCategoria,
                                'devengado' => false,
                                'monto_estimado' => $this->monto_estimado,
                                'usuario_ins' => auth()->id()
                            ]);

                            TAnteproyectosRubrosPromos::create([
                                'id_anteproyecto_rubros' => $this->objAnteproyectoRubro->id,
                                'id_tipo_solicitud' => $this->selected_tipo_solicitud,
                                'id_categoria_academica' => $this->selected_categoria_academica,
                                'descripcion_promocion' => $this->descripcion_promocion,
                                'fecha_inicio_promocion' => $this->fecha_inicio_promocion,
                                'fecha_fin_promocion' => $this->fecha_fin_promocion
                            ]);

                            $this->mensaje = 'Rubro de Promociones creado correctamente';
                        });

                    }                     

                    break;

                case '8': //Viajes


                    if($this->objAnteproyectoRubro){

                        DB::transaction(function () {
                            $this->objAnteproyectoRubro->update([
                                'id_cat_subcategoria' => $this->selectedSubCategoria,
                                'monto_estimado' => $this->monto_estimado,
                                'usuario_mod' => auth()->id()
                            ]);

                            $this->obj_ant_rubro_viajes->update([
                                'id_estado' => $this->selectedEstado,
                                'lugar_institucion' => $this->lugar_institucion,
                                'fecha_inicio_viaje' => $this->fecha_inicio_viaje,
                                'fecha_fin_viaje' => $this->fecha_fin_viaje
                            ]);

                            $this->mensaje = 'Rubro de Viajes actualizado correctamente';
                        });

                    }else{

                        DB::transaction(function () {

                            $this->objAnteproyectoRubro = TAnteproyectosRubro::create([
                                'id_anteproyecto' => $this->objAnteproyecto->id,
                                'id_cat_subcategoria' => $this->selectedSubCategoria,
                                'devengado' => false,
                                'monto_estimado' => $this->monto_estimado,
                                'usuario_ins' => auth()->id()
                            ]);

                            TAnteproyectosRubrosViajes::create([
                                'id_anteproyecto_rubros' => $this->objAnteproyectoRubro->id,
                                'id_cat_estado' => $this->selectedEstado,
                                'lugar_institucion' => $this->lugar_institucion,
                                'fecha_inicio_viaje' => $this->fecha_inicio_viaje,
                                'fecha_fin_viaje' => $this->fecha_fin_viaje
                            ]);

                            $this->mensaje = 'Rubro de Viajes creado correctamente';
                        });

                    }                     

                    break;
            }

            session()->flash('success', $this->mensaje);
    
            return $this->redirect('/dashboard/anteproyecto/listado_rubro/' . $this->objAnteproyecto->id);

        } catch (\Exception $e) {
            report($e->getMessage());

            session()->flash(
                'error',
                'Ocurrió un error al actualizar el Rubro, por favor intenta nuevamente.'
            );
        }

    }

    private function validaciones(){

        $service = app(AnteproyectoRubroService::class);

        if($service->ValidaSiSePuedeAgregar($this->objAnteproyecto))
        {
            switch ($this->selectedRubro) {

                case '1': //Becarios

                    $this->validate([
                        'actividades_a_desarrollar' => 'required|string|max:3000','nombre_becario' => 'required|string|max:255', 'fecha_inicio' => 'required|date', 'fecha_final' => 'required|date'
                    ],[
                    'actividades_a_desarrollar.required' => 'Favor de ingresar las actividades a desarrollar',
                    'actividades_a_desarrollar.max' => 'La longitud máxima de las actividades a desarrollar es de 3000 caracteres',
                    'nombre_becario.required' => 'Favor de ingresar el nombre del becario',
                    'nombre_becario.max' => 'La longitud máxima del nombre del becario es de 255 caracteres',
                    'fecha_inicio.required' => 'Favor de ingresar la fecha de inicio',
                    'fecha_final.required' => 'Favor de ingresar la fecha de finalización',
                    ]);

                    break;
                    
                case '2': //Computo

                    $this->validate([
                        'justificacion_objeto_comprar' => 'required|string|max:3000'
                    ],[
                    'justificacion_objeto_comprar.required' => 'Favor de ingresar la justificación del objeto a comprar',
                    'justificacion_objeto_comprar.max' => 'La longitud máxima de la justificación del objeto a comprar es de 3000 caracteres',
                    ]);

                    break;
                    
                case '3': //Eventos

                    $this->validate([
                        'nombre_evento' => 'required|string|max:1000', 'descripcion_evento' => 'required|string|max:1000', 'fecha_inicio_evento' => 'required|date', 'fecha_fin_evento' => 'required|date'
                    ],[
                    'nombre_evento.required' => 'Favor de ingresar el nombre del evento',
                    'nombre_evento.max' => 'La longitud máxima del nombre del evento es de 1000 caracteres',
                    'descripcion_evento.required' => 'Favor de ingresar la descripción del evento',
                    'descripcion_evento.max' => 'La longitud máxima de la descripción del evento es de 1000 caracteres',
                    'fecha_inicio_evento.required' => 'Favor de ingresar la fecha de inicio del evento',
                    'fecha_fin_evento.required' => 'Favor de ingresar la fecha de finalización del evento',
                    ]);

                    break;
                    
                case '4': //Financiamiento externo

                    $this->validate([
                        'selected_tipo_financiamiento' => 'required', 'titulo_proyecto' => 'required|string|max:1000', 'nombre_dependencia' => 'required|string|max:1000', 'fecha_inicio_evento' => 'required|date', 'fecha_fin_evento' => 'required|date'
                    ],[
                    'selected_tipo_financiamiento.required' => 'Favor de seleccionar el tipo de financiamiento',
                    'titulo_proyecto.required' => 'Favor de ingresar el título del proyecto',
                    'titulo_proyecto.max' => 'La longitud máxima del título del proyecto es de 1000 caracteres',
                    'nombre_dependencia.required' => 'Favor de ingresar el nombre de la dependencia',
                    'nombre_dependencia.max' => 'La longitud máxima del nombre de la dependencia es de 1000 caracteres',
                    'fecha_inicio_evento.required' => 'Favor de ingresar la fecha de inicio del evento',
                    'fecha_fin_evento.required' => 'Favor de ingresar la fecha de finalización del evento',
                    ]);

                    break;
                    
                case '5': //Invitados

                    $this->validate([
                        'actividades_a_desarrollar' => 'required|string|max:3000', 'descripcion_evento' => 'required|string|max:3000', 'nombre_invitado' => 'required|string|max:1000', 'procedencia_invitado' => 'required|string|max:1000', 'fecha_inicio_evento' => 'required|date', 'fecha_fin_evento' => 'required|date'
                    ],[
                    'actividades_a_desarrollar.required' => 'Favor de ingresar las actividades a desarrollar',
                    'actividades_a_desarrollar.max' => 'La longitud máxima de las actividades a desarrollar es de 3000 caracteres',
                    'descripcion_evento.required' => 'Favor de ingresar la descripción del evento',
                    'descripcion_evento.max' => 'La longitud máxima de la descripción del evento es de 3000 caracteres',
                    'nombre_invitado.required' => 'Favor de ingresar el nombre del invitado',
                    'nombre_invitado.max' => 'La longitud máxima del nombre del invitado es de 1000 caracteres',
                    'procedencia_invitado.required' => 'Favor de ingresar la procedencia del invitado',
                    'procedencia_invitado.max' => 'La longitud máxima de la procedencia del invitado es de 1000 caracteres',
                    'fecha_inicio_evento.required' => 'Favor de ingresar la fecha de inicio del evento',
                    'fecha_fin_evento.required' => 'Favor de ingresar la fecha de finalización del evento',
                    ]);

                    break;
                    
                case '6': //Otras Peticiones

                    $this->validate([
                        'peticion' => 'required|string|max:1000'
                    ],[
                    'peticion.required' => 'Favor de ingresar la petición',
                    'peticion.max' => 'La longitud máxima de la petición es de 3000 caracteres',
                    ]);

                    break;
                    
                case '7': //Promociones

                    $this->validate([
                        'selected_tipo_solicitud' => 'required', 'selected_categoria_academica' => 'required', 'descripcion_promocion' => 'required|string|max:1000', 'fecha_inicio_promocion' => 'required|date', 'fecha_fin_promocion' => 'required|date'
                    ],[
                    'selected_tipo_solicitud.required' => 'Favor de seleccionar el tipo de solicitud',
                    'selected_categoria_academica.required' => 'Favor de seleccionar la categoría académica',
                    'descripcion_promocion.required' => 'Favor de ingresar la descripción de la promoción',
                    'descripcion_promocion.max' => 'La longitud máxima de la descripción de la promoción es de 3000 caracteres',
                    'fecha_inicio_promocion.required' => 'Favor de ingresar la fecha de inicio de la promoción',
                    'fecha_fin_promocion.required' => 'Favor de ingresar la fecha de finalización de la promoción',
                    ]);

                    break;
                    
                case '8': //Viajes

                    $this->validate([
                        'selectedPais' => 'required', 'selectedEstado' => 'required', 'lugar_institucion' => 'required|string|max:255', 'fecha_inicio_viaje' => 'required|date', 'fecha_fin_viaje' => 'required|date'
                    ],[
                    'selectedPais.required' => 'Favor de seleccionar el país',
                    'selectedEstado.required' => 'Favor de seleccionar el estado',
                    'lugar_institucion.required' => 'Favor de ingresar el lugar de la institución',
                    'descripcion_promocion.max' => 'La longitud máxima del lugar de la institución es de 255 caracteres',
                    'fecha_inicio_viaje.required' => 'Favor de ingresar la fecha de inicio del viaje',
                    'fecha_fin_viaje.required' => 'Favor de ingresar la fecha de finalización del viaje',
                    ]);

                    break;

            }
        }
        else{
            session()->flash('error', "Ya no se puede realizar el guardado de este Rubro porque el Anteproyecto está concluido o se encuentra fuera de tiempo establecido");
            return false;
        }
        return true;
    }

    public function regresar()
    {
        return $this->redirect('/dashboard/anteproyecto/listado_rubro/' . $this->objAnteproyecto->id);
    }
};
?>



<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Anteproyecto del ejercicio: ' . $this->ejercicio) }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Rubros') }}</flux:subheading>
        <flux:button type="button" wire:click="regresar" wire:confirm="Se perderán todos los cambios, ¿Deseas continuar?">Regresar</flux:button>
        <flux:separator variant="subtle" />
    </div>

    @if(session()->has('error'))
        <div 
            x-init="setTimeout(() => show = false, 3000)"
            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div style="display: flex; justify-content: center;">
        <div style="width: 50%; padding: 1rem;">

            <div style="background-color: #eae7e0; color: #d04a31; padding: 1rem; justify-content: center;">
                <h3 style="font-size: 38px;">Nuevo registro</h3>
            </div>

            <flux:select label="Rubros" wire:model.live="selectedRubro">
                <flux:select.option value="">Selecciona el rubro</flux:select.option>
                    @foreach($catRubros as $rubro)
                        <flux:select.option value="{{ $rubro->id }}">
                            {{ $rubro->titulo }}
                        </flux:select.option>
                    @endforeach
            </flux:select>

            <flux:select label="Categorias" wire:model.live="selectedCategoria">
                <flux:select.option :disabled="!$this->selectedRubro" value="">Selecciona la categoria</flux:select.option>
                    @foreach($catCategorias as $categoria)
                        <flux:select.option value="{{ $categoria->id }}">
                            {{ $categoria->categoria }}
                        </flux:select.option>
                    @endforeach
            </flux:select>

            <flux:select label="Subcategorías" wire:model.live="selectedSubCategoria">
                <flux:select.option :disabled="!$this->selectedCategoria" value="">Selecciona la subcategoria</flux:select.option>
                    @foreach($catSubCategorias as $subcategoria)
                        <flux:select.option value="{{ $subcategoria->id }}">
                            {{ $subcategoria->subcategoria }}
                        </flux:select.option>
                    @endforeach
            </flux:select>


            {{-- FORMULARIOS DINAMICOS --}}
            <form wire:submit.prevent="submit">
                @if($selectedRubro == 1 && $selectedSubCategoria)
                    @include(
                        'pages.dashboard.forms.becarios'
                    )
                @endif

                @if($selectedRubro == 2 && $selectedSubCategoria)
                    @include(
                        'pages.dashboard.forms.computo'
                    )
                @endif

                @if($selectedRubro == 3 && $selectedSubCategoria)
                    @include(
                        'pages.dashboard.forms.eventos'
                    )
                @endif

                @if($selectedRubro == 4 && $selectedSubCategoria)
                    @include(
                        'pages.dashboard.forms.financ_externo'
                    )
                @endif

                @if($selectedRubro == 5 && $selectedSubCategoria)
                    @include(
                        'pages.dashboard.forms.invitados'
                    )
                @endif

                @if($selectedRubro == 6 && $selectedSubCategoria)
                    @include(
                        'pages.dashboard.forms.otras_peticiones'
                    )
                @endif

                @if($selectedRubro == 7 && $selectedSubCategoria)
                    @include(
                        'pages.dashboard.forms.promociones'
                    )
                @endif

                @if($selectedRubro == 8 && $selectedSubCategoria)
                    @include(
                        'pages.dashboard.forms.viajes'
                    )
                @endif

                {{-- BOTON --}}
                @if($selectedSubCategoria)
                    <div class="mt-6 flex justify-end">
                        <button
                            type="submit"
                            class="bg-blue-500 hover:bg-blue-400 text-gray px-5 py-2 rounded"
                        >
                            Guardar
                        </button>
                    </div>

                @endif

            </form>

        </div>
    </div>
</div>