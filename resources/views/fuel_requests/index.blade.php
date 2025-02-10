@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col">
        <h2 class="mb-2 page-title">طلبات تعبئة الوقود</h2>
    </div>
    
    <div class="col ml-auto">
        <div class="dropdown float-right">
    
            <a href="{{route('fuel_requests.create')}}" class="btn rounded-btn btn-primary" id="create">+ أمر تعبئة</a>
    
            <a id="bulkDeleteBtn" href="{{route('fuel_requests.bulk-delete')}}" class="btn rounded-btn btn-danger ml-auto">
                حذف المحدد
            </a>
            <button class="btn rounded-btn btn-secondary dropdown-toggle" type="button" id="actionMenuButton"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> المزيد </button>
            <div class="dropdown-menu" aria-labelledby="actionMenuButton">
                <a class="dropdown-item more" href=""><i class="fa fa-download mr-2"></i>تصدير</a>
                <a class="dropdown-item more" href="" data-toggle="modal" data-target="#exampleModal" id="modal"><i class="fa-solid fa-file-import mr-2" ></i>استيراد</a>
            </div>
        </div>
    </div>
</div>

<div class="col-12">
    <div class="row my-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body">
                    <div id="table-container"></div>
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

                    

                    <table class="table datatables" id="dataTable-1">
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="checkbox" id='check_all' /></th>
                                <th>#</th>
                                <th>الرقم</th>
                                <th>التاريخ</th>
                                <th>رقم السيارة</th>
                                <th>السائق</th>
                                <th>الكمية</th>
                                <th>المسافة المقطوعة</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($filling as $fill)
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="{{$fill->id}}" id="check" /></td>

                                <td>{{$fill->id}}</td>
                                <td>{{$fill->number}}</td>
                                <td>{{$fill->date}}</td>
                                <td>{{$fill->truck->plate_number}}</td>
                                <td>{{$fill->driver->first_name.' '.$fill->driver->last_name}}</td>
                                <td>{{$fill->amount}}</td>
                                <td>{{$fill->distance}}</td>
                                
                                <td>
                                    <a id="modal" type="button" data-toggle="modal" title="تعديل" data-target="#exampleModal" href="{{ route('fuel_requests.edit',$fill->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-edit"></i> 
                                        </a>

                                    <a href="{{ route('fuel_requests.delete',$fill->id) }}"  title="حذف"id="destroy"
                                        class="btn btn-danger btn-sm delete-driver" data-id="">
                                        <i class="fa fa-trash"></i> 
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection