@extends('marketplace::admin.layouts.content')

@section('page_title')
        {{ __('mangopay::app.admin.wallet.module-name') }}
@stop

@section('content')

    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>
                    {{ __('mangopay::app.admin.wallet.module-name') }}
                </h1>
            </div>
        </div>

        <div class="page-content">

            <a href="{{ route('admin.mangopay.create-wallet') }}" class="btn btn-lg btn-primary mb-20">
                    {{ __('mangopay::app.admin.wallet.create-wallet') }}
            </a>
            <br>

            <div class="control-group">
                    <label for="wallet_id">{{ __('mangopay::app.admin.wallet.wallet-id') }}</label>
                    <input type="text" v-validate="" class="control" id="wallet_id" name="wallet_id" value="{{ $data ? $data->wallet_id : ''}}" readonly
                        data-vv-as="&quot;{{ __('mangopay::app.admin.wallet.wallet-id') }}&quot;">
            </div>
            <div class="control-group">
                    <label for="mangopay_id">{{ __('mangopay::app.admin.wallet.mangopay-id') }}</label>
                    <input type="text" v-validate="" class="control" id="mangopay_id" name="mangopay_id" value="{{ $data ? $data->mangopay_id : ''}}"  readonly
                        data-vv-as="&quot;{{ __('mangopay::app.admin.wallet.mangopay-id') }}&quot;">
            </div>               

        </div>
    </div>
@stop
