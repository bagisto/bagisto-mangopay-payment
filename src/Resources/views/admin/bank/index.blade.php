@extends('marketplace::admin.layouts.content')

@section('page_title')
        {{ __('mangopay::app.admin.bank-details.module-name') }}
@stop

@section('content')

<form action="{{ route('admin.mangopay.save-bank-details.store') }}" method="POST">
    @csrf
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>
                    {{ __('mangopay::app.admin.bank-details.module-name') }}
                </h1>
            </div>

            <div class="page-action">

                <button type="submit" class="btn btn-lg btn-primary">
                    {{ __('mangopay::app.admin.mangopay.save-btn-title') }}
                </button>
                
            </div>
        </div>

        <div class="page-content">

            <input type="hidden" name="admin_id" value="{{ $admin->id }}">

            <account-information></account-information>

        </div>
    </div>
</form>

@stop

@push('scripts')  
  
    <script type="text/x-template" id="account-information-template">
        <div>
            <div class="form-container">

                <div class="control-group">
                    <label for="type"> {{ __('mangopay::app.admin.bank-details.type') }} </label>
                    <select v-validate="" class="control" id="type" v-model="type" name="type" >
                        <option value="IBAN">IBAN</option>
                        <option value="GB">GB</option>
                        <option value="US">US</option>
                        <option value="CA">CA</option>
                        <option value="OTHER">OTHER</option>
                    </select>
                </div>

                <div class="default-booking-section" v-if="type == 'IBAN'">
                    @include ('mangopay::admin.bank.iban',['bankdetail' => $bankdetail])
                </div>
    
                <div class="appointment-booking-section" v-if="type == 'GB'">
                    @include ('mangopay::admin.bank.gb',['bankdetail' => $bankdetail])
                </div>
    
                <div class="event-booking-section" v-if="type == 'US'">
                    @include ('mangopay::admin.bank.us',['bankdetail' => $bankdetail])
                </div>
    
                <div class="rental-booking-section" v-if="type == 'CA'">
                    @include ('mangopay::admin.bank.ca',['bankdetail' => $bankdetail])
                </div>
    
                <div class="table-booking-section" v-if="type == 'OTHER'">
                    @include ('mangopay::admin.bank.others',['bankdetail' => $bankdetail])
                </div>  
                                
                <div class="control-group">
                    <label for="owner_name">{{ __('mangopay::app.admin.bank-details.owner-name') }}</label>
                    <input type="text" v-validate="" class="control" id="owner_name" name="owner_name" value="{{ $bankdetail ? $bankdetail->owner_name : '' }}"
                        data-vv-as="&quot;{{ __('mangopay::app.admin.bank-details.owner-name') }}&quot;">
                </div>
                <div class="control-group">
                    <label for="owner_address">{{ __('mangopay::app.admin.bank-details.owner-address') }}</label>
                    <input type="text" v-validate="" class="control" id="owner_address" name="owner_address" value="{{ $bankdetail ? $bankdetail->owner_address : '' }}"
                        data-vv-as="&quot;{{ __('mangopay::app.admin.bank-details.owner-address') }}&quot;">
                </div>
                <div class="control-group">
                    <label for="owner_city">{{ __('mangopay::app.admin.bank-details.owner-city') }}</label>
                    <input type="text" v-validate="" class="control" id="owner_city" name="owner_city" value="{{ $bankdetail ? $bankdetail->owner_city : '' }}"
                        data-vv-as="&quot;{{ __('mangopay::app.admin.bank-details.owner-city') }}&quot;">
                </div>
                <div class="control-group">
                    <label for="owner_region">{{ __('mangopay::app.admin.bank-details.owner-region') }}</label>
                    <input type="text" v-validate="" class="control" id="owner_region" name="owner_region" value="{{ $bankdetail ? $bankdetail->owner_region : '' }}"
                        data-vv-as="&quot;{{ __('mangopay::app.admin.bank-details.owner-region') }}&quot;">
                </div>
                <div class="control-group">
                    <label for="owner_postal_code">{{ __('mangopay::app.admin.bank-details.owner-postal-code') }}</label>
                    <input type="text" v-validate="" class="control" id="owner_postal_code" name="owner_postal_code" value="{{ $bankdetail ? $bankdetail->owner_postal_code : '' }}"
                        data-vv-as="&quot;{{ __('mangopay::app.admin.bank-details.owner-postal-code') }}&quot;">
                </div>
                
                <div class="control-group">
                    <label for="country"> {{ __('mangopay::app.admin.bank-details.country') }} </label>
                    <select v-validate="" class="control" id="" name="country" data-vv-as="">
                        @foreach (core()->countries() as $country)
                            <option value="{{ $country->code }}" @if ($bankdetail)
                                {{ $bankdetail->country == $country->code ? "selected" : '' }}
                            @endif >{{ $country->name }}</option>
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
                       type : "{{ $bankdetail? $bankdetail->type : 'IBAN' }}" ,           
                }
            },

            created: function() {
               
            }
        });
    </script>

@endpush