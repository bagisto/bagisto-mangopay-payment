<?php

namespace Webkul\MangoPay\DataGrids\Admin;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class EscrowedAmountDataGrid extends DataGrid
{
    /**
     * Primary column.
     *
     * @var string
     */
    protected $primaryColumn = 'id';

    /**
     * Prepare query builder.
     */
    public function prepareQueryBuilder(): Builder
    {
        $queryBuilder = DB::table('mangopay_escrowed_amount')
            ->select(
                'id',
                'order_id',
                'wallet_id',
                'escrowed_amount',
                'status',
                'created_at',
                'updated_at'
            );

        $this->addFilter('order_id', 'order_id');
        $this->addFilter('wallet_id', 'wallet_id');
        $this->addFilter('escrowed_amount', 'escrowed_amount');
        $this->addFilter('created_at', 'created_at');

        return $queryBuilder;
    }

    /**
     * Prepare columns.
     */
    public function prepareColumns(): void
    {
        $this->addColumn([
            'index' => 'order_id',
            'label' => trans('mangopay::app.admin.datagrid.order-id'),
            'type' => 'integer',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'wallet_id',
            'label' => trans('mangopay::app.admin.datagrid.wallet-id'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'escrowed_amount',
            'label' => trans('mangopay::app.admin.datagrid.escrowed-amount'),
            'type' => 'decimal',
            'searchable' => true,
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
                if ($row->status) {
                    return '<span class="label-active px-2.5 py-1.5 rounded-full text-xs">'
                        .trans('mangopay::app.admin.datagrid.released').
                        '</span>';
                }

                return '<span class="label-pending px-2.5 py-1.5 rounded-full text-xs">'
                    .trans('mangopay::app.admin.datagrid.pending').
                    '</span>';
            },
        ]);

        $this->addColumn([
            'index' => 'created_at',
            'label' => trans('mangopay::app.admin.datagrid.created-at'),
            'type' => 'datetime',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
            'closure' => function ($row) {
                return core()->formatDate($row->created_at, 'd M Y H:i:s');
            },
        ]);
    }

    /**
     * Prepare actions.
     */
    public function prepareActions(): void
    {
        $this->addAction([
            'index' => 'release',
            'icon' => 'icon-sort-right',
            'title' => trans('mangopay::app.admin.datagrid.release-amount'),
            'method' => 'POST',
            'url' => function ($row) {
                return route('admin.mangopay.release_amount', $row->id);
            },
        ]);
    }
}
