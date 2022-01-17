@extends('shop::customers.account.index')

@section('page_title')
    {{ __('mangopay::app.admin.kyc.module-name') }}
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

@php

$user = auth()->guard('customer')->user();

$seller = app('Webkul\Marketplace\Repositories\SellerRepository')->where('customer_id',$user->id)->first();

@endphp


@section('page-detail-wrapper')
    <div class="account-content">
        <div class="account-layout">
            <div class="account-head" style="margin-bottom:40px">
                <span class="back-icon"><a href="{{ route('customer.account.index') }}"><i class="icon icon-menu-back"></i></a></span>
                <span class="account-heading">
                    {{ __('mangopay::app.admin.kyc.module-name') }}
                </span>
                <span>
                    <a href="{{ route('mangopay.shop.kyc.create') }}" class="btn btn-primary btn-md float-right">Create Kyc</a>
                </span>                
            </div>
            <br>

            @csrf

            {!! view_render_event('bagisto.shop.customers.account.mangopay.kyc.view.before') !!}

            <div class="account-items-list">
                <div class="account-table-content">

                    {!! app('Webkul\MangoPay\DataGrids\Shop\KycDatagrid')->render() !!}

                </div>
            </div> 

            {!! view_render_event('bagisto.shop.customers.account.mangopay.kyc.view.after') !!}
        </div>
    </div>
@endsection