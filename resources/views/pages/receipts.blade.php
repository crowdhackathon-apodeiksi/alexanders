@extends('pages.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">{{$page_title or 'Οι αποδείξεις μου.'}}</div>

                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="receipts-table"
                                   class="table table-striped table-bordered table-hover dataTable no-footer">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ΑΦΜ</th>
                                    <th>Αύξων Αριθμός</th>
                                    <th>Επωνυμία</th>
                                    <th>Ποσό</th>
                                    <th>Κατηγορίες</th>
                                    <th>Ημερομηνία Έκδοσης</th>
                                    <th>Ημερομηνία Καταχώρησης</th>
                                    <th>Φωτογραφία</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($receipts as $receipt)
                                    <tr>
                                        <td>{{$receipt->id}}</td>
                                        <td>{{$receipt->afm}}</td>
                                        <td>{{$receipt->aa}}</td>
                                        <td>{{$receipt->eponimia}}</td>
                                        <td>{{$receipt->poso}}</td>
                                        <td>
                                            @foreach($receipt->categories as $category)
                                                <a class="btn btn-warning" type="button" href="{{URL::route('category.browse', [$category->id])}}">
                                                    {{$category->name}}
                                                </a>
                                            @endforeach
                                        </td>
                                        <td>{{$receipt->printed_at}}</td>
                                        <td>{{$receipt->created_at}}</td>
                                        <td><img src="{{$receipt->image or '/images/noimage.jpg'}}" class="img-rounded" height="160px"/></td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                        <?php echo $receipts->render() ?>
                    </div>
                    <!-- /.panel-body -->
                </div>
            </div>
        </div>
    </div>
@endsection
