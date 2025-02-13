@extends('app')

@section('content')
<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center">
            <div class="panel panel-default">
				<div class="panel-heading"><span style="color:blue"><big>Daily plan Table (all)</big></span>
                &nbsp;&nbsp;
				<a href="{{url('/daily_plan')}}" class="btn  btn-warning">Today table</a>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <a href="{{url('/import_daily_plan')}}" class="btn  btn-danger">Import</a>
                &nbsp;&nbsp;&nbsp;&nbsp;


                </div>
				<div class="input-group"> <span class="input-group-addon">Filter</span>
                    <input id="filter" type="text" class="form-control" placeholder="Type here...">
                </div>
                
                <table class="table table-striped table-bordered" id="sort" 
                 data-show-export="true"
                    data-export-types="['excel']"
                 
                >
                    <!--
                    data-show-export="true"
                    data-export-types="['excel']"
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
                            
                                <!-- <td>Id</td> -->
                                <th><span style="color:blue">date</span></th>
                                <th><span style="color:blue">module</span></th>
                                <th><span style="color:blue">pro</span></th>
                                <th><span style="color:blue">style</span></th>
                                <th><span style="color:blue">qty</span></th>
                              
                        </thead>
                        <tbody class="searchable">
    			        @foreach ($data as $req)
                            <tr>
                                
                                <td><span style="font-s ize: 10px;">{{ $req->date }}</span></td>
                                <td><span style="font-s ize: 10px;">{{ $req->module }}</span></td>
                                <td><span style="font-s ize: 10px;">{{ $req->pro }}</span></td>
                                <td><span style="font-s ize: 15px;">{{ $req->style }}</span></td>
                                <td><span style="font-s ize: 15px;">{{ $req->qty }}</span></td>
                               
                            </tr>
                        @endforeach
                        
                        </tbody>
                </table>
			 </div>
		</div>
	</div>
</div>
@endsection