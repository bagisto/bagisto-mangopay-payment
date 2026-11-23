<?php

namespace Webkul\MangoPay\Repositories;

use Webkul\Core\Eloquent\Repository;

class MangopayWalletRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'Webkul\MangoPay\Contracts\MangopayWallet';
    }

    /**
     * Get the store's admin wallet, shared by every admin; the oldest one when several exist.
     */
    public function adminWallet()
    {
        return $this->getModel()->newQuery()
            ->whereNotNull('admin_id')
            ->orderBy('id')
            ->first();
    }
}
