<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Profile\UpdateUserProfileRequest;
use App\Models\User;
use App\Services\ImageManagementService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserProfileController extends Controller
{
    public function __construct(
        protected ImageManagementService $imageManagementService
    ) {}
    
    public function show()
    {
        $user = Auth::user();
        
        return view('pages.backend.user-profile', [
            'title' => 'Profile ' . $user->name,
            'user' => $user,
        ]);
    }

    public function update(UpdateUserProfileRequest $request)
    {
        try {
            $user = Auth::user();

            $imagePath = $this->_handleImageUpload($request, $user);

            $data = [
                'name'     => $request->name,
                'username' => $request->username,
                'email'    => $request->email,
            ];

            if ($imagePath) {
                $data['photo'] = $imagePath;
            }

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            return redirect()
                ->route('be.user_profile.show')
                ->with('success', 'Profile updated successfully.');
        } catch (Exception $e) {
            Log::error('User update failed', [
                'user_id' => Auth::id(),
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return redirect()
                ->route('be.user_profile.show')
                ->with('error', 'Failed to update profile. Please try again.');
        }
    }

    /**
     * Handle image upload before creating the user.
     */
    private function _handleImageUpload($request, $user): ?string
    {
        $imagePath = null;
        
        if ($request->has('remove_photo') && $request->remove_photo == 1) {
            $this->imageManagementService->destroyImage($user->photo);
    
            $user->photo = null;
            return null;
        }

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');

            $imagePath = $this->imageManagementService->uploadImage($image, [
                'currentImagePath' => $user->photo,
                'disk' => env('FILESYSTEM_DISK'),
                'folder' => 'uploads/user_profiles'
            ]);

            $user->photo = $imagePath;
        }

        return $imagePath;
    }
}
