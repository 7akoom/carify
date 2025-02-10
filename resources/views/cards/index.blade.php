@extends('layouts.app')
@section('content')


<div class="row">
    <div class="col">
        <h2 class="mb-2 page-title">قائمة بطاقات التسليم</h2>
    </div>
    
    <div class="col ml-auto">
        <div class="dropdown float-right">
            <a id="bulkDeleteBtn" href="{{ route('trucks.bulk-delete') }}" class="btn rounded-btn btn-danger ml-auto">حذف المحدد</a>
            <button class="btn rounded-btn btn-secondary dropdown-toggle" type="button" id="actionMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> المزيد </button>
            <div class="dropdown-menu" aria-labelledby="actionMenuButton">
                <a class="dropdown-item more" href=""><i class="fa fa-download mr-2"></i>تصدير</a>
                <a class="dropdown-item more" href="#"><i class="fa-solid fa-file-import mr-2"></i>استيراد</a>
            </div>
        </div>
    </div>
</div>

<div class="col-12">
    <div class="row my-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-container">
                        <div id="table-container"></div>

                        @if(session('success'))
                        <div class="alert alert-success" id="success">{{ session('success') }}</div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger" id='danger'>{{ session('error') }}</div>
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
                                    <th><input type="checkbox"  class="checkbox"  id='check_all'/></th>
                                    <th>#</th>
                                    <th>النوع</th>
                                    <th>رقم اللوحة</th>
                                    <th>السائق</th>
                                    <th>تاريخ الاستلام</th>
                                    <th>تاريخ التسليم</th>
                                    <th>اللون</th>
                                    <th>عدد الركاب</th>
                                    <th>الحمولة</th>
                                    <th>رقم العداد</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cards as $card)
                                    <tr>
                                        <td><input type="checkbox" name="ids[]" value="{{ $card->id }}" id="check"/></td>
                                        <td>{{$card->id}}</td>
                                        <td>{{$card->truck->type}}</td>
                                        <td>{{$card->truck->plate_number}}</td>
                                        <td>
                                            @if($card->driver)
                                                {{ $card->driver->first_name }} {{ $card->driver->last_name }}
                                            @else
                                                <span>غير متوفر</span> <!-- "Not available" in Arabic -->
                                            @endif
                                        </td>
                                        <td>{{$card->receipt_date}}</td>
                                        <td>{{$card->deliver_date}}</td>
                                        <td>{{$card->truck->color}}</td>
                                        <td>{{$card->truck->passengers_number}}</td>
                                        <td>{{$card->truck->load}}</td>
                                        <td>{{$card->truck->kilometer_number}}</td>
                                        <td>
                                            <a id="modal" type="button" data-toggle="modal" title="عرض" data-target="#exampleModal" href="{{route('cards.show',$card->id)}}" class="btn btn-success btn-sm">
                                                <i class="fa fa-eye"></i>
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
</div>

@endsection
