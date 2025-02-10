<div class="row d-flex justify-content-center align-items-center" style="">
    @can('index',\App\Models\Truck::class)

    <div class="col-md-2 col-sm-1 col-lg-4 ">
        <div class=" flip-container">
            <div class="flipper">
                <div class="front flex-column">
                    <i class="fe fe-truck fe-16" style=""></i>

                    <h1>المركبات</h1>
                    <h1>{{ \App\Models\Truck::count() }}</h1>

                </div>
                <div class="back d-flex justify-content-center align-items-center flex-column"
                    style="">
                    <a href="{{route('trucks.index')}}" style="color: #fff">
                        <h2 class="card-text">قائمة المركبات </h2>
                    </a>
                    <a href="{{route('cards.index')}}" style="color:#fff">
                        <h2 class="card-text">بطاقة تسليم المركبات</h2>
                    </a>
                    <a href="{{route('trucks.create')}}" style="color:#fff">
                        <h2 class="card-text">بطاقة مركبة</h2>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endcan
    @can('index',\App\Models\MovementCommand::class)

    <div class="col-md-2 col-sm-1 col-lg-4 ">
        <div class=" flip-container">
            <div class="flipper">
                <div class="front flex-column">
                    <i class="fe fe-truck fe-16"></i>

                    <h1>أمر الحركة</h1>
                    <h1> {{ \App\Models\MovementCommand::count() }}</h1>
                </div>
                <div class="back d-flex justify-content-center flex-column align-items-center"
                    style="">
                    <a href="{{route('commands.index')}}" style="color: #fff">
                        <h2 class="card-text">قائمة أوامر الحركة </h2>
                    </a>

                </div>
            </div>
        </div>
    </div>
    @endcan
    @can('index',\App\Models\Driver::class)

    <div class="col-md-2 col-sm-1 col-lg-4">
        <div class=" flip-container">
            <div class="flipper">
                <div class="front  flex-column">
                    <i class="fe fe-users fe-16"></i>

                    <h1>السائقين</h1>
                    <h1>{{ \App\Models\Driver::count() }}</h1>

                </div>
                <div class="back d-flex justify-content-center flex-column align-items-center"
                    style="">
                    <a href="{{route('drivers.index')}}" style="color: #fff">
                        <h2 class="card-text">قائمة السائقين </h2>
                    </a>
                    <a href="{{route('drivers.create')}}" style="color:#fff">
                        <h2 class="card-text">بطاقة سائق</h2>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @endcan



</div>

<div class="row d-flex justify-content-center align-items-center" style="">
    @can('index',\App\Models\Escort::class)

    <div class="col-md-2 col-sm-1 col-lg-4">
        <div class=" flip-container">
            <div class="flipper">
                <div class="front  flex-column">
                    <i class="fe fe-users fe-16"></i>

                    <h1>المرافقين</h1>
                    <h1>{{ \App\Models\Escort::count() }}</h1>

                </div>
                <div class="back d-flex justify-content-center flex-column align-items-center"
                    style="">
                    <a href="{{route('escorts.index')}}" style="color: #fff">
                        <h2 class="card-text">قائمة المرافقين </h2>
                    </a>
                    <a href="{{route('escorts.create')}}" style="color:#fff">
                        <h2 class="card-text">بطاقة مرافق</h2>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endcan
    @can('index',\App\Models\User::class)

    <div class="col-md-2 col-sm-1 col-lg-4">
        <div class=" flip-container">
            <div class="flipper">
                <div class="front  flex-column">
                    <i class="fe fe-users fe-16"></i>

               
                    <h1>المستخدمين</h1>
                    <h1>{{ \App\Models\User::count() }}</h1>

                </div>
                <div class="back d-flex justify-content-center flex-column align-items-center"
                    style="">
                    <a href="{{route('users.index')}}" style="color: #fff">
                        <h2 class="card-text">قائمة المستخدمين </h2>
                    </a>
                    <a href="{{route('users.create')}}" style="color:#fff">
                        <h2 class="card-text">بطاقة مستخدم</h2>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endcan
    @if(auth()->user()->can('index',\App\Models\MaintenanceRequest::class) ||
    auth()->user()->can('index',\App\Models\MaintenanceTypes::class) ||
    auth()->user()->can('index',\App\Models\Product::class) )

    <div class="col-md-2 col-sm-1 col-lg-4">
        <div class=" flip-container">
            <div class="flipper">
                <div class="front  flex-column">
                    <i class="fe fe-package fe-16"></i>

                    <h1 >الصيانة</h1>
                </div>
                <div class="back d-flex justify-content-center flex-column align-items-center"
                    style="">
                    <a href="{{route('maintenance_orders.index')}}" style="color: #fff">
                        <h2 class="card-text">طلبات الصيانة :{{ \App\Models\MaintenanceRequest::count() }}</h2>

                    </a>
                    <a href="{{route('maintenance.create')}}" style="color:#fff">
                        <h2 class="card-text">أنواع الصيانة :{{ \App\Models\MaintenanceTypes::count() }}</h2>
                    </a>
                    <a href="{{route('products.create')}}" style="color:#fff">
                        <h2 class="card-text">مواد الصيانة :{{ \App\Models\Product::count() }}</h2>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

<div class="row d-flex justify-content-center align-items-center" style="">
    @can('index',\App\Models\Supplier::class)
    <div class="col-md-2 col-sm-1 col-lg-4">
        <div class=" flip-container">
            <div class="flipper">
                
                <div class="front  flex-column">
                    <i class="fa-solid fa-parachute-box"></i>

                    <h1>المورّدين</h1>
                    <h1>{{ App\Models\Supplier::count() }}</h1>
                </div>
                <div class="back d-flex justify-content-center flex-column align-items-center"
                    style="">
                    <a href="{{route('suppliers.index')}}" style="color: #fff">
                        <h2 class="card-text">قائمة المورّدين </h2>
                    </a>

                </div>
            </div>
        </div>
    </div>
    @endcan

    <div class="col-md-2 col-sm-1 col-lg-4">
        <div class=" flip-container">
            <div class="flipper">
                <div class="front  flex-column">
                    <i class="fe fe-package fe-16"></i>

                    <h1>الطلبات</h1>
                </div>
                <div class="back d-flex justify-content-center flex-column align-items-center"
                    style="">
                    <a href="" style="color: #fff">
                        <h2 class="card-text">قائمة الطلبات :</h2>
                    </a>
                    <a href="{{ route('purchase_requests.index') }}" style="color: #fff">
                        <h2 class="card-text">طلب شراء :</h2>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-2 col-sm-1 col-lg-4">
        <div class=" flip-container">
            <div class="flipper">
                <div class="front  flex-column">
                    <i class="fe fe-plus-square fe-16"></i>

                    <h1>تعبئة وقود </h1>
                    <h1> {{\App\Models\FuelRequest::count() }}</h1>

                </div>
                <div class="back d-flex justify-content-center flex-column align-items-center"
                    style="">
                    <a href="{{ route('fuel_requests.index') }}" style="color: #fff">
                        <h2 class="card-text">تعبئة وقود </h2>
                    </a>

                </div>
            </div>
        </div>
    </div>



</div>

<div class="col-md-2 col-sm-1 col-lg-4">
    <div class=" flip-container">
        <div class="flipper">
            <div class="front  flex-column">
                <i class="fe fe-flag fe-16"></i>

                <h1>التقارير</h1>
            </div>
            <div class="back d-flex justify-content-center flex-column align-items-center"
                style="">
                <a href="" style="color: #fff">
                    <h2 class="card-text">تقرير إجمالي المركبات :</h2>
                </a>
                <a href="" style="color: #fff">
                    <h2 class="card-text">تقرير صيانة :</h2>
                </a>
                <a href="" style="color: #fff">
                    <h2 class="card-text">تقرير طلبات الشراء :</h2>
                </a>
                <a href="" style="color: #fff">
                    <h2 class="card-text">تقرير حركة مركبة :</h2>
                </a>
            </div>
        </div>
    </div>
</div>