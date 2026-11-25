<?php

namespace Webkul\MangoPay\DataGrids\Admin;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class TransactionDataGrid extends DataGrid
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
            ->whereNotNull('admin_id');

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
            'searchable' => false,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'transaction_id',
            'label' => trans('mangopay::app.admin.datagrid.transaction-id'),
            'type' => 'string',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'amount',
            'label' => trans('mangopay::app.admin.datagrid.amount'),
            'type' => 'decimal',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'message',
            'label' => trans('mangopay::app.admin.datagrid.message'),
            'type' => 'string',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => trans('mangopay::app.admin.datagrid.status'),
            'type' => 'string',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true,
            'closure' => function ($row) {
                return $row->status === 'SUCCEEDED'
                    ? trans('mangopay::app.admin.transaction.success')
                    : trans('mangopay::app.admin.transaction.failed');
            },
        ]);
    }
}
