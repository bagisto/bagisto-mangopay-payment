<?php

namespace Webkul\MangoPay\Repositories;

use Webkul\Core\Eloquent\Repository;

class MangopayKycRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'Webkul\MangoPay\Contracts\MangopayKyc';
    }
}
