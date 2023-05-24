<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Producto;
use Livewire\WithPagination;

class Productos extends Component
{
    
    use WithPagination;
    public $buscar = '';
    public $open = false; // controla cuando se muestra el modal
    public $openeditor = false;
    public $openeliminar = false;
    
    public $productoId;

    public $nombre;
    public $precio;
    public $descripcion;


    

    protected $messages = [
        'nombre.required' => 'El nombre es obligatorio.',
        'nombre.unique' => 'El nombre ya está en uso.',
        'precio.required' => 'El precio es obligatorio.',
        'precio.numeric' => 'El precio debe ser un número.',
    ];

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

        $this->reset(['open','openeditor','openeliminar','nombre','precio','descripcion']);
    }

     public function select_index($productoId)
     {
        $this->productoId = $productoId;
        
        $producto = Producto::findOrFail($productoId);
        
        if ($producto) {
            $this->nombre = $producto->nombre;
            $this->precio = $producto->precio;
            $this->descripcion = $producto->descripcion;
            
            $this->openeditor = true; // Abre el modal
        } else {
            // Manejo del caso en que el producto no se encuentra
        }
    }

    public function actualizar()
    {
        $this->validate([
            'nombre' => 'required|unique:productos,nombre,' . $this->productoId,
            'precio' => 'required|numeric',
            'descripcion' => 'nullable',
        ]);
    
        $producto = Producto::findOrFail($this->productoId);
    
        if ($producto) {
            $producto->update([
                'nombre' => $this->nombre,
                'precio' => $this->precio,
                'descripcion' => $this->descripcion,
            ]);
        } else {
            // Manejo del caso en que el producto no se encuentra
        }
    
        $this->reset(['nombre', 'precio', 'descripcion', 'openeditor']);
    }

    public function delete_index($productoId){
        $this->producto = Producto::find($productoId);
        $this->openeliminar = true;
        
        
      }

    public function eliminar(){
        if ($this->producto) {
            $this->producto->delete();
        }
        $this->cancelar();
        $this->reset([ 'openeliminar']);
    
  }

    
}
