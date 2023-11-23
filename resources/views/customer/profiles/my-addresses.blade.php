@extends('customer.layouts.master-two-col')

@section('head-tag')
<title>{{__('public.my addresses')}}</title>
@endsection


@section('content')
<!-- start body -->
<section class="">
    <section id="main-body-two-col" class="container-xxl body-container">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <section class="row">


            @include('customer.layouts.partials.profile-sidebar')

            <main id="main-body" class="main-body col-md-9">
                <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

                    <!-- start vontent header -->
                    <section class="content-header mb-4">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>{{__('public.my addresses')}}</span>
                            </h2>

                        </section>
                    </section>
                    <!-- end vontent header -->



                    <section class="address-select">

                        @forelse(auth()->user()->addresses as $address)
                        <input type="radio" name="address_id" value="{{ $address->id }}" id="a-{{ $address->id }}" />
                        <!--checked="checked"-->
                        <label for="a-{{ $address->id }}" class="address-wrapper mb-2 p-2">
                            <section class="mb-2">
                                <i class="fa fa-map-marker-alt mx-1"></i>
                                {{__('public.address : ')}} {{ $address->address ?? '-' }}
                            </section>
                            <section class="mb-2">
                                <i class="fa fa-user-tag mx-1"></i>
                                {{__('public.receiver : ')}} {{ $address->recipient_first_name ?? '-' }}
                                {{ $address->recipient_last_name ?? '-' }}
                            </section>
                            <section class="mb-2">
                                <i class="fa fa-mobile-alt mx-1"></i>
                                {{__('public.receiver phone number : ')}} {{ $address->mobile ?? '-' }}
                            </section>
                            <a class="" data-bs-toggle="modal" data-bs-target="#edit-address-{{ $address->id }}"><i
                                    class="fa fa-edit"></i>
                                    {{__('public.edit address')}}</a>
                        </label>


                        <!-- start edit address Modal -->
                        <section class="modal fade" id="edit-address-{{ $address->id }}" tabindex="-1"
                            aria-labelledby="add-address-label" aria-hidden="true">
                            <section class="modal-dialog">
                                <section class="modal-content">
                                    <section class="modal-header">
                                        <h5 class="modal-title" id="add-address-label"><i class="fa fa-plus"></i> {{__('public.edit address')}}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </section>
                                    <section class="modal-body">
                                        <form class="row" method="post"
                                            action="{{ route('customer.sales-process.addresss.update-address', $address->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <section class="col-6 mb-2">
                                                <label for="province" class="form-label mb-1">{{__('public.province')}}</label>
                                                <select name="province_id" class="form-select form-select-sm"
                                                    id="province-{{ $address->id }}">
                                                    @foreach ($provinces as $province)
                                                    <option
                                                        {{ $address->province_id == $province->id ? 'selected' : '' }}
                                                        value="{{ $province->id }}"
                                                        data-url="{{ route('customer.sales-process.addresss.get-cities', $province->id) }}">
                                                        {{ $province->name }}</option>
                                                    @endforeach

                                                </select>
                                            </section>

                                            <section class="col-6 mb-2">
                                                <label for="city" class="form-label mb-1">{{__('public.city')}}</label>
                                                <select name="city_id" class="form-select form-select-sm"
                                                    id="city-{{ $address->id }}">
                                                    <option selected>{{__('public.choose city')}}</option>
                                                </select>
                                            </section>
                                            <section class="col-12 mb-2">
                                                <label for="address" class="form-label mb-1">{{__('public.address')}}</label>
                                                <textarea name="address" class="form-control form-control-sm"
                                                    id="address" placeholder="{{__('public.address')}}">{{ $address->address }}</textarea>
                                            </section>

                                            <section class="col-6 mb-2">
                                                <label for="postal_code" class="form-label mb-1">{{__('public.postal code')}}</label>
                                                <input value="{{ $address->postal_code }}" type="text"
                                                    name="postal_code" class="form-control form-control-sm"
                                                    id="postal_code" placeholder="{{__('public.postal code')}}">
                                            </section>

                                            <section class="col-3 mb-2">
                                                <label for="no" class="form-label mb-1">{{__('public.no')}}</label>
                                                <input type="text" value="{{ $address->no }}" name="no"
                                                    class="form-control form-control-sm" id="no" placeholder="{{__('public.no')}}">
                                            </section>

                                            <section class="col-3 mb-2">
                                                <label for="unit" class="form-label mb-1">{{__('public.unit')}}</label>
                                                <input type="text" value="{{ $address->unit }}" name="unit"
                                                    class="form-control form-control-sm" id="unit" placeholder="{{__('public.unit')}}">
                                            </section>

                                            <section class="border-bottom mt-2 mb-3"></section>

                                            <section class="col-12 mb-2">
                                                <section class="form-check">
                                                    <input {{ $address->recipient_first_name ? 'checked' : '' }}
                                                        class="form-check-input" name="receiver" type="checkbox"
                                                        id="receiver">
                                                    <label class="form-check-label" for="receiver">
                                                    {{__('public.i am not the recipient')}}
                                                    </label>
                                                </section>
                                            </section>

                                            <section class="col-6 mb-2">
                                                <label for="first_name" class="form-label mb-1">{{__('public.recipient first name')}}</label>
                                                <input
                                                    value="{{ $address->recipient_first_name ?? $address->recipient_first_name }}"
                                                    type="text" name="recipient_first_name"
                                                    class="form-control form-control-sm" id="first_name"
                                                    placeholder="{{__('public.recipient first name')}}">
                                            </section>

                                            <section class="col-6 mb-2">
                                                <label for="last_name" class="form-label mb-1">{{__('public.recipient last name')}}</label>
                                                <input
                                                    value="{{ $address->recipient_last_name ?? $address->recipient_last_name }}"
                                                    type="text" name="recipient_last_name"
                                                    class="form-control form-control-sm" id="last_name"
                                                    placeholder="{{__('public.recipient last name')}}">
                                            </section>

                                            <section class="col-6 mb-2">
                                                <label for="mobile" class="form-label mb-1">{{__('public.mobile number')}}</label>
                                                <input value="{{ $address->mobile ?? $address->mobile }}" type="text"
                                                    name="mobile" class="form-control form-control-sm" id="mobile"
                                                    placeholder="{{__('public.mobile number')}}">
                                            </section>


                                    </section>
                                    <section class="modal-footer py-1">
                                        <button type="submit" class="btn btn-sm btn-primary">{{__('public.add address')}}</button>
                                        <button type="button" class="btn btn-sm btn-danger"
                                            data-bs-dismiss="modal">{{__('public.close')}}</button>
                                    </section>
                                    </form>

                                </section>
                            </section>
                        </section>
                        <!-- end add address Modal -->
                        @empty
                        <p>{{__('public.there is not any address')}}</p>
                        @endforelse





                        <section class="address-add-wrapper">
                            <button class="address-add-button" type="button" data-bs-toggle="modal"
                                data-bs-target="#add-address"><i class="fa fa-plus"></i>{{__('public.create new address')}}</button>
                            <!-- start add address Modal -->
                            <section class="modal fade" id="add-address" tabindex="-1"
                                aria-labelledby="add-address-label" aria-hidden="true">
                                <section class="modal-dialog">
                                    <section class="modal-content">
                                        <section class="modal-header">
                                            <h5 class="modal-title" id="add-address-label"><i class="fa fa-plus"></i>
                                            {{__('public.create new address')}}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </section>
                                        <section class="modal-body">
                                            <form class="row" method="post"
                                                action="{{ route('customer.sales-process.addresss.add-address') }}">
                                                @csrf
                                                <section class="col-6 mb-2">
                                                    <label for="province" class="form-label mb-1">{{__('public.province')}}</label>
                                                    <select name="province_id" class="form-select form-select-sm"
                                                        id="province">
                                                        <option selected>{{__('public.choose province')}}</option>
                                                        @foreach ($provinces as $province)
                                                        <option value="{{ $province->id }}"
                                                            data-url="{{ route('customer.sales-process.addresss.get-cities', $province->id) }}">
                                                            {{ $province->name }}</option>
                                                        @endforeach

                                                    </select>
                                                </section>

                                                <section class="col-6 mb-2">
                                                    <label for="city" class="form-label mb-1">{{__('public.city')}}</label>
                                                    <select name="city_id" class="form-select form-select-sm" id="city">
                                                        <option selected>{{__('public.choose city')}}</option>
                                                    </select>
                                                </section>
                                                <section class="col-12 mb-2">
                                                    <label for="address" class="form-label mb-1">{{__('public.address')}}</label>
                                                    <textarea name="address" class="form-control form-control-sm"
                                                        id="address" placeholder="{{__('public.address')}}"></textarea>
                                                </section>

                                                <section class="col-6 mb-2">
                                                    <label for="postal_code" class="form-label mb-1">{{__('public.postal code')}}</label>
                                                    <input type="text" name="postal_code"
                                                        class="form-control form-control-sm" id="postal_code"
                                                        placeholder="{{__('public.postal code')}}">
                                                </section>

                                                <section class="col-3 mb-2">
                                                    <label for="no" class="form-label mb-1">{{__('public.no')}}</label>
                                                    <input type="text" name="no" class="form-control form-control-sm"
                                                        id="no" placeholder="{{__('public.no')}}">
                                                </section>

                                                <section class="col-3 mb-2">
                                                    <label for="unit" class="form-label mb-1">{{__('public.unit')}}</label>
                                                    <input type="text" name="unit" class="form-control form-control-sm"
                                                        id="unit" placeholder="{{__('public.unit')}}">
                                                </section>

                                                <section class="border-bottom mt-2 mb-3"></section>

                                                <section class="col-12 mb-2">
                                                    <section class="form-check">
                                                        <input class="form-check-input" name="receiver" type="checkbox"
                                                            id="receiver">
                                                        <label class="form-check-label" for="receiver">
                                                        {{__('public.i am not the recipient')}}
                                                        </label>
                                                    </section>
                                                </section>

                                                <section class="col-6 mb-2">
                                                    <label for="first_name" class="form-label mb-1">{{__('public.recipient first name')}}</label>
                                                    <input type="text" name="recipient_first_name"
                                                        class="form-control form-control-sm" id="first_name"
                                                        placeholder="{{__('public.recipient first name')}}">
                                                </section>

                                                <section class="col-6 mb-2">
                                                    <label for="last_name" class="form-label mb-1">{{__('public.recipient last name')}}</label>
                                                    <input type="text" name="recipient_last_name"
                                                        class="form-control form-control-sm" id="last_name"
                                                        placeholder="{{__('public.recipient last name')}}">
                                                </section>

                                                <section class="col-6 mb-2">
                                                    <label for="mobile" class="form-label mb-1">{{__('public.mobile number')}}</label>
                                                    <input type="text" name="mobile"
                                                        class="form-control form-control-sm" id="mobile"
                                                        placeholder="{{__('public.mobile number')}}">
                                                </section>


                                        </section>
                                        <section class="modal-footer py-1">
                                            <button type="submit" class="btn btn-sm btn-primary">{{__('public.add address')}}</button>
                                            <button type="button" class="btn btn-sm btn-danger"
                                                data-bs-dismiss="modal">{{__('public.close')}}</button>
                                        </section>
                                        </form>

                                    </section>
                                </section>
                            </section>
                            <!-- end add address Modal -->
                        </section>

                    </section>

                </section>
            </main>
        </section>
    </section>
