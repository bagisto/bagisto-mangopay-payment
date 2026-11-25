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
    public function model()
    {
        return 'Webkul\MangoPay\Contracts\MangopayBankDetails';
    }

    /**
     * Get the bank account registered for the store's admin wallet, the newest one when several exist.
     */
    public function adminBankDetails()
    {
        return $this->getModel()->newQuery()
            ->whereNotNull('admin_id')
            ->orderByDesc('id')
            ->first();
    }
}
