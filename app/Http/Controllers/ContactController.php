<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMailForm;

class ContactController extends Controller
{
    public function index() 
    {
        $latestBlogPostsWithMaxReviews = BlogPost::query()
                                        ->sortByMaxReviewsForOneMonth()
                                        ->limit(3)
                                        ->get();
        $latestBlogPosts = BlogPost::query()
                           ->with(['category'])
                           ->latestBlogPostWithStatusEnable()
                           ->limit(12)
                           ->get();
        $frontCategories = Category::query()
                    ->orderBy('priority','ASC')
                    ->get();
        return view('front.contact.index',[
            'latestBlogPostsWithMaxReviews' => $latestBlogPostsWithMaxReviews,
            'latestBlogPosts' => $latestBlogPosts,
            'frontCategories' => $frontCategories,
        ]);
    }
    
    public function sendMessage(Request $request) 
    {
        $formData = $request->validate([
            'contact_person' => ['required','string','between:2,255'],
            'contact_email' => ['required','email','max:255'],
            'message' => ['required','string','between:50,500'],
            'g-recaptcha-response' => ['required','recaptcha'],
        ]);
        Mail::to('dsntesic1985@gmail.com')
            ->send(new ContactMailForm($formData['contact_person'],$formData['contact_email'],$formData['message']));
        
        session()->flash('system_message',__('Your message has been received, we will contact you soon'));
        return redirect()->back(); 
    }
}
