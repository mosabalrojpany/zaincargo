@extends('CP.layouts.header-footer')
@section('content')



    <!--    Start header    -->
    <div class="d-flex justify-content-between">
        <h4 class="font-weight-bold">أدوار المستخدمين {{ count($roles) }}</h4>
        <button class="btn btn-primary btnAdd w-100px" data-toggle="modal" data-active="0" data-target="#Modal">
            <i class="fas fa-plus mx-1"></i>أضف
        </button>
    </div>
    <!--    End header    -->




    <!--    Start show Roles   -->
    <table class="table text-center mt-4 bg-white">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">الاسم</th>
                <th scope="col">معلومات إضافية</th>
                <th scope="col">تعديل</th>
            </tr>
        </thead>
        <tbody>

            <!-- Start print Roles -->
            @foreach($roles as $role)
                <tr data-permissions="{{ $role->toJson() }}">
                    <th scope="row">{{ $loop->iteration}}</th>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->extra }}</td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm btnEdit" data-toggle="modal" data-target="#Modal">
                            <i class="fas fa-pen"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            <!-- End print Roles -->

        </tbody>
    </table>
    <!--    End show Roles   -->



    <!--    Start Modal  -->
    <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">تعديل دور</h5>
                    <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class='formSendAjaxRequest was-validated' refresh-seconds='2' action="{{ url('/cp/user-roles') }}" method="post">
                    <div class="modal-body px-sm-5">

                        <div class="formResult text-center"></div>

                        {{ csrf_field() }}
                        <input type="hidden" name="id" />

                        <div class="form-group row">
                            <label for="inputName" class="col-sm-auto w-75px col-form-label text-right">الاسم</label>
                            <div class="col-sm">
                                <input type="text" name="name" class="form-control" id="inputName" placeholder="دور المستخدم" pattern="\s*([^\s]\s*){3,32}" required>
                                <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'الاسم','min'=> 3 ,'max'=>32])</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputExtra" class="col-sm-auto w-75px col-form-label text-right">أخرى</label>
                            <div class="col-sm">
                                <textarea name="extra" rows="2" class="form-control" id="inputExtra" placeholder="معلومات أخرى" maxlength="150"></textarea>
                                <div class="invalid-feedback text-center">@lang('validation.max.string',['attribute'=>'المعلومات الأخرى','max'=>150])</div>
                            </div>
                        </div>

                        {{-- Start Permissions --}}
                        <table class="table table-bordered text-center">

                            <thead>
                                <tr>
                                    <th scope="col">الوظيفة</th>
                                    <th scope="col">
                                        <div class="custom-control custom-checkbox pr-4 pl-2">
                                            <input type="checkbox" class="custom-control-input" id="checkBoxSelectAll">
                                            <label class="custom-control-label text-dark" for="checkBoxSelectAll">الكل</label>
                                        </div>
                                    </th>
                                    <th scope="col">عرض</th>
                                    <th scope="col">إضافة</th>
                                    <th scope="col">تعديل</th>
                                    <th scope="col">حذف</th>
                                    <th scope="col">تنزيل</th>
                                </tr>
                            </thead>
                            <tbody>

                                {{-- Start Purchase orders --}}
                                <tr>
                                    <td>طلبات الشراء</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" class="custom-control-input checkbox-parent" id="checkBoxSelectAllPurchaseOrders">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllPurchaseOrders"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[purchase_orders_show]" class="custom-control-input checkbox-child" id="customCheckShowPurchaseOrders">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckShowPurchaseOrders"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[purchase_orders_add]" class="custom-control-input checkbox-child" id="customCheckAddPurchaseOrders">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckAddPurchaseOrders"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[purchase_orders_edit]" class="custom-control-input checkbox-child" id="customCheckEditPurchaseOrders">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckEditPurchaseOrders"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[purchase_orders_delete]" class="custom-control-input checkbox-child" id="customCheckDeletePurchaseOrders">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckDeletePurchaseOrders"></label>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                {{-- End Purchase orders --}}

                                {{-- Start Purchase Orders comments (purchase_order_comments) --}}
                                <tr>
                                    <td>تعليقات طلبات الشراء</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" class="custom-control-input checkbox-parent" id="checkBoxSelectAllPurchaseOrderComments">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllPurchaseOrderComments"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[purchase_order_comments_show]" class="custom-control-input checkbox-child" id="customCheckPurchaseOrderComments">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckPurchaseOrderComments"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[purchase_order_comments_add]" class="custom-control-input checkbox-child" id="customCheckAddPurchaseOrderComments">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckAddPurchaseOrderComments"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[purchase_order_comments_edit]" class="custom-control-input checkbox-child" id="customCheckEditPurchaseOrderComments">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckEditPurchaseOrderComments"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[purchase_order_comments_delete]" class="custom-control-input checkbox-child" id="customCheckDeletePurchaseOrderComments">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckDeletePurchaseOrderComments"></label>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                {{-- End Purchase Orders comments (purchase_order_comments) --}}

                                {{-- Start Money Transfers --}}
                                <tr>
                                    <td>الحوالات المالية</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" class="custom-control-input checkbox-parent" id="checkBoxSelectAllMoneyTransfers">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllMoneyTransfers"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[money_transfers_show]" class="custom-control-input checkbox-child" id="customCheckShowMoneyTransfers">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckShowMoneyTransfers"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[money_transfers_add]" class="custom-control-input checkbox-child" id="customCheckAddMoneyTransfers">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckAddMoneyTransfers"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[money_transfers_edit]" class="custom-control-input checkbox-child" id="customCheckEditMoneyTransfers">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckEditMoneyTransfers"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[money_transfers_delete]" class="custom-control-input checkbox-child" id="customCheckDeleteMoneyTransfers">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckDeleteMoneyTransfers"></label>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                {{-- End Money Transfers --}}

                                {{-- Start Trips --}}
                                <tr>
                                    <td>الرحلات</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" class="custom-control-input checkbox-parent" id="checkBoxSelectAllTrips">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllTrips"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[trips_show]" class="custom-control-input checkbox-child" id="customCheckShowTrips">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckShowTrips"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[trips_add]" class="custom-control-input checkbox-child" id="customCheckAddTrips">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckAddTrips"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[trips_edit]" class="custom-control-input checkbox-child" id="customCheckEditTrips">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckEditTrips"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[trips_delete]" class="custom-control-input checkbox-child" id="customCheckDeleteTrips">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckDeleteTrips"></label>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                {{-- End Trips --}}

                                {{-- Start Shipping Invoices --}}
                                <tr>
                                    <td>الشحنات</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" class="custom-control-input checkbox-parent" id="checkBoxSelectAllShippingInvoices">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllShippingInvoices"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[shipping_invoices_show]" class="custom-control-input checkbox-child" id="customCheckShowShippingInvoices">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckShowShippingInvoices"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[shipping_invoices_add]" class="custom-control-input checkbox-child" id="customCheckAddShippingInvoices">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckAddShippingInvoices"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[shipping_invoices_edit]" class="custom-control-input checkbox-child" id="customCheckEditShippingInvoices">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckEditShippingInvoices"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[shipping_invoices_delete]" class="custom-control-input checkbox-child" id="customCheckDeleteShippingInvoices">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckDeleteShippingInvoices"></label>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                {{-- End Shipping Invoices --}}


                                {{-- Start Shipping Invoices comments (shipment_comments) --}}
                                <tr>
                                    <td>تعليقات الشحنات</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" class="custom-control-input checkbox-parent" id="checkBoxSelectAllShipmentComments">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllShipmentComments"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[shipment_comments_show]" class="custom-control-input checkbox-child" id="customCheckShipmentComments">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckShipmentComments"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[shipment_comments_add]" class="custom-control-input checkbox-child" id="customCheckAddShipmentComments">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckAddShipmentComments"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[shipment_comments_edit]" class="custom-control-input checkbox-child" id="customCheckEditShipmentComments">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckEditShipmentComments"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[shipment_comments_delete]" class="custom-control-input checkbox-child" id="customCheckDeleteShipmentComments">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckDeleteShipmentComments"></label>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                {{-- End Shipping Invoices comments (shipment_comments) --}}

                                {{-- Start Customers --}}
                                <tr>
                                    <td>الزبائن</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" class="custom-control-input checkbox-parent" id="checkBoxSelectAllCustomers">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllCustomers"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[customers_show]" class="custom-control-input checkbox-child" id="customCheckShowCustomers">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckShowCustomers"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[customers_add]" class="custom-control-input checkbox-child" id="customCheckAddCustomers">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckAddCustomers"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[customers_edit]" class="custom-control-input checkbox-child" id="customCheckEditCustomers">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckEditCustomers"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[customers_delete]" class="custom-control-input checkbox-child" id="customCheckDeleteCustomers">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckDeleteCustomers"></label>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                {{-- End Customers --}}

                                {{-- Start Clients Logins --}}
                                <tr>
                                    <td>حركات دخول الزبائن</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[clients_logins]"  class="custom-control-input checkbox-parent" id="checkBoxSelectAllClientLogins">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllClientLogins"></label>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                {{-- End Clients Logins --}}

                                {{-- Start Messages --}}
                                <tr>
                                    <td>الرسائل</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" class="custom-control-input checkbox-parent" id="checkBoxSelectAllMessages">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllMessages"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[messages_show]" class="custom-control-input checkbox-child" id="customCheckShowMessages">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckShowMessages"></label>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[messages_edit]" class="custom-control-input checkbox-child" id="customCheckEditMessages">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckEditMessages"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[messages_delete]" class="custom-control-input checkbox-child" id="customCheckDeleteMessages">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckDeleteMessages"></label>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                {{-- End Messages --}}

                                {{-- Start Posts --}}
                                <tr>
                                    <td>الأخبار</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" class="custom-control-input checkbox-parent" id="checkBoxSelectAllPosts">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllPosts"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[posts_show]" class="custom-control-input checkbox-child" id="customCheckShowPosts">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckShowPosts"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[posts_add]" class="custom-control-input checkbox-child" id="customCheckAddPosts">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckAddPosts"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[posts_edit]" class="custom-control-input checkbox-child" id="customCheckEditPosts">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckEditPosts"></label>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                {{-- End Posts --}}

                                {{-- Start Tags --}}
                                <tr>
                                    <td>تصنيفات الأخبار</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[tags]" class="custom-control-input checkbox-parent" id="checkBoxSelectAllTags">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllTags"></label>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                {{-- End Tags --}}

                                {{-- Start Addresses --}}
                                <tr>
                                    <td>عناوين الشحن</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" class="custom-control-input checkbox-parent" id="checkBoxSelectAllAddresses">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllAddresses"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[addresses_show]" class="custom-control-input checkbox-child" id="customCheckShowAddresses">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckShowAddresses"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[addresses_add]" class="custom-control-input checkbox-child" id="customCheckAddAddresses">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckAddAddresses"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[addresses_edit]" class="custom-control-input checkbox-child" id="customCheckEditAddresses">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckEditAddresses"></label>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                {{-- End Addresses --}}


                                {{-- Start Shipping Companies --}}
                                <tr>
                                    <td>شركات الشحن</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[shipping_companies]" class="custom-control-input checkbox-parent" id="checkBoxSelectAllShippingCompanies">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllShippingCompanies"></label>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                {{-- End Shipping Companies --}}

                                {{-- Start Receiving Places --}}
                                <tr>
                                    <td>أماكن الاستلام</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[receiving_places]" class="custom-control-input checkbox-parent" id="customCheckShowReceivingPlaces">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="customCheckShowReceivingPlaces"></label>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                {{-- End Receiving Places --}}

                                {{-- Start Item Types --}}
                                <tr>
                                    <td>أنواع الأصناف</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[item_types]" class="custom-control-input checkbox-parent" id="checkBoxSelectAllItemTypes">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllItemTypes"></label>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                {{-- End Item Types --}}

                                {{-- Start Users --}}
                                <tr>
                                    <td>المستخدمين</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[users]" class="custom-control-input checkbox-parent" id="checkBoxSelectAllUsers">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllUsers"></label>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                {{-- End Users --}}

                                {{-- Start Permissions --}}
                                <tr>
                                    <td>أدوار المستخدمين</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[user_roles]" class="custom-control-input checkbox-parent" id="checkBoxSelectAllUserRoles">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllUserRoles"></label>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                {{-- End Permissions --}}

                                {{-- Start Users Logins --}}
                                <tr>
                                    <td>حركات دخول المستخدمين</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[users_logins]" class="custom-control-input checkbox-parent" id="checkBoxSelectAllUsersLogins">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllUsersLogins"></label>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                {{-- End Users Logins --}}

                                {{-- Start Branches --}}
                                <tr>
                                    <td>الفروع</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[branches]" class="custom-control-input checkbox-parent" id="checkBoxSelectAllBranches">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllBranches"></label>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                {{-- End Branches --}}

                                {{-- Start Backups --}}
                                <tr>
                                    <td>النسخ الاحتياطية</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" class="custom-control-input checkbox-parent" id="checkBoxSelectAllBackups">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllBackups"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[backups_show]" class="custom-control-input checkbox-child" id="customCheckShowBackups">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckShowBackups"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[backups_add]" class="custom-control-input checkbox-child" id="customCheckAddBackups">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckAddBackups"></label>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[backups_delete]" class="custom-control-input checkbox-child" id="customCheckDeleteBackups">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckDeleteBackups"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[backups_download]" class="custom-control-input checkbox-child" id="customCheckDownloadBackups">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckDownloadBackups"></label>
                                        </div>
                                    </td>
                                </tr>
                                {{-- End Backups --}}

                                {{-- Start Settings --}}
                                <tr>
                                    <td>الإعدادات</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[settings]" class="custom-control-input checkbox-parent" id="checkBoxSelectAllSettings">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllSettings"></label>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                {{-- End Settings --}}

                                {{-- Start FAQ --}}
                                <tr>
                                    <td>الأسئلة الشائعة</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[faq]" class="custom-control-input checkbox-parent" id="checkBoxSelectAllFAQ">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllFAQ"></label>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                {{-- End FAQ --}}

                                {{-- Start Currency Types --}}
                                <tr>
                                    <td>أنواع العملات</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[currency_types]" class="custom-control-input checkbox-parent" id="checkBoxSelectAllCurrencyTypes">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllCurrencyTypes"></label>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                {{-- End Currency Types --}}

                                {{-- Start Countries --}}
                                <tr>
                                    <td>البلدان</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[countries]" class="custom-control-input checkbox-parent" id="checkBoxSelectAllCountries">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllCountries"></label>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                {{-- End Countries --}}

                                {{-- Start Cities --}}
                                <tr>
                                    <td>المدن</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[cities]" class="custom-control-input checkbox-parent" id="checkBoxSelectAllCities">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllCities"></label>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                {{-- End Cities --}}

                                                                {{-- Start merchant for order --}}
                                                                <tr>
                                                                    <td>احالة طلبات الشراء</td>
                                                                    <td>
                                                                        <div class="custom-control custom-checkbox px-0">
                                                                            <input type="checkbox" value="1" name="permissions[merchant]" class="custom-control-input checkbox-parent" id="checkBoxSelectMerchant">
                                                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectMerchant"></label>
                                                                        </div>
                                                                    </td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>
                                                                {{-- End merchant --}}
                                {{--حركات احالة طلبات الشراء--}}
                                <tr>
                                    <td>حركات احالة طلبات الشراء</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[merchanttrnsactionadmin]" class="custom-control-input checkbox-parent" id="checkBoxSelectAllmerchanttrnsactionadmin">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllmerchanttrnsactionadmin"></label>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                {{--حركات احالة طلبات الشراء  --}}
                                {{-- حركات التاجر على طلبات الشراء--}}
                                <tr>
                                    <td>حركات التاجر على طلبات الشراء</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[merchanttransaction]" class="custom-control-input checkbox-parent" id="checkBoxSelectAllmerchanttransaction">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllmerchanttransaction"></label>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                {{-- حركات التاجر على طلبات الشراء --}}
                                {{-- Start merchant for order --}}
                                <tr>
                                    <td>ميزة التاجر للزبائن</td>
                                    <td>
                                                <div class="custom-control custom-checkbox px-0">
                                                       <input type="checkbox" value="1" name="permissions[merchant_from_customer]" class="custom-control-input checkbox-parent" id="checkBoxSelectMerchant_from_customer">
                                                      <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectMerchant_from_customer"></label>
                                               </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                   <td></td>
                                </tr>
                              {{-- End merchant --}}
                            </tbody>
                        </table>
                        {{-- End Permissions --}}

                        <div class="modal-header" style="margin-bottom: 17px;">
                            <h5 class="modal-title" id="ModalLabel">ادوار المحفظة</h5>
                        </div>

                        {{-- Start Permissions wallet --}}
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th scope="col">الوظيفة</th>
                                    <th scope="col">
                                        <div class="custom-control pr-4 pl-2">
                                            <label class="text-dark" for="checkBoxSelectAll">الكل</label>
                                        </div>
                                    </th>
                                    <th scope="col">عرض</th>
                                    <th scope="col">دخول</th>
                                    <th scope="col">ايداع و سحب</th>
                                    <th scope="col">كشف حساب</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Start Purchase orders --}}
                                <tr>
                                    <td>المحفظة</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" class="custom-control-input checkbox-parent" id="checkBoxSelectAllWallet">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllWallet"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[user_wallet_index]" class="custom-control-input checkbox-child" id="customCheckOpenWallet">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckOpenWallet"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[user_wallet_show]" class="custom-control-input checkbox-child" id="customCheckShowWallet">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckShowWallet"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[user_wallet_add]" class="custom-control-input checkbox-child" id="customCheckPropWallet">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckPropWallet"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[user_wallet_statement]" class="custom-control-input checkbox-child" id="customCheckShowallwather">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckShowallwather" ></label>
                                        </div>
                                    </td>
                                </tr>
                                {{-- End Purchase orders --}}
                            </tbody>
                        </table>
                        {{-- End Permissions wallet--}}
                        {{-- Start Permissions wallet --}}
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th scope="col">الوظيفة</th>
                                    <th scope="col">
                                        <div class="custom-control pr-4 pl-2">
                                            <label class=" text-dark" for="checkBoxSelectAll">الكل</label>
                                        </div>
                                    </th>
                                    <th scope="col">طباعة</th>
                                    <th scope="col">تعديل</th>
                                    <th scope="col">حدف</th>
                                    <th scope="col">المعاملات</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Start Purchase orders --}}
                                <tr>
                                    <td>عمليات المحفظة</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" class="custom-control-input checkbox-parent" id="checkBoxSelectAllWallet2">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllWallet2"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[user_wallet_depoprint]" class="custom-control-input checkbox-child" id="customCheckPrintDepo">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckPrintDepo"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[user_wallet_edit]" class="custom-control-input checkbox-child" id="customCheckEdit">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckEdit"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[user_wallet_delete]" class="custom-control-input checkbox-child" id="customCheckDelet">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckDelet"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[user_wallet_editdelet]" class="custom-control-input checkbox-child" id="customCheckDeletEdit">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckDeletEdit"></label>
                                        </div>
                                    </td>
                                </tr>
                                {{-- End Purchase orders --}}
                            </tbody>
                        </table>
                        {{-- End Permissions wallet--}}
                        {{-- Start Permissions wallet --}}
                        <table class="table table-bordered text-center">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">الوظيفة</th>
                                                            <th scope="col">
                                                                <div class="custom-control pr-4 pl-2">
                                                                    <label class=" text-dark">الكل</label>
                                                                </div>
                                                            </th>
                                                            <th scope="col">الايداع</th>
                                                            <th scope="col">السحب</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- Start Purchase orders --}}
                                                        <tr>
                                                            <td>العمليات</td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox px-0">
                                                                    <input type="checkbox" class="custom-control-input checkbox-parent" id="checkBoxSelectAllWalletprob">
                                                                    <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllWalletprob"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox px-0">
                                                                    <input type="checkbox" value="1" name="permissions[user_wallet_alldepo]" class="custom-control-input checkbox-child" id="customCheckAlldepo">
                                                                    <label class="custom-control-label custom-control-label-center" for="customCheckAlldepo" ></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox px-0">
                                                                    <input type="checkbox" value="1" name="permissions[user_wallet_allwather]" class="custom-control-input checkbox-child" id="customCheckAllwather">
                                                                    <label class="custom-control-label custom-control-label-center" for="customCheckAllwather" ></label>
                                                                </div>
                                                            </td>

                                                        </tr>
                                                        {{-- End Purchase orders --}}
                                                    </tbody>
                         </table>
                                                {{-- End Permissions wallet--}}

                        <div class="modal-header" style="margin-bottom: 17px;">
                            <h5 class="modal-title" id="ModalLabel">الحوالات الداخلية</h5>
                        </div>

                            {{-- Start internal transfare money bank --}}

                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th scope="col">الوظيفة</th>
                                    <th scope="col">
                                        <div class="custom-control pr-4 pl-2">
                                            <label class=" text-dark">الكل</label>
                                        </div>
                                    </th>
                                    <th scope="col">  عرض  </th>
                                    <th scope="col">ايداع راس مال</th>
                                    <th scope="col">سحب من راس مال</th>
                                    <th scope="col">سحب من الارباح</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Start Purchase orders --}}
                                <tr>
                                    <td>خزينة الحوالات الداخلية</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" class="custom-control-input checkbox-parent" id="checkBoxSelectAllInternalbranchbank">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllInternalbranchbank"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[internal_transfaremoney_bank_show]" class="custom-control-input checkbox-child" id="customCheckAllShowInternalbranchbank">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckAllShowInternalbranchbank" ></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[internal_transfaremoney_bank_depo]" class="custom-control-input checkbox-child" id="customCheckAllDepoInternalbranchbank">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckAllDepoInternalbranchbank" ></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[internal_transfaremoney_bank_wather]" class="custom-control-input checkbox-child" id="customCheckAllwatherInternalbranchbank">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckAllwatherInternalbranchbank" ></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[internal_transfaremoney_bank_watherearning]" class="custom-control-input checkbox-child" id="customCheckAllwatherearningInternalbranchbank">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckAllwatherearningInternalbranchbank" ></label>
                                        </div>
                                    </td>

                                </tr>
                        {{-- End internal transfare money bank--}}
                            </tbody>

                            <thead>
                                <tr>
                                    <th scope="col">الوظيفة</th>
                                    <th scope="col">
                                        <div class="custom-control pr-4 pl-2">
                                            <label class=" text-dark">عرض</label>
                                        </div>
                                    </th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Start Purchase orders --}}
                                <tr>
                                    <td>خزينة الحوالات الداخلية</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[transfaremoneybank_transaction]" class="custom-control-input checkbox-child" id="customCheckAllShowtransfaremoneybank_transaction">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckAllShowtransfaremoneybank_transaction" ></label>
                                        </div>
                                    </td>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                    <td>

                                    </td>

                                </tr>
                        {{-- End internal transfare money bank--}}
                            </tbody>
                        </table>
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th scope="col">الوظيفة</th>
                                    <th scope="col">
                                        <div class="custom-control pr-4 pl-2">
                                            <label class=" text-dark">الكل</label>
                                        </div>
                                    </th>
                                    <th scope="col">عرض</th>
                                    <th scope="col">عمليات</th>

                                </tr>
                            </thead>
                            <tbody>
                                {{-- Start Purchase orders --}}
                                <tr>
                                    <td>الحوالات المالية الداخلية</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" class="custom-control-input checkbox-parent" id="checkBoxSelectAlltransfaremoney">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAlltransfaremoney"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[transfaremoney_show]" class="custom-control-input checkbox-child" id="customCheckShowtransfaremoney">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckShowtransfaremoney" ></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[transfaremoney_doneordel]" class="custom-control-input checkbox-child" id="customCheckAddOrDeletetransfaremoney">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckAddOrDeletetransfaremoney" ></label>
                                        </div>
                                    </td>
                                </tr>
                        {{-- End internal transfare money bank--}}
                            </tbody>
                        </table>

                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th scope="col">الوظيفة</th>
                                    <th scope="col">
                                        <div class="custom-control pr-4 pl-2">
                                            <label class=" text-dark">الكل</label>
                                        </div>
                                    </th>
                                    <th scope="col">  عرض   </th>
                                    <th scope="col">اضافة</th>
                                    <th scope="col">اظهار</th>
                                    <th scope="col">طباعة</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Start Purchase orders --}}
                                <tr>
                                    <td>فواتير التجار</td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" class="custom-control-input checkbox-parent" id="checkBoxSelectAllmarchent_invoice">
                                            <label class="custom-control-label text-dark custom-control-label-center" for="checkBoxSelectAllmarchent_invoice"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[marchent_invoice_index]" class="custom-control-input checkbox-child" id="customCheckAllmarchent_invoice_index">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckAllmarchent_invoice_index" ></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[marchent_invoice_show]" class="custom-control-input checkbox-child" id="customCheckAllmarchent_invoice_show">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckAllmarchent_invoice_show" ></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[marchent_invoice_add]" class="custom-control-input checkbox-child" id="customCheckAllmarchent_invoice_add">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckAllmarchent_invoice_add" ></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox px-0">
                                            <input type="checkbox" value="1" name="permissions[marchent_invoice_print]" class="custom-control-input checkbox-child" id="customCheckAllmarchent_invoice_print">
                                            <label class="custom-control-label custom-control-label-center" for="customCheckAllmarchent_invoice_print" ></label>
                                        </div>
                                    </td>

                                </tr>
                        {{-- End internal transfare money bank--}}
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">تحديث</button>
                        <button type="button" class="btn btn-danger mr-2" data-dismiss="modal">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--    End Modal  -->


