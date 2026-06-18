<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\CatCategoria;
use App\Models\CatSubcategoria;
use App\Livewire\Traits\WithPermissions;

new class extends Component
{
    use WithPermissions;

    function mount(?int $categoria_id = null, ?int $id = null){

        $this->checkPermission('catalogos.rubros.editar');

        if($categoria_id){
            $this->categoria = CatCategoria::findOrFail($categoria_id);
        }

        if($id){
            $this->objSubcategoria = CatSubcategoria::findOrFail($id);
            $this->subcategoria = $this->objSubcategoria->subcategoria;
            $this->descripcion = $this->objSubcategoria->descripcion;
            // $this->mostrar_monto_estimado = $this->objSubcategoria->mostrar_monto_estimado;
            // $this->modificar_monto_estimado = $this->objSubcategoria->modificar_monto_estimado;
            // $this->requiere_comentarios = $this->objSubcategoria->requiere_comentarios;
            $this->monto_estimado = $this->objSubcategoria->monto_estimado;
        }
    }

    #[Validate('required', message: 'Favor de ingresar un título')]
    #[Validate('min:2', message: 'La longitud mínima del título es de 2 caracteres')]
    #[Validate('max:255', message: 'La longitud máxima del título es de 255 caracteres')]
    #[Validate('string', message: 'El contenido del título debe ser una cadena de texto')]
    public $subcategoria;
    #[Validate('nullable|string')]
    public $descripcion;
    #[Validate('boolean')]
    public $mostrar_monto_estimado = false;
    #[Validate('boolean')]
    public $modificar_monto_estimado = false;
    #[Validate('boolean')]
    public $requiere_comentarios = false;

    #[Validate('required', message: 'Favor de ingresar el presupuesto estimado')]
    // #[Validate('gt:0', message: 'El presupuesto estimado debe ser mayor a $0')]
    public $monto_estimado = 0;

    public $categoria;

    public $objSubcategoria;

    public $mensaje = '';


    function submit() {

        $this->validate();

        if($this->objSubcategoria){
            $this->objSubcategoria->update([
                'id_categoria' => $this->categoria->id,
                'subcategoria' => $this->subcategoria,
                'descripcion' => $this->descripcion,
                'mostrar_monto_estimado' => false,
                'modificar_monto_estimado' => false,
                'requiere_comentarios' => false,
                'monto_estimado' => $this->monto_estimado,
                'usuario_mod' => auth()->id(),
                'updated_at' => now()
            ]);
            $this->mensaje = 'Subcategoría actualizada correctamente';
        }else{
            CatSubcategoria::create([
                'id_categoria' => $this->categoria->id,
                'subcategoria' => $this->subcategoria,
                'descripcion' => $this->descripcion,
                'mostrar_monto_estimado' => false,
                'modificar_monto_estimado' => false,
                'requiere_comentarios' => false,
                'monto_estimado' => $this->monto_estimado,
                'usuario_ins' => auth()->id(),
                'updated_at' => now()
            ]);
            $this->mensaje = 'Subcategoría creada correctamente';
        }

        session()->flash('success', $this->mensaje);
 
        return $this->redirect('/dashboard/subcategorias/categorias/' . $this->categoria->id);
    }

    public function regresar()
    {
        return $this->redirect('/dashboard/subcategorias/categorias/' . $this->categoria->id);
    }
};
?>



<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Categoría: ' . $this->categoria->categoria) }}</flux:heading>
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
    <form wire:submit.prevent="submit" class="my-6 w-full space-y-6">
        <flux:input label="Subcategoría" type="text" wire:model="subcategoria" />
        <flux:textarea label="Descripción" wire:model="descripcion" />
        <flux:input label="Presupuesto estimado" step="any" type="number" wire:model="monto_estimado" />
        <flux:button variant="primary" type="submit">Guardar</flux:button>
    </form>
</div>