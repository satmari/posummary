@extends('app')

@section('content')
<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center">
            <div class="panel panel-default">
				<div class="panel-heading">Checking Table</div>
				
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
    	                        <th><big><span style="color:red">PLO</span></big></th>
                                <th><small><span style="color:red">Material</span></small></th>
                                <th><small><span style="color:red">Color</span></small></th>
                                <th><small><span style="color:red">Segment</span></small></th>
                                
                                <th><small><span style="color:red">Qty</span></small></th>
                                {{-- <th><small><span style="color:red">Start date</span></small></th> --}}
    	                        
                                <th><small><span style="color:red"><i>Bom</i></span></small></th>
                                <th><small><span style="color:red"><i>Routing</i></span></small></th>
                                <th><small><span style="color:red"><i>Prod Ver</i></span></small></th>

                                <th><big><span style="color:blue">PRO</span></big></th>

                                <th><small><span style="color:blue"><i>Ex Cost</i></span></small></th>
                                <th><small><span style="color:blue"><i>Pref. Origin</i></span></small></th>
                                <th><small><span style="color:blue"><i>Released</i></span></small></th>
                                <th><small><span style="color:blue"><i>Sent to Int.</i></span></small></th>

                            </tr>
                        </thead>
                        <tbody class="searchable">
    			        @foreach ($data as $req)
                            <tr>
                                {{--<td>{{ $req->id }}</td>--}}
                                <td><b>{{ $req->plo }}</b></td>
                                <td></pre>{{ $req->sku }}</pre></td>
                                <td>{{ $req->color_desc }}</td>
                                <td>{{ $req->segment }}</td>
                                
                                <td>{{ $req->qty }}</td>
                                {{--<td>{{ substr($req->delivery_date_orig,0,11) }}</td> --}}
                                
                                @if ($req->bom == 'YES')  <td> <div class="yes">{{ $req->bom }}</div></td>  @else <td><div class="no">{{ $req->bom }}</div></td> @endif
                                @if ($req->routing == 'YES')  <td> <div class="yes">{{ $req->routing }}</div></td>  @else <td><div class="no">{{ $req->routing }}</div></td> @endif
                                @if ($req->prod_version == 'YES')  <td> <div class="yes">{{ $req->prod_version }}</div></td>  @else <td><div class="no">{{ $req->prod_version }}</div></td> @endif

                                <td><b>{{ $req->pro }}</b></td>

                                @if ($req->ec_cost == 'YES')  <td> <div class="yes">{{ $req->ec_cost }}</div></td>  @else <td><div class="no">{{ $req->ec_cost }}</div></td> @endif
                                @if ($req->pref_origin == 'PREF')  <td> <div class="yes">{{ $req->pref_origin }}</div></td>  @else <td><div class="no">{{ $req->pref_origin }}</div></td> @endif
                                @if ($req->release == 'YES')  <td> <div class="yes">{{ $req->release }}</div></td>  @else <td><div class="no">{{ $req->release }}</div></td> @endif
                                @if ($req->sent_to_inteos == 'YES')  <td> <div class="yes">{{ $req->sent_to_inteos }}</div></td>  @else <td><div class="no">{{ $req->sent_to_inteos }}</div></td> @endif
                                
                            </tr>
                        @endforeach
                        
                        </tbody>
                </table>
			 </div>
		</div>
	</div>
</div>
@endsection