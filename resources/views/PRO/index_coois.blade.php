@extends('app')

@section('content')
<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center">
            <div class="panel panel-default">
				<div class="panel-heading">PRO Coois Table</div>
				
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
    	                        <th>PRO</th>
                              <th>FG Material</th>
                              <th>WC</th>
                              <th>Activity</th>
                              <th>Material</th>
                              <th>Desc</th>
                              <th>Uom</th>
                              <th>St. Qty</th>
    	                          
    	                        
                            </tr>
                        </thead>
                        <tbody class="searchable">
    			             @foreach ($data as $req)
                            <tr>
                                {{--<td>{{ $req->id }}</td>--}}
                                <td>{{ $req->po }}</td>
                                <td></pre>{{ $req->fg }}</pre></td>
                                <td>{{ $req->wc }}</td>
                                <td>{{ $req->activity }}</td>
                                <td>{{ $req->material }}</td>
                                <td>{{ $req->description }}</td>
                                <td>{{ $req->uom }}</td>
                                <td>{{ $req->standard_qty }}</td>
                              
                            </tr>
                        @endforeach
                        
                        </tbody>
                </table>
			 </div>
		</div>
	</div>
</div>
@endsection