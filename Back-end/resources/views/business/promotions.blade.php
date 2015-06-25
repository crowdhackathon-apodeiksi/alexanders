@extends('business.layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{$page_title or 'Οι προσφορές της επιχείρησης μου.'}}</div>

                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="receipts-table"
                                   class="table table-striped table-bordered table-hover dataTable no-footer">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Τίτλος</th>
                                    <th>Τύπος Προσφοράς</th>
                                    <th>Απαιτούμενος Αριθμός Αποδείξεων</th>
                                    <th>Απαιτούμενο Ποσό</th>
                                    <th>Ημερομηνία Δημιουργίας</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($promotions as $promo)
                                    <tr>
                                        <td>{{$promo->id}}</td>
                                        <td>{{$promo->title}}</td>
                                        <td>{{$promo->type}}</td>
                                        <td>{{$promo->receipts_count}}</td>
                                        <td>{{$promo->money_count}}</td>
                                        <td>{{$promo->created_at}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                        <?php
                        if ($promotions instanceof Illuminate\Pagination\LengthAwarePaginator)
                        {
                            echo $promotions->render();
                        }
                        ?>
                    </div>
                    <!-- /.panel-body -->
                </div>
            </div>
        </div>
    </div>
@endsection
