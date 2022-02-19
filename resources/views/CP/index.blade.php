@extends('CP.layouts.header-footer')
@section('content')


    @php
        $colors = [
            'purchase_orders' => '#F86080',
            'money_transfers' => '#359EE5',
            'trips' => '#F8C854',
            'shipping_invoices' => '#22CECE',
        ]
    @endphp


    <div class="statistics text-right">

        {{-- Start statistics New Requests --}}
        <section class="row statistics-counts mb-3" >


            <div class="col-md-6 col-lg-3" style="padding: 10px;">
                <div class="card border-0 shadow">
                    <a href="{{ url('cp/customers') }}" class="card-body">
                        <div class="row">
                            <div class="col">
                                <h6 class="mb-2">زبائن جدد</h6>
                                <h3 class="card-text">{{ $newRequests->customers }}</h3>
                            </div>
                            <div class="col-auto my-auto">
                                <i class="fa fa-users"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-6 col-lg-3" style="padding: 10px;">
                <div class="card border-0 shadow">
                    <a href="{{ url('cp/messages') }}" class="card-body">
                        <div class="row">
                            <div class="col">
                                <h6 class="mb-2">رسائل جديدة</h6>
                                <h3 class="card-text">{{ $newRequests->messages }}</h3>
                            </div>
                            <div class="col-auto my-auto">
                                <i class="fa fa-comments"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>


        </section>
        {{-- End statistics New Requests --}}



        <!--    Start Financial movement Charts     -->
        <section class="row my-4 text-right">

            {{-- Start Liner Chart --}}
            <div class="col-md-8 mb-3">
                <div class="card border-0 shadow rounded-lg overflow-hidden">

                    <div class="card-header bg-white">
                        <h6 class="text-secondary mb-1 mt-2">نظرة عامة</h6>
                        <h5>الحركة المالية لأخر 8 أشهر</h5>

                    </div>

                    <div class="card-body">
                        <canvas id="FinancialMovementLineChart"></canvas>
                    </div>

                </div>
            </div>
            {{-- End Liner Chart --}}


            {{-- Start Pie Chart --}}
            <div class="col-md-4 mb-3">
                <div class="card h-100 border-0 shadow rounded-lg overflow-hidden">

                    <div class="card-header bg-white">
                        <h6 class="text-secondary mb-1 mt-2">نظرة عامة</h6>
                        <h5>الحركة المالية</h5>
                    </div>

                    <div class="card-body pb-2">

                        <ul class="pr-0 mb-1">
                            <li class="d-flex my-1">
                                <span class="ml-2 text-center text-white w-50px" style="background-color:{{ $colors['trips'] }};">{{ $sum->percentage->trips_sum }}%</span>
                                <span>الرحلات {{ number_format($sum->trips_sum) }}$</span>
                            </li>
                            <li class="d-flex my-1">
                                <span class="ml-2 text-center text-white w-50px" style="background-color:{{ $colors['shipping_invoices'] }};">{{ $sum->percentage->shipping_invoices_sum }}%</span>
                                <span>الشحنات {{ number_format($sum->shipping_invoices_sum) }}$</span>
                            </li>
                            <li class="d-flex">
                                <span class="ml-2 text-center text-white bg-secondary w-50px">100%</span>
                                <span>الإجمالي {{ number_format($sum->total_sum) }}$</span>
                            </li>
                        </ul>

                        <canvas id="FinancialMovementPieChart" width="100" height="70"></canvas>

                    </div>

                </div>
            </div>
            {{-- End Pie Chart --}}

        </section>
        <!--    End Financial movement Charts     -->



        <!--    Start Public movement Charts     -->
        <section class="row my-4 text-right">

            {{-- Start Liner Chart --}}
            <div class="col-md-8 mb-3">
                <div class="card border-0 shadow rounded-lg overflow-hidden">

                    <div class="card-header bg-white">
                        <h6 class="text-secondary mb-1 mt-2">نظرة عامة</h6>
                        <h5>الحركة العامة لأخر 8 أشهر</h5>
                    </div>

                    <div class="card-body">
                        <canvas id="PublicMovementLineChart"></canvas>
                    </div>

                </div>
            </div>
            {{-- End Liner Chart --}}


            {{-- Start Pie Chart --}}
            <div class="col-md-4 mb-3">
                <div class="card h-100 border-0 shadow rounded-lg overflow-hidden">

                    <div class="card-header bg-white">
                        <h6 class="text-secondary mb-1 mt-2">نظرة عامة</h6>
                        <h5>الحركة العامة</h5>
                    </div>

                    <div class="card-body pb-2">

                        <ul class="pr-0 mb-1">
                            <li class="d-flex my-1">
                                <span class="ml-2 text-center text-white w-50px" style="background-color:{{ $colors['trips'] }};">{{ $sum->percentage->trips_count }}%</span>
                                <span>الرحلات {{ number_format($sum->trips_count) }}</span>
                            </li>
                            <li class="d-flex my-1">
                                <span class="ml-2 text-center text-white w-50px" style="background-color:{{ $colors['shipping_invoices'] }};">{{ $sum->percentage->shipping_invoices_count }}%</span>
                                <span>الشحنات {{ number_format($sum->shipping_invoices_count) }}</span>
                            </li>
                            <li class="d-flex">
                                <span class="ml-2 text-center text-white bg-secondary w-50px">100%</span>
                                <span>الإجمالي {{ number_format($sum->total_count) }}</span>
                            </li>
                        </ul>

                        <canvas id="PublicMovementPieChart" width="100" height="70"></canvas>

                    </div>

                </div>
            </div>
            {{-- End Pie Chart --}}


        </section>
        <!--    End Public movement Charts     -->

    </div>


@endsection
