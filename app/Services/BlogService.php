<?php

namespace App\Services;

use App\Helpers\DecodeJwt;
use App\Repositories\BlogsRepo;
use App\Repositories\CommentsRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Services\JwtServiceException;
use Illuminate\Support\Facades\Auth;

class BlogService
{
    protected $blogRepo;
    protected $commentRepo;
    private $jwtHelper;

    public function __construct(BlogsRepo $blogRepo,  CommentsRepo $commentRepo, DecodeJwt $jwtHelper)
    {
        $this->blogRepo = $blogRepo;
        $this->commentRepo = $commentRepo;
        $this->jwtHelper = $jwtHelper;
    }
    public function createBlog(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255', // max 255 char
            'content' => 'required|string',
            'image' => 'nullable|image|max:4048', // image is being uploaded, max is 2 MB
        ]);
    
        // Extract JWT token from headers
        $token = (string) $request->bearerToken(); // Get token from Authorization header
        $userDetails = $this->jwtHelper->decodeJwtToken($token);
    
        // Add the username and user ID to the validated data array
        $validatedData['username'] = $userDetails['name'] ?? null;
        $validatedData['user_id'] = $userDetails['id'] ?? null;
    
        // Initialize $imagePath to null
        $imagePath = null;
    
        // Upload and store image if provided
        if ($request->hasFile('image')) {
            $path = $request->file('image');
            $extension = $path->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $path->move(public_path('images'), $filename);
            $imagePath = 'images/' . $filename;
        }
    
        // Add the image path to validated data if an image was uploaded
        $validatedData['image'] = $imagePath;
    
        // Create the blog entry
        $blog = $this->blogRepo->createBlog($validatedData);
    
        // Log the creation of the blog
        Log::info("Blog created by user: {$userDetails['name']}", ['data' => $validatedData]);
    
        return $blog;
    }
    


    public function updateBlog(Request $request, $id)
{
    // Retrieve the blog by its ID
    $blog = $this->blogRepo->findById($id);

    // Update the blog's title and content based on the request input
    $blog->title = $request->input('title');
    $blog->content = $request->input('content');

    // Check if a new image file was uploaded
    if ($request->hasFile('image')) {
        $path = $request->file('image');
        $extension = $path->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $path->move(public_path('images'), $filename);
        $blog->image = 'images/' . $filename;
    }

    // Save the updated blog details
    $this->blogRepo->save($blog);
}


    public function deleteBlog($blogId)
    {
        // Retrieve the blog using the provided ID
        $blog = $this->blogRepo->findById($blogId);

        // Delete the blog
        return $this->blogRepo->delete($blog);
    }


    public function retriewBlogdata($id, Request $request)
    {
        // Retrieve the current user ID from the session
       // $userId = $request->session()->get('user_id');

        // Retrieve the blog using the provided ID
        $blog = $this->blogRepo->findById($id);

        return $blog;
    }

    
    public function viewBlogWithComments($id, Request $request)
    {
        // Get the token from the cookie
        $token = $request->cookie('jwt_token');


        Log::info('View comments', ['token' => $token]);

        if ($token) {
            $userDetails = $this->jwtHelper->decodeJwtToken($token);
            $userId = $userDetails['id'] ?? null;
            $hasAuth = true;  // Authentication is present
        } else {
            $userId = null;
            $hasAuth = false;  // No authentication
        }

        $blog = $this->blogRepo->findById($id);
        $comments = $this->commentRepo->findByBlogId($id);

        return [
            'blog' => $blog,
            'comments' => $comments,
            'userId' => $userId,
            'hasAuthToken' => $hasAuth
        ];
    }



    public function getAllBlogs(Request $request)
    {
        // Get the token from the cookie
        $token = $request->cookie('jwt_token');

        Log::info('Get All Blogs', ['token' => $token]);

        if ($token) {
            $userDetails = $this->jwtHelper->decodeJwtToken($token);
            $userId = $userDetails['id'] ?? null;
        } else {
            $userId = null;
        }

        $blogs = $this->blogRepo->getAll();

        return [
            'blogs' => $blogs,
            'userId' => $userId
        ];
    }
}
