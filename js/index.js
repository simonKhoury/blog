$(document).ready(function() {
	

	get_total_pages();
	
	function get_total_pages()
	{
		
		$.ajax({
		
          				type: 'POST',
			  			url: "http://localhost/index/Ublog/includes/ws_queries.php",
			  			data: ({action:1}),
			  			
			  			dataType: 'json',
			  			timeout: 10000,
						
						success: function(data, textStatus, xhr) 
						{
//								data = JSON.parse(xhr.responseText);
							
 							$("#pagination").bootpag({total: parseInt(data)});
//									
									
							
						},
			  			error: function(xhr, status, errorThrown) 
						{
								  
							
			 			 }
		  			});
	}
	
	
	
			
	
		
			
		
	 
	
	
	
	
	$("#results").load("./fetch_pages.php");  //initial page number to load
	$("#pagination").bootpag({
	   
	    page: 1,
	    maxVisible: 5 ,
		leaps: true,
    	firstLastUse: true,
    	first: '←',
    	last: '→',
    	wrapClass: 'pagination',
    	activeClass: 'active',
    	disabledClass: 'disabled',
    	nextClass: 'next',
    	prevClass: 'prev',
    	lastClass: 'last',
    	firstClass: 'first'
		
		}).on("page", function(e, num){
		e.preventDefault();
		
		$("#results").load("fetch_pages.php", {'page':num});
	});
	


});