<?php

namespace Webkul\MangoPay\DataGrids\Shop;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;

class TransactionDatagrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    public function prepareQueryBuilder()
    {

        $user = auth()->guard('customer')->user();

        $seller = app('Webkul\Marketplace\Repositories\SellerRepository')->where('customer_id',$user->id)->first();
       
        $queryBuilder = DB::table('mangopay_transaction_details')
            ->select('id', 'transaction_id', 'amount', 'message', 'status')
            ->where('seller_id',$seller->id)
            ;

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('mangopay::app.admin.transaction.id'),
            'type'       => 'number',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'transaction_id',
            'label'      => trans('mangopay::app.admin.transaction.transaction-id'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'amount',
            'label'      => trans('mangopay::app.admin.transaction.amount'),
            'type'       => 'string',
            'sortable'   => true,
            'searchable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'message',
            'label'      => trans('mangopay::app.admin.transaction.message'),
            'type'       => 'string',
            'sortable'   => true,
            'searchable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('mangopay::app.admin.transaction.status'),
            'type'       => 'string',
            'sortable'   => true,
            'searchable' => true,
            'filterable' => true,
        ]);
    }
}
