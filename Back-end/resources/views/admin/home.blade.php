@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">{{$page_title or 'Καλως όρισες, διαχειριστή.'}}</div>

                    <div class="panel-body">
                        <a href="{{ URL::route('admin.receipts') }}" class="btn btn-primary btn-block"> Διαχείριση Αποδείξεων</a>
                        <a href="{{ URL::route('admin.receipts') }}" class="btn btn-info btn-block"> Διαχείριση Προσφορών</a>
                        <a href="{{ URL::route('admin.categories') }}" class="btn btn-default btn-block"> Διαχείριση Κατηγοριών</a>
                    </div>



                </div>
            </div>
        </div>
    </div>
@stop