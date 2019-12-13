<?php

namespace Travellab\Modules\Blog\Api\v1\Transformers;

use League\Fractal;
use Travellab\Modules\Blog\Models\Blog;
use Travellab\Modules\Blog\Models\BlogPhotos;

class BlogTransformer extends Fractal\TransformerAbstract
{
  public function transform(Blog $Blog)
  {

    $tags = collect($Blog->tags)->pluck('tag');
    $category = collect($Blog->categoryname);
    $photos = collect($Blog->photos)->pluck('photo');

    $photos = collect($Blog->photos)->pluck('photo');
    $photos = $photos->map(function ($image) {
      return url('storage/' . $image);
    });
    return [
      'id' => $Blog->id,
      'title' => $Blog->title,
      'truncated' => $Blog->truncated,
      'content' => $Blog->content,
      'category_id' => $Blog->category_id,
      'photo' => $photos,
      'tags' => $tags,
      'category' => $category,
      'date' => $Blog->created_at,
      'status' => $Blog->status
    ];
  }
}
