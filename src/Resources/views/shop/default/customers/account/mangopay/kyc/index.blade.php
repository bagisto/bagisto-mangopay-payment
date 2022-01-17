@extends('shop::layouts.master')

@section('page_title')
    {{ __('mangopay::app.admin.kyc.module-name') }}
@endsection

@php

$user = auth()->guard('customer')->user();

$seller = app('Webkul\Marketplace\Repositories\SellerRepository')->where('customer_id',$user->id)->first();

@endphp

@section('content-wrapper')
    <div class="account-content">

        @include('shop::customers.account.partials.sidemenu')
       
        <div class="account-layout">
            
            <div class="account-head mb-10">
            <span class="back-icon"><a href="{{ route('customer.account.index') }}"><i class="icon icon-menu-back"></i></a></span>
                <span class="account-heading">
                    {{ __('mangopay::app.admin.kyc.module-name') }}
                </span>
                <span>
                    <a href="{{ route('mangopay.shop.kyc.create') }}" class="btn btn-primary btn-md pull-right">Create Kyc</a>
                </span>
            </div>

            @csrf

            <div class="account-items-list">
                <div class="account-table-content">
                  
                    {!! app('Webkul\MangoPay\DataGrids\Shop\KycDatagrid')->render() !!}

                </div>
            </div>
        </div>
       


    </div>
@endsection
