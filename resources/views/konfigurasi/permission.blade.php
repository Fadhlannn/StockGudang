@extends('layouts/app', ['activePage' => 'permission', 'title' => 'Permission'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                @foreach ($roles as $role)
                    <div class="col-md-4">
                        <div class="card-permission mb-4 shadow-sm border-light">
                            <div class="card-permission-header bg-primary text-white">
                                <h4 class="mb-0">{{ $role->role }}</h4>
                            </div>
                            <div class="card-permission-body">
                                <form action="{{ route('permissions.update', $role->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    @foreach ($permissions as $permission)
                                        <div class="form-check mb-3">
                                            <input type="checkbox"  class="form-check-input" name="permissions[]" value="{{ $permission->id }}"
                                                {{ in_array($permission->id, $rolePermissions->where('role_id', $role->id)->where('can_access', true)->pluck('permission_id')->toArray()) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="check{{ $permission->id }}">{{ $permission->name }}</label>
                                        </div>
                                    @endforeach

                                    <button type="submit" class="btn btn-primary w-100 mt-3">Simpan Perubahan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
