<div>
  <div class="my-4"></div>

  <div class="flex justify-between items-center mb-4">
      <input type="text" wire:model.debounce.500ms="buscar" placeholder="Buscar Vendedor" class="input input-bordered input-accent w-full max-w-xs" />
      <button class="btn btn-outline" wire:click="$set('open',true)">Agregar Vendedor</button>
  </div>

  <div class="overflow-x-auto">
      @if ($vendedors)
          <table class="table w-full">
              <!-- head -->
              <thead>
                  <tr>
                      <th>Cedula</th>
                      <th>Nombre</th>
                      <th>Telefono</th>
                      <th>Correo</th>
                      <th class="text-center">Acciones</th>
                  </tr>
              </thead>
              <tbody>
                  <!-- row 1 -->
                  @foreach($vendedors as $item)
                      <tr class="hover">
                          <td>{{$item->cedula}}</td>
                          <td>{{$item->nombre}}</td>
                          <td>{{$item->telefono}}</td>
                          <td>{{$item->correo}}</td>
                          <td>
                              <div class="flex justify-center items-center space-x-2">
                                  <button class="btn btn-primary" wire:click="select_index({{$item->id}})">Editar</button>
                                  {{-- <button class="btn btn-error" wire:click="eliminar({{$item->id}})">Eliminar</button>    --}}
                                  <button wire:click="eliminar({{ $item }})">Eliminar</button>
                              </div>
                          </td>
                      </tr>
                  @endforeach
              </tbody>
          </table>
          {{ $vendedors->links() }}
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
          @lang('Agregar Vendedor')
      </x-slot>

      <x-slot name="content">
          <div class="flex flex-col space-y-4">
              <div>
                  <x-label for="cedula" value="Cedula" />
                  <x-input id="cedula" type="text" class="w-full" wire:model.defer="cedula" required autofocus autocomplete="cedula" />
                  <x-input-error for="cedula" />
              </div>

              <div>
                  <x-label for="nombre" value="Nombre" />
                  <x-input id="nombre" type="text" class="w-full" wire:model.defer="nombre" required autofocus autocomplete="nombre" />
              </div>

              <div>
                  <x-label for="telefono" value="Telefono" />
                  <x-input id="telefono" type="text" class="w-full" wire:model.defer="telefono" required autofocus autocomplete="telefono" />
                </div>
                <div>
                <x-label for="correo" value="Email" />
                <x-input id="correo" type="text" class="w-full" wire:model.defer="correo" required autofocus autocomplete="correo" />
                </div>
                </div>
                </x-slot><x-slot name="footer">
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
                  @lang('Editar Vendedor')
              </x-slot>
          
              <x-slot name="content">
                  <div class="flex flex-col space-y-4">
                      <div>
                          <x-label for="cedula-edit" value="Cedula" />
                          <x-input id="cedula-edit" type="text" class="w-full" wire:model="cedulaEditar" required autofocus autocomplete="cedula" />
                          <x-input-error for="cedula" />
                      </div>
          
                      <div>
                          <x-label for="nombre-edit" value="Nombre" />
                          <x-input id="nombre-edit" type="text" class="w-full" wire:model="nombreEditar" required autofocus autocomplete="nombre" />
                      </div>
          
                      <div>
                          <x-label for="telefono-edit" value="Telefono" />
                          <x-input id="telefono-edit" type="text" class="w-full" wire:model="telefonoEditar" required autofocus autocomplete="telefono" />
                      </div> 
                      <div>
                          <x-label for="correo-edit" value="Email" />
                          <x-input id="correo-edit" type="text" class="w-full" wire:model="correoEditar" required autofocus autocomplete="correo" />
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
                @lang('Eliminar Vendedor')
            </x-slot>
            
            <x-slot name="content">
                <div class="flex flex-col space-y-4">
                  <x-label>Desea eliminar el Vendedor con la cedula: {{ $cedula }} ?</x-label>
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