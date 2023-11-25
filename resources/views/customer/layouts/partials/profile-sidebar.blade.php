<aside id="sidebar" class="sidebar col-md-3">

    <section class="content-wrapper bg-white p-3 rounded-2 mb-3">
        @if (!auth()->user()->hasVerifiedEmail())
            <a href="{{route('auth.email.send.verification')}}">Verify Email</a>
        @endif
        <!-- start sidebar nav-->
        <section class="sidebar-nav">
            <section class="sidebar-nav-item">
                <span class="sidebar-nav-item-title"><a class="p-3" href="{{ route('customer.profiles.orders') }}">{{__('public.orders')}}</a></span>
            </section>
            <section class="sidebar-nav-item">
                <span class="sidebar-nav-item-title"><a class="p-3" href="{{ route('customer.profiles.my-compares') }}">
                {{__('public.my compares')}}
                    </a></span>
            </section>
            <section class="sidebar-nav-item">
                <span class="sidebar-nav-item-title"><a class="p-3"
                        href="{{ route('customer.profiles.my-addresses') }}"> my Addresses</a></span>
            </section>
            <section class="sidebar-nav-item">
                <span class="sidebar-nav-item-title"><a class="p-3"
                        href="{{ route('customer.profiles.my-favorites') }}">{{__('public.my favorites')}}</a></span>
            </section>
            <section class="sidebar-nav-item">
                <span class="sidebar-nav-item-title"><a class="p-3"
                        href="{{ route('customer.profiles.my-tickets.index') }}">
                        {{__('public.ticket management')}}
                    </a></span>
            </section>
            <section class="sidebar-nav-item">
                <span class="sidebar-nav-item-title"><a class="p-3"
                        href="{{ route('customer.profiles.profile') }}">{{__('public.edit profile')}}</a></span>
            </section>
            <section class="sidebar-nav-item">
                <span class="sidebar-nav-item-title"><a class="p-3" href="{{route('auth.otp.profile.two.factor.toggle.form')}}">{{__('public.Two factor')}}</a></span>
            </section>
            <section class="sidebar-nav-item">
                <span class="sidebar-nav-item-title"><a class="p-3" href="{{route('auth.logout')}}">{{__('public.logout')}}</a></span>
            </section>

        </section>
        <!--end sidebar nav-->
    </section>
</aside>
