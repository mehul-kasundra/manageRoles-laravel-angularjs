@extends('layout/template')

@section('content')
<link href="{{ asset('css/customStyle.css') }}" rel="stylesheet">
<script src="{{ asset('js/manageRoleController.js') }}"></script>
<h1>Manage Roles</h1>

	@if(Session::has('error'))
		<div class="alert alert-danger">
		{{Session::get('error')}}
		</div>
	@endif

	@if(Session::has('success'))
		<div class="alert alert-success">
		{{Session::get('success')}}
		</div>
	@endif
	
<a href="{{url('/manageRoles/create')}}" class="btn btn-success">Create</a>
<div id="app_url" style="display:none"><?php echo asset('/');?></div>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div ng-controller="manageRoleController">
<table class="table table-striped table-bordered table-hover" style="margin-top:15px;">
	<tr>
		<thead>
			<th>#</th>
			<th>Departments</th>
			<th>Sellers</th>
		</thead>
	</tr>	<tr ng-if="departmentSellerDetails.length == 0">	<td colspan="3">No department seller found.</td>	</tr>
<tr ng-repeat="departmentDetail in departmentSellerDetails | pagination: curPage * pageSize | limitTo: pageSize" ng-if="departmentSellerDetails.length > 0">	<td><% departmentDetail.counter %></td>	<td><% departmentDetail.departmentName %></td>	<td>		<div class="sellerTotal" ng-repeat="singleSeller in departmentDetail.sellerDetails" ng-if="departmentDetail.sellerDetails.length > 0"><span id="sellerStyle"><% singleSeller.sellerName %></span><a href="javascript:void(0)" ng-click="deleteDepartmentSeller(departmentDetail.departmentId,singleSeller.sellerId,singleSeller.departmentSellerId)" class="btn btn-danger deleteButton">X</a>		</div>	</td>	</tr>	
</table>





<div   class="paginationclass" ng-show="departmentSellerDetails.length">
<ul class="pagination pull-right manageRolePagination">
 <li>
  <button type="button" ng-disabled="curPage == 0"
 ng-click="curPage=curPage-1" class="btn btn-default"><</button>
 </li>
 <li class="pageNumbering">
 <span>Page <%curPage + 1 %> of <% numberOfPages()  %></span>
 </li>
 <li>
 <button type="button"
 ng-disabled="curPage >= departmentSellerDetails.length/pageSize - 1"
 ng-click="curPage = curPage+1"  class="btn btn-default">></button>
 </li>
</ul>

</div>

@stop