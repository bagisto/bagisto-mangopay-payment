<?php

namespace Webkul\MangoPay\DataGrids\Shop;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class TransactionDatagrid extends DataGrid
{
    /**
     * Primary column.
     */
    protected $primaryColumn = 'id';

    /**
     * Prepare query builder.
     */
    public function prepareQueryBuilder(): Builder
    {
        $queryBuilder = DB::table('mangopay_transaction_details')
            ->select(
                'id',
                'transaction_id',
                'amount',
                'message',
                'status'
            )
            ->where('seller_id', seller()->id() ?? 0);

        $this->addFilter('id', 'id');
        $this->addFilter('transaction_id', 'transaction_id');
        $this->addFilter('amount', 'amount');
        $this->addFilter('message', 'message');
        $this->addFilter('status', 'status');

        return $queryBuilder;
    }

    /**
     * Prepare columns.
     */
    public function prepareColumns(): void
    {
        $this->addColumn([
            'index' => 'id',
            'label' => trans('mangopay::app.admin.transaction.id'),
            'type' => 'integer',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'transaction_id',
            'label' => trans('mangopay::app.admin.transaction.transaction-id'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'amount',
            'label' => trans('mangopay::app.admin.transaction.amount'),
            'type' => 'decimal',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'message',
            'label' => trans('mangopay::app.admin.transaction.message'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => trans('mangopay::app.admin.transaction.status'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
            'closure' => function ($row) {
                return $row->status;
            },
        ]);
    }
}
