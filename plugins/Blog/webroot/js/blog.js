
_adurl = "<?php echo  __SITE_URL.'admin/'.__BLOG.'/'; ?>"

 $('#name').keyup(function(){
	 	$("#loading").html('<img src="'+_durl+'img/loader/25.gif" >');	
		var name = $('#name').val();
		$.ajax({
			type:"POST",
			url:_url+'blogs/user_search/',
			data:'name='+name,
			success:function(response){
				$("#user_place").html(response);								
			    $("#loading").empty();
			}
			
		});	
	 })

$("#friend_input").autocomplete(
		{
			//define callback to format results
			source: function(req, add)
			{

				//pass request to server
				$.getJSON(_adurl+"blogtags/tag_search?callback=?", req, function(data)
					{

						//create array for response objects
						var suggestions = [];
						//process response
						$.each(data, function(i, val)
							{
								suggestions.push({'name':val.name,'id':val.id,'image':val.image});
							});

						//pass array to callback
						add(suggestions);
					});
			},
			select: function(e, ui)
			{

				//create formatted tag
				var friend = ui.item.value;

				var tarr = get_span_arr('#tag_place span');

				for (var i=0;i<tarr.length;i++)
				{
					if(tarr[i]==friend)
					{
						show_warning_msg(_not_added_repeated_tag);
						return false;
					}
				}

				var user_count= $("#friends span").length+1;
				var id= ui.item.id;
				span = $("<span>").text(friend),
				a = $("<a>").addClass("remove").attr(
					{
						href: "javascript:",
						title: "Remove " + friend,
						id   : friend,
						onclick :"remove('"+friend+"')"
					}).text("x").appendTo(span);
				var hide_input= "<input type='hidden' title='"+friend+"' name='data[Blogrelatetag][blog_tag_id][]' value='"+id+"' >";

				span.append(hide_input);
				//add friend to friend div

				//span.insertBefore("#friend_input");
				$("#tag_place").append(span);
			},

			//define select handler
			change: function()
			{

				//prevent 'to' field being updated and correct position
				$("#friend_input").val("").css("top", 2);
			}
		});

function remove(title){
	$('#'+title).parent().remove();

	//correct 'to' field position
	if($("#friends span").length === 0)
	{
		$("#friend_input").css("top", 0);
	}
}

	//add click handler to user_ids div
	$("#friends").click(function()
		{

			//focus 'to' field
			$("#friend_input").focus();
		});

	
	//add live handler for clicks on remove links
	/*$(".remove", document.getElementById("friends")).live("click", function()
		{
			//remove current friend
			$(this).parent().remove();

			//correct 'to' field position
			if($("#friends span").length === 0)
			{
				$("#friend_input").css("top", 0);
			}
		});*/
	//$('#mainmenu a').live('click', function)
	//$('#mainmenu').on('click', 'a', function)	
	 
	$('#add_tag').click(function()
		{
			var tag = $('#friend_input').val();

			var tarr = get_span_arr('#tag_place span');

			for (var i=0;i<tarr.length;i++)
			{
				if(tarr[i]==tag)
				{
					show_warning_msg(_not_added_repeated_tag);
					return false;
				}
			}

			span = $("<span>").text(tag),
			a = $("<a>").addClass("remove").attr(
				{
					href: "javascript:",
					title: "Remove " + tag,
					id   : tag,
					onclick :"remove('"+tag+"')"
				}).text("x").appendTo(span);
			var hide_input= "<input title='"+tag+"' type='hidden' name='new_tags[]' value='"+tag+"' >";
			//hide_input.appendTo(span);
			span.append(hide_input);
			//add tag to tag div

			//span.insertBefore("#tag_place");
			$("#tag_place").append(span);
			$('#friend_input').val('');
			 
		});

	function get_span_arr(item)
	{

		var tarr = [];
		$(item).each(function()
			{
				tarr.push($(this).find('input').attr('title'));
			});

		return tarr;
	}

	 