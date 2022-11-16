<?php

namespace App\Repositories;

use App\Models\Purchase;
use App\Repositories\BaseRepository;

class PurchaseRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'purchase_date',
        'id_user',
        'state_purchase'
    ];

    public function model()
    {
        return Purchase::class;
    }
}
