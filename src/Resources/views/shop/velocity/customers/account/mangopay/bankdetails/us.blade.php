<div class="control-group">
    <label for="account_number" class="label-style">{{ __('mangopay::app.admin.bank-details.account-number') }}</label>
    <input type="text" v-validate="" class="form-style" id="account_number" name="account_number" value="{{ $bankdetail ? $bankdetail->account_number : '' }}"
        data-vv-as="&quot;{{ __('mangopay::app.admin.bank-details.account-number') }}&quot;">
</div>

<div class="control-group">
    <label for="aba" class="label-style">{{ __('mangopay::app.admin.bank-details.aba') }}</label>
    <input type="text" v-validate="" class="form-style" id="aba" name="aba" value="{{ $bankdetail ? $bankdetail->aba : '' }}"
        data-vv-as="&quot;{{ __('mangopay::app.admin.bank-details.aba') }}&quot;">
</div>
