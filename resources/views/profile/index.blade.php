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
                        <li class="breadcrumb-item active" aria-current="page">
                            Profile
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
                        <h4><i class="fa fa-user"></i> My Profile</h4>
                        <div class="text-center mb-3">

    @if($user->foto)
        <img src="{{ asset('uploads/profile/'.$user->foto) }}"
             width="150"
             height="150"
             style="object-fit:cover;border-radius:50%;">
    @else
        <img src="https://ui-avatars.com/api/?name={{ $user->name }}"
             width="150"
             height="150"
             style="border-radius:50%;">
    @endif

</div>

                        <table class="table table-bordered">
                            <tbody>
        <tr>
            <td width="200">Nama</td>
            <td width="10">:</td>
            <td>{{ $user->name }}</td>
        </tr>

        <tr>
            <td>Email</td>
            <td>:</td>
            <td>{{ $user->email }}</td>
        </tr>

        <tr>
            <td>No HP</td>
            <td>:</td>
            <td>{{ $user->nohp }}</td>
        </tr>

        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $user->alamat }}</td>
        </tr>
    </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <h4>
                            <i class="fa fa-pencil-alt"></i>
                            Edit Profile
                        </h4>

                        <form method="POST"
      action="{{ route('profile.update') }}"
      enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="name"
                                    class="col-md-2 col-form-label text-md-right">
                                    {{ __('Name') }}
                                </label>

                                <div class="col-md-6">
                                    <input id="name"
                                        type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        name="name"
                                        value="{{ $user->name }}"
                                                                                autocomplete="name"
                                        autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email"
                                    class="col-md-2 col-form-label text-md-right">
                                    {{ __('E-Mail Address') }}
                                </label>

                                <div class="col-md-6">
                                    <input id="email"
                                        type="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        name="email"
                                        value="{{ $user->email }}"
                                        
                                        autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div><div class="form-group row">
    <label class="col-md-2 col-form-label text-md-right">
        Foto Profil
    </label>

    <div class="col-md-6">
        <input type="file"
               name="foto"
               class="form-control">
    </div>
</div>
                        

                            <div class="form-group row">
        <label class="col-md-2 col-form-label text-md-right">
            No HP
        </label>

        <div class="col-md-6">
            <input type="text"
                name="nohp"
                class="form-control"
                inputmode ="numeric"
                value="{{ $user->nohp }}"
                oninput="this.value = this.value.replace(/[^0-8]/g, '')">
                
        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-2 col-form-label text-md-right">
            Alamat
        </label>

        <div class="col-md-6">
            <textarea name="alamat"
                    class="form-control"
                    rows="3">{{ $user->alamat }}</textarea>
        </div>
    </div>

                            <div class="form-group row">
                                <label for="password"
                                    class="col-md-2 col-form-label text-md-right">
                                    {{ __('Password') }}
                                </label>

                                <div class="col-md-6">
                                    <input id="password"
                                        type="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        name="password"
                                        
                                        autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm"
                                    class="col-md-2 col-form-label text-md-right">
                                    {{ __('Confirm Password') }}
                                </label>

                                <div class="col-md-6">
                                    <input id="password-confirm"
                                        type="password"
                                        class="form-control"
                                        name="password_confirmation"
                                        
                                        autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit"
                                            class="btn btn-primary">
                                    Save Changes
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @endsection