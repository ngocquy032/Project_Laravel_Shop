<?php

namespace App\Repositories\ProductComment;

use App\Models\ProductComment;
use App\Repositories\BaseRepository;
use App\Repositories\RepositoryInterface;

class ProductCommentReponsitory extends BaseRepository implements ProductCommentRepositoryInterface
{

    public function getModel()
    {
        return ProductComment::class;
    }
}
