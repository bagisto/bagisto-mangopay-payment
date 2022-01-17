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
            <form method="post" action="{{ route('mangopay.shop.kyc.store') }}" enctype="multipart/form-data">
       
            <div class="account-head mb-10">
            <span class="back-icon"><a href="{{ route('customer.account.index') }}"><i class="icon icon-menu-back"></i></a></span>
                <span class="account-heading">
                    {{ __('mangopay::app.admin.kyc.module-name') }}
                </span>
                <span>
                    <button type="submit" class="btn btn-primary btn-md pull-right">Save Kyc</button>
                </span>
            </div>

            @csrf

            <input type="hidden" name="seller_id" value="{{ $seller->id }}">


            <div class="account-items-list">
                <div class="account-table-content">

                    <div class="control-group">
                        <label for="type" class="label-style"> {{ __('mangopay::app.admin.kyc.type') }} </label>
                        <select v-validate="" class="control" id="type" name="type" >
                            <option value="IDENTITY_PROOF">IDENTITY PROOF</option>
                            <option value="REGISTRATION_PROOF">REGISTRATION PROOF</option>
                            <option value="ARTICLES_OF_ASSOCIATION">ARTICLES OF ASSOCIATION</option>
                            <option value="SHAREHOLDER_DECLARATION">SHAREHOLDER DECLARATION</option>
                            <option value="ADDRESS_PROOF">ADDRESS PROOF</option>
                        </select>
                    </div>

                    <div class="control-group">
                            <label for="file"  >{{ __('mangopay::app.admin.kyc.file') }}</label>
                            <input type="file" v-validate="" class="control" id="file" name="file"
                            data-vv-as="&quot;{{ __('mangopay::app.admin.kyc.file') }}&quot;">
                    </div>

                </div>
            </div>
            </form>
        </div>
    </div>
@endsection
