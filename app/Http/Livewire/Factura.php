<?php

namespace App\Http\Livewire;

use App\Models\Vendedor;
use App\Models\Factura as Modelfactura;
use App\Models\Detalles;
use Livewire\Component;
use Livewire\WithPagination;

class Factura extends Component
{
    use WithPagination;

    public $buscar = '';
    public $open = false;
    public $openeditor = false;
    public $openeliminar =false;

    public $codigoFactura; //variable que tiene un dato que se muestra en el label de el modal de eliminacion
    public $facturaId;

    //variables representantes de mi base de datos
    public $codigo;
    public $fecha;
    public $nombre_cliente;
    public $vendedor_id, $vendedor;

   
    protected $rules = [
    'codigo' => 'required|unique:facturas,codigo',
    'fecha' => 'required',
    'nombre_cliente' => 'required',
    'vendedor_id' => 'required',
    ];
    protected $messages = [
        'codigo.required' => 'El nombre es obligatorio.',
        'codigo.unique' => 'El nombre ya está en uso.',
        'nombre_clienre.required' => 'El precio es obligatorio.',
        
    ];
        public function mount(){
        $this->vendedor = Vendedor::get();
        
        //if(sizeof($this->vendedor)>=0){
            if ($this->vendedor->isNotEmpty()) {
            $this->vendedor_id = null;
           // $this->vendedor_id = Vendedor::first()->id;
        }   
    }


    public function render()
    {
       
      $factura = Modelfactura::where('codigo', 'like', '%' . $this->buscar . '%')->paginate(7);
    return view('livewire.factura', compact('factura'));
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

     public function cancelar()
    {

        $this->reset(['open','openeliminar','openeditor','codigo','fecha','nombre_cliente','vendedor_id']);
    }

     public function guardar()
     {
        $this->validate([
            'codigo' => 'required|unique:facturas,codigo',
            'fecha' => 'required',
            'nombre_cliente' => 'required',
            'vendedor_id' => 'required',
        ]);
 
         $factura = new Modelfactura();
         $factura->codigo = $this->codigo;
         $factura->fecha = $this->fecha;
         $factura->nombre_cliente = $this->nombre_cliente;
         $factura->vendedor_id = $this->vendedor_id;
         $factura->save();
          
         $this->reset(['codigo', 'fecha', 'nombre_cliente','vendedor_id','open']);
     }

     public function select_index($facturaId)
     {
        $this->facturaId = $facturaId;
        
        $factura = Modelfactura::findOrFail($facturaId);
        
        if ($factura) {
            $this->codigo = $factura->codigo;
            $this->fecha = $factura->fecha;
            $this->nombre_cliente = $factura->nombre_cliente;
            $this->vendedor_id = $factura->vendedor_id;
            $this->openeditor = true; // Abre el modal
        } else {
            // Manejo del caso en que el producto no se encuentra
        }
    }


     public function actualizar(){
    
        $this->validate();

    $factura = Modelfactura::findOrFail($this->facturaId);

    // Verificar si existen detalles asociados
    $tieneDetalles = $factura->detalles()->count() > 0;

    

    $factura->codigo = $this->codigo;
    $factura->fecha = $this->fecha;
    $factura->nombre_cliente = $this->nombre_cliente;
    $factura->vendedor_id = $this->vendedor_id;
    $factura->save();

    $this->reset(['codigo', 'fecha', 'nombre_cliente', 'vendedor_id', 'openeditor']);

    if ($tieneDetalles) {
        session()->flash('message', 'Elimine los datos de detalle para actualizar.');
        return;
    }

    // Agregar lógica adicional si es necesario, como mostrar un mensaje de éxito
     }

     

     public function delete_index($facturaId)
     {
        $this->facturaId = $facturaId;
        $factura = Modelfactura::findOrFail($facturaId);
        $this->codigoFactura = $factura->codigo;
        $this->openeliminar = true; // Abre el modal de confirmación
     }

     public function eliminar()
     {
        $factura = Modelfactura::findOrFail($this->facturaId);

    // Verificar si existen detalles asociados
    $tieneDetalles = $factura->detalles()->count() > 0;

    if ($tieneDetalles) {
        session()->flash('message', 'Elimine los detalles de esta factura primero.');
        return;
    }

    // Si no hay detalles asociados, proceder con la eliminación
    $factura->delete();

    $this->reset(['facturaId', 'openeliminar']);
     }


    
}
