@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">

        <div class="col-md-12">
            <a href="{{ url('home') }}" class="btn btn-primary">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="col-md-12 mt-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Data User
                    </li>
                </ol>
            </nav>
        </div>


<div class="container">

    <div class="card">

        <div class="card-body">

            <h3>Data User</h3>

            <table class="table table-bordered">

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>

                </thead>

                <tbody>

                @foreach($users as $user)

                <tr>

                    <td>{{ $user->id }}</td>

                    <td>{{ $user->name }}</td>

                    <td>{{ $user->email }}</td>

                    <td>{{ $user->role }}</td>

                    <td>

                        @if($user->role != 'admin')

                        <a href="{{ url('/admin/user/delete/'.$user->id) }}"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Hapus user ini?')">

                            Hapus

                        </a>

                        @endif

                    </td>

                </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection