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
use App\Models\TAnteproyectosRubrosBecarios;
use App\Models\TAnteproyectosRubrosComputos;

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

    public function mount(?int $anteproyecto_id = null, ?int $rubro_id = null)
    {
        $this->checkPermission('anteproyecto.listar');

        if($anteproyecto_id){

            $this->objAnteproyecto = TAnteproyectos::findOrFail($anteproyecto_id);
            $this->ejercicio = $this->objAnteproyecto->ejercicio->ejercicio;


            $this->catRubros = CatRubro::orderBy('titulo', 'asc')
                ->get();

            // Inicialmente vacío
            $this->catCategorias = collect();

            ///BAMS TODO
            ///Si ya existe un rubro, buscar la subcategoría seleccionada y cargar su monto estimado
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


                        }
                } catch (\Exception $e) {
                    dd($e->getMessage());
                    report($e->getMessage());

                    session()->flash(
                        'error',
                        'Ocurrió un error al actualizar el Rubro, por favor intenta nuevamente.'
                    );
                }
                


            }

        }
    }

    public function updatedSelectedRubro()
    {
        // Resetear subcategoría
        $this->selectedCategoria = '';

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
        $this->objSubcategoria =
            CatSubcategoria::findOrFail($this->selectedSubCategoria);

        $this->monto_estimado = $this->objSubcategoria->monto_estimado;
        $this->modificar_monto_estimado = $this->objSubcategoria->modificar_monto_estimado;
    }

    
        /*
    |--------------------------------------------------------------------------
    | General
    |--------------------------------------------------------------------------
    */

    #[Validate('required', message: 'Favor de ingresar un monto estimado')]
    #[Validate('numeric', message: 'El monto estimado debe ser un número')]
    public $monto_estimado = 0;
   
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
    | DOCENCIA
    |--------------------------------------------------------------------------
    */

    public $curso;

    public $horas;

    public $institucion;

    public $mensaje = '';

    public $validacion = false;


    function submit() {

        if(!$this->validaciones())
        return;
                    
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

                case 'equipo':

                    // Guardar equipo

                    break;

                case 'eventos':

                    // Guardar eventos

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
        switch ($this->selectedRubro) {

            case '1': //Becarios

                $this->validate([
                    'actividades_a_desarrollar' =>
                        'required|string|max:255',
                    'nombre_becario' =>
                        'required|string|max:255',
                    'fecha_inicio' =>
                        'required|date',
                    'fecha_final' =>
                        'required|date'
                ],[
                'actividades_a_desarrollar.required' => 'Favor de ingresar las actividades a desarrollar',
                'actividades_a_desarrollar.max' => 'La longitud máxima de las actividades a desarrollar es de 255 caracteres',
                'nombre_becario.required' => 'Favor de ingresar el nombre del becario',
                'nombre_becario.max' => 'La longitud máxima del nombre del becario es de 255 caracteres',
                'fecha_inicio.required' => 'Favor de ingresar la fecha de inicio',
                'fecha_final.required' => 'Favor de ingresar la fecha de finalización',
                ]);

                break;
                
            case '2': //Computo

                $this->validate([
                    'justificacion_objeto_comprar' =>
                        'required|string|max:255'
                ],[
                'justificacion_objeto_comprar.required' => 'Favor de ingresar la justificación del objeto a comprar',
                'justificacion_objeto_comprar.max' => 'La longitud máxima de la justificación del objeto a comprar es de 255 caracteres',
                ]);

                break;
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
        <flux:subheading size="lg" class="mb-6">{{ __('Administrar') }}</flux:subheading>
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
        @if($selectedRubro)
            <div class="mt-6 flex justify-end">
                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded"
                >
                    Guardar
                </button>
            </div>

        @endif

    </form>
</div>