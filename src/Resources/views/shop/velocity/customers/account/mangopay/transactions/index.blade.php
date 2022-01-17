@extends('shop::customers.account.index')

@section('page_title')
    {{ __('mangopay::app.admin.transaction.module-name') }}
@endsection

@push('css')
    <style type="text/css">
        .account-content .account-layout .account-head {
            margin-bottom: 0px;
        }
        .sale-summary .dash-icon {
            margin-right: 30px;
            float: right;
        }
    </style>
@endpush

@section('page-detail-wrapper')
    <div class="account-content">
        <div class="account-layout">
            <div class="account-head mb-15">
                <span class="back-icon"><a href="{{ route('customer.account.index') }}"><i class="icon icon-menu-back"></i></a></span>
                <span class="account-heading">
                   {{ __('mangopay::app.admin.transaction.module-name') }}
                </span>
                <span></span>
        
            </div>
            <br>

            {!! view_render_event('bagisto.shop.customers.account.mangopay.transactions.view.before') !!}

            <div class="account-items-list">
                <div class="account-table-content">

                    {!! app('Webkul\MangoPay\DataGrids\Shop\TransactionDatagrid')->render() !!}

                </div>
            </div> 

            {!! view_render_event('bagisto.shop.customers.account.mangopay.transactions.view.after') !!}
        </div>
    </div>
@endsection