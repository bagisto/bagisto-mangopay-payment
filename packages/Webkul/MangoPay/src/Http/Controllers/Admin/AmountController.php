<?php

namespace Webkul\MangoPay\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\MangoPay\DataGrids\Admin\EscrowedAmountDataGrid;

class AmountController extends Controller
{
    /**
     * Display the escrowed amount listing page.
     */
    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(EscrowedAmountDataGrid::class)->process();
        }

        return view('mangopay::admin.amount.index');
    }
}
