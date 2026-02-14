<div class="children-container">
    <div class="header-section">
        <h2>Mis Hijos / Acudidos</h2>
        <p>Selecciona un estudiante para ver su información detallada.</p>
    </div>

    <div class="children-grid">
        @forelse ($children as $child)
            <a href="{{ route('informacion', $child->id) }}" class="child-card">
                <div class="child-avatar">
                    @if ($child->imagen)
                        <img src="{{ asset('users/' . $child->imagen) }}" alt="{{ $child->name }}">
                    @else
                        <img src="{{ asset('images/perfil.png') }}" alt="Perfil">
                    @endif
                </div>
                <div class="child-info">
                    <h3>{{ $child->name }} {{ $child->apellido }}</h3>
                    <span class="badge {{ $child->estado ? 'active' : 'inactive' }}">
                        {{ $child->estado ? 'Activo' : 'Inactivo' }}
                    </span>
                    <div class="details">
                        <span>{{ $child->group->name ?? 'Sin Grupo' }}</span>
                        <span>{{ $child->sede->sede ?? 'Sede N/A' }}</span>
                    </div>
                </div>
                <div class="action-icon">
                    <span class="material-symbols-outlined">arrow_forward_ios</span>
                </div>
            </a>
        @empty
            <div class="no-data">
                <span class="material-symbols-outlined">face_dissatisfied</span>
                <p>No se encontraron estudiantes asociados a tu cuenta.</p>
            </div>
        @endforelse
    </div>

</div>
