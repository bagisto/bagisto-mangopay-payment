<div class="sidebar left">
    <?php
        $customer = auth('customer')->user();
    ?>

    @if ( isset($customer->id))
        <div class="customer-sidebar row no-margin no-padding">
            <div class="account-details col-12">
                <div class="customer-name col-12 text-uppercase">
                    {{ substr(auth('customer')->user()->first_name, 0, 1) }}
                </div>

                <div class="col-12 customer-name-text text-capitalize text-break">{{ auth('customer')->user()->first_name . ' ' . auth('customer')->user()->last_name}}</div>
                <div class="customer-email col-12 text-break">{{ auth('customer')->user()->email }}</div>
            </div>

            @foreach ($menu->items as $menuItem)
                @if ($menuItem['key'] == "marketplace")
                    @if (core()->getConfigData('marketplace.settings.general.status'))
                        <div class="menu-block-title">
                            {{ trans($menuItem['name']) }}
                        </div>
                    @endif
                @else
                    <div class="menu-block-title">
                        {{ core()->getConfigData('marketplace.settings.general.status') == "1" ? trans($menuItem['name']) : '' }}
                    </div>
                @endif

                <ul type="none" class="navigation">

                    @if ($menuItem['key'] != 'marketplace')
                        @foreach ($menuItem['children'] as $index => $subMenuItem)
                            @if ($index == 'compare')
                                @if (core()->getConfigData('general.content.shop.compare_option'))
                                <li class="{{ $menu->getActive($subMenuItem) }}">
                                    <a class="unset fw6 full-width" href="{{ $subMenuItem['url'] }}">
                                        <i class="icon {{ $index }} text-down-3"></i>
                                        <span>{{ trans($subMenuItem['name']) }}</span>
                                        <i class="rango-arrow-right pull-right text-down-3"></i>
                                    </a>
                                </li>
                                @endif
                            @else
                            <li class="{{ $menu->getActive($subMenuItem) }}">
                                <a class="unset fw6 full-width" href="{{ $subMenuItem['url'] }}">
                                    <i class="icon {{ $index }} text-down-3"></i>
                                    <span>{{ trans($subMenuItem['name']) }}</span>
                                    <i class="rango-arrow-right pull-right text-down-3"></i>
                                </a>
                            </li>
                            @endif
                        @endforeach
                    @else
                    @if (core()->getConfigData('marketplace.settings.general.status'))
                        @if (app('Webkul\Marketplace\Repositories\SellerRepository')->isSeller(auth()->guard('customer')->user()->id))

                            @foreach ($menuItem['children'] as $index => $subMenuItem)

                            @if($index == 'bankdetails' || $index == 'kyc' || $index == 'amount')
                                @if(core()->getConfigData('mangopay.general.general.active'))
                                    <li class="{{ $menu->getActive($subMenuItem) }}">
                                            <a class="unset fw6 full-width" href="{{ $subMenuItem['url'] }}">
                                                <i class="icon {{ $index }} text-down-3"></i>
                                                <span>{{ trans($subMenuItem['name']) }}</span>
                                            <i class="rango-arrow-right pull-right text-down-3"></i>
                                        </a>
                                    </li>
                                @endif
                            @elseif ($index == 'compare')
                                    @if (core()->getConfigData('general.content.shop.compare_option'))
                                        <li class="{{ $menu->getActive($subMenuItem) }}">
                                            <a class="unset fw6 full-width" href="{{ $subMenuItem['url'] }}">
                                                <i class="icon {{ $index }} text-down-3"></i>
                                                <span>{{ trans($subMenuItem['name']) }}</span>
                                                <i class="rango-arrow-right pull-right text-down-3"></i>
                                            </a>
                                        </li>
                                    @endif
                              @else
                                <li class="{{ $menu->getActive($subMenuItem) }}">
                                    <a class="unset fw6 full-width" href="{{ $subMenuItem['url'] }}">
                                        <i class="icon {{ $index }} text-down-3"></i>
                                        <span>{{ trans($subMenuItem['name']) }}</span>
                                        <i class="rango-arrow-right pull-right text-down-3"></i>
                                    </a>
                                </li>
                                @endif
                            @endforeach

                        @else

                            <li class="menu-item {{ request()->route()->getName() == 'marketplace.account.seller.create' ? 'active' : '' }}">
                                <a class="unset fw6 full-width" href="{{ route('marketplace.account.seller.create') }}">
                                    {{ __('marketplace::app.shop.layouts.become-seller') }}

                                    <i class="rango-arrow-right pull-right text-down-3"></i>
                                </a>
                            </li>

                        @endif
                    @endif
                 @endif
                </ul>
            @endforeach
        </div>
    @endif
</div>


@push('css')
    <style type="text/css">
        .main-content-wrapper {
            margin-bottom: 0px;
            min-height: 100vh;
        }
    </style>
@endpush