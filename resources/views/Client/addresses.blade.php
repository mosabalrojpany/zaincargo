@extends('Client.layouts.app')


@section('content')


    <!--    Start header    -->
    <h4 class="font-weight-bold">عناوين الشحن</h4>
    <!--    End header    -->



    <div class="row mt-4" id="shipping-addresses">

        <!-- Start print addresses -->
        @foreach($addresses as $address)

            <div class="col-lg-6 mb-3" id="{{ $address->id }}">

                <div class="card border-0 border-state-active shadow">

                    {{--  Start header address  --}}
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center" role="tab" id="heading{{ $address->id }}">
                        <h5 class="mb-0">
                            <span class="address-type-icon">
                                <img src="{{ $address->getTypeIcon() }}" style="height: 40px" class="ml-1">
                            </span>
                            <img src="{{ $address->country->getAvatarLogo() }}" class="ml-1">
                            <bdi>{{ $address->country->name }}</bdi> / <bdi>{{ $address->city->name }}</bdi>
                        </h5>
                        <a data-toggle="collapse" class="text-dark" href="#collapse{{ $address->id }}" aria-expanded="false" aria-controls="collapse{{ $address->id }}">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                    {{--  End header address  --}}

                    {{--  Start body address  --}}
                    <div id="collapse{{ $address->id }}" class="collapsing" role="tabpanel" aria-labelledby="heading{{ $address->id }}">

                        <div class="card-body text-right">

                            {{-- Start header navs for address info and prices --}}
                            <div class="pb-3">
                                <ul class="nav nav-fill nav-tabs pr-0" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="addressInfo{{ $address->id }}-tab" data-toggle="tab" href="#addressInfo{{ $address->id }}" role="tab" aria-controls="addressInfo{{ $address->id }}" aria-selected="true">العنوان</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="prices{{ $address->id }}-tab" data-toggle="tab" href="#prices{{ $address->id }}" role="tab" aria-controls="prices{{ $address->id }}" aria-selected="false">الأسعار</a>
                                    </li>
                                </ul>
                            </div>
                            {{-- End header navs for address info and prices --}}


                            <div class="tab-content">

                                {{--  Start address info  --}}
                                <div class="tab-pane fade show active" id="addressInfo{{ $address->id }}" role="tabpanel" aria-labelledby="addressInfo{{ $address->id }}-tab">
                                    <table class="table text-left">
                                        <tbody>
                                            <tr>
                                                <td><bdi>{{ $address->country->name }}</bdi></td>
                                                <td class="font-weight-bold no-wrap">Country</td>
                                            </tr>
                                            <tr>
                                                <td><bdi>{{ $address->city->name }}</bdi></td>
                                                <td class="font-weight-bold no-wrap">City</td>
                                            </tr>
                                            <tr>
                                                <td><bdi>{{ $address->fullname }} / ELL{{ substr(authClient()->user()->code, 1) }}</bdi></td>
                                                <td class="font-weight-bold no-wrap">FullName</td>
                                            </tr>
                                            @if($address->address1)
                                                <tr>
                                                    <td><bdi>{{ $address->address1 }}</bdi></td>
                                                    <td class="font-weight-bold no-wrap">Address Line 1</td>
                                                </tr>
                                            @endif
                                            @if($address->address2)
                                                <tr>
                                                    <td><bdi>{{ $address->address2 }}</bdi></td>
                                                    <td class="font-weight-bold no-wrap">Address Line 2</td>
                                                </tr>
                                            @endif
                                            @if($address->state)
                                                <tr>
                                                    <td>{{ $address->state }}</td>
                                                    <td class="font-weight-bold no-wrap">State/Region</td>
                                                </tr>
                                            @endif
                                            @if($address->zip)
                                                <tr>
                                                    <td><bdi>{{ $address->zip }}</bdi></td>
                                                    <td class="font-weight-bold no-wrap">PostCode/Zip</td>
                                                </tr>
                                            @endif
                                            @if($address->phone)
                                                <tr>
                                                    <td><bdi>{{ $address->phone }}</bdi></td>
                                                    <td class="font-weight-bold no-wrap">Phone 1</td>
                                                </tr>
                                            @endif
                                            @if($address->phone2)
                                                <tr>
                                                    <td><bdi>{{ $address->phone2 }}</bdi></td>
                                                    <td class="font-weight-bold no-wrap">Phone 2</td>
                                                </tr>
                                            @endif
                                            @if($address->phone3)
                                                <tr>
                                                    <td><bdi>{{ $address->phone3 }}</bdi></td>
                                                    <td class="font-weight-bold no-wrap">Phone 3</td>
                                                </tr>
                                            @endif
                                            @if($address->note)
                                                <tr>
                                                    <td><bdi>{{ $address->note }}</bdi></td>
                                                    <td class="font-weight-bold no-wrap"><bdi>Note(ملاحظة)</bdi></td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                {{--  End address info  --}}

                                {{--  Start prices  --}}
                                <div class="tab-pane fade" id="prices{{ $address->id }}" role="tabpanel" aria-labelledby="prices{{ $address->id }}-tab">
                                    <table class="table table-bordered text-center">
                                        <tbody>
                                            @foreach($address->prices as $price)
                                                <tr>
                                                    <td>{{ $price->description }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{--  End prices  --}}

                            </div>

                        </div>

                    </div>
                    {{--  End body address  --}}


                </div>

            </div>

        @endforeach
        <!-- End print addresses -->

    </div>



@endsection


@section('extra-js')

    <script>

        if(window.location.hash){
            $('#shipping-addresses ' + window.location.hash + ' a[data-toggle="collapse"]').click();
        }

    </script>

@endsection
