    <?php

    use Illuminate\Support\Facades\Route;
    use Illuminate\Http\Request;
    use App\Models\User;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\HomeController;
    use App\Http\Controllers\PesanController;
    use App\Http\Controllers\BarangController;
    use App\Http\Controllers\HistoryController;
    use App\Http\Controllers\AdminUserController;
    use App\Http\Controllers\AdminPesananController;
    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\AdminController;
    

    Route::get('/', function () {

        if (Auth::check()) {
            return redirect('/home');
        }

        return redirect('/login');
    });
    Auth::routes();

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/pesan/{id}', [PesanController::class, 'index']);
    Route::post('/pesan/{id}', [PesanController::class, 'pesan']);

    Route::get('/barang/tambah', [BarangController::class, 'create']);
    Route::post('/barang/tambah', [BarangController::class, 'store']);

    Route::get('/reset-password', function () {
        return view('auth.reset-password');
    });

    Route::post('/reset-password', function (Request $request) {

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/login')->with('success', 'Password berhasil diubah');
    });

    Route::get('check-out', [PesanController::class, 'check_out']);
    Route::get('check-out/{id}', [PesanController::class, 'delete']);
    Route::get('konfirmasi-check-out', [PesanController::class, 'konfirmasi']);
    

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    Route::post('/profile/update', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::get('/history', [HistoryController::class, 'index']);
    Route::get('/history/{id}', [HistoryController::class, 'detail']);

    Route::post(
        'upload-bukti/{id}',
        [HistoryController::class,'uploadBukti']
    );

    // Admin routes
    Route::prefix('admin')->group(function () {
        Route::get('/pembayaran',
        [AdminController::class,'pembayaran']);

    Route::get('/approve/{id}',
        [AdminController::class,'approve']);

         Route::get('/pesanan',
        [AdminPesananController::class,'index']);

    Route::get('/pesanan/{id}',
        [AdminPesananController::class,'detail']);

  

    Route::get('/user',
        [AdminUserController::class,'index']);

    Route::get('/user/delete/{id}',
        [AdminUserController::class,'delete']);

    Route::get('/laporan',
    [AdminController::class,'laporan']);

    });
    
    Route::get('/barang', [BarangController::class, 'index']);

    Route::get('/barang/edit/{id}',
        [BarangController::class, 'edit']);

    Route::post('/barang/update/{id}',
        [BarangController::class, 'update']);

    Route::get('/barang/delete/{id}', [BarangController::class, 'destroy']);

    

   