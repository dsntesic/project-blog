<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategoriesController extends Controller 
{

    public function index() 
    {
        return view('admin.categories.index');
    }

    public function datatable(Request $request) 
    {
        $query = Category::query();
        return DataTables::of($query)
                        ->addColumn('actions', function($category) {
                            return view('admin.categories.partials.actions', ['category' => $category]);
                        })
                        ->editColumn('id', function($category) {
                            return view('admin.categories.partials.sortable_id', ['category' => $category]);
                        })
                        ->editColumn('name', function($category) {
                            return '<strong>' . $category->name . '</strong>';
                        })
                        ->editColumn('description', function($category) {
                            return \Str::limit($category->description,50);
                        })
                        ->rawColumns(['id','name', 'description','actions'])
                        ->make(true);
    }

    public function create() 
    {
        $category = new Category();
        return view('admin.categories.create', [
            'category' => $category
        ]);
    }
    
    public function store(Request $request) 
    {
        $formData = $request->validate([           
            'name' => ['required', 'string','max:50','unique:categories,name'],           
            'description' => ['required','string','between:50,255'],           
        ]);
        
        $newCategory = new Category($formData); 
        
        $newCategory->priority = Category::getPriorityForCategory();
       
        $newCategory->save();         
        
        session()->flash('system_message',__('Category has been added successfully!!'));
            
        return redirect()->route('admin.categories.index');
    }
    
    public function edit(Category $category) 
    {
        return view('admin.categories.edit', [
            'category' => $category
        ]);
    }
    
    public function update(Request $request,Category $category) 
    {
        
        $formData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('categories')
                ->ignore($category->id)
            ],
            'description' => ['required','string','between:50,255'],
        ]);
        
        $category->fill($formData);        
        
        $category->save();
        
        session()->flash('system_message',__('Category has been changed successfully!!'));
            
        return redirect()->route('admin.categories.index');
    }
    
    public function changePriorities(Request $request) 
    {   
        $formData = $request->validate([
                'category_ids' => ['required','string'],
                'priorities' => ['required','string'],
        ]);
        
        $combineCategoryIdsPriorities = array_combine(
                                            explode(',',$formData['category_ids']), 
                                            explode(',',$formData['priorities'])
        );
        
        foreach ($combineCategoryIdsPriorities as $id => $priority) {
            $category = Category::findOrFail($id);
            if($category->priority == $priority){
                continue;
            }
            $category->priority = $priority;
            $category->save();
        }
            
        return response()->json([
            'system_message' => __('Priority of the brand has been changed successfully!!')          
        ]);
    }

    public function delete(Request $request) 
    {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:categories,id']
        ]);

        $category = Category::findOrFail($formData['id']);
        $category ->delete();
        
        DB::table('categories')
            ->where('priority','>',$category->priority)
            ->decrement('priority');
        
        return response()->json([
            'system_message' => __('Category photo has been deleted')          
        ]);
    }

}
