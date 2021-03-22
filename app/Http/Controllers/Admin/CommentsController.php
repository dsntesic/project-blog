<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Comment;
use App\Models\BlogPost;

class CommentsController extends Controller 
{

    public function index() 
    {
        $blogPosts = BlogPost::query()
                  ->isEnable()
                  ->orderBy('created_at','desc')
                  ->get();
        return view('admin.comments.index',[
            'blogPosts' => $blogPosts,
        ]);
    }

    public function datatable(Request $request) 
    {
        $serachFormTerm = $request->validate($this->validationSearchFormRules());
        $query = Comment::query()
                ->with(['blogPost'])
                ->join('blog_posts','comments.blog_post_id','=','blog_posts.id')
                ->select('comments.*','blog_posts.name as blog_post_name')
                ->filterSearchTerm($serachFormTerm);
        return DataTables::of($query)
                        ->addColumn('actions', function($comment) {
                            return view('admin.comments.partials.actions', ['comment' => $comment]);
                        })                       
                        ->editColumn('message', function($comment) {
                            return  (\Str::limit($comment->message,30)) ;
                        })
                        ->editColumn('blog_post_name', function($comment) {
                            return  (\Str::limit($comment->blog_post_name,30)) ;
                        })
                        ->editColumn('status', function($comment) {
                            return view('admin.comments.partials.status', ['comment' => $comment]);
                        })
                        ->rawColumns(['status','actions'])
                        ->filter(function ($query) use ($request){
                            if(
                                $request->has('search') &&
                                is_array($request->get('search')) &&
                                isset($request->get('search')['value'])
                            ){
                                $searchTerm = $request->get('search')['value'];
                                $query->where(function ($query) use ($searchTerm) {

                                        $query->orWhere('blog_posts.name', 'LIKE', '%' . $searchTerm . '%')
                                              ->orWhere('comments.message', 'LIKE', '%' . $searchTerm . '%')
                                              ->orWhere('comments.name', 'LIKE', '%' . $searchTerm . '%')
                                              ->orWhere('comments.email', 'LIKE', '%' . $searchTerm . '%');
                                });
                            }
                        })
                        ->make(true);
    }
    
    public function enable(Request $request) 
    {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:comments,id']
        ]);

        $comment = Comment::findOrFail($formData['id']);
        $comment ->status = Comment::STATUS_ENABLE;        
        $comment->save();
        
        return response()->json([
            'system_message' => __('Comment has been enabled')          
        ]);
    }
    
    public function disable(Request $request) 
    {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:comments,id']
        ]);

        $comment = Comment::findOrFail($formData['id']);
        $comment ->status = Comment::STATUS_DISABLE;        
        $comment->save();
        
        return response()->json([
            'system_message' => __('Comment has been disabled')          
        ]);
    }

    protected function validationSearchFormRules() {
        return [
            'blog_post_id' => ['nullable', 'numeric','exists:blog_posts,id'],
            'status' => ['nullable', 'numeric','in:' . implode(',', Comment::STATUS_ALL)],
        ];
    }

}
