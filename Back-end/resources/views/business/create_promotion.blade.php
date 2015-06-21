@extends('business.layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{$page_title or 'Δημιουργία προσφοράς.'}}</div>

                    <div class="panel-body">
                        {!! Form::open(['route'=>'api.promotions.store']) !!}
                        <div class="form-group">
                            {!! Form::label('type', 'Τύπος προσφοράς:') !!}
                            {!! Form::select('type', array('Προσφορά' => 'Προσφορά', 'Κλήρωση' => 'Κλήρωση', 'Δώρο' => 'Δώρο' ), 'Προσφορά', array('class'=>'form-control')) !!}
                        </div>
                        <!-- Τίτλος Προσφοράς Form Input -->
                        <div class="form-group">
                            {!! Form::label('Τίτλος Προσφοράς', 'Τίτλος Προσφοράς:') !!}
                            {!! Form::text('title', null, array('class'=>'form-control')) !!}
                        </div>
                        <!-- Περιγραφή Form Input -->
                        <div class="form-group">
                            {!! Form::label('Περιγραφή', 'Περιγραφή:') !!}
                            {!! Form::text('description', null, array('class'=>'form-control')) !!}
                        </div>
                        <!-- Απαιτούμενος Αριθμός Αποδείξεων Form Input -->
                        <div class="form-group">
                            {!! Form::label('Απαιτούμενος Αριθμός Αποδείξεων', 'Απαιτούμενος Αριθμός Αποδείξεων:') !!}
                            {!! Form::text('receipts_count', null, array('class'=>'form-control')) !!}
                        </div>
                        <!-- Απαιτούμενο Ποσό Form Input -->
                        <div class="form-group">
                            {!! Form::label('Απαιτούμενο Ποσό', 'Απαιτούμενος Αριθμός Αποδείξεων:') !!}
                            {!! Form::text('money_count', null, array('class'=>'form-control')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Υποβολή', array('class'=>'btn btn-primary btn-lg btn-block'))!!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
