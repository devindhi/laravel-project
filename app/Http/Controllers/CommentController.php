<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class commentController extends Controller
{

    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function store(Request $request, $blogId)
    {
        Log::info('in comments cntroler');
        $this->commentService->storeComment($request, $blogId);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Comment added successfully!');
    }


    // Delete comment
    public function delete($id)
    {
        try {
            // Use the service to delete the comment
            $blogId = $this->commentService->deleteComment($id);

            return redirect()->route('blog.view', ['id' => $blogId])->with('success', 'Comment deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('blog.view', ['id' => $blogId])->with('error', 'Failed to delete comment');
        }
    }
}
