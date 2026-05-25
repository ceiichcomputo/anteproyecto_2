<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Livewire\Traits\WithPermissions;
use Livewire\Attributes\Validate;
use App\Models\TAnteproyectos;
use App\Models\CatEjercicio;
use App\Models\TAnteproyectosRubro;
use App\Models\TAnteproyectosRubrosBecarios;
use App\Models\CatRubro;
use App\Models\CatCategoria;
use App\Models\CatSubcategoria;

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

    public function mount(?int $anteproyecto_id = null)
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
    | Becarios
    |--------------------------------------------------------------------------
    */

    #[Validate('required', message: 'Favor de ingresar las actividades a desarrollar')]
    #[Validate('min:2', message: 'La longitud mínima de las actividades a desarrollar es de 2 caracteres')]
    #[Validate('max:255', message: 'La longitud máxima de las actividades a desarrollar es de 255 caracteres')]
    #[Validate('string', message: 'El contenido de las actividades a desarrollar debe ser una cadena de texto')]
    public $actividades_a_desarrollar;
    #[Validate('required', message: 'Favor de ingresar un nombre de becario')]
    #[Validate('min:2', message: 'La longitud mínima del nombre de becario es de 2 caracteres')]
    #[Validate('max:255', message: 'La longitud máxima del nombre de becario es de 255 caracteres')]
    #[Validate('string', message: 'El contenido del nombre de becario debe ser una cadena de texto')]
    public $nombre_becario;

    #[Validate('required', message: 'Favor de ingresar una fecha de inicio')]
    public $fecha_inicio;
    #[Validate('required', message: 'Favor de ingresar una fecha de finalización')]
    public $fecha_final;
    #[Validate('required', message: 'Favor de ingresar un monto estimado')]
    #[Validate('numeric', message: 'El monto estimado debe ser un número')]
    public $monto_estimado = 0;

    /*
    |--------------------------------------------------------------------------
    | DOCENCIA
    |--------------------------------------------------------------------------
    */

    public $curso;

    public $horas;

    public $institucion;

    public $mensaje = '';


    function submit() {

        $this->validate();

        try{

            switch ($this->selectedRubro) {

                case '7':

                    if($this->objSubcategoriaAEditar){
                        $this->objSubcategoriaAEditar->update([
                            'id_cat_subcategoria' => $this->selectedSubCategoria,
                            'devengado' => false,
                            'monto_estimado' => $this->monto_estimado,
                            'usuario_mod' => auth()->id(),
                            'updated_at' => now()
                        ]);
                        $this->mensaje = 'Categoría actualizada correctamente';
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
                                'id_anteproyecto_rubros' => $this->objAnteproyecto->id,
                                'actividades_a_desarrollar' => $this->actividades_a_desarrollar,
                                'nombre_becario' => $this->nombre_becario,
                                'fecha_inicio_becario' => $this->fecha_inicio,
                                'fecha_fin_becario' => $this->fecha_final
                            ]);


                        });



                            $this->mensaje = 'Rubro creado correctamente';
                    }

                    //                            

                    break;

                case 'docencia':

                    // Guardar docencia

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
                'Ocurrió un error al actualizar el Académico, por favor intenta nuevamente.'
            );
        }

    }

    // function mount(?int $rubro_id = null, ?int $id = null){

    //     if($rubro_id){
    //         $this->rubro = CatRubro::findOrFail($rubro_id);
    //     }

    //     if($id){
    //         $this->objCategoria = CatCategoria::findOrFail($id);
    //         $this->categoria = $this->objCategoria->categoria;
    //         $this->descripcion = $this->objCategoria->descripcion;
    //     }
    // }

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
        @if($selectedRubro == 7 && $selectedSubCategoria)
            @include(
                'pages.dashboard.forms.becarios'
            )
        @endif

        @if($selectedRubro == 2 && $selectedSubCategoria)
            @include(
                'pages.dashboard.forms.computo'
            )
        @endif

        @if($selectedRubro == 6 && $selectedSubCategoria)
            @include(
                'pages.dashboard.forms.eventos'
            )
        @endif

        @if($selectedRubro == 8 && $selectedSubCategoria)
            @include(
                'pages.dashboard.forms.financ_externo'
            )
        @endif

        @if($selectedRubro == 5 && $selectedSubCategoria)
            @include(
                'pages.dashboard.forms.invitados'
            )
        @endif

        @if($selectedRubro == 9 && $selectedSubCategoria)
            @include(
                'pages.dashboard.forms.otras_peticiones'
            )
        @endif

        @if($selectedRubro == 3 && $selectedSubCategoria)
            @include(
                'pages.dashboard.forms.promociones'
            )
        @endif

        @if($selectedRubro == 1 && $selectedSubCategoria)
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
                    Guardar Bri
                </button>
            </div>

        @endif

    </form>
</div>