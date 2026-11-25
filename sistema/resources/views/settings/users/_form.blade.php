{{-- Formulario compartido por create y edit.
     old('campo', $user->campo ?? '') muestra: lo que el usuario escribió si la validación falló,
     o el valor guardado al editar, o vacío al crear. --}}
<div class="row">
    <div class="col-12 col-md-6 mb-3">
        <label for="name" class="form-label">Nombre completo</label>
        <input type="text" name="name" id="name" maxlength="255"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $user->name ?? '') }}">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6 mb-3">
        <label for="rol_id" class="form-label">Rol</label>
        {{-- Clave foránea: se guarda rol_id, se muestra el nombre del rol --}}
        <select name="rol_id" id="rol_id" class="form-select @error('rol_id') is-invalid @enderror">
            <option value="">-- Seleccione --</option>
            @foreach ($roles as $role)
                {{-- @selected marca la opción guardada (al editar) o la elegida antes del error --}}
                <option value="{{ $role->id }}" @selected(old('rol_id', $user->rol_id ?? '') == $role->id)>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
        @error('rol_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-4 mb-3">
        <label for="dni" class="form-label">DNI</label>
        <input type="text" name="dni" id="dni" maxlength="8"
            class="form-control @error('dni') is-invalid @enderror"
            value="{{ old('dni', $user->dni ?? '') }}">
        @error('dni')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-4 mb-3">
        <label for="phone" class="form-label">Teléfono</label>
        <input type="text" name="phone" id="phone" maxlength="15"
            class="form-control @error('phone') is-invalid @enderror"
            value="{{ old('phone', $user->phone ?? '') }}">
        @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-4 mb-3">
        <label for="tuition" class="form-label">Colegiatura</label>
        <input type="text" name="tuition" id="tuition" maxlength="20"
            class="form-control @error('tuition') is-invalid @enderror"
            value="{{ old('tuition', $user->tuition ?? '') }}">
        @error('tuition')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 mb-3">
        <label for="email" class="form-label">Correo electrónico</label>
        <input type="email" name="email" id="email" maxlength="255"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $user->email ?? '') }}">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6 mb-3">
        <label for="password" class="form-label">
            Contraseña
            {{-- @isset: este texto solo aparece al editar, cuando $user existe --}}
            @isset($user)
                <small class="text-muted">(déjela vacía para no cambiarla)</small>
            @endisset
        </label>
        {{-- Nunca se rellena con value: la contraseña guardada está encriptada --}}
        <input type="password" name="password" id="password" autocomplete="new-password"
            class="form-control @error('password') is-invalid @enderror">
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6 mb-3">
        {{-- La regla 'confirmed' compara password con password_confirmation --}}
        <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
        <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password" class="form-control">
    </div>
</div>

<button type="submit" class="btn btn-primary text-white">Guardar</button>
<a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
