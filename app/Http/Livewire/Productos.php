<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Producto;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\SoftDeletes;
class Productos extends Component
{
    
    use WithPagination;
    public $buscar = '';
    public $open = false; // controla cuando se muestra el modal

    public $nombre;
    public $precio;
    public $descripcion;

    public function render()
    {
        $productos = Producto::where('nombre', 'like', '%' . $this->buscar . '%')
        ->orWhere('precio', 'like', '%' . $this->buscar . '%')
        ->paginate(5);

    return view('livewire.productos', compact('productos'));
       
    }
    //metodo que reinicia la pagina al buscar
    public function updatingBuscar()
    {
        $this->resetPage();
    }
    //metodo para mostrar el resultado
    public function actualizarResultados()
    {
        $this->render();
    }
    //funcion que te da un mensaje si no se cumplen los estandares de las variables
    protected $messages = [
        'nombre.unique' => 'El nombre ya está en uso.',
        'precio.numeric' => 'El precio debe ser un número.',
    ];
    

    public function guardar()
    {
        $this->validate([
            'nombre' => 'required|unique:productos,nombre',
            'precio' => 'required|numeric',
            'descripcion' => 'nullable',
        ]);

        $producto = new Producto();
        $producto->nombre = $this->nombre;
        $producto->precio = $this->precio;
        $producto->descripcion = $this->descripcion;
        $producto->save();
         
        $this->reset(['nombre', 'precio', 'descripcion','open']);
    }
    public function cancelar()
    {

        $this->reset(['open']);
    }

    public function select_index( Producto $producto)
    {
     dd($producto->nombre);  
    }
}
