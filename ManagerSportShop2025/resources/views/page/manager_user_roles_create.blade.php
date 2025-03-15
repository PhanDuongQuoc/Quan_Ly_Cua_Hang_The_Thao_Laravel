@extends('dashboard_master')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Thêm phân quyền cho tài khoản</h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('manager_role_users.store') }}" method="POST">
                @csrf


                <div class="mb-3">
                    <label class="form-label">ID người dùng - hiển thị dưới dạng tên tài khoản</label>
                    <select name="user_id" class="form-select" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->email }}</option>
                    @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Id quyền người dùng - hiển thị giới dang tên quyền người dùng</label>
                    <select name="role_id" class="form-select" required>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu phân quyền</button>
                <a href="{{ route('manager_role_users') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</a>
            </form>
        </div>
    </div>
</div>
@endsection
