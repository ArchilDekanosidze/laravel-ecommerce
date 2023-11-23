<aside id="sidebar" class="sidebar">
    <section class="sidebar-container">
        <section class="sidebar-wrapper">
            <a href="{{route('customer.home')}}" class="sidebar-link" target="_blank">
                <i class="fas fa-shopping-cart"></i>
                <span>{{__('admin.website')}}</span>
            </a>

            <hr>

            <a href="{{route('admin.home')}}" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span>{{__('admin.home')}}</span>
            </a>

            <section class="sidebar-part-title">{{__('admin.selling section')}}</section>

            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle">
                    <i class="fas fa-chart-bar icon"></i>
                    <span>{{__('admin.market')}}</span>
                    <i class="fas fa-angle-right angle"></i>
                </section>
                <section class="sidebar-dropdown">
                    <a href="{{route('admin.market.categories.index')}}">{{__('admin.category')}}</a>
                    <a href="{{route('admin.market.properties.index')}}">{{__('admin.product form')}}</a>
                    <a href="{{route('admin.market.brands.index')}}">{{__('admin.brands')}}</a>
                    <a href="{{route('admin.market.products.index')}}">{{__('admin.products')}}</a>
                    <a href="{{route('admin.market.stores.index')}}">{{__('admin.store')}}</a>
                    <a href="{{route('admin.market.comments.index')}}">{{__('admin.comments')}}</a>
                </section>
            </section>

            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle">
                    <i class="fas fa-chart-bar icon"></i>
                    <span>{{__('admin.orders')}}</span>
                    <i class="fas fa-angle-right angle"></i>
                </section>
                <section class="sidebar-dropdown">
                    <a href="{{route('admin.market.orders.newOrders')}}"> {{__('admin.new')}}</a>
                    <a href="{{route('admin.market.orders.sending')}}">{{__('admin.sending')}}</a>
                    <a href="{{route('admin.market.orders.unpaid')}}">{{__('admin.unpaid')}}</a>
                    <a href="{{route('admin.market.orders.canceled')}}">{{__('admin.canceled')}}</a>
                    <a href="{{route('admin.market.orders.returned')}}">{{__('admin.returned')}}</a>
                    <a href="{{route('admin.market.orders.all')}}">{{__('admin.all')}}</a>
                </section>
            </section>

            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle">
                    <i class="fas fa-chart-bar icon"></i>
                    <span>{{__('admin.payments')}}</span>
                    <i class="fas fa-angle-right angle"></i>
                </section>
                <section class="sidebar-dropdown">
                    <a href="{{ route('admin.market.payments.index') }}">{{__('admin.all payments')}}</a>
                    <a href="{{ route('admin.market.payments.online') }}">{{__('admin.online payments')}}</a>
                    <a href="{{ route('admin.market.payments.offline') }}">{{__('admin.offline payments')}}</a>
                    <a href="{{ route('admin.market.payments.cash') }}">{{__('admin.cash on delivery payments')}}</a>
                </section>
            </section>

            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle">
                    <i class="fas fa-chart-bar icon"></i>
                    <span>{{__('admin.discount')}}</span>
                    <i class="fas fa-angle-right angle"></i>
                </section>
                <section class="sidebar-dropdown">
                    <a href="{{route('admin.market.discounts.copan')}}">{{__('admin.discount coupon')}}</a>
                    <a href="{{route('admin.market.discounts.commonDiscount')}}">{{__('admin.common discount')}}</a>
                    <a href="{{route('admin.market.discounts.amazingSale')}}">{{__('admin.amazing sale')}}</a>
                </section>
            </section>

            <a href="{{route('admin.market.deliveries.index')}}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>{{__('admin.delivery methods')}}</span>
            </a>



            <section class="sidebar-part-title">{{__('admin.content section')}}</section>
            <a href="{{route('admin.content.categories.index')}}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>{{__('admin.category')}}</span>
            </a>
            <a href="{{route('admin.content.posts.index')}}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>{{__('admin.posts')}}</span>
            </a>
            <a href="{{route('admin.content.comments.index')}}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>{{__('admin.comments')}}</span>
            </a>
            <a href="{{route('admin.content.menus.index')}}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>{{__('admin.menus')}}</span>
            </a>
            <a href="{{route('admin.content.faqs.index')}}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>{{__('admin.faqs')}}</span>
            </a>
            <a href="{{route('admin.content.pages.index')}}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>{{__('admin.page builder')}}</span>
            </a>
            <a href="{{ route('admin.content.banners.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>{{__('admin.banners')}}</span>
            </a>


            <section class="sidebar-part-title">{{__('admin.users section')}}</section>
            <a href="{{route('admin.user.admin-users.index')}}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>{{__('admin.admin users')}}</span>
            </a>
            <a href="{{route('admin.user.customers.index')}}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>{{__('admin.customers')}}</span>
            </a>
            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle">
                    <i class="fas fa-chart-bar icon"></i>
                    <span>{{__('admin.access level')}}</span>
                    <i class="fas fa-angle-right angle"></i>
                </section>
                <section class="sidebar-dropdown">
                    <a href="{{ route('admin.user.roles.index') }}">{{__('admin.roles management')}}</a>
                    <a href="{{ route('admin.user.permissions.index') }}"> {{__('admin.permissions management')}}</a>
                </section>
            </section>




            <section class="sidebar-part-title">{{__('admin.tickets')}}</section>
            <a href="{{ route('admin.ticket.categories.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span> {{__('admin.tickets category')}}</span>
            </a>
            <a href="{{ route('admin.ticket.priorities.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span> {{__('admin.tickets priority')}} </span>
            </a>
            <a href="{{ route('admin.ticket.admins.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span> {{__('admin.tickets admin')}}</span>
            </a>
            <a href="{{route('admin.ticket.newTickets')}}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>{{__('admin.new tickets')}}</span>
            </a>
            <a href="{{route('admin.ticket.openTickets')}}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>{{__('admin.open tickets')}}</span>
            </a>
            <a href="{{route('admin.ticket.closeTickets')}}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>{{__('admin.close tickets')}}</span>
            </a>



            <section class="sidebar-part-title">{{__('admin.notifications')}}</section>
            <a href="{{route('admin.notify.emails.index')}}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>{{__('admin.email notifications')}}</span>
            </a>
            <a href="{{route('admin.notify.smss.index')}}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>{{__('admin.sms notifications')}}</span>
            </a>



            <section class="sidebar-part-title">{{__('admin.setting')}}</section>
            <a href="{{route('admin.settings.index')}}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>{{__('admin.setting')}}</span>
            </a>

        </section>
    </section>
</aside>
