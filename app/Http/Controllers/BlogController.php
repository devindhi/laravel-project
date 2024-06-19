<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\blog;
use App\Models\comment;
use App\Services\BlogService;;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class blogController extends Controller
{
    protected $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    //creation of a blog
    public function store(Request $request)
    {
        Log::info('is in controller');
        $blog = $this->blogService->createBlog($request);

        $request->session()->flash('success', 'Blog created successfully');
        return redirect('/home')->with('success', 'Blog created successfully');
    }


    public function show(Request $request)
    {
        Log::info('Entering show method');

        // Retrieve JWT token from localStorage if available
        $hasToken = false; // Default value

        // Check if token exists in cookie
 if ($request->hasCookie('jwt_token')){
            $hasToken = true;
        }

        $result = $this->blogService->getAllBlogs($request);
        $blogs = $result['blogs'];
        $userId = $result['userId'];

        return view('home', compact('blogs', 'userId', 'hasToken'));
    }

    public function update(Request $request, $id)
    {
        $this->blogService->updateBlog($request, $id);

        return redirect()->route('home')->with('success', 'Blog updated successfully');
    }

    public function edit(Request $request, $id)
    {

        $blog = $this->blogService->retriewBlogdata($id, $request);
        // If the user is authorized, load the 'edit' view with the blog data
        return view('edit', compact('blog', 'id'));
    }


    // view blog related comments
    public function view(Request $request, $id)
    {
        Log::info('Entering view method with ID: ' . $id);

        try {
            // Retrieve the data from the blog service
            $data = $this->blogService->viewBlogWithComments($id, $request);

            // Return the view with the data
            return view('blog', $data);
        } catch (\Exception $e) {
            Log::error('Error in view method: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load blog'], 500);
        }
    }



    public function delete(Request $request, $id)
    {
        // Use the service to delete the blog
        $this->blogService->deleteBlog($id);

        return redirect()->route('home')->with('success', 'Blog deleted successfully');
    }
}
