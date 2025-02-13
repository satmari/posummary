@extends('app')

@section('content')
<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center">
            <div class="panel panel-default">
				<div class="panel-heading"><span style="color:blue"><big>PRO Table</big></span>
                &nbsp;&nbsp;
				<a href="{{url('/pro_all')}}" class="btn  btn-warning">Full table</a>
                &nbsp;&nbsp;&nbsp;&nbsp;

                @if (Auth::check() && Auth::user()->level() != 3)
									
						<a href="{{url('/update_pro')}}" class="btn btn-default btn-info">Update PRO from FR</a>
                        
                        <!-- <a href="{{url('/update_pro_inteos')}}" class="btn btn-default btn-default" disabled>Insert PRO from Inteos</a> -->
                        <a href="{{url('/update_pro_from_inteos')}}" class="btn btn-default btn-default" >Update PRO from Inteos</a>
                        <a href="{{url('/update_destination')}}" class="btn btn-default btn-default" >Update Location</a>
				               
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
                            <!--<tr>
                                
                                <th colspan="3"><span style="color:blue">FastReact</span></th>
                                <th colspan="1"><span style="color:#a900ff">SAP Coois</span></th>
                                <th colspan="6"><span style="color:#00dcff">Inteos</span></th>
                                <th colspan="3"><span style="color:blue">FastReact</span></th>
                                <th colspan="6"><span style>Manual or import</span></th>
                                
                                <th><small></small></th>
                                <th><small></small></th>
                                <th><small></small></th>
                                <th><small></small></th>
                            </tr>
                        	<tr>-->
                                <!-- <td>Id</td> -->
                                <th><span style="color:blue">PRO</span></th>
                                <th><span style="color:blue">Material</span></th>
                                <th><span style="color:blue">Color</span></th>
                                <th><span style="color:#a900ff">Location</span></th>
                                
                                <th><span style="color:#00dcff">Segment</span></th>
                                <th><span style="color:#00dcff">Brand</span></th>
                                
                                <th><span style="color:#00dcff">Approval</span></th>
                                <th><span style="color:#00dcff">Eur1</span></th>
                                <th><span style="color:#00dcff">Status Inteos</span></th>
                                <th><span style="color:blue">Qty</span></th>
                                <th><span style="color:pink">Del date</span></th>
                                <th><span style="color:pink">Target date</span></th>
                                <!-- <th><span style="color:blue">Start date</span></th> -->

                                <th><span style>Type</span></th>
                               
                                <!-- <th><span style>Ex Cost</span></th> -->
                                <!-- <th><span style>Pref. Origin</span></th> -->
                                <!-- <th><span style>Released</span></th> -->
                                <!-- <th><span style>Sent to Int.</span></th> -->
                                
                                <th><span style>TPP ship.</span></th>
                                <th><span style>TPP wastage</span></th>

                                <th><span style="color:pink">PDM file</span></th>
                                <th><span style="color:pink">Skeda</span></th>
                                <th><span style="color:pink">Skeda Status</span></th>
                                <th><span style="color:pink">No of Lines</span></th>
                                
                                <th><small>Output</small></th>
                                <th><small>Strip </small></th>
                                <th><small>Coois</small></th>
                                <th><small>Other</small></th>
                            <!-- </tr> -->
                            
                        </thead>
                        <tbody class="searchable">
    			        @foreach ($data as $req)
                            <tr>
                                {{--<td>{{ $req->id }}</td>--}}
                                <td><span style="font-size: 15px;">{{ $req->pro }}</span></td>
                                <td><span style="font-size: 10px;"><pre>{{ $req->sku }}</pre></span></td>
                                <td><span style="font-size: 5px;">{{ $req->color_desc }}</span></td>
                                <td><span style="font-size: 10px;">{{ $req->location_all }}</span></td>
                                
                                <td><span style="font-size: 10px;">{{ $req->segment }}</span></td>
                                <td><span style="font-size: 10px;">{{ $req->brand }}</span></td>
                                
                                <td><span style="font-size: 10px;">{{ $req->approval }}</span></td>
                                <td><span style="font-size: 10px;">{{ $req->eur1 }}</span></td>
                                <td><span style="font-size: 10px;">{{ $req->status_int }}</span></td>
                                <td><span style="font-size: 15px;">{{ $req->qty }}</span></td>
                                <td><span style="font-size: 10px;">{{ substr($req->delivery_date,0,11) }}</span></td>
                                <td><span style="font-size: 10px;">{{ substr($req->target_date,0,11) }}</span></td>
                                
                                <td><span style="font-size: 8px;">{{ $req->flash_type }}</span></td>
                                
                                <td><span style="font-size: 8px;">{{ $req->tpp_shipments }}</span></td>
                                <td><span style="font-size: 8px;">{{ $req->tpp_wastage }}</span></td>

                                <td><span style="font-size: 8px;">{{ $req->pdm }}</span></td>
                                <td><span style="font-size: 8px;">{{ $req->skeda }}</span></td>
                                <td><span style="font-size: 8px;">{{ $req->skeda_status }}</span></td>
                                <td><span style="font-size: 8px;">{{ $req->no_lines_by_skeda }}</span></td>
                                
                                <td><a href="{{ url('/pro/conf/'.$req->id) }}" class="btn btn-primary btn-xs center-block">Conf</a></td>
                                <td><a href="{{ url('/pro/strip/'.$req->id) }}" class="btn btn-info btn-xs center-block">Strip</a></td>
                                <td><a href="{{ url('/pro/coois/'.$req->id) }}" class="btn btn-success btn-xs center-block">Coois</a></td>

                                @if (Auth::check() && Auth::user()->level() != 3)
                                    
                                    <td><a href="{{ url('/pro/edit/'.$req->id) }}" class="btn btn-warning btn-xs center-block">Edit</a></td>
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