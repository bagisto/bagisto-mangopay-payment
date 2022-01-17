<div class="control-group">
    <label for="account_number"  class="label-style">{{ __('mangopay::app.admin.bank-details.account-number') }}</label>
    <input type="text" v-validate="" class="control" id="account_number" name="account_number" value="{{ $bankdetail ? $bankdetail->account_number : '' }}"
        data-vv-as="&quot;{{ __('mangopay::app.admin.bank-details.account-number') }}&quot;">
</div>

<div class="control-group">
    <label for="sortcode"  class="label-style">{{ __('mangopay::app.admin.bank-details.sortcode') }}</label>
    <input type="text" v-validate="" class="control" id="sortcode" name="sortcode" value="{{ $bankdetail ? $bankdetail->sortcode : '' }}"
        data-vv-as="&quot;{{ __('mangopay::app.admin.bank-details.sortcode') }}&quot;">
</div>

