<?php

namespace App\Services\Refactoring;

use App\Repositories\Interfaces\Refactoring\BannerRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BannerService
{
    public function __construct(
        private readonly BannerRepositoryInterface $bannerRepository
    )
    {
    }

    public function findById(int $invoiceId): Model
    {
        return $this->bannerRepository->find($invoiceId);
    }

}
