@extends('shop::layouts.master')

@section('page_title')
    {{ __('mangopay::app.admin.transaction.module-name') }}
@endsection

@section('content-wrapper')
    <div class="account-content">

        @include('shop::customers.account.partials.sidemenu')

        <div class="account-layout">

            <div class="account-head mb-10">
            <span class="back-icon"><a href="{{ route('customer.account.index') }}"><i class="icon icon-menu-back"></i></a></span>
                <span class="account-heading">
                    {{ __('mangopay::app.admin.transaction.module-name') }}
                </span>
                <span></span>
            </div>

            <div class="account-items-list">
                <div class="account-table-content">

                    {!! app('Webkul\MangoPay\DataGrids\Shop\TransactionDatagrid')->render() !!}

                </div>
            </div>


           
        </div>

    </div>
@endsection
