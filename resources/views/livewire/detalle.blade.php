<div>   

        <div class="my-4"></div> 
    <div class="container mx-auto">
            
          <div class="flex justify-between items-center mb-4">
                <input type="text" wire:model.debounce.500ms="buscar" placeholder="Buscar Detalle" class="input input-bordered input-accent w-full max-w-xs" />
                <button class="btn btn-outline" wire:click="$set('open', true)">Crear Detalle</button>
          </div>


          <div class="overflow-x-auto">
            @if ($detalle)
                <table class="table w-full">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th>Codigo de la factura</th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- row 1 -->
                        @foreach($detalle as $item)
                            <tr class="hover">
                                <td>{{$item->factura->codigo}}</td>
                                <td>{{$item->producto->nombre}}</td>
                                <td>{{$item->producto->precio}}</td>
                                <td>{{$item->cantidad}}</td>
                                <td>{{$item->subtotal}}</td>
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
                {{ $detalle->links() }}
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
                        <x-label for="factura_id" value="Codigo de Factura" />
                        <select wire:model="factura_id" class="input input-bordered input-accent">
                            <option value="">Selecciona una factura</option>
                            @foreach ($factura as $item)
                                <option value="{{ $item->id }}">{{ $item->codigo }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="factura_id" />
                    </div>
        
                    <div>
                        <x-label for="producto_id" value="Producto" />
                        <select wire:model="producto_id" class="input input-bordered input-accent">
                            <option value="">Seleccionar Producto</option>
                            @foreach($producto as $item)
                                <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="producto_id" />
                    </div>
                    
                    <div>
                        <x-label for="cantidad" value="Cantidad" />
                       
                        <x-input id="cantidad" type="number" class="input input-bordered input-accent w-full max-w-xs" wire:model.defer="cantidad" required autofocus autocomplete="cantidad" />
                        <x-input-error for="cantidad" />
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
                        <x-label for="factura_id" value="Codigo de Factura" />
                        <select wire:model="factura_id" class="input input-bordered input-accent">
                            <option value="">Selecciona una factura</option>
                            @foreach ($factura as $item)
                                <option value="{{ $item->id }}">{{ $item->codigo }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="factura_id" />
                    </div>
        
                    <div>
                        <x-label for="producto_id" value="Producto" />
                        <select wire:model="producto_id" class="input input-bordered input-accent">
                            <option value="">Seleccionar Producto</option>
                            @foreach($producto as $item)
                                <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="producto_id" />
                    </div>
                    
                    <div>
                        <x-label for="cantidad" value="Cantidad" />
                       
                        <x-input id="cantidad" type="number" class="input input-bordered input-accent w-full max-w-xs" wire:model.defer="cantidad" required autofocus autocomplete="cantidad" />
                        <x-input-error for="cantidad" />
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
                    <x-label class="font-bold">
                        ¿Estás seguro de que quieres eliminar este detalle?
                    </x-label>
                    
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
