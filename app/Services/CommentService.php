<?php

namespace App\Services;

use App\Models\Comment;
use App\Repositories\CommentsRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Helpers\DecodeJwt;

class CommentService
{
    protected $commentRepo;
    private $jwtHelper;

    public function __construct(CommentsRepo $commentRepo, DecodeJwt $jwtHelper)
    {
        $this->commentRepo = $commentRepo;
        $this->jwtHelper = $jwtHelper;
    }

    public function storeComment(Request $request, $blogId)
    {
        Log::info('in create comment');
      
        // Extract JWT token from headers
        $token = (string) $request->bearerToken(); // Get token from Authorization header

        Log::info($token);
        $userDetails = $this->jwtHelper->decodeJwtToken($token);

        // Validate the comment
        $validatedData = $request->validate([
            'comment' => 'required|string',
        ]);

        // Add the username and user ID to the validated data array
        $validatedData['username'] = $userDetails['name'] ?? null;
        $validatedData['user_id'] = $userDetails['id'] ?? null;
        $validatedData['blog_id'] = $blogId;

        // Call the repository to store the comment
        $comment = $this->commentRepo->createComment($validatedData);
        Log::info("Comment added by user: ", ['data' => $validatedData]);

        return $comment;
    }

    public function deleteComment($id)
    {
        $comment = $this->commentRepo->findById($id);
        $blogId = $comment->blog_id;
        $this->commentRepo->delete($comment);

        return $blogId;
    }
}
