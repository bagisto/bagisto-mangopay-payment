<div class="control-group">
    <label for="iban">{{ __('mangopay::app.admin.bank-details.iban') }}</label>
    <input type="text" v-validate="" class="control" id="iban" name="iban" value="{{ $bankdetail ? $bankdetail->iban : '' }}"
        data-vv-as="&quot;{{ __('mangopay::app.admin.bank-details.iban') }}&quot;">
</div>

<div class="control-group">
    <label for="bic">{{ __('mangopay::app.admin.bank-details.bic') }}</label>
    <input type="text" v-validate="" class="control" id="bic" name="bic" value="{{ $bankdetail ? $bankdetail->bic : '' }}"
        data-vv-as="&quot;{{ __('mangopay::app.admin.bank-details.bic') }}&quot;">
</div>



