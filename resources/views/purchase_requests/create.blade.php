@extends('layouts.app')
@section('content')

<div class="col-12">
    <h2 class="page-title">طلب شراء</h2>
    <div class="card shadow mb-4">
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form method="POST" action="{{route('purchase_requests.store')}}" class="submit-form">
                @csrf
                <div id="vehicle-forms-container">
                    <div class="vehicle-form">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="number">الرقم</label>
                                    <input type="text" name="number[]" id="number" class="form-control number" value="{{$number}}"
                                        readonly>
                                    <span class="text-danger" id="number-error"></span>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="date">التاريخ</label>
                                <div class="input-group">
                                    <input type="date" name="date[]" class="date form-control"
                                        value="{{ date('Y-m-d') }}">
                                    <div class="input-group-append">
                                        <div class="input-group-text" id="button-addon-date">
                                            <span class="fe fe-calendar fe-16">
                                            </span>
                                        </div>
                                    </div>
                                    <span class="text-danger" id="date-error"></span>
                                </div>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="reference">المرجع</label>
                                <input type="text" name="reference[]" id="reference" class="form-control">
                                <span class="text-danger" id="reference-error"></span>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="responsible">الجهة الطالبة</label>
                                <input type="text" name="responsible[]" id="responsible" class="form-control">
                                <span class="text-danger" id="responsible-error"></span>
                            </div>
                            <div id="card-order" style="background-color: rgba(0,0,0,.03);border:1px solid rgba(0,0,0,.125);">
                                <div class="card-order">
                                <div class="row" style="margin: 10px">
                                    <div class="form-group col-md-1">
                                        <input class="form-control" id="procedure_number" name="[]" value="1" placeholder="الرقم" autocomplete="true">
                                        <span class="text-danger" id="-error"></span>
                                    </div>
                                    <div class="form-group col-md-2 mb-3">
                                        <select class=" form-control" id="product_id" name="product_id[]">
                                            <option value="" disabled selected>اختر المادة</option>
                                            @foreach($products as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="product_id-error"></span>
                                    </div>
                                    {{-- <div class="form-group col-md-2 mb-3">
                                        <select class="form-control" id="product_id" name="product_id[]">
                                            <option value="" disabled selected>اختر المادة</option>
                                            @foreach($products as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                            <option value="new_product" id="add-new-product-option">إضافة مادة جديدة</option>
                                        </select>
                                        <span class="text-danger" id="product_id-error"></span>
                                    </div> --}}
                                    <div class="form-group col-md-1 ">
                                        <input class="form-control" id="quantity" name="quantity[]" placeholder="الكمية" autocomplete="true">

                                        <span class="text-danger" id="quantity-error"></span>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <input class="form-control" id="price" name="price[]" placeholder="السعر" autocomplete="true">
                                        <span class="text-danger" id="price-error"></span>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <input class="form-control" id="total_price" name="total_price[]" placeholder="الإجمالي" autocomplete="true">
                                        <span class="text-danger" id="total_price-error"></span>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <input class="form-control" id="description" name="description[]" placeholder="الوصف" autocomplete="true">
                                        <span class="text-danger" id="description-error"></span>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <input class="form-control" id="product_responsible" name="product_responsible[]" placeholder="الجهة الطالبة" autocomplete="true">
                                        <span class="text-danger" id="product_responsible-error"></span>
                                    </div>
                                    <a style="margin-bottom:15px" title="اضافة" class="btn btn-primary btn-sm justify-content-center d-flex align-items-center" id="add">
                                        <i class="fa fa-plus" style="color: #fff"></i>
                                    </a>
                                    <a style="margin-bottom:15px" href="" title="حذف" class="btn btn-danger btn-sm delete-driver justify-content-center d-flex align-items-center" id="remove">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="parts_description">الملاحظات</label>
                                <textarea class="form-control" id="notes" name="notes[]" rows="4"></textarea>
                                <span class="text-danger" id="notes-error"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="purchase_justifications">مبررات الشراء</label>
                                <textarea class="form-control" id="purchase_justifications" name="purchase_justifications[]" rows="4"></textarea>
                                <span class="text-danger" id="purchase_justifications-error"></span>
                            </div>
                            <div class="form-group col-md-6 ml-auto">
                                <label for="total">الإجمالي</label>
                                <input class="form-control" id="total" name="total[]" />
                                <span class="text-danger" id="total-error"></span>
                            </div>
                        </div>

                        <div class="col mr-auto mb-5 mt-5">
                            <div class="ml-auto">
                            </div>
                            <div class="dropdown">
                                <button type="submit" class="btn btn-success rounded-btn">حفظ</button>
                                <button type="button" id="add-form-btn" class="btn rounded-btn btn-primary">
                                    طلب شراء جديد
                                </button>
                                <button type="button" class="btn btn-danger rounded-btn delete-form-btn">
                                    إلغاء هذا الطلب
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- <div class="modal fade" id="newProductModal" tabindex="-1" aria-labelledby="newProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newProductModalLabel">إضافة مادة جديدة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('products.store') }}" id="new-product-form">
                    @csrf
                    <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="code">الرمز</label>
                                <input type="text" name="code[]" id="code" class="form-control">
                                <span class="text-danger" id="code-error"></span>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="name">الاسم</label>
                                <input type="text" name="name[]" id="name" class="form-control">
                                <span class="text-danger" id="name-error"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="qty">الكمية</label>
                                <input type="number" name="qty[]" id="qty" class="form-control">
                                <span class="text-danger" id="qty-error"></span>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="price">السعر</label>
                                <input type="number" name="price[]" id="price" class="form-control">
                                <span class="text-danger" id="price-error"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="prod_date">تاريخ الإنتاج</label>
                                <input type="date" name="prod_date[]" id="prod_date" class="form-control">
                                <span class="text-danger" id="prod_date-error"></span>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="exp_date">تاريخ الانتهاء</label>
                                <input type="date" name="exp_date[]" id="exp_date" class="form-control">
                                <span class="text-danger" id="exp_date-error"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="supplier_id">المورّد</label>
                                <select class="form-control" id="supplier_id" name="supplier_id[]">
                                    <option value="" disabled selected>اختر المورّد</option>
                                    @foreach($suppliers as $supp)
                                        <option value="{{ $supp->id }}">{{ $supp->trade_name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="supplier_id-error"></span>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="origin_country">بلد المنشأ</label>
                                <input type="text" name="origin_country[]" id="origin_country" class="form-control">
                                <span class="text-danger" id="origin_country-error"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="notes">ملاحظات</label>
                                    <textarea class="form-control" id="notes" name="notes[]" rows="4"></textarea>
                                    <span class="text-danger" id="notes-error"></span>
                                </div>
                            </div>
                        </div>
                    <button type="submit" class="btn btn-success">حفظ</button>
                </form>
            </div>
        </div>
    </div>
</div> --}}

@endsection

@section('scripts')
<script src="{{ asset('js/form-repeater.js') }}"></script>

{{-- <script>
document.getElementById('product_id').addEventListener('change', function(event) {
    if (event.target.value === 'new_product') {
        // Open the modal for adding a new product
        $('#newProductModal').modal('show');
    }
});
</script> --}}
@endsection