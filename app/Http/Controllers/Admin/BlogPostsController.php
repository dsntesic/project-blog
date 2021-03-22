<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Tag;
use App\User;

class BlogPostsController extends Controller 
{

    public function index() 
    {
        $categories = Category::query()
                    ->orderBy('priority','asc')
                    ->get();
        $tags = Tag::query()
                    ->orderBy('created_at','desc')
                    ->get();
        $autors = User::query()
                  ->where('status','LIKE', User::STATUS_ACTIVE)
                  ->orderBy('created_at','desc')
                  ->get();
        return view('admin.blog_posts.index',[
            'categories' => $categories,
            'tags' => $tags,
            'autors' => $autors,
        ]);
    }

    public function datatable(Request $request) 
    {
        $serachFormTerm = $request->validate($this->validationSearchFormRules());
        $query = BlogPost::query()
                ->with(['category','tags',
                    'comments' =>function($query){
                        return $query->isEnable();
                    }
                ])
                ->join('users','blog_posts.user_id','=','users.id')
                ->select('blog_posts.*','users.name as autor_name')
                ->filterSearchTerm($serachFormTerm);
        return DataTables::of($query)
                        ->addColumn('actions', function($blogPost) {
                            return view('admin.blog_posts.partials.actions', ['blogPost' => $blogPost]);
                        })
                        ->addColumn('category_name', function($blogPost) {
                            return optional($blogPost->category)->name??'Uncategorized';
                        })
                        ->editColumn('comments', function($blogPost) {
                            return $blogPost->comments->count();
                        })
                        ->editColumn('photo', function($blogPost) {
                            return view('admin.blog_posts.partials.photo', ['blogPost' => $blogPost]);
                        })
                        ->editColumn('status', function($blogPost) {
                            return view('admin.blog_posts.partials.status', ['blogPost' => $blogPost]);
                        })
                        ->editColumn('important', function($blogPost) {
                            return view('admin.blog_posts.partials.important', ['blogPost' => $blogPost]);
                        })
                        ->editColumn('name', function($blogPost) {
                            return '<strong>' . e(\Str::limit($blogPost->name,20)) . '</strong>';
                        })
                        ->rawColumns(['status','important','name','comments','actions'])
                        ->filter(function ($query) use ($request){
                            if(
                                $request->has('search') &&
                                is_array($request->get('search')) &&
                                isset($request->get('search')['value'])
                            ){
                                $searchTerm = $request->get('search')['value'];
                                $query->where(function ($query) use ($searchTerm) {

                                        $query->orWhere('blog_posts.name', 'LIKE', '%' . $searchTerm . '%')
                                              ->orWhere('blog_posts.description', 'LIKE', '%' . $searchTerm . '%')
                                              ->orWhere('users.name', 'LIKE', '%' . $searchTerm . '%');
				});
                            }
                        })
                        ->make(true);
    }

    public function create() 
    {
        $blogPost = new BlogPost();
        $categories = Category::query()
                    ->orderBy('priority','asc')
                    ->get();
        $tags = Tag::query()
                    ->latest()
                    ->get();
        return view('admin.blog_posts.create', [
            'blogPost' => $blogPost,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }
    
    public function store(Request $request) 
    {
        $formData = $request->validate($this->validationRules(new BlogPost()));
        
        $newBlogPost = new BlogPost($formData);
        
        $newBlogPost->user_id = auth()->user()->id;
        $newBlogPost->status = BlogPost::STATUS_ENABLE;
        $newBlogPost->important = BlogPost::IMPORTANT_NO;
       
        $newBlogPost->save();
        
        $newBlogPost->photo = $this->storageBlogPostPhoto($request, $newBlogPost);
        $newBlogPost->save();
                
        $newBlogPost->tags()->sync($formData['tag_id']);
        
        session()->flash('system_message',__('Blog Post has been added successfully!!'));
            
        return redirect()->route('admin.blog_posts.index');
    }
    
    public function edit(BlogPost $blogPost) 
    {
        $categories = Category::query()
                    ->orderBy('priority','asc')
                    ->get();
        $tags = Tag::query()
                    ->latest()
                    ->get();
        return view('admin.blog_posts.edit', [
            'blogPost' => $blogPost,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }
    
    public function update(Request $request,BlogPost $blogPost) 
    {
        
        $formData = $request->validate($this->validationRules($blogPost));
        
        $blogPost->fill($formData);
        
        if($request->hasFile('photo')){  
            $blogPost->deletePhotoFromStorage();
            $blogPost->photo = $this->storageBlogPostPhoto($request, $blogPost);
        }
        
        $blogPost->save();
                  
        $blogPost->tags()->sync($formData['tag_id']);
        
        session()->flash('system_message',__('Blog Post has been changed successfully!!'));
            
        return redirect()->route('admin.blog_posts.index');
    }

    public function enable(Request $request) 
    {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:blog_posts,id']
        ]);

        $blogPost = BlogPost::findOrFail($formData['id']);
        $blogPost ->status = BlogPost::STATUS_ENABLE;        
        $blogPost->save();
        
        return response()->json([
            'system_message' => __('Blog Post has been enabled')          
        ]);
    }
    
    public function disable(Request $request) 
    {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:blog_posts,id']
        ]);

        $blogPost = BlogPost::findOrFail($formData['id']);
        $blogPost ->status = BlogPost::STATUS_DISABLE;        
        $blogPost->save();
        
        return response()->json([
            'system_message' => __('Blog Post has been disabled')          
        ]);
    }
    
