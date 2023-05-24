<div>
    <div class="my-4"></div> 

    <div class="flex justify-between items-center mb-4">
        <input type="text" wire:model.debounce.500ms="buscar" placeholder="Buscar Producto" class="input input-bordered input-accent w-full max-w-xs" />
        <button class="btn btn-outline" wire:click="$set('open',true)">Agregar Producto</button>
    </div>


    <div class="overflow-x-auto">
        @if ($productos)
            <table class="table w-full">
                <!-- head -->
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Descripcion</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- row 1 -->
                    @foreach($productos as $item)
                        <tr class="hover">
                            <td>{{$item->nombre}}</td>
                            <td>{{$item->precio}}</td>
                            <td>{{$item->descripcion}}</td>
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
            {{ $productos->links() }}
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
                    <x-label for="nombre" value="Nombre" />
                    <x-input id="nombre" type="text" class="input input-bordered input-accent w-full max-w-xs" wire:model.defer="nombre" required autofocus autocomplete="nombre" />
                    <x-input-error for="nombre" />
                </div>
    
                <div>
                    <x-label for="precio" value="Precio" />
                    <x-input id="precio" type="number" step="0.01" class="input input-bordered input-accent w-full max-w-xs" wire:model.defer="precio" required autocomplete="precio" />
                    <x-input-error for="precio" />
                </div>
    
                <div>
                    <x-label for="descripcion" value="Descripcion" />
                    <x-input id="descripcion" type="text" class="input input-bordered input-accent w-full max-w-xs" wire:model.defer="descripcion" required autofocus autocomplete="descripcion" />
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
                    <x-label for="nombre" value="Nombre" />
                    <x-input id="nombre" type="text" class="input input-bordered input-accent w-full max-w-xs" wire:model.defer="nombre" required autofocus autocomplete="nombre" />
                    <x-input-error for="nombre" />
                </div>
    
                <div>
                    <x-label for="precio" value="Precio" />
                    <x-input id="precio" type="number" step="0.01" class="input input-bordered input-accent w-full max-w-xs" wire:model.defer="precio" required autocomplete="precio" />
                    <x-input-error for="precio" />
                </div>
    
                <div>
                    <x-label for="descripcion" value="Descripcion" />
                    <x-input id="descripcion" type="text" class="input input-bordered input-accent w-full max-w-xs" wire:model.defer="descripcion" required autofocus autocomplete="descripcion" />
                </div>
            </div>
        </x-slot>
    
        <x-slot name="footer">
            <x-secondary-button class="mx-5" wire:click="cancelar" wire:loading.attr="disabled">
                CANCELAR
            </x-secondary-button>
    
            <x-secondary-button class="btn-active btn-primary" wire:click="actualizar" wire:loading.attr="disabled">
                ACTUALIZAR
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model="openeliminar">
        <x-slot name="title">
        </x-slot>
    
        <x-slot name="content">
            <div class="flex flex-col space-y-4">
                @isset($producto)
                    <x-label>Desea eliminar el producto: {{ $producto->nombre }} ?</x-label>
                @endisset
                @if (session('message'))
                <div class="alert alert-danger">
                    {{ session('message') }}
                </div>
            @endif
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
