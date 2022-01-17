<?php

namespace Webkul\MangoPay\DataGrids\Admin;

use DB;
use Webkul\Ui\DataGrid\DataGrid;

class EscrowedAmountDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('mangopay_escrowed_amount')
            ->addSelect('id','order_id','wallet_id','escrowed_amount','status','created_at');
       
        // $this->addFilter('order_id', 'order_id');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'order_id',
            'label'      => trans('mangopay::app.admin.datagrid.order_id'),
            'type'       => 'number',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'wallet_id',
            'label'      => trans('mangopay::app.admin.datagrid.wallet_id'),
            'type'       => 'number',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'escrowed_amount',
            'label'      => trans('mangopay::app.admin.datagrid.escrowed_amount'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'created_at',
            'label'      => trans('mangopay::app.admin.datagrid.created_at'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'updated_at',
            'label'      => trans('mangopay::app.admin.datagrid.pay'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => false,
            'filterable' => false,
            'closure'    => true,
            'wrapper'    => function($row) {
                
                if($row->status) {
                    return '<button type="button" disabled data-id="'.$row->id.'" class="pay btn btn-primary btn-md">'.trans('mangopay::app.admin.datagrid.release-amount').'</button>';
                }
                               
                return '<button type="button" data-id="'.$row->id.'" class="pay btn btn-primary btn-md">'.trans('mangopay::app.admin.datagrid.release-amount').'</button>';
            },
        ]);
    }
}