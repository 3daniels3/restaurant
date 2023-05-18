<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Vendedor;
use Livewire\WithPagination;


class Vendedores extends Component
{
    use WithPagination;
   
    
    public $openeliminar; // controla el modal para eliminar
    public $openeditor = false; // controla el modal de edición
    public $open = false; // controla cuando se muestra el modal

    public $buscar = '';
    public $id2;

    public $vendedor;

    public $cedula;
    public $nombre;
    public $telefono;
    public $correo;

    public $cedulaEditar;
    public $nombreEditar;
    public $telefonoEditar;
    public $correoEditar;

    protected $rules = [
        'cedula' => 'required|unique:vendedors|max:20',
        'nombre' => 'required|max:100',
        'telefono' => 'required|max:20',
        'correo' => 'max:100',
    ];

    public function render()
    {
        $vendedors = Vendedor::where('cedula', 'like', '%' . $this->buscar . '%')
            ->orWhere('nombre', 'like', '%' . $this->buscar . '%')
            ->paginate(5);

        return view('livewire.vendedores', compact('vendedors'));
    }

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    public function actualizarResultados()
    {
        $this->render();
    }

    public function agregarVendedor()
    {
        $this->open = true;
    }

    public function cancelar()
    {
        $this->reset(['cedula', 'nombre', 'telefono', 'correo', 'open', 'openeditor', 'openeliminar']);
    }

    public function guardar()
    {
        $this->validate();

        Vendedor::create([
            'cedula' => $this->cedula,
            'nombre' => $this->nombre,
            'telefono' => $this->telefono,
            'correo' => $this->correo,
        ]);

        $this->cancelar();
    }

    public function select_index($vendedorId)
    {
        $vendedor = Vendedor::find($vendedorId);

    if ($vendedor) {
        $this->id2 = $vendedor->id;
        $this->cedulaEditar = $vendedor->cedula;
        $this->nombreEditar = $vendedor->nombre;
        $this->telefonoEditar = $vendedor->telefono;
        $this->correoEditar = $vendedor->correo;
        $this->openeditor = true;
    }
    }

    public function actualizar()
    {
        $this->validate([
            'cedulaEditar' => 'required|unique:vendedors,cedula,' . $this->id2,
            'nombreEditar' => 'required|max:100',
            'telefonoEditar' => 'required|max:20',
            'correoEditar' => 'max:100',
        ]);

        $vendedor = Vendedor::findOrFail($this->id2);

        $vendedor->update([
            'cedula' => $this->cedulaEditar,
            'nombre' => $this->nombreEditar,
            'telefono' => $this->telefonoEditar,
            'correo' => $this->correoEditar,
        ]);

        $this->cancelar();
    }
    public function delete_index($vendedorId){

        //$vendedor = Vendedor::findOrFail($vendedorId);
        //$this->vendedor->delete();
          // dd($vendedor);
       // if ($vendedor) {
         //   $vendedor->delete();
           // dd('Vendedor eliminado exitosamente');
        //} else {
          //  dd('Vendedor no encontrado');
        //}
    
       // $this->openeliminar = true;
    }
     
    public function eliminar(Vendedor $Vendedor)
     { 
        $Vendedor->delete();
      }
    
    
       

    
}