@extends('shop::customers.account.index')

@section('page_title')
    {{ __('mangopay::app.admin.bank-details.module-name') }}
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

$type = '';

if($data && $data->type) {
    $type = $data->type;
}


@endphp

@section('page-detail-wrapper')
    <div class="account-content">
        <div class="account-layout">
            <form method="post" action="{{ route('mangopay.shop.bankdetails.store') }}">
            <div class="account-head mb-15">
                <span class="back-icon"><a href="{{ route('customer.account.index') }}"><i class="icon icon-menu-back"></i></a></span>
                <span class="account-heading">
                    {{ __('mangopay::app.admin.bank-details.module-name') }}
                </span>
                <span>
                    <button type="submit" class="btn btn-primary btn-md float-right">Save Bank Details</button>
                </span>
        
            </div>
            <br>

            @csrf

            <input type="hidden" name="seller_id" value="{{ $seller->id }}">

            {!! view_render_event('bagisto.shop.customers.account.mangopay.bankdetails.view.before') !!}

            <account-information></account-information>

            {!! view_render_event('bagisto.shop.customers.account.mangopay.bankdetails.view.after') !!}
            </form>
        </div>
    </div>
@endsection

@push('scripts')  
  
    <script type="text/x-template" id="account-information-template">
        <div>
           
            <div class="account-table-content">          

                <div class="control-group">
                    <label for="type" class="label-style"> {{ __('mangopay::app.admin.bank-details.type') }} </label>
                    <select v-validate="" class="form-style" id="type" v-model="type" name="type" >
                        <option value="IBAN">IBAN</option>
                        <option value="GB">GB</option>
                        <option value="US">US</option>
                        <option value="CA">CA</option>
                        <option value="OTHER">OTHER</option>
                    </select>
                </div>

                <div class="default-booking-section" v-if="type == 'IBAN'">
                    @include ('mangopay::shop.customers.account.mangopay.bankdetails.iban',['bankdetail' => $data ])
                </div>
    
                <div class="appointment-booking-section" v-if="type == 'GB'">
                    @include ('mangopay::shop.customers.account.mangopay.bankdetails.gb',['bankdetail' => $data ])
                </div>
    
                <div class="event-booking-section" v-if="type == 'US'">
                    @include ('mangopay::shop.customers.account.mangopay.bankdetails.us',['bankdetail' => $data ])
                </div>
    
                <div class="rental-booking-section" v-if="type == 'CA'">
                    @include ('mangopay::shop.customers.account.mangopay.bankdetails.ca',['bankdetail' => $data ])
                </div>
    
                <div class="table-booking-section" v-if="type == 'OTHER'">
                    @include ('mangopay::shop.customers.account.mangopay.bankdetails.others',['bankdetail' => $data ])
                </div>  
                                
                <div class="control-group">
                    <label for="owner_name"  class="label-style">{{ __('mangopay::app.admin.bank-details.owner-name') }}</label>
                    <input type="text" v-validate="" class="form-style" id="owner_name" name="owner_name" value="{{ $data ? $data->owner_name : '' }}"
                        data-vv-as="&quot;{{ __('mangopay::app.admin.bank-details.owner-name') }}&quot;">
                </div>
                <div class="control-group">
                    <label for="owner_address"  class="label-style">{{ __('mangopay::app.admin.bank-details.owner-address') }}</label>
                    <input type="text" v-validate="" class="form-style" id="owner_address" name="owner_address" value="{{ $data ? $data->owner_address : '' }}"
                        data-vv-as="&quot;{{ __('mangopay::app.admin.bank-details.owner-address') }}&quot;">
                </div>
                <div class="control-group">
                    <label for="owner_city"  class="label-style">{{ __('mangopay::app.admin.bank-details.owner-city') }}</label>
                    <input type="text" v-validate="" class="form-style" id="owner_city" name="owner_city" value="{{ $data ? $data->owner_city : '' }}"
                        data-vv-as="&quot;{{ __('mangopay::app.admin.bank-details.owner-city') }}&quot;">
                </div>
                <div class="control-group">
                    <label for="owner_region"  class="label-style">{{ __('mangopay::app.admin.bank-details.owner-region') }}</label>
                    <input type="text" v-validate="" class="form-style" id="owner_region" name="owner_region" value="{{ $data ? $data->owner_region : '' }}"
                        data-vv-as="&quot;{{ __('mangopay::app.admin.bank-details.owner-region') }}&quot;">
                </div>
                <div class="control-group">
                    <label for="owner_postal_code"  class="label-style">{{ __('mangopay::app.admin.bank-details.owner-postal-code') }}</label>
                    <input type="text" v-validate="" class="form-style" id="owner_postal_code" name="owner_postal_code" value="{{ $data ? $data->owner_postal_code : '' }}"
                        data-vv-as="&quot;{{ __('mangopay::app.admin.bank-details.owner-postal-code') }}&quot;">
                </div>
                
                <div class="control-group">
                    <label for="country"  class="label-style"> {{ __('mangopay::app.admin.bank-details.country') }} </label>
                    <select v-validate="" class="form-style" id="" name="country" data-vv-as="">
                        @foreach (core()->countries() as $country)
                            <option value="{{ $country->code }}" @if($data && $data->country == $country->code) selected @endif >{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>  
            </div>
            
        </div>
    </script>

    <script>
       
        Vue.component('account-information', {

            template: '#account-information-template',

            inject: ['$validator'],

            data: function() {
                return {
                       type : "{{ $type ? $type : 'IBAN'}}" ,           
                }
            },

            created: function() {
               
            }
        });
    </script>

@endpush