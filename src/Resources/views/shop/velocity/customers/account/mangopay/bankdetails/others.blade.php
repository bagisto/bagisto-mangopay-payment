<div class="control-group">
    <label for="" class="label-style">{{ __('mangopay::app.admin.bank-details.account-number') }}</label>
    <input type="text" v-validate="" value="{{ $bankdetail ? $bankdetail->account_number : '' }}" class="form-style" id=""  name="account_number"
        data-vv-as="&quot;Enter Points&quot;">
</div>

<div class="control-group">
    <label for="bic" class="label-style">{{ __('mangopay::app.admin.bank-details.bic') }}</label>
    <input type="text" v-validate="" class="form-style" id="bic" name="bic" value="{{ $bankdetail ? $bankdetail->bic : '' }}"
        data-vv-as="&quot;{{ __('mangopay::app.admin.bank-details.bic') }}&quot;">
</div>
