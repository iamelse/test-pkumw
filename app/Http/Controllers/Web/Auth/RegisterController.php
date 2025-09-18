<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Auth\RegisterRequest;
use App\Models\User;
use App\Services\ImageManagementService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function __construct(
        protected ImageManagementService $imageManagementService
    ) {}

    public function index(): View
    {
        return view('pages.auth.register', [
            'title' => 'Sign Up | Talavel'
        ]);
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        try {
            // Upload image (jika ada)
            $imagePath = $this->_handleImageUpload($request);

            // Simpan user ke database
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'photo'    => $imagePath,
            ]);

            // Login otomatis
            Auth::login($user);

            return redirect()
                ->intended(route('be.dashboard.index'))
                ->with('success', 'Registration successful! Welcome, ' . $user->name);
        } catch (Exception $e) {
            Log::error('Register error: ' . $e->getMessage());

            return back()
                ->withErrors(['register' => 'Something went wrong. Please try again.'])
                ->withInput($request->except('password'));
        }
    }

    /**
     * Handle image upload before creating the user.
     */
    private function _handleImageUpload($request): ?string
    {
        if (!$request->hasFile('photo')) {
            return null;
        }

        return $this->imageManagementService->uploadImage(
            $request->file('photo'),
            [
                'disk'   => env('FILESYSTEM_DISK', 'public'),
                'folder' => 'uploads/user_profiles',
            ]
        );
    }
}