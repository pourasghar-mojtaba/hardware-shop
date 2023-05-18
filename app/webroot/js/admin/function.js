// JavaScript Document

/*
   follow and not_follow
*/ 
 function active_permission(role_id,id)
 {
 	
	 
	$.ajax({
			type:"POST",
			url:_url+'aclroles/active_permission',
			data:'role_id='+role_id+'&aclitem_id='+id,
			dataType: "json",
			success:function(response){
				// hide table row on success
				if(response.success == true) {
					$('#aclitem_'+id).remove();
						var inactive_permission=$("<a href='JavaScript:void(0);' onclick='inactive_permission("+role_id+","+id+")' id='aclitem_"+id+"'><span class='label label-success'>"+_active+"</span></a>");
					    $("#prbtn_"+id).append(inactive_permission);
						
					if( response.message ) {
						//showmsg(response.message);
						
					} 
					
				}
				else 
				 {
					if( response.message ) {
						show_error_msg(response.message);
					}  
				 }

			}
		});
 }
 
 
 
 function inactive_permission(role_id,id)
 {
 	 
	$.ajax({
			type:"POST",
			url:_url+'aclroles/inactive_permission',
			data:'role_id='+role_id+'&aclitem_id='+id,
			dataType: "json",
			success:function(response){
				// hide table row on success
				if(response.success == true) {
					$('#aclitem_'+id).remove();
						var  active_permission=$("<a href='JavaScript:void(0);' onclick='active_permission("+role_id+","+id+")' id='aclitem_"+id+"'><span class='label label-danger'>"+_inactive+"</span></a>");
					    $("#prbtn_"+id).append(active_permission);
						 
					if( response.message ) {
						//showmsg(response.message);
						
					} 
					
				}
				else 
				 {
					if( response.message ) {
						show_error_msg(response.message);
					}  
				 }

			}
		});
 }
   ///////////////////////////////////////////////////////////////////
   
function LoadEditor(Editor_name,Editor_Width)
{

	var sBasePath =_durl+'/js/admin/fckeditor/'

	var oFCKeditor = new FCKeditor( Editor_name) ;

	oFCKeditor.Config['ToolbarStartExpanded'] = true ;

	oFCKeditor.BasePath		= sBasePath ;
	//oFCKeditor.ToolbarSet	= 'DiamondPanel' ;
	oFCKeditor.Value		= '';
	oFCKeditor.Width=Editor_Width;
	var sSkinPath ='skins/office2003/' ;

	oFCKeditor.Config['SkinPath'] = sSkinPath ;
	oFCKeditor.Config['ContentLangDirection'] = "rtl" ;
	oFCKeditor.ReplaceTextarea() ;

	return oFCKeditor;
}





	