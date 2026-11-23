@php $mangopayStandard = app('Webkul\MangoPay\Payment\Standard'); @endphp

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>MangoPay</title>
    </head>

    <body data-gr-c-s-loaded="true">
        <p>{{ __('mangopay::app.shop.standard.redirect-message') }}</p>

        <form
            action="{{ $mangopayStandard->getMangoPayUrl() }}"
            id="mangopay_standard_checkout"
            method="get"
        >
            <input
                value="{{ __('mangopay::app.shop.standard.redirect-button') }}"
                type="submit"
            >
        </form>

        <script type="text/javascript">
            document.getElementById('mangopay_standard_checkout').submit();
        </script>
    </body>
</html>
