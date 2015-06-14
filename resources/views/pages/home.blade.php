@extends('pages.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">Το Top μαγαζί της ημέρας κοντά στην περιοχή σου</div>

                    <div class="panel-body" style="text-align: center;">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> {{$errors->first()}}
                            </div>
                        @endif
                        <img src="/images/glamour.jpg" class="img-responsive img-thumbnail" width="400px"/>
                        <h3>Καφέ μπαρ Glamour, με 75 αποδείξεις μέχρι στιγμής.</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
