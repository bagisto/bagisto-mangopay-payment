<div class="control-group">
    <label for="">{{ __('mangopay::app.admin.bank-details.account-number') }}</label>
    <input type="text" v-validate="" class="control" id="" name="account_number" value="{{ $bankdetail ? $bankdetail->account_number : '' }}"
        data-vv-as="&quot;Enter Points&quot;">
</div>

<div class="control-group">
    <label for="bic">{{ __('mangopay::app.admin.bank-details.bic') }}</label>
    <input type="text" v-validate="" class="control" id="bic" name="bic" value="{{ $bankdetail ? $bankdetail->bic : '' }}"
        data-vv-as="&quot;{{ __('mangopay::app.admin.bank-details.bic') }}&quot;">
</div>
