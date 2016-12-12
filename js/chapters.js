if (typeof location.origin === 'undefined') location.origin = location.protocol + '//' + location.host;
//site_url = location.origin
site_url = location.origin + '/mod02/index.php';

$(function() {
	$(document).on('click', '.edit-chapter', function() {
		var row_elem = $(this).closest('tr');
		var chapter_name = row_elem.find('.chapter-name').attr('data-value');
		var max_regular = row_elem.find('.max-regular').html();
		var max_associate = row_elem.find('.max-associate').html();

		//row_elem.find('.chapter-name').html('<input type="text" class="form-control" name="chapter" value="'+chapter_name+'" />');
		row_elem.find('.max-regular').html('<input type="text" class="form-control quantity" name="max-regular" value="'+max_regular+'" />');
		row_elem.find('.max-associate').html('<input type="text" class="form-control quantity" name="max-associate" value="'+max_associate+'" />');

		$(this).parent().html('<a href="#" class="save-chapter"><i class="fa fa-check-square-o"></i></a>');
	});

	$(document).on('click', '.save-chapter', function() {
		var result;
		var row_elem = $(this).closest('tr');
		//var chapter_name = row_elem.find('.chapter-name').find('input').val();
		var max_regular = row_elem.find('.max-regular').find('input').val();
		var max_associate = row_elem.find('.max-associate').find('input').val();
		var chapter_id = row_elem.data('id');
		
		$(this).parent().html('<i class="fa fa-spinner fa-spin"></i>');
		//row_elem.find('.chapter-name').find('input').prop('disabled', true);
		row_elem.find('.max-regular').find('input').prop('disabled', true);
		row_elem.find('.max-associate').find('input').prop('disabled', true);

		$.ajax({
		   url: site_url + '/admin/chapters/save',
		   method: "POST",
		   data: {id : chapter_id, max_regular : max_regular, max_associate : max_associate },
		   success: function(response) {
		        result = JSON.parse(response);
		   },
		   complete: function() {
		        if(result.type) {
		        	row_elem.find('.actions').html('<a href="#" class="edit-chapter"><i class="fa fa-pencil"></i></a>'); 
		            //row_elem.find('.chapter-name').html('<mark><strong>'+chapter_name+'</strong></mark>');
					row_elem.find('.max-regular').html(max_regular);
					row_elem.find('.max-associate').html(max_associate);
					row_elem.find('.category').html(result.category);
					row_elem.find('.voting-strength').html(result.voting_strength);
		        } else {
		        	//row_elem.find('.chapter-name').find('input').prop('disabled', false);
					row_elem.find('.max-regular').find('input').prop('disabled', false);
					row_elem.find('.max-associate').find('input').prop('disabled', false);
		        	row_elem.find('.actions').html('<a href="#" class="save-chapter"><i class="fa fa-check-square-o"></i></a>');
		        }
		        
		        alert(result.message);
		        
		   },
		   error: function() {
		        alert("ERROR in running requested function. Page will now reload.");
		        location.reload();
		   }
		});
	});
});