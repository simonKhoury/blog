

$(document).ready(function() {
	

 var URL  = window.location.href;
//	var slug= url('/',URL);
	var slug = URL.split("/")[6];
	
	
	
//	get_comments(slug);
	window.serverURL = "http://localhost/index/Ublog/includes/";
	
	function get_comments(slug){
		
		
		
		$.ajax({
           					
          					type: 'POST',
			  				url: window.serverURL+"ws_queries.php",
			  				data: ({action:2,Pslug:slug}),
			  
			  				dataType: 'json',
			  				timeout: 10000,
							
							success: function(data, textStatus, xhr) 
							{
                				data = JSON.parse(xhr.responseText);
								
							
								
							},
			  				error: function(xhr, status, errorThrown) 
							  {
								  
								  alert(status + errorThrown);
			 				  }
		  				});
	}
	
	
	
	
	function populate_comments(data){
		
		count=data.length;
			
		$("#comments_box").empty();	
			
				
		var item="";
		if(count>0)
			{
					
					item+="<div class='row'>";
							item+="<div class='col-sm-12'>";
									item+="<h3>Comments</h3>";
											item+="</div>";
													item+="</div>";
	
					
		 			$.each(data, function(index, row) {
						
						
						
						item+="<div class='row'>";
						item+="<div class='col-sm-2'>";
						item+="<div class='thumbnail'>";
						item+="<img class='img-responsive user-photo' src='https://ssl.gstatic.com/accounts/ui/avatar_2x.png'>";
						item+="</div>";
						item+="</div>";

						item+="<div class='col-sm-1-'>";
						item+="<div class='panel panel-default'>";
						item+="<div class='panel-heading'>";
						item+="<strong>'"+row.username+"'</strong> <span class='text-muted'>commented on '" + $row.date + "'</span>";
						item+="</div>";
						item+="<div class='panel-body'>'"+$row.comment +"'</div>";
						
						
						item+="</div>";
						item+="</div>";
						item+="</div>";
						
			 
			 
			 			});
				
				item+="</section>";
				
				$("#comments_box").append(item);
				
			}
		
		
										
		
		
	}
	
	
	
});