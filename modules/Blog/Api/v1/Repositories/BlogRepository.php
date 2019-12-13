<?php

namespace Medom\Modules\Blog\Api\v1\Repositories;

use Medom\Modules\Blog\Models\Blog;
use Medom\Modules\Blog\Models\BlogTags;
use Medom\Modules\Blog\Models\BlogCategory;
use Medom\Modules\Blog\Models\BlogPhotos;
use Medom\Modules\BaseRepository;

class BlogRepository extends BaseRepository
{
    public function __construct()
    {
        $this->blogModel = new Blog;
        $this->blogTagModel = new BlogTags;
        $this->blogCategory = new BlogCategory;
        $this->blogPhotoModel = new BlogPhotos;
    }
    public function createBlog($data)
    {
        $image = $data['photo']->store('blogimages', 'public');
        $category_id = $this->blogCategory->where('name', $data['category'])->first();
        $shortdesc = $this->truncateWords($data['content'], 30, "...");
        if (!(is_array($data['tags'])))
            return response()->json(['status' => false, 'message' => 'tags are not in an array'], 500);

        $blog = $this->blogModel->create([
            'id' => $this->generateUuid(),
            'title' => $data['title'],
            'truncated' => $shortdesc,
            'content' => $data['content'],
            'category_id' => $category_id->id,
            'status' => $data['status']
        ]);
        if ($blog) {
            foreach ($data['tags'] as $tag) {
                BlogTags::create([
                    'id' => $this->generateUuid(),
                    'blog_id' => $blog->_id,
                    'tag' => $tag
                ]);
            }
            BlogPhotos::create([
                'id' => $this->generateUuid(),
                'blog_id' => $blog->_id,
                'photo' => $image
            ]);
            $result = array("details" => $blog, "images" => $image, "tags" => $data['tags']);
            return $result;
        } else {
            return response()->json(['status' => false, 'message' => 'an error occured, try agai'], 500);
        }
    }
    public function updateBlog($data, $id)
    {
        $shortdesc = $this->truncateWords($data['content'], 30, "...");
        $content = $data['content'];
        $blog = $this->blogModel->where('id', $id)->update([
            'title' => $data['title'],
            'truncated' => $shortdesc,
            'content' => $content
        ]);
        if ($blog) {
            return true;
        } else {
            return false;
        }
    }
    public function getAllBlogs()
    {
        $blogs = Blog::all();
        foreach ($blogs as $blog) {
            $blog['photos'] = $this->blogPhotoModel->where('blog_id', $blog->id)->select("photo")->get();
            $blog['tags'] = $this->blogTagModel->where('blog_id', $blog->id)->select("tag")->get();
            $blog['categoryname'] = BlogCategory::where('_id', $blog->category_id)->first();
            $result[] = $blog;
        }
        return $result;
    }
    public function getAllBlogsbyId($id)
    {
        $blog = $this->blogModel->where('_id', $id)->get();
        foreach ($blog as $blog) {
            $blog['photos'] = $this->blogPhotoModel->where('blog_id', $blog->id)->select("photo")->get();
            $blog['tags'] = $this->blogTagModel->where('blog_id', $blog->id)->select("tag")->get();
            $blog['categoryname'] = BlogCategory::where('_id', $blog->category_id)->first();
            $result[] = $blog;
        }
        return $result;
    }
    public function getbyCategory($category)
    {
        $categoryid = $this->blogCategory->where('name', $category[0])->value('_id');
        $blog = $this->blogModel->where('category_id', $categoryid)->get(); #->paginate(10);
        // return $blog;
        foreach ($blog as $blog) {
            $blog['photos'] = $this->blogPhotoModel->where('blog_id', $blog->id)->select("photo")->get();
            $blog['tags'] = $this->blogTagModel->where('blog_id', $blog->id)->select("tag")->get();
            $blog['categoryname'] = BlogCategory::where('_id', $blog->category_id)->first();
            $result[] = $blog;
        }
        return $result;
    }

    public function deleteBlog($id)
    {
        $deleteBlog = $this->blogModel->where('id', $id)->delete();
        $deleteTag = $this->blogTagModel->where('blog_id', $id)->delete($id);
        $getphoto=$this->blogPhotoModel->where('blog_id', $id)->first();
        $check=   unlink('storage/' . $getphoto->photo);
        // sN7CD8R4bxBZr6MrbbaFvOFgfB1FKHsyr0bGUBRK.jpeg
        $deletephoto = $this->blogPhotoModel->where('blog_id', $id)->delete($id);
        return $deleteBlog;
        if ($deleteBlog) {
            return $deleteBlog;
        } else {
            return false;
        }
    }
    public function createBlogCategory($data)
    {
        $blog = $this->blogCategory->create([
            'name' => $data['name'],
            'description' => $data['description']
        ]);
        if ($blog) {
            return $blog;
        } else {
            return false;
        }
    }
    public function updateCategory($data, $id)
    {
        $blog = $this->blogCategory->where('_id', $id)->update([
            'name' => $data['name'],
            'description' => $data['description']
        ]);
        if ($blog) {
            return $blog;
        } else {
            return false;
        }
    }
    public function getAllCategory()
    {
        $AllCategory = BlogCategory::all();
        return $AllCategory;
    }
    public function deleteCategory($id)
    {
        $deletecategory = $this->blogCategory->where('_id', $id)->delete();
        return $deletecategory;
    }
    public function truncateWords($input, $numwords, $padding = "")
    {
        $output = strtok($input, " \n");
        while (--$numwords > 0) $output .= " " . strtok(" \n");
        if ($output != $input) $output .= $padding;
        return $output;
        // dd($output);
    }
}
