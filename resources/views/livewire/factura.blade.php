<div>
<div class="my-4"></div> 
    <div class="container mx-auto">

        <div class="flex justify-between items-center mb-4">
            <input type="text" wire:model.debounce.500ms="buscar" placeholder="Buscar Factura" class="input input-bordered input-accent w-full max-w-xs" />
            <button class="btn btn-outline" wire:click="$set('open',true)">Crear Factura</button>
          </div>
            
     <div class="overflow-x-auto">
        @if ($factura)
            <table class="table w-full">
                <!-- head -->
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Vendedor</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- row 1 -->
                    @foreach($factura as $item)
                        <tr class="hover">
                            <td>{{$item->codigo}}</td>
                            <td>{{$item->fecha}}</td>
                            <td>{{$item->nombre_cliente}}</td>
                            <td>{{$item->vendedor->nombre}}</td>
                            <td>
                                <div class="flex justify-center items-center space-x-2">
                                    <button class="btn btn-primary" wire:click="select_index({{$item->id}})">Editar</button>
                                    <button class="btn btn-error" wire:click="delete_index({{$item->id}})">Eliminar</button>   
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $factura->links() }}
         @else
            <div class="alert alert-info shadow-lg">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current flex-shrink-0 w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Hay un error en la búsqueda</span>
                </div>
            </div>
        @endif
      </div>

      <x-dialog-modal wire:model="open">
        <x-slot name="title">
        </x-slot>
    
        <x-slot name="content">
            <div class="flex flex-col space-y-4">
                <div>
                    <x-label for="codigo" value="Codigo" />
                    <x-input id="codigo" type="text" class="input input-bordered input-accent w-full max-w-xs" wire:model.defer="codigo" required autofocus autocomplete="codigo" />
                    <x-input-error for="codigo" />
                </div>
    
                <div>
                    <x-label for="fecha" value="Fecha" />
                    <x-input id="fecha" type="date" class="input input-bordered input-accent w-full max-w-xs" wire:model.defer="fecha" required autocomplete="fecha" />
                    <x-input-error for="fecha" />
                </div>
    
                <div>
                    <x-label for="nombre_cliente" value="Cliente" />
                    <x-input id="nombre_cliente" type="text" class="input input-bordered input-accent w-full max-w-xs" wire:model.defer="nombre_cliente" required autofocus autocomplete="nombre_cliente" />
                    <x-input-error for="nombre_cliente" />
                </div>
                <div>
                    <x-label for="vendedor_id" value="Vendedor" />
                    <select class="select select-info w-full max-w-xs" name="vendedor_id" id="vendedor_id" wire:model="vendedor_id" >
                        <option value="">Seleccionar vendedor</option> <!-- Agrega esta opción en blanco -->
                    @foreach($vendedor as $item)
                    <option value="{{$item->id}}">{{$item->nombre}}</option>
                    @endforeach
                    
                </select>
                <x-input-error for="vendedor_id" />
                </div>
            </div>
        </x-slot>
    
        <x-slot name="footer">
            <x-secondary-button class="mx-5" wire:click="cancelar" wire:loading.attr="disabled">
                CANCELAR
            </x-secondary-button>
    
            <x-secondary-button class="btn-active btn-primary" wire:click="guardar" wire:loading.attr="disabled">
                GUARDAR
            </x-secondary-button>
        </x-slot>
      </x-dialog-modal>


       <x-dialog-modal wire:model="openeditor">
        <x-slot name="title">
        </x-slot>
    
        <x-slot name="content">
            <div class="flex flex-col space-y-4">
                <div>
                    <x-label for="codigo" value="Codigo" />
                    <x-input id="codigo" type="text" class="input input-bordered input-accent w-full max-w-xs" wire:model.defer="codigo" required autofocus autocomplete="codigo" />
                    <x-input-error for="codigo" />
                </div>
    
                <div>
                    <x-label for="fecha" value="Fecha" />
                    <x-input id="fecha" type="date" class="input input-bordered input-accent w-full max-w-xs" wire:model.defer="fecha" required autocomplete="fecha" />
                    <x-input-error for="fecha" />
                </div>
    
                <div>
                    <x-label for="nombre_cliente" value="Cliente" />
                    <x-input id="nombre_cliente" type="text" class="input input-bordered input-accent w-full max-w-xs" wire:model.defer="nombre_cliente" required autofocus autocomplete="nombre_cliente" />
                    <x-input-error for="nombre_cliente" />
                </div>
                <div>
                    <x-label for="vendedor_id" value="Vendedor" />
                    <select class="select select-info w-full max-w-xs" name="vendedor_id" id="vendedor_id" wire:model="vendedor_id" >
                        <option value="">Seleccionar vendedor</option> <!-- Agrega esta opción en blanco -->
                    @foreach($vendedor as $item)
                    <option value="{{$item->id}}">{{$item->nombre}}</option>
                    @endforeach
                    
                </select>
                <x-input-error for="vendedor_id" />
                </div>
            </div>
        </x-slot>
    
        <x-slot name="footer">
            <x-secondary-button class="mx-5" wire:click="cancelar" wire:loading.attr="disabled">
                CANCELAR
            </x-secondary-button>
    
            <x-secondary-button class="btn-active btn-primary" wire:click="actualizar" wire:loading.attr="disabled">
                Actualizar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>


    <x-dialog-modal wire:model="openeliminar">
        <x-slot name="title">
        </x-slot>
            
        <x-slot name="content">
            <div class="flex flex-col space-y-4">
                
    
                <div>
                    <p>¿Estás seguro de eliminar la factura con el código <strong>{{ $codigoFactura }}</strong>?</p>

                    @if (session('message'))
                    <div class="alert alert-danger">
                        {{ session('message') }}
                    </div>
                @endif
                </div>
                
            </div>
        </x-slot>
    
        <x-slot name="footer">
            <x-secondary-button class="mx-5" wire:click="cancelar" wire:loading.attr="disabled">
                CANCELAR
            </x-secondary-button>
    
            <x-secondary-button class="btn-active btn-primary" wire:click="eliminar" wire:loading.attr="disabled">
                Eliminar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>




     </div>
</div>
