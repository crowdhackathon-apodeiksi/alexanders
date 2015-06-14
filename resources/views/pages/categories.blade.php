@extends('pages.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">{{$page_title or 'Οι κατηγορίες μου.'}}</div>

                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="receipts-table"
                                   class="table table-striped table-bordered table-hover dataTable no-footer">
                                <thead>
                                <tr>
                                    <th>Κατηγορία</th>
                                    <th>Αριθμός Αποδείξεων</th>
                                    <th>Προβολή Αποδείξεων</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td><strong>{{$category->name}}</strong></td>
                                        <td>{{$category->receipts->count()}}</td>
                                        <td><a class="btn btn-primary" href="{{URL::route('category.browse', [$category->id])}}">Περιήγηση</a> </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.panel-body -->
                    <?php echo $categories->render() ?>
                </div>
            </div>
        </div>
    </div>
@endsection
