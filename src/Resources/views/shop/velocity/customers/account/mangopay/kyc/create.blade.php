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
        <form method="post" action="{{ route('mangopay.shop.kyc.store') }}" enctype="multipart/form-data">
        <div class="account-layout">
            <div class="account-head">
                <span class="back-icon"><a href="{{ route('customer.account.index') }}"><i class="icon icon-menu-back"></i></a></span>
                <span class="account-heading">
                    {{ __('mangopay::app.admin.kyc.module-name') }}
                </span>
                <span>
                    <button type="submit" class="btn btn-primary btn-md float-right mb-4">Save Kyc</button>
                </span>
                
            </div>
            <br>

            @csrf

            <input type="hidden" name="seller_id" value="{{ $seller->id }}">

            {!! view_render_event('bagisto.shop.customers.account.mangopay.kyc.create.before') !!}

            <div class="account-items-list">
                <div class="account-table-content">

                    <div class="control-group">
                        <label for="type" class="label-style"> {{ __('mangopay::app.admin.kyc.type') }} </label>
                        <select v-validate="" class="form-style" id="type" name="type" >
                        <option value="IDENTITY_PROOF">IDENTITY PROOF</option>
                            <option value="REGISTRATION_PROOF">REGISTRATION PROOF</option>
                            <option value="ARTICLES_OF_ASSOCIATION">ARTICLES OF ASSOCIATION</option>
                            <option value="SHAREHOLDER_DECLARATION">SHAREHOLDER DECLARATION</option>
                            <option value="ADDRESS_PROOF">ADDRESS PROOF</option>
                        </select>
                    </div>
                    
                    <div class="control-group">
                        <label for="file"  class="label-style">{{ __('mangopay::app.admin.kyc.file') }}</label>
                        <input type="file" v-validate="" class="form-style" id="file" name="file" 
                            data-vv-as="&quot;{{ __('mangopay::app.admin.kyc.file') }}&quot;">
                    </div>  

                </div>
            </div> 

            {!! view_render_event('bagisto.shop.customers.account.mangopay.kyc.create.after') !!}
        </div>
        </form>
    </div>
@endsection