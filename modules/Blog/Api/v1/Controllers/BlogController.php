<?php

namespace Medom\Modules\Blog\Api\v1\Controllers;

use Medom\Modules\BaseController;
use Medom\Modules\Blog\Api\v1\Repositories\BlogRepository;
use Illuminate\Http\Request;
use Medom\Modules\Blog\Api\v1\Requests\CreateBlogRequest;
use Medom\Modules\Blog\Api\v1\Requests\CreateBlogCategoryRequest;
use Medom\Modules\Blog\Api\v1\Requests\UpdateBlogCategoryRequest;
use Medom\Modules\Blog\Api\v1\Requests\UpdateBlogRequest;
use Medom\Modules\Blog\Api\v1\Transformers\BlogTransformer;
use Medom\Modules\Blog\Api\v1\Transformers\BlogPhotosTransformer;

class BlogController extends BaseController
{
    // use Notifiable;
    public function __construct(BlogRepository $blogRepo)
    {
        $this->blogRepo = $blogRepo;
        // $this->userTransformer = $userTransformer;
    }

    public function createBlog(CreateBlogRequest $request)
    {
        $data = $this->blogRepo->createBlog($request->all());
        if ($data) {
            return $this->success($data);
        } else {
            return $this->fail('unable to complete request');
        }
    }

    public function updateBlog(UpdateBlogRequest $request, $id)
    {

        $Blogs = $this->blogRepo->updateBlog($request->all(), $id);

        if ($Blogs) {
            $key=["message"=>"post updated succesfully"];
            return $this->success($key);
        } else {

            return $this->fail("Unable to update post");
        }
    }
    public function getAllBlogs(BlogTransformer $transformer, BlogPhotosTransformer $BlogPhotosTransformer)
    {
        $Blogs = $this->blogRepo->getAllBlogs();
        return $this->transform($Blogs, $transformer);
    }
    public function getAllBlogsbyId(BlogTransformer $transformer, BlogPhotosTransformer $BlogPhotosTransformer, $id)
    {
        $Blogs = $this->blogRepo->getAllBlogsbyId($id);
        return $this->transform($Blogs, $transformer);
    }
    public function getbyCategory(Request $request, BlogTransformer $transformer)
    {
        $types = explode(',', $request->get('category'));
        $Blogs = $this->blogRepo->getbyCategory($types);
        return $this->transform($Blogs, $transformer);
    }

    public function deleteBlog($id)
    {
        $delete = $this->blogRepo->deleteBlog($id);
        if ($delete) {
            return $this->success("deleted successfully");
        } else {
            return $this->error("cannot delete Blog");
        }
    }
    public function createBlogCategory(CreateBlogCategoryRequest $request)
    {
        $blogcategory = $this->blogRepo->createBlogCategory($request->all());
        return $blogcategory;
    }
    public function updateCategory(UpdateBlogCategoryRequest $request, $id)
    {
        $blogcategory = $this->blogRepo->updateCategory($request->all(), $id);
        if ($blogcategory) {
            return $this->success("updated category successfully");
        } else {
            return $this->error("cannot update category");
        }
    }
    public function getAllCategory()
    {
        $AllCategory = $this->blogRepo->getAllCategory();
        return $AllCategory;
    }
    public function deleteCategory($id)
    {
        $delete = $this->blogRepo->deleteCategory($id);
        if ($delete) {
            return $this->success("deleted successfully");
        } else {
            return $this->error("cannot delete post");
        }
    }
}
