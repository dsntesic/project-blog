<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use App\User;

class UsersController extends Controller {

    public function index() {
        return view('admin.users.index');
    }

    public function datatable(Request $request) {
        $searchTerm = $request->validate([
            'status' => ['nullable', 'numeric', 'in:' . implode(',', User::STATUS_ALL)],
            'email' => ['nullable', 'string'],
            'name' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
        ]);
        $query = User::query()
                ->filterSearchTerm($searchTerm);
        return DataTables::of($query)
                        ->addColumn('status', function($user) {
                            return view('admin.users.partials.status', ['user' => $user]);
                        })
                        ->addColumn('photo', function($user) {
                            return view('admin.users.partials.photo', ['user' => $user]);
                        })
                        ->addColumn('actions', function($user) {
                            return view('admin.users.partials.actions', ['user' => $user]);
                        })
                        ->editColumn('id', function($user) {
                            return '#' . $user->id;
                        })
                        ->editColumn('name', function($user) {
                            return '<strong>' . $user->name . '</strong>';
                        })
                        ->rawColumns(['id', 'photo', 'name', 'actions'])
                        ->make(true);
    }

    public function create() {
        $user = new User();
        return view('admin.users.create', [
            'user' => $user
        ]);
    }
    
    public function store(Request $request) {
        $formData = $request->validate($this->validationRules());
        
        $newUser = new User($formData);
        
        $newUser->password = \Hash::make('admin');
        
        $newUser->save();
        
        if($request->hasFile('photo')){
            
            $newUser->photo = $this->storageUserPhoto($request, $newUser);
            $newUser->save();
        }         
        
        session()->flash('system_message',__('User has been added successfully!!'));
            
        return redirect()->route('admin.users.index');
    }
    
    public function edit(User $user) {
        return view('admin.users.edit', [
            'user' => $user
        ]);
    }
    
    public function update(Request $request,User $user) {
        
        $formData = $request->validate($this->validationRules($user));
        
        $user->fill($formData);
        
        
        if($request->hasFile('photo')){  
            $user->deletePhotoFromStorage();
            $user->photo = $this->storageUserPhoto($request, $user);
        }         
        
        $user->save();
        
        session()->flash('system_message',__('User has been changed successfully!!'));
            
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
            'system_message' => __('User photo has been deleted'),
            'user_photo' => $user->getPhotoUrl(),           
        ]);
    }
    public function active(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:users,id']
        ]);

        $user = User::findOrFail($formData['id']);
        $user->status = User::STATUS_ACTIVE;
        $user->save();
        return response()->json([
                    'system_message' => __('User has been activated')
        ]);
    }

    public function ban(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:users,id']
        ]);

        $user = User::findOrFail($formData['id']);
        $user->status = User::STATUS_BAN;
        $user->save();
        return response()->json([
                    'system_message' => __('User has been banned')
        ]);
    }
    
    protected function validationRules(User $user = null) {
        
        $uniqueEmail = $user?$this->validationEmail($user):'unique:users,email';
        
        return [
            'email' => [
                'required',
                'email',
                $uniqueEmail
            ],
            'name' => ['required', 'string','max:50'],
            'phone' => ['required', 'string','min:12','max:13','regex:/^\+(3816)\d{7,8}$/'],
            'photo' => ['nullable', 'image','max:65000'],
        ];
    }
    
    protected function validationEmail(User $user) 
    {
        return Rule::unique('users')
                ->ignore($user->id);
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
