$(document).ready(function(){
      		$('#checkall').click (function () {
			     var checkedStatus = this.checked;
			    $('#itemList tbody tr').find('td:first :checkbox').each(function () {
			        $(this).prop('checked', checkedStatus);
			     });
			});
			
			$("#edit").click(function(){
				//console.log($('input[name="table_id"]:checked'));
				$('.table_id:checked').each(function() {
				   segment = this.value;
				});
				if(typeof segment == 'undefined'){
					alert('Please first make a selection from the list');
				}else{
					window.location.href = add_link+'/'+segment;	
				}
			});
			
			$("#delete").click(function(){
				//console.log($('input[name="table_id[]"]:checked'));
				$('.table_id:checked').each(function() {
				   segment = this.value;
				});
				if(typeof segment == 'undefined'){
					alert('Please first make a selection from the list');
				}else{
					$("#table_form").attr('action',delete_link);
					$("#table_form").submit();
				}
			});
			$("#clear").click(function(){

				//document.cookie=limit_cookie+"=; path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;";
				document.cookie=search_cookie+"=; path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;";
				window.location.href = current_url;
				
			});
			$("#limit").change(function(){
				limit = $(this).val();
				document.cookie=limit_cookie+'='+limit+';path=/';
				window.location.href = current_url;
			});
			
			$("#search").click(function(){
				//_search_param
				search_val = $("[name='table_search']").val();
				document.cookie=search_cookie+'='+search_val+';path=/';
				window.location.href = current_url;
			});
			
			$("[name='table_search']").click(function(){
				startDate = $("#startDate").val();
				endDate = $("#endDate").val();
				if(endDate!="" && endDate!=""){
					
					document.cookie='startDate1='+startDate+';path=/';
					document.cookie='endDate1='+endDate+';path=/';
				}else{
					$("#startDate,#endDate").css("border-color","red");
					return false;
				}
			});
		});		