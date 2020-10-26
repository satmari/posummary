@extends('app')

@section('content')
<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center">
            <div class="panel panel-default">
				<div class="panel-heading">PLO Table
				
                @if (Auth::check() && Auth::user()->level() != 3)
									
						<a href="{{url('/update_plo')}}" class="btn btn-default btn-info">Update PLO table</a>
				               
                @endif
                </div>
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
    	                        <th><span style="color:red">PLO</span></th>
                                <th><span style="color:red">Material</span></th>
                                <th><span style="color:red">Color</span></th>
                                <th><span style="color:red">Segment</span></th>
                                
                                <th><span style="color:red">Qty</span></th>
                                <th><span style="color:red">Del Date</span></th>
    	                        <th><span style="color:red">Del Date O</span></th>
    	                        

                                <th>Bom</th>
                                <th>Routing</th>
                                <th>Prod Ver</th>
                                
                                <th></th>
                            </tr>
                            <!-- <tr>
                                <th colspan="7"><span style="color:red">FastReact</span></th>
                                <th colspan="3">Manual or import</th>
                                <th></th>

                            </tr> -->
                        </thead>
                        <tbody class="searchable">
    			        @foreach ($data as $req)
                            <tr>
                                {{--<td>{{ $req->id }}</td>--}}
                                <td>{{ $req->plo }}</td>
                                <td>{{ $req->material }}</td>
                                <td>{{ $req->color_desc }}</td>
                                
                                <td>{{ $req->segment }}</td>
                                
                                <td>{{ $req->qty }}</td>
                                <td>{{ substr($req->delivery_date,0,11) }}</td>
                                <td>{{ substr($req->delivery_date_orig,0,11) }}</td>
                                
                                <td>{{ $req->bom }}</td>
                                <td>{{ $req->routing }}</td>
                                <td>{{ $req->prod_version }}</td>

                                @if (Auth::check() && Auth::user()->level() != 3)
                                    <td><a href="{{ url('/plo/edit/'.$req->id) }}" class="btn btn-warning btn-xs center-block">Edit</a></td>
                                @endif

                            </tr>
                        @endforeach
                        
                        </tbody>
                </table>
			 </div>
		</div>
	</div>
</div>
@endsection