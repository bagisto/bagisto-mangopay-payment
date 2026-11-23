<?php

namespace Webkul\MangoPay\Listeners;

use Webkul\MangoPay\Repositories\MangopayBankDetailsRepository;
use Webkul\MangoPay\Repositories\MangopayTransferAmountRepository;
use Webkul\MangoPay\Repositories\MangopayWalletRepository;
use Webkul\User\Repositories\AdminRepository;

class Admin
{
    /**
     * Create a new listener instance.
     */
    public function __construct(
        protected AdminRepository $adminRepository,
        protected MangopayWalletRepository $mangopayWalletRepository,
        protected MangopayBankDetailsRepository $mangopayBankDetailsRepository,
        protected MangopayTransferAmountRepository $mangopayTransferAmountRepository
    ) {}

    /**
     * Hand the store wallet, its bank account and the admin transfers recorded by an admin about to
     * be deleted to another admin, so the cascading foreign keys do not delete them.
     */
    public function beforeDelete($adminId): void
    {
        $successorId = $this->successorId((int) $adminId);

        if (! $successorId) {
            return;
        }

        foreach ([
            $this->mangopayWalletRepository,
            $this->mangopayBankDetailsRepository,
            $this->mangopayTransferAmountRepository,
        ] as $repository) {
            $repository->getModel()->newQuery()
                ->where('admin_id', (int) $adminId)
                ->update(['admin_id' => $successorId]);
        }
    }

    /**
     * Get the admin who takes the records over: the acting admin when possible, and never one who
     * already holds a wallet record while the deleted admin holds one too.
     */
    protected function successorId(int $adminId): ?int
    {
        $walletOwnerIds = $this->mangopayWalletRepository->getModel()->newQuery()
            ->whereNotNull('admin_id')
            ->pluck('admin_id')
            ->map(fn ($id) => (int) $id)
            ->all();

        $candidates = $this->adminRepository->getModel()->newQuery()
            ->whereKeyNot($adminId)
            ->when(
                in_array($adminId, $walletOwnerIds),
                fn ($query) => $query->whereNotIn('id', $walletOwnerIds)
            )
            ->orderBy('id')
            ->pluck('id')
            ->map(fn ($id) => (int) $id);

        $actingAdminId = (int) auth()->guard('admin')->id();

        return $candidates->contains($actingAdminId)
            ? $actingAdminId
            : $candidates->first();
    }
}
