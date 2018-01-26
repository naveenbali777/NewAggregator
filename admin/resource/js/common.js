$(document).ready(function(){
	$("#all_articles").click(function(){
		if($("#all_articles").is(':checked')){
			$('.articlesCheck').prop('checked', true);
			$('.articlesCheck').addClass('articles_active');
		}else{
			$('.articlesCheck').prop('checked', false);
			$('.articlesCheck').removeClass('articles_active');
		}
	});
	$(".articlesCheck").click(function(){
		$(this).hasClass('articles_active') ? $(this).removeClass('articles_active') : $(this).addClass('articles_active');
		($(".articles_active").length == $(".articlesCheck").length) ? $('#all_articles').prop('checked', true) : $('#all_articles').prop('checked', false);
	});
	$(".cmp_images").click(function(){
		var imgId = $(this).val();
		if($(this).is(':checked')){
			var fldvalue = 'mark'+'='+imgId;
		}else{
			var fldvalue = 'unmark'+'='+imgId;
		}
		$.ajax({
		    url: 'mark_image.php?'+fldvalue,
		    type: 'GET',
		    success: function (data) {
		        // console.log(data);
		    }
		});
	});
	$(".actionButton input").click(function(){
		var imgId = $(this).val();
		var bname = $(this).attr("name");

		if($(this).is(':checked')){
			var nwvalue = 'mark'+'='+imgId+'&bname='+bname;
		}else{
			var nwvalue = 'unmark'+'='+imgId+'&bname='+bname;
		}
		// alert(nwvalue);
		$.ajax({
		    url: 'mark_news.php?'+nwvalue,
		    type: 'GET',
		    success: function (data) {
		        console.log(data);
		        if(data == 'mark'){
		        	$(".successMsg").html('<div class="alert alert-success"><strong>Success!</strong> Set '+bname+' successfully.</div>');
		        }else{
		        	$(".successMsg").html('<div class="alert alert-success"><strong>Success!</strong> Unset '+bname+' successfully.</div>');
		        }
		    }
		});
	});
	$( ".categoryDrop" ).change(function() {
		var ids = $(this).val();
		if(ids != ""){
			var idArray = ids.split("~");
			var catId = idArray[0];
			var nId = idArray[1];
			var catName = idArray[2];
			var catnwvalue = 'catId='+catId+'&nId'+'='+nId;
			$.ajax({
			    url: 'change_category.php?'+catnwvalue,
			    type: 'GET',
			    success: function (data) {
			        console.log(data);
			        if(data == 'done'){
			        	$(".successMsg").html('<div class="alert alert-success"><strong>Success!</strong> Category Changed to '+catName+' successfully.</div>');
			        }
			    }
			});
		}
	});
	$(".company_note").keyup(function(){
		var prnt = $(this).parent();
		var notevalue = $(this).val();
		var cmpId = prnt.find(".company_id").val();
		var fldvalue = 'company_id='+cmpId+'&notevalue='+notevalue;
		$.ajax({
		    url: 'company_note.php?'+fldvalue,
		    type: 'GET',
		    success: function (data) {
		        // console.log(data);
		    }
		});
	});
});
