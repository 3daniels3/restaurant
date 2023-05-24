<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Factura;
use App\Models\Producto;
use App\Models\Detalles;
use Livewire\WithPagination;

class Detalle extends Component
{ 
    use WithPagination;

    public $buscar = '';
    public $open = false;
    public $openeditor = false;
    public $openeliminar = false;
    
    public $detalleId;
    public $factura_id, $factura;
    public $producto_id, $producto;
    public $cantidad;
    public $subtotal;


    public function mount(){
        $this->factura = Factura::get();
        if ($this->factura->isNotEmpty()) {
            $this->factura_id = null;
        }
    
        $this->producto = Producto::get();
        if ($this->producto->isNotEmpty()) {
            $this->producto_id = null;
        }
    }

    protected $rules = [
        'factura_id' => 'required',
        'producto_id' => 'required',
        'cantidad' => 'required|numeric|min:1',
        
    ];
    protected $messages = [
        'factura_id.required' => 'El campo factura es obligatorio.',
        
        'producto_id.required' => 'El campo producto es obligatorio.',
        'cantidad.required' => 'El campo cantidad es obligatorio.',
        'cantidad.numeric' => 'El campo cantidad debe ser un valor numérico.',
        'cantidad.min' => 'El campo cantidad debe ser igual o mayor a 1.',
        
    ];

    public function render()
    {
        $detalle = Detalles::with('factura', 'producto')
        ->where(function ($query) {
            $query->whereHas('factura', function ($q) {
                $q->where('codigo', 'like', '%' . $this->buscar . '%');
            })
            ->orWhereHas('producto', function ($q) {
                $q->where('nombre', 'like', '%' . $this->buscar . '%');
            });
        })
        ->paginate(7);

    return view('livewire.detalle', compact('detalle'));
    }
    public function updatingBuscar()
    {
        $this->resetPage();
    }
    //metodo para mostrar el resultado
    public function actualizarResultados()
    {
        $this->render();
    }  

    public function cancelar()
    {

        $this->reset(['open','openeliminar','openeditor','factura_id', 'producto_id', 'cantidad', 'subtotal']);
    }

    public function guardar()
    {
         $this->validate([
        'factura_id' => 'required',
        'producto_id' => 'required',
        'cantidad' => 'required|numeric|min:1',
        ]);
         
        $producto = Producto::find($this->producto_id);
        $subtotal = $producto->precio * $this->cantidad;
    
        Detalles::create([
            'factura_id' => $this->factura_id,
            'producto_id' => $this->producto_id,
            'cantidad' => $this->cantidad,
            'subtotal' => $subtotal,
        ]);
    
        $this->reset(['factura_id', 'producto_id', 'cantidad', 'subtotal', 'open']);
    }


    public function select_index($detalleId)
    {
        $detalle = Detalles::find($detalleId);
    
        if ($detalle) {
            $this->detalleId = $detalle->id;
            $this->factura_id = $detalle->factura_id;
            $this->producto_id = $detalle->producto_id;
            $this->cantidad = $detalle->cantidad;
            $this->subtotal = $detalle->subtotal;
    
            $this->openeditor = true; // Abre el modal de edición
        } else {
            // Manejo del caso en que el detalle no se encuentra
        }
    }
    
    public function actualizar()
    {
        $this->validate([
            'factura_id' => 'required',
            'producto_id' => 'required',
            'cantidad' => 'required|numeric|min:1',
        ]);
    
        $detalle = Detalles::find($this->detalleId);
    
        if ($detalle) {
            $detalle->factura_id = $this->factura_id;
            $detalle->producto_id = $this->producto_id;
            $detalle->cantidad = $this->cantidad;
            $producto = Producto::find($this->producto_id);
            $detalle->subtotal = $this->cantidad * $producto->precio;
            $detalle->save();
    
            $this->reset(['factura_id', 'producto_id', 'cantidad', 'subtotal', 'openeditor','detalleId']);
            // Agregar lógica adicional si es necesario, como mostrar un mensaje de éxito
        } else {
            // Manejo del caso en que el detalle no se encuentra
        }
    }

    public function delete_index($detalleId)
  {
    $detalle = Detalles::findOrFail($detalleId);

    if ($detalle) {
        $this->detalleId = $detalleId;
        $this->openeliminar = true; // Abrir el modal de eliminación
    } else {
        // Manejo del caso en que el detalle no se encuentra
    }
}

public function eliminar()
{
    $detalle = Detalles::findOrFail($this->detalleId);

    if ($detalle) {
        $detalle->delete();

        $this->reset(['factura_id', 'producto_id', 'cantidad', 'subtotal', 'openeliminar']);
        // Agregar lógica adicional si es necesario, como mostrar un mensaje de éxito
    } else {
        // Manejo del caso en que el detalle no se encuentra
    }
}



}