    public function important(Request $request) 
    {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:blog_posts,id']
        ]);

        $blogPost = BlogPost::findOrFail($formData['id']);
        
        $blogPost ->important = BlogPost::IMPORTANT_YES;

        $blogPost->save();
        
        return response()->json([
            'system_message' => __('Blog post has been important')          
        ]);
    }
    
    public function noImportant(Request $request) 
    {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:blog_posts,id']
        ]);

        $blogPost = BlogPost::findOrFail($formData['id']);
        
        $blogPost ->important = BlogPost::IMPORTANT_NO;

        $blogPost->save();
        
        return response()->json([
            'system_message' => __('Blog post has been no important')          
        ]);
    }
    
    public function delete(Request $request) 
    {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:blog_posts,id']
        ]);

        $blogPost = BlogPost::findOrFail($formData['id']);
        $blogPost ->delete();
        $blogPost->deletePhotoFromStorage();        
        $blogPost->tags()->sync([]);
        
        return response()->json([
            'system_message' => __('Blog Post has been deleted')          
        ]);
    }
    
    protected function validationRules(BlogPost $blogPost) {
        $validationPhoto = $blogPost->exists?'nullable':'required';
        return [
            
            'photo' => [$validationPhoto , 'image','max:65000'],
            'name' => ['required', 'string', 'min:20', 'max:255'],
            'description' => ['required', 'string','min:50','max:500'],
            'content' => ['nullable', 'string'],
            'category_id' => ['nullable', 'numeric','exists:categories,id'],
            'tag_id' => ['required', 'array','exists:tags,id'],
        ];
    }
    
    protected function validationSearchFormRules() {
        return [
            'name' => ['nullable', 'string'],
            'category_id' => ['nullable', 'numeric','exists:categories,id'],
            'user_id' => ['nullable', 'numeric','exists:users,id'],
            'status' => ['nullable', 'numeric','in:' . implode(',', BlogPost::STATUS_ALL)],
            'important' => ['nullable', 'numeric','in:' . implode(',', BlogPost::IMPORTANT)],
            'tag_id' => ['nullable', 'array','exists:tags,id'],
        ];
    }
    
    /**
     * 
     * @param Request $request
     * @param BlogPost $blogPost
     * @return string
     */
    protected function storageBlogPostPhoto($request,$blogPost) 
    {
        
        $photoFile = $request->file('photo');
        $photoName = $blogPost->id . '-' . \Str::slug($request->name) .  '.' . $photoFile->extension();        
        $photoFile->move(public_path('/storage/blog_posts/'),$photoName);
        
        \Image::make(public_path("/storage/blog_posts/$photoName"))
        ->fit(256,256)
        ->save(public_path("/storage/blog_posts/thumbs/$photoName"));
        
        \Image::make(public_path("/storage/blog_posts/$photoName"))
                ->fit(640,450)
                ->save();

        return $photoName;
    }

}
