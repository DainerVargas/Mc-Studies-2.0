<section id="sendEmail">
    <!-- Header & Filter Section -->
    <div class="conteFilter">
        <div class="conteInput">
            <label for="search">Nombre del Estudiante</label>
            <input wire:model.live="search" id="search" type="text" placeholder="Buscar estudiante por nombre o apellido...">
        </div>

        <div class="conteInput">
            <label for="group">Filtrar por Grupo</label>
            <select wire:model.live="group" id="group">
                <option value="all">Todos los grupos</option>
                @foreach ($groups as $g)
                    <option value="{{ $g->id }}" wire:key="group-opt-{{ $g->id }}">{{ $g->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="conteMessage">
            <div wire:click="show" class="text">
                <span class="material-symbols-outlined">bolt</span>
                <p>Mensajes rápidos</p>
                <span class="material-symbols-outlined {{ $hidden2 ? 'rotate' : '' }}">expand_more</span>
            </div>
            
            @if ($hidden2)
                <div class="messages">
                    <small>Respuestas rápidas</small>
                    <div class="scroll">
                        @forelse ($messages as $msg)
                            <div class="message" wire:key="msg-{{ $msg->id }}" x-data="{
                                copy() {
                                    navigator.clipboard.writeText($refs.text.innerText);
                                }
                            }">
                                <p>{{ \Illuminate\Support\Str::limit($msg->message, 45, '...') }}</p>

                                <div class="actions">
                                    <span x-ref="text" class="hidden" style="display:none">{{ $msg->message }}</span>
                                    <span @click="copy()" class="material-symbols-outlined copy" title="Copiar">
                                        content_copy
                                    </span>
                                    <span wire:click="delete({{ $msg->id }})"
                                          wire:confirm="¿Deseas eliminar este mensaje?"
                                          class="material-symbols-outlined delete" title="Eliminar">
                                        delete
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="message"><p>No hay mensajes aún</p></div>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>

        <button wire:click="active">
            <span class="material-symbols-outlined">add</span>
            Crear Plantilla
        </button>
    </div>

    <div class="container">
        <!-- Student Selection Column -->
        <div class="conteList">
            <div class="title">
                <h3>Estudiantes ({{ count($estudiantes) }})</h3>
                <div class="check" wire:click="selectAll" style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <label style="cursor: pointer;">Seleccionar todos</label>
                    <input type="checkbox" 
                           {{ $allSelectedInView ? 'checked' : '' }}
                           readonly>
                </div>
            </div>

            <div class="scroll">
                @forelse ($estudiantes as $estudiante)
                    @php 
                        $id = (int)$estudiante->id;
                        $isSelected = in_array($id, $selectEstudents, true); 
                    @endphp
                    <div class="list-item {{ $isSelected ? 'selected' : '' }}" 
                         wire:key="student-row-{{ $id }}"
                         wire:click="selectStudent({{ $id }})"
                         style="cursor: pointer;">
                        <div class="student-info">
                            <div class="initials">{{ substr($estudiante->name, 0, 1) }}{{ substr($estudiante->apellido, 0, 1) }}</div>
                            <span class="name">{{ $estudiante->name }} {{ $estudiante->apellido }}</span>
                            <small>{{ $estudiante->email ?? optional($estudiante->attendant)->email }}</small>
                        </div>
                        <input type="checkbox" {{ $isSelected ? 'checked' : '' }} wire:click.stop="selectStudent({{ $id }})">
                    </div>
                @empty
                    <div class="no-results" style="text-align: center; padding: 2rem; color: #9ca3af;">
                        <span class="material-symbols-outlined" style="font-size: 3rem;">search_off</span>
                        <p>No se encontraron estudiantes</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Email Composer Column -->
        <div class="sendEmail">
            <div class="asunto">
                <p>Asunto</p>
                <input type="text" placeholder="Escribe el título del correo..." wire:model="asunto">
            </div>

            <div class="conteFor">
                <p>Destinatarios ({{ count($selectedStudentsInfo) }})</p>
                <div class="students">
                    <div class="conteName">
                        @forelse ($selectedStudentsInfo  as $sel)
                            <div class="student-chip" wire:key="chip-dest-{{ $sel->id }}">
                                {{ $sel->name }} {{ substr($sel->apellido, 0, 1) }}.
                                <span class="material-symbols-outlined" wire:click="removeStudent({{ $sel->id }})">close</span>
                            </div>
                        @empty
                            <span class="no-selection">Selecciona estudiantes de la lista de la izquierda</span>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="conteArea">
                <textarea placeholder="Escribe tu mensaje aquí..." wire:model="text"></textarea>
            </div>

            <div class="conteBtn">
                <div class="file-input-wrapper">
                    <input type="file" wire:model="documento" id="attachment">
                    <div wire:loading wire:target="documento" style="font-size: 0.8rem; color: #4f46e5;">Subiendo archivo...</div>
                </div>
                
                <button wire:click="send" {{ count($selectEstudents) == 0 ? 'disabled' : '' }}>
                    <span class="material-symbols-outlined">send</span>
                    Enviar Ahora
                </button>
            </div>
        </div>
    </div>

    <!-- Create Message Modal -->
    @if ($hidden)
        <div class="createMessage" x-transition>
            <h3>Crear mensaje automático</h3>
            <textarea wire:model="message" placeholder="Escribe el contenido de la plantilla..."></textarea>
            <button wire:click="save">Guardar Plantilla</button>
            <span class="material-symbols-outlined" 
                  wire:click="active" 
                  style="position: absolute; top: 1.5rem; right: 1.5rem; cursor: pointer; color: #9ca3af;">
                close
            </span>
        </div>
        <div style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 999;" wire:click="active"></div>
    @endif

    <!-- Success Notification -->
    @if (session('success'))
        <div class="card" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
             style="position: fixed; bottom: 2rem; right: 2rem; z-index: 5000;">
            <div class="message-text-container" style="background: white; padding: 1rem 2rem; border-radius: 1rem; box-shadow: 0 10px 15px rgba(0,0,0,0.1); border-left: 5px solid #10b981;">
                <p class="message-text" style="font-weight: 800; color: #065f46; margin: 0;">¡Éxito!</p>
                <p class="sub-text" style="font-size: 0.9rem; color: #059669; margin: 0;">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="card" style="position: fixed; bottom: 2rem; right: 2rem; z-index: 5000;">
            <div class="message-text-container" style="background: white; padding: 1rem 2rem; border-radius: 1rem; box-shadow: 0 10px 15px rgba(0,0,0,0.1); border-left: 5px solid #ef4444;">
                <p class="message-text" style="font-weight: 800; color: #991b1b; margin: 0;">Error</p>
                <p class="sub-text" style="font-size: 0.9rem; color: #dc2626; margin: 0;">{{ session('error') }}</p>
            </div>
        </div>
    @endif
</section>