<?php

namespace Webkul\MangoPay\DataGrids\Shop;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class KycDatagrid extends DataGrid
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
        $queryBuilder = DB::table('mangopay_kyc')
            ->select(
                'id',
                'type',
                'status',
                'created_at'
            )
            ->where('seller_id', seller()->id() ?? 0);

        $this->addFilter('id', 'id');
        $this->addFilter('type', 'type');
        $this->addFilter('status', 'status');
        $this->addFilter('created_at', 'created_at');

        return $queryBuilder;
    }

    /**
     * Prepare columns.
     */
    public function prepareColumns(): void
    {
        $this->addColumn([
            'index' => 'id',
            'label' => trans('mangopay::app.admin.kyc.id'),
            'type' => 'integer',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'type',
            'label' => trans('mangopay::app.admin.kyc.type'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => trans('mangopay::app.admin.kyc.status'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'created_at',
            'label' => trans('mangopay::app.admin.kyc.created-at'),
            'type' => 'datetime',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
            'closure' => function ($row) {
                return core()->formatDate($row->created_at, 'd M Y H:i:s');
            },
        ]);
    }
}
