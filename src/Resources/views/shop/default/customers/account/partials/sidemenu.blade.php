<div class="sidebar">
    @foreach ($menu->items as $menuItem)
        <div class="menu-block">

            @if ($menuItem['key'] == "marketplace")
                @if (core()->getConfigData('marketplace.settings.general.status'))
                    <div class="menu-block-title">
                            {{ trans($menuItem['name']) }}
                            <i class="icon icon-arrow-down right" id="down-icon"></i>
                    </div>
                @endif
            @else
                <div class="menu-block-title">
                    {{ trans($menuItem['name']) }}
                    <i class="icon icon-arrow-down right" id="down-icon"></i>
                </div>
            @endif

            <div class="menu-block-content">
                <ul class="menubar">

                    @if ($menuItem['key'] != 'marketplace')
                        @foreach ($menuItem['children'] as $index => $subMenuItem)
                            @if ($index == 'compare')
                                @if (core()->getConfigData('general.content.shop.compare_option'))
                                    <li class="menu-item {{ $menu->getActive($subMenuItem) }}">
                                        <a href="{{ $subMenuItem['url'] }}">
                                            {{ trans($subMenuItem['name']) }}
                                        </a>

                                        <i class="icon angle-right-icon"></i>
                                    </li>
                                @endif
                            @else
                            <li class="menu-item {{ $menu->getActive($subMenuItem) }}">
                                <a href="{{ $subMenuItem['url'] }}">
                                    {{ trans($subMenuItem['name']) }}
                                </a>

                                <i class="icon angle-right-icon"></i>
                            </li>
                            @endif
                        @endforeach
                    @else
                       @if (core()->getConfigData('marketplace.settings.general.status'))
                        @if (app('Webkul\Marketplace\Repositories\SellerRepository')->isSeller(auth()->guard('customer')->user()->id))

                            @foreach ($menuItem['children'] as $index => $subMenuItem)

                                @if($index == 'bankdetails' || $index == 'kyc' || $index == 'amount')
                                    @if(core()->getConfigData('mangopay.general.general.active'))
                                        <li class="menu-item {{ $menu->getActive($subMenuItem) }}">
                                            <a href="{{ $subMenuItem['url'] }}">
                                                {{ trans($subMenuItem['name']) }}
                                            </a>

                                            <i class="icon angle-right-icon"></i>
                                        </li>
                                    @endif
                                @else
                                    <li class="menu-item {{ $menu->getActive($subMenuItem) }}">
                                        <a href="{{ $subMenuItem['url'] }}">
                                            {{ trans($subMenuItem['name']) }}
                                        </a>

                                        <i class="icon angle-right-icon"></i>
                                    </li>
                                @endif
                            @endforeach

                        @else

                            <li class="menu-item {{ request()->route()->getName() == 'marketplace.account.seller.create' ? 'active' : '' }}">
                                <a href="{{ route('marketplace.account.seller.create') }}">
                                    {{ __('marketplace::app.shop.layouts.become-seller') }}
                                </a>

                                <i class="icon angle-right-icon"></i>
                            </li>

                        @endif
                     @endif
                    @endif
                </ul>
            </div>
        </div>
    @endforeach
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $(".icon.icon-arrow-down.right").on('click', function(e){
            var currentElement = $(e.currentTarget);
            if (currentElement.hasClass('icon-arrow-down')) {
                $(this).parents('.menu-block').find('.menubar').show();
                currentElement.removeClass('icon-arrow-down');
                currentElement.addClass('icon-arrow-up');
            } else {
                $(this).parents('.menu-block').find('.menubar').hide();
                currentElement.removeClass('icon-arrow-up');
                currentElement.addClass('icon-arrow-down');
            }
        });
    });
</script>
@endpush

