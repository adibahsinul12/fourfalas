<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\RatingModel;

class Rating extends BaseController
{
    public function index()
    {
        $ratingModel = new RatingModel();

        // Filter opsional dari query string, contoh: /owner/rating?rating=5
        $filterBintang = $this->request->getGet('rating');

        $rataRatingRaw = $ratingModel->getRataRating();

        $data = [
            'rata_rating'    => $rataRatingRaw ? round($rataRatingRaw, 1) : 0,
            'total_rating'   => $ratingModel->getTotalRating(),
            'distribusi'     => $ratingModel->getDistribusiBintang(),
            'daftar_ulasan'  => $ratingModel->getUlasan($filterBintang),
            'filter_bintang' => $filterBintang,
        ];

        return view('owner/rating', $data);
    }
}