@endsection

@section('extra-js')
    <script>

            var addAction = "{{ url('/cp/user-roles') }}";
            var editAction = "{{ url('/cp/user-roles/edit') }}";
            var form = $('#Modal form')[0];

            $('.btnAdd').click(function() {

                form.reset();
                $(form).attr('action',addAction);
                $('#ModalLabel').html('إضافة دور');
                $(form).find('.formResult').html('');

            });


            $('.btnEdit').click(function() {

                var tr = $(this).parent().parent();
                $(form).attr('action',editAction);
                $('#ModalLabel').html('تعديل دور');
                $(form).find('.formResult').html('');

                var data = $(tr).data('permissions');

                $(form).find('input[name="id"]').val(data.id);
                $(form).find('input[name="name"]').val(data.name);
                $(form).find('textarea[name="extra"]').val(data.extra);

                $.each(data, function (key, value) {
                    $(form).find('input[name="permissions['+key+']"]').prop('checked',value == 1/* to skip error "0" return true */).change();
                });

                checkBoxSelectAll();
            });


            {{-- /* Checked/Unchecked all boxes */ --}}
            $(form).find('#checkBoxSelectAll').change(function () {
                $(form).find('.checkbox-parent').prop('checked', this.checked).change();
            });


            {{-- /* Checked/Unchecked all inputs in row in table */ --}}
            $(form).find('.checkbox-parent').change(function () {
                $(this).closest('tr').find('input[type=checkbox]').prop('checked', this.checked);
                checkBoxSelectAll();
            });


            {{-- /* Checked/Unchecked parent(Select all) input in row in table */ --}}
            $(form).find('.checkbox-child').change(function () {
                var tr = $(this).closest('tr');
                $(tr).find('.checkbox-parent').prop('checked', $(tr).find('.checkbox-child:not(:checked)').length == 0);
            });

            /* check if user select all checkboxes */
            function checkBoxSelectAll(){
                $(form).find('#checkBoxSelectAll').prop('checked', $(form).find('.checkbox-parent:not(:checked)').length == 0);
            }
    </script>
@endsection
