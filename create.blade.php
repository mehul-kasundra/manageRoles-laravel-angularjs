@extends('layout/template')@section('content')
<script src="{{ url('js/manageRoleController.js') }}">
</script>	
<h1>Create Role</h1>		
@if($errors->any())		
	<div class="alert alert-danger">			
		@foreach($errors->all() as $error)							
		<p>{{ $error }}</p>			
		@endforeach		
	</div>	
@endif		
@if(Session::has('error'))	
	<div class="alert alert-danger">	
	{{Session::get('error')}}	
	</div>	
	@endif	@if(Session::has('success'))		
		<div class="alert alert-success">		
		{{Session::get('success')}}		
		</div>	
		@endif		
		{!! Form::open(array('url'=>'manageRoles','method'=>'POST','id'=>'roleFormSubmission','ng-controller'=>'manageRoleController')) !!}				
		<div class="form-group">	
		{!! Form::label('department','Department') !!}	
		<div>		
		{!! Form::select('departmentId',$departmentList,null,['class'=>'form-control departmentId', 'id'=>'departmentId','ng-change'=>'getExistingSellers()','ng-model'=>"dropValue"]) !!}		
		</div>	
		</div>							
		<div class="form-group">				
		{!! Form::label('SELLER', 'Sellers:') !!}		
		<div>				
		<label class="checkbox-inline" ng-repeat="singleSeller in sellersList" ng-if="sellersList.length > 0">
		{!! Form::checkbox('sellerId[]', "<% singleSeller.id %>", NULL, ['class' => 'sellerId','ng-checked'=>'singleSeller.status','ng-disabled'=>'singleSeller.disabled']) !!}	
		<% singleSeller.name %></label>		
		</div>	
		</div>	
		{!! Form::hidden('appUrl',asset('/'),['id'=>'appUrl']) !!}											
		<div class="form-group">	
		{!! Form::submit('Save',['class'=>'btn btn-primary form-control', 'id'=>'roleSubmit']) !!}	
		</div>	
		{!! Form::close() !!}		
@stop