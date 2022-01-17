<?php

namespace Webkul\MangoPay\Repositories;

use Webkul\Core\Eloquent\Repository;

class MangopayBankDetailsRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Webkul\MangoPay\Contracts\MangopayBankDetails';
    }
}