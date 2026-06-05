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
    public $objSubcategoria = '';
    public $objSubcategoriaAEditar = '';

    public $modificar_monto_estimado = false;
    public $pueden_editar = false;
    public $cat_tipo_financiamientos = [];
    public $cat_tipo_solicitudes = [];
    public $cat_categoria_academicas = [];
    public $catPaises = [];
    public $catEstados = [];
    public $selectedPais = '';
    public $selectedEstado = '';

    public function mount(?int $anteproyecto_id = null, ?int $rubro_id = null)
    {
        $this->checkPermission('anteproyecto.listar');

        if($anteproyecto_id){

            $this->objAnteproyecto = TAnteproyectos::findOrFail($anteproyecto_id);
            $this->ejercicio = $this->objAnteproyecto->ejercicio->ejercicio;


            $this->cat_tipo_financiamientos = CatTipoFinanciamiento::orderBy('tipo_financiamiento', 'asc')->get();
            $this->cat_tipo_solicitudes = CatTipoSolicitudes::orderBy('tipo_solicitud', 'asc')->get();
            $this->cat_categoria_academicas = CatCategoriaAcademicas::orderBy('categoria_academica', 'asc')->get();
            $this->catRubros = CatRubro::orderBy('titulo', 'asc')->get();

            // Inicialmente vacío
            $this->catCategorias = collect();

            ///BAMS TODO
            ///Si ya existe un rubro, buscar la subcategoría seleccionada y cargar su monto estimado
            ///A partir de la subcategoría, seleccionar la categoria de la lista.
            if($rubro_id){
                $this->objAnteproyectoRubro = TAnteproyectosRubro::findOrFail($rubro_id);
                $this->selectedSubCategoria = $this->objAnteproyectoRubro->id_cat_subcategoria;
                $this->monto_estimado = $this->objAnteproyectoRubro->monto_estimado;

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

                            // dd($this->obj_ant_rubro_viajes->estado->pais->id);

                            $this->catPaises = CatPais::where('id', $this->obj_ant_rubro_viajes->estado->pais->id)->get();
                            $this->selectedPais = $this->obj_ant_rubro_viajes->estado->pais->id;
                            $this->catEstados = CatEstado::where('id', $this->obj_ant_rubro_viajes->id_cat_estado)->get();
                            $this->selectedEstado = $this->obj_ant_rubro_viajes->id_cat_estado;
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

    

    
        /*
    |--------------------------------------------------------------------------
    | General
    |--------------------------------------------------------------------------
    */
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

    public $obj_ant_rubro_viajes;


    public function regresar()
    {
        return $this->redirect('/dashboard/anteproyecto/listado_rubro/' . $this->objAnteproyecto->id);
    }
};
?>



<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Anteproyecto del ejercicio: ' . $this->ejercicio) }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Administrar') }}</flux:subheading>
        <flux:button type="button" wire:click="regresar">Regresar</flux:button>
        <flux:separator variant="subtle" />
    </div>

    @if(session()->has('error'))
        <div 
            x-init="setTimeout(() => show = false, 3000)"
            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

        <flux:select label="Rubros" :disabled="true" wire:model.live="selectedRubro">
            <flux:select.option value="">Selecciona el rubro</flux:select.option>
                @foreach($catRubros as $rubro)
                    <flux:select.option value="{{ $rubro->id }}">
                        {{ $rubro->titulo }}
                    </flux:select.option>
                @endforeach
        </flux:select>

        <flux:select label="Categorias" :disabled="true" wire:model.live="selectedCategoria">
            <flux:select.option :disabled="!$this->selectedRubro" value="">Selecciona la categoria</flux:select.option>
                @foreach($catCategorias as $categoria)
                    <flux:select.option value="{{ $categoria->id }}">
                        {{ $categoria->categoria }}
                    </flux:select.option>
                @endforeach
        </flux:select>

        <flux:select label="Subcategorías" :disabled="true" wire:model.live="selectedSubCategoria">
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

    </form>
</div>