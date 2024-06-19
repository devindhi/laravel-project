<?php
namespace App\Repositories;

use App\Models\blog;

class BlogsRepo{

    public function createBlog($validatedData){
        $blog = Blog::create($validatedData);
    }

    public function getAll()
    {
        return Blog::all();
    }

    public function deleteBlog($id){
        $blog = blog::findOrFail($id);
        $blogId = $blog->blog_id;
        $blog->delete();
        return $blogId;
    }

    public function findById($id)
    {
        return Blog::findOrFail($id);
    }

    public function save(Blog $blog)
    {
        return $blog->save();
    }
    public function delete(Blog $blog)
    {
        $blog->delete();
    }

}


