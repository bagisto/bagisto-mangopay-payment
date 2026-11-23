<?php

namespace Webkul\MangoPay\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\MangoPay\DataGrids\Admin\TransactionDataGrid;
use Webkul\MangoPay\Helpers\ReleaseAmount;

class TransactionController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected ReleaseAmount $releaseAmount
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(TransactionDataGrid::class)->process();
        }

        return view('mangopay::admin.transaction.index');
    }

    /**
     * Release escrowed amount.
     */
    public function releaseAmount(int $id): RedirectResponse
    {
        try {
            $this->releaseAmount->execute([
                'id' => $id,
                'message' => request('message', ''),
            ]);

            session()->flash(
                'success',
                trans('mangopay::app.admin.response.amount-release-success')
            );
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->route('admin.mangopay.amount');
    }
}
