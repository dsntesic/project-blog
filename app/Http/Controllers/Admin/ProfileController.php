<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use App\User;

class ProfileController extends Controller {
    
    public function edit() {
        return view('admin.profile.edit');
    }
    
    public function update(Request $request) {
        $user = auth()->user();
        
        $formData = $request->validate([
            'name' => ['required', 'string','max:50'],
            'phone' => ['required', 'string','min:12','max:13','regex:/^\+(3816)\d{7,8}$/'],
            'photo' => ['nullable', 'image','max:65000'],
        ]);
       
        $user->fill($formData);   
        if($request->hasFile('photo')){  
            $user->deletePhotoFromStorage();
            $user->photo = $this->storageUserPhoto($request, $user);
        }         
        
        $user->save();
        
        session()->flash('system_message',__('Profile has been changed successfully!!'));
            
        return redirect()->route('admin.users.index');
    }
    
    public function showChangePassword() {
        return view('admin.profile.change_password');
    }
    
    public function changePassword(Request $request) {
        
        $user = auth()->user(); 
        
        $formData = $request->validate([
            'old_password' => [
                'required' ,
                'string',
                'min:5',
                function ($attribute, $value, $fail) use($user) {
                    if (!\Hash::check($value,$user->password)) {
                    $fail('You entered a wrong password');
                    }
                }
            ],
            'new_password' => ['required', 'string','min:5'],
            'confirm_password' => ['required', 'string','min:5','same:new_password'],
        ]);
            
        $user->password = \Hash::make($formData['new_password']);           
        
        $user->save();
        
        session()->flash('system_message',__('Password has been changed successfully!!'));
            
        return redirect()->route('admin.users.index');
    }

    public function deletePhoto(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:users,id']
        ]);

        $user = User::findOrFail($formData['id']);
        $user->deletePhotoFromStorage();
        $user->photo = null;
        $user->save();
        return response()->json([
            'system_message' => __('Profile photo has been deleted'),
            'profile_photo' => $user->getPhotoUrl(),           
        ]);
    }
    
    /**
     * 
     * @param Request $request
     * @param User $user
     * @return string
     */
    protected function storageUserPhoto($request,$user) 
    {
        
        $photoFile = $request->file('photo');
        $photoName = $user->id . '-' . \Str::slug($request->name) .  '.' . $photoFile->extension();        
        $photoFile->move(public_path('/storage/users/'),$photoName);
        \Image::make(public_path("/storage/users/$photoName"))
                ->fit(300,300)
                ->save();

        return $photoName;
    }

}
