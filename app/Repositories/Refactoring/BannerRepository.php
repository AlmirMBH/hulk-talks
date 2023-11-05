<?php

namespace App\Repositories\Refactoring;

use App\Models\Refactoring\Banner;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Refactoring\BannerRepositoryInterface;

class BannerRepository extends BaseRepository implements BannerRepositoryInterface
{
    public function __construct(Banner $model)
    {
        parent::__construct($model);
    }
}
