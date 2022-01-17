@extends('marketplace::admin.layouts.content')

@section('page_title')
        {{ __('mangopay::app.admin.transaction.module-name') }}
@stop

@section('content')

    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>
                    {{ __('mangopay::app.admin.transaction.module-name') }}
                </h1>
            </div>
        </div>

        <div class="page-content">

            @inject('trasactionDataGrid', 'Webkul\MangoPay\DataGrids\Admin\TrasactionDataGrid')
            {!! $trasactionDataGrid->render() !!}

        </div>
    </div> 
@stop