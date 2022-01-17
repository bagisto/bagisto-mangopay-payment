<div class="control-group">
    <label for="bank_name" class="label-style">{{ __('mangopay::app.admin.bank-details.bank-name') }}</label>
    <input type="text" v-validate="" class="control" id="bank_name" name="bank_name" value="{{ $bankdetail ? $bankdetail->bank_name : '' }}"
        data-vv-as="&quot;{{ __('mangopay::app.admin.bank-details.bank-name') }}&quot;">
</div>

<div class="control-group">
    <label for="institution_number"  class="label-style">{{ __('mangopay::app.admin.bank-details.institution-number') }}</label>
    <input type="text" v-validate="" class="control" id="institution_number" name="institution_number"  value="{{ $bankdetail ? $bankdetail->institution_number : '' }}"
        data-vv-as="&quot;{{ __('mangopay::app.admin.bank-details.institution-number') }}&quot;">
</div>

<div class="control-group">
    <label for="branch_code"  class="label-style">{{ __('mangopay::app.admin.bank-details.branch-code') }}</label>
    <input type="text" v-validate="" class="control" id="branch_code" name="branch_code"  value="{{ $bankdetail ? $bankdetail->branch_code : '' }}"
        data-vv-as="&quot;{{ __('mangopay::app.admin.bank-details.branch-code') }}&quot;">
</div>

<div class="control-group">
    <label for="account_number"  class="label-style">{{ __('mangopay::app.admin.bank-details.account-number') }}</label>
    <input type="text" v-validate="" class="control" id="account_number" name="account_number" value="{{ $bankdetail ? $bankdetail->account_number : '' }}"
        data-vv-as="&quot;{{ __('mangopay::app.admin.bank-details.account-number') }}&quot;">
</div>
