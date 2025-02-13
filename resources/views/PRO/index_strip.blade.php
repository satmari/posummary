@extends('app')

@section('content')
<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center">
            <div class="panel panel-default">
				<div class="panel-heading">PRO Strip Table</div>
				
              	<div class="input-group"> <span class="input-group-addon">Filter</span>
                    <input id="filter" type="text" class="form-control" placeholder="Type here...">
                </div>
                
                <table class="table table-striped table-bordered" id="sort" 
                 data-show-export="true"
                 data-export-types="['excel']"
                 
                >
                    <!--
                    data-search="true"
                    data-show-refresh="true"
                    data-show-toggle="true"
                    data-query-params="queryParams" 
                    data-pagination="true"
                    data-height="300"
                    data-show-columns="true" 
                    data-export-options='{
                             "fileName": "preparation_app", 
                             "worksheetName": "test1",         
                             "jspdf": {                  
                               "autotable": {
                                 "styles": { "rowHeight": 20, "fontSize": 10 },
                                 "headerStyles": { "fillColor": 255, "textColor": 0 },
                                 "alternateRowStyles": { "fillColor": [60, 69, 79], "textColor": 255 }
                               }
                             }
                           }'
                    -->
                        <thead>
                        	<tr>
    	                        <!-- <td>Id</td> -->
    	                        <th>PRO FR</th>
                                <th>Material</th>
                                <th>Segment</th>
                                <th>Tot Qty</th>
                                <th>Line</th>
                                <th>Line G.</th>
                                <th>Strip Start</th>
                                <th>Strip End</th>
    	                          <th>Qty Plan</th>
                                <th>Qty Made</th>
                                
    	                        
                            </tr>
                        </thead>
                        <tbody class="searchable">
    			        @foreach ($data as $req)
                            <tr>
                                {{--<td>{{ $req->id }}</td>--}}
                                <td>{{ $req->pro_fr }}</td>
                                <td></pre>{{ $req->material }}</pre></td>
                                <td>{{ $req->segment }}</td>
                                <td>{{ $req->qty }}</td>
                                <td>{{ substr($req->line,3) }}</td>
                                <td>{{ $req->line_group }}</td>
                                <td>{{ $req->s_start }}</td>
                                <td>{{ $req->s_end }}</td>
                                <td>{{ $req->qty_plan }}</td>
                                <td>{{ $req->qty_made }}</td>


                            </tr>
                        @endforeach
                        
                        </tbody>
                </table>
			 </div>
		</div>
	</div>
</div>
@endsection