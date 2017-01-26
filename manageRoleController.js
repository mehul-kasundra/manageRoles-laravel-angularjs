 myApp.filter('pagination', function () {
            return function (input, start) {
				 if (!input || !input.length) { return; }
                start = +start;
                return input.slice(start);
            };
        });

myApp.controller('manageRoleController',function($scope,$http){
	
	var splittedUrl=location.pathname.split("/"); 
	var pageUrl=splittedUrl[splittedUrl.length-1];
	$scope.departmentList=[];
	$scope.sellersList=[];
		// pagination
		$scope.curPage = 0;
		$scope.pageSize = 2;
	// ajax for manageRole index page
	if(pageUrl == "manageRoles")
	{
		
		
		var url="http://"+location.host+"/webplanex/public/manageRoles/listSelectedDepartmentSellers";	
		$http.post(url).success(function(output){
		if(output.success == '1')
		{
			$scope.departmentSellerDetails=output.sellerDetail;
			
			$scope.numberOfPages = function() 
			{
				
				
				return Math.ceil($scope.departmentSellerDetails.length / $scope.pageSize);
			};
		}
		});	

			


		
	}
	
	// ajax for manageRole create page
	if(pageUrl == "create")
	{
		
		var ajaxUrl="http://"+location.host+"/webplanex/public/manageRoles/listDepartmentSellers";
		$http.post(ajaxUrl).success(function(output){
			if(output.success == '1')
			{
				$scope.departmentList=output.departmentList;
				$scope.sellersList=output.sellersList;
				
			}
			else
			{
				if(output.success == '0')
				{
					$scope.departmentList=[];
					$scope.sellersList=[];
				}					
			}
		});		
	}
	 
	$scope.deleteDepartmentSeller=function(departmentId,sellerId,departmentSellerId){
		/* alert(departmentId+' '+sellerId+' '+departmentSellerId);
		return false; */
		var url="http://"+location.host+"/webplanex/public/manageRoles/deleteSeller";
		var data={departmentId:departmentId,sellerId:sellerId,departmentSellerId:departmentSellerId};
		if(!confirm('Seller will be deleted from assigned buyers also. Are you sure you want to delete this seller?'))
		{
			return false;
		}
		$http.post(url,data).success(function(output){
			if(output.success == '1')
			{
				angular.forEach($scope.departmentSellerDetails,function(departmentDetail){
					angular.forEach(departmentDetail.sellerDetails,function(sellerdetail){
						if(departmentDetail.departmentId == departmentId && sellerdetail.sellerId == sellerId)
						{
							if(departmentDetail.sellerDetails.length > 1)
							{
								
								departmentDetail.sellerDetails.splice(departmentDetail.sellerDetails.indexOf(sellerdetail),1);
							}
							else
							{
								
								$scope.departmentSellerDetails.splice($scope.departmentSellerDetails.indexOf(departmentDetail),1);
							}
							$scope.departmentSellerDetails;
						}
					});
				});
			}
			else
			{
				alert('failure');
			}

		});
	}
	
	$scope.getExistingSellers=function(){
		if($scope.dropValue == '')
		{
			return false;
		}
		else
		{
			// by default, checkboxes will be unchecked and disabled.
			 angular.forEach($scope.sellersList,function(singleSeller){
				singleSeller.status=0;
				singleSeller.disabled=0; 
			}); 
			var departmentId=$scope.dropValue;	
			var url="http://"+location.host+"/webplanex/public/manageRoles/getSellers";
			var data={departmentId:departmentId};
			$http.post(url,data).success(function(output){
				if(output.success == '1')
				{					
					angular.forEach($scope.sellersList,function(singleSeller){
						angular.forEach(output.sellerIds,function(selectedSeller){
							if(singleSeller.id == selectedSeller)
							{
								singleSeller.status='1';
								singleSeller.disabled='1';
							}
						});
					});
					
				}
				else
				{
					return false;
				}
			});
		}
		
	}
	
});
