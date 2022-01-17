<?php $mangopayStandard = app('Webkul\MangoPay\Payment\Standard') ?>

<body data-gr-c-s-loaded="true" cz-shortcut-listen="true">
    You will be redirected to the MangoPays website in a few seconds.
    

    <form action="{{ $mangopayStandard->getMangoPayUrl() }}" id="mangopay_standard_checkout" method="get">
        <input value="Click here if you are not redirected within 10 seconds..." type="submit">
    </form>

    <script type="text/javascript">
        document.getElementById("mangopay_standard_checkout").submit();
    </script>
</body>