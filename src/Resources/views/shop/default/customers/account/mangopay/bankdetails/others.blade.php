<div class="control-group">
    <label for="" class="label-style">{{ __('mangopay::app.admin.bank-details.account-number') }}</label>
    <input type="text" v-validate="" class="control" id="" name="reward_points"
        data-vv-as="&quot;Enter Points&quot;">
</div>

<div class="control-group">
    <label for="bic" class="label-style">{{ __('mangopay::app.admin.bank-details.bic') }}</label>
    <input type="text" v-validate="" class="control" id="bic" name="bic" value="{{ $bankdetail ? $bankdetail->bic : '' }}"
        data-vv-as="&quot;{{ __('mangopay::app.admin.bank-details.bic') }}&quot;">
</div>
