<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Slider;

class SlidersController extends Controller 
{

    public function index() 
    {
        return view('admin.sliders.index');
    }

    public function datatable(Request $request) 
    {
        $query = Slider::query();

        return DataTables::of($query)
                        ->addColumn('actions', function($slider) {
                            return view('admin.sliders.partials.actions', ['slider' => $slider]);
                        })
                        ->editColumn('id', function($slider) {
                            return view('admin.sliders.partials.sortable_id', ['slider' => $slider]);
                        })
                        ->editColumn('name', function($slider) {
                            return '<strong>' . e($slider->name) . '</strong>';
                        })
                        ->rawColumns(['id','name','actions'])
                        ->make(true);
    }

    public function create() 
    {
        $slider = new Slider();
        return view('admin.sliders.create', [
            'slider' => $slider
        ]);
    }
    
    public function store(Request $request) 
    {
        $formData = $request->validate($this->validationRules(new Slider()));
        
        $newSlider = new Slider($formData); 
        
        $newSlider->priority = Slider::getPriorityForSlider();
       
        $newSlider->save(); 
                
        $newSlider->photo = $this->storageSliderPhoto($request, $newSlider);
        
        $newSlider->save();
        
        session()->flash('system_message',__('Slider has been added successfully!!'));
            
        return redirect()->route('admin.sliders.index');
    }
    
    public function edit(Slider $slider) 
    {
        return view('admin.sliders.edit', [
            'slider' => $slider
        ]);
    }
    
    public function update(Request $request,Slider $slider) 
    {
        
        $formData = $request->validate($this->validationRules($slider));
        
        $slider->fill($formData);        
        
        $slider->save();
        
        session()->flash('system_message',__('Slider has been changed successfully!!'));
            
        return redirect()->route('admin.sliders.index');
    }
    
    public function changePriorities(Request $request) 
    {   
        $formData = $request->validate([
                'slider_ids' => ['required','string'],
                'page' => ['required','numeric'],
                'length' => ['required','numeric'],
        ]);
        $sliderIds = explode(',',$formData['slider_ids']);
        foreach ($sliderIds as $key => $id) {
            $slider = Slider::findOrFail($id);
            $slider->priority = $formData['page'] * $formData['length'] + $key + 1;
            $slider->save();
        }
            
        return response()->json([
            'system_message' => __('Priority of the slider has been changed successfully!!')          
        ]);
    }
    
    public function enable(Request $request) 
    {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:sliders,id']
        ]);

        $slider = Slider::findOrFail($formData['id']);
        $slider ->status = Slider::STATUS_ENABLE;        
        $slider->save();
        
        return response()->json([
            'system_message' => __('Slider photo has been enabled')          
        ]);
    }
    
    public function disable(Request $request) 
    {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:sliders,id']
        ]);

        $slider = Slider::findOrFail($formData['id']);
        $slider ->status = Slider::STATUS_DISABLE;        
        $slider->save();
        
        return response()->json([
            'system_message' => __('Slider photo has been disabled')          
        ]);
    }

    public function delete(Request $request) 
    {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:sliders,id']
        ]);

        $slider = Slider::findOrFail($formData['id']);
        $slider ->delete();
        $slider->deletePhotoFromStorage();        
        
        DB::table('sliders')
            ->where('priority','>',$slider->priority)
            ->decrement('priority');
        
        return response()->json([
            'system_message' => __('Slider has been deleted')          
        ]);
    }
    
    protected function validationRules(Slider $slider) {
        $validationPhoto = $slider->exists?'nullable':'required';
        return [          
            'name' => ['required', 'string','max:50','unique:sliders,name'],           
            'button_url' => ['required', 'string','regex:/((http:|https:)\/\/)|(\/)/'],           
            'button_title' => ['required', 'string','max:30','unique:sliders,name'],           
            'photo' => [$validationPhoto , 'image','max:65000'],          
        ];
    }
    
    /**
     * 
     * @param Request $request
     * @param Slider $slider
     * @return string
     */
    protected function storageSliderPhoto($request,$slider) 
    {
        
        $photoFile = $request->file('photo');
        
        $photoName = $slider->id . '-' . \Str::slug($request->name) .  '.' . $photoFile->extension();
        
        $photoFile->move(public_path('/storage/sliders/'),$photoName);
        
        return $photoName;
    }

}