</section>
<!-- end body -->
@endsection


@section('scripts')
<script>
$(document).ready(function() {
    $('#province').change(function() {
        var element = $('#province option:selected');
        var url = element.attr('data-url');

        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                if (response.status) {
                    let cities = response.cities;
                    $('#city').empty();
                    cities.map((city) => {
                        $('#city').append($('<option/>').val(city.id).text(city
                            .name))
                    })
                } else {
                    errorToast("{{__('public.error')}}")
                }
            },
            error: function() {
                errorToast("{{__('public.error')}}")
            }
        })
    })


    // edit
    var addresses = {
        !!auth() - > user() - > addresses!!
    }
    // console.log(addresses);
    addresses.map(function(address) {
        var id = address.id;
        var target = `#province-${id}`;
        var selected = `${target} option:selected`
        $(target).change(function() {
            var element = $(selected);
            var url = element.attr('data-url');

            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    if (response.status) {
                        let cities = response.cities;
                        $(`#city-${id}`).empty();
                        cities.map((city) => {
                            $(`#city-${id}`).append($('<option/>').val(
                                city.id).text(city
                                .name))
                        })
                    } else {
                        errorToast("{{__('public.error')}}")
                    }
                },
                error: function() {
                    errorToast("{{__('public.error')}}")
                }
            })
        })
    })

})
</script>
@endsection
