<?php

namespace Medom\Modules\Blog\Api\v1\Transformers;

use League\Fractal;
use Medom\Modules\Blog\Models\BlogPhotos;

class BlogPhotosTransformer extends Fractal\TransformerAbstract
{
  public function transform(BlogPhotos $BlogPhotos)
  {
    return [
      'photo'=>$BlogPhotos->photo
    ];
  }
}