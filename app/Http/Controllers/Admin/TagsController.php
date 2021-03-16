<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use App\Models\Tag;

class TagsController extends Controller 
{

    public function index() 
    {
        return view('admin.tags.index');
    }

    public function datatable(Request $request) 
    {
        $query = Tag::query();
        return DataTables::of($query)
                        ->addColumn('actions', function($tag) {
                            return view('admin.tags.partials.actions', ['tag' => $tag]);
                        })
                        ->editColumn('id', function($tag) {
                            return '#' . $tag->id;
                        })
                        ->editColumn('name', function($tag) {
                            return '<strong>' . $tag->name . '</strong>';
                        })
                        ->rawColumns(['id','name', 'actions'])
                        ->make(true);
    }

    public function create() 
    {
        $tag = new Tag();
        return view('admin.tags.create', [
            'tag' => $tag
        ]);
    }
    
    public function store(Request $request) 
    {
        $formData = $request->validate([           
            'name' => ['required', 'string','max:50','unique:tags,name'],
        ]);
        
        $newTag = new Tag($formData);       
        $newTag->save();         
        
        session()->flash('system_message',__('Tag has been added successfully!!'));
            
        return redirect()->route('admin.tags.index');
    }
    
    public function edit(Tag $tag) 
    {
        return view('admin.tags.edit', [
            'tag' => $tag
        ]);
    }
    
    public function update(Request $request,Tag $tag) 
    {
        
        $formData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('tags')
                ->ignore($tag->id)],
        ]);
        
        $tag->fill($formData);        
        
        $tag->save();
        
        //session()->flash('system_message',__('Tag has been changed successfully!!'));
        
        return response()->json([
            'system_message' => __('Tag has been changed successfully!!')          
        ]);
            
        //return redirect()->route('admin.tags.index');
    }

    public function delete(Request $request) 
    {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:tags,id']
        ]);

        $tag = Tag::findOrFail($formData['id']);
        //potrebno je srediti brisanje post tagove
        
        $tag->delete();
        return response()->json([
            'system_message' => __('Tag photo has been deleted')          
        ]);
    }

}
