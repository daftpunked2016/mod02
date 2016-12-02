$(document).ready(function(){

    //fadeOut additional field inputs for selected national positions
    function fadeOut(){
      $("#avpArea").fadeOut(1000);
      $("#rvpRegion").fadeOut(1000);
      $("#ncProject").fadeOut(1000);
    }

    function getAreaAVP(){
      var stringArea = '';
      var area = document.getElementById('area_no');
      var area2 = document.getElementById('reg-avp_area');
      area2.value = area.value;
      //$('#reg-avp_area').find('input').val(area.value);
    }

    function getRegionRVP(){
      var stringRegion = '';
      var region = document.getElementById('region');
      var region2 = document.getElementById('reg-rvp_reg');
      var regionDisplay = document.getElementById('reg-rvp_reg2');
      region2.value = region.value;
      stringRegion = region.value;
      //$('#reg-rvp_reg').find('input').val(region.value);

      if (typeof location.origin === 'undefined')
        location.origin = location.protocol + '//' + location.host;

      $.post(location.origin+"/mod02/index.php/account/findRegion?id="+region.value, function(data) {
            regionDisplay.value = data;
            //$('#reg-rvp_reg2').find('input').val(data); 
      }); 
    }

    //LIST REGIONS
    $("#area_no").change(function(){
        if (typeof location.origin === 'undefined')
          location.origin = location.protocol + '//' + location.host;

        $.post(location.origin+"/mod02/index.php/account/listRegions?area_no="+$(this).val(), function(data) {
        		$("select#region").html("<option value=''>Select Region.. </option>" + data);
        		$("select#chapter").html("<option value=''> -- </option>");
        });
        getAreaAVP();
    });

    $("#area_no2").change(function(){
      if (typeof location.origin === 'undefined')
          location.origin = location.protocol + '//' + location.host;

        $.post(location.origin+"/mod02/index.php/account/listRegions?area_no="+$(this).val(), function(data) {
            $("select#region2").html("<option value='*'>* ALL</option>" + data);
            $("select#chapter2").html("<option value='*'>* ALL</option>");
        });
    });

    //LIST CHAPTERS
    $("#region").change(function(){
        if (typeof location.origin === 'undefined')
          location.origin = location.protocol + '//' + location.host;

        $.post(location.origin+"/mod02/index.php/account/listChapters?region="+$(this).val(), function(data) {
        		$("select#chapter").html("<option value=''>Select Chapter.. </option>" + data);
        });
        getRegionRVP();
    });

    $("#region2").change(function(){
        if (typeof location.origin === 'undefined')
          location.origin = location.protocol + '//' + location.host;

        $.post(location.origin+"/mod02/index.php/account/listChapters?region="+$(this).val(), function(data) {
            $("select#chapter2").html("<option value='*'>* ALL</option>" + data);
        });
    });

    //LIST POSITIONS
    $("#pos_category").change(function(){
        fadeOut();
        if (typeof location.origin === 'undefined')
          location.origin = location.protocol + '//' + location.host;

        $.post(location.origin+"/mod02/index.php/account/listPositions?category="+$(this).val(), function(data) {
            $("select#position_id").html("<option value=''>Select Position.. </option>" + data);
        });
    });

    //SHOW SEN. NO FIELD IF TITLE=JCI-SEN
    $('#user-title').change(function(){
    	var title = $('#user-title').val();
    	if(title==1)
    	{
        	$("#user-senno").fadeIn(1000);
    	}
    	else
    		$("#user-senno").fadeOut(1000);
    });

    //SHOW FORMS FOR BUSINESS OR WORK
    $("#chooseType").change(function(){
      var type = $(this).val();
      if(type == 1)
      {
        $("#workFormFields").css("display","none");
        $("#businessFormFields").fadeIn(1500);
      }
      else
      {
        $("#businessFormFields").css("display","none");
        $("#workFormFields").fadeIn(1500);
      }
    });

    //ADD/UPDATE BUSINESS FORM LIST BUSINESS SUBTYPES
    $("#business-category").change(function(){
        if (typeof location.origin === 'undefined')
          location.origin = location.protocol + '//' + location.host;

        $.post(location.origin+"/mod02/index.php/account/listSubtype?category="+$(this).val(), function(data) {
            $("select#business-subtype").html("<option value=''>Select Subtype.. </option>" + data);
        });
    });

    //ADD/UPDATE BUSINESS FORM LIST CITIES
    $("#business-province").change(function(){
        if (typeof location.origin === 'undefined')
          location.origin = location.protocol + '//' + location.host;

        $.post(location.origin+"/mod02/index.php/account/listCities?province="+$(this).val(), function(data) {
            $("select#business-city").html("<option value=''>Select City.. </option>" + data);
        });
    });

    //ADD/UPDATE WORK FORM LIST WORK SUBTYPES
    $("#work-category").change(function(){
        if (typeof location.origin === 'undefined')
          location.origin = location.protocol + '//' + location.host;

        $.post(location.origin+"/mod02/index.php/account/listSubtype?category="+$(this).val(), function(data) {
            $("select#work-subtype").html("<option value=''>Select Subtype.. </option>" + data);
        });
    });

    //ADD/UPDATE WORK FORM LIST CITIES
    $("#work-province").change(function(){
        if (typeof location.origin === 'undefined')
          location.origin = location.protocol + '//' + location.host;
        
        $.post(location.origin+"/mod02/index.php/account/listCities?province="+$(this).val(), function(data) {
            $("select#work-city").html("<option value=''>Select City.. </option>" + data);
        });
    });

    //SHOW FIELDS FOR ADDITIONAL INPUTS FOR SELECTED NATIONAL POSITIONS
    $("#position_id").change(function(){

        if($(this).val() == 8)
        {
          fadeOut();
          $("#avpArea").fadeIn(1000);
          getAreaAVP();
        }
        else if($(this).val() == 9)
        {
          fadeOut();
          $("#rvpRegion").fadeIn(1000);
          getRegionRVP();
        }
        else if($(this).val() == 10)
        { 
          fadeOut();
          $("#ncProject").fadeIn(1000);
        }
        else
        {
          fadeOut();
        }
    });


  
    //CHANGE AVATAR/LOGO MODAL SCRIPTS
    function readURL(input) {

      if (input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
          $('#avatarRead').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
      }
    }

    $("#avatar").change(function(){
      readURL(this);
    });


  //POPULATE CHAPTER MEMBERS FOR EVENT HOST SELECTION
  $("#chapter").change(function(){
      if (typeof location.origin === 'undefined')
          location.origin = location.protocol + '//' + location.host;

      $.post(location.origin+"/mod02/index.php/admin/account/listChapterMembers?chapter="+$(this).val(), function(data) {
          $("select#host_accounts").html("<option value=''>Select Host.. </option>" + data);
      });
  });


  //EVENT: PRICING MODE SYSTEM
  $("#pricing-type").change(function(){
    if($(this).val() == 1)
      {
        //$('#EventPricing_early_bird_price').prop('disabled', false);
        $('.pricing-info-inputs').prop('disabled',true);
        $('#EventPricing_early_bird_price').val('0.00');
        $('#EventPricing_onsite_price').val('0.00');
        $('#EventPricing_regular_price').val('0.00');
        $('.reg-dates').val('0');
        $('.eb-dates').val('0');
        $('.os-dates').val('0');
        $('#paymentSchemeSec').remove();
      }
    else if($(this).val() == 2)
    {
        $('#paymentSchemeSec').fadeIn();
        $('.pricing-info-inputs').prop('disabled',true);
        $('#EventPricing_early_bird_price').val('0.00');
        $('#EventPricing_onsite_price').val('0.00');
        $('#EventPricing_regular_price').prop('disabled', false);
        $('.reg-dates').prop('disabled', false);
        $('.eb-dates').val('0');
        $('.os-dates').val('0');
        alert('Input pricing and date details in the Regular Pricing Section.')
        $( "#EventPricing_regular_price" ).focus();
    }
    else if($(this).val() == 3)
    {
        $('#paymentSchemeSec').fadeIn();
        $('.pricing-info-inputs').prop('disabled',true);
        $('#EventPricing_early_bird_price').prop('disabled', false);
        $('#EventPricing_onsite_price').prop('disabled', false);
        $('#EventPricing_regular_price').prop('disabled', false);
        $('.reg-dates').prop('disabled', false);
        $('.eb-dates').prop('disabled', false);
        $('.os-dates').prop('disabled', false);
        alert('Input pricing and date details in all Pricing Sections.')
        $( "#EventPricing_early_bird_price" ).focus();
    }
  });

  //SHOW EVENT AREA NO FIELD IF AREACON = create
  $("#event-type").change(function(){

      if($(this).val() == 2)
      {
        $("#areacon-areano").fadeIn(500);
      }
      else
       $("#areacon-areano").fadeOut(500);
  }); 

  //FUNCTION TO DISABLE NON-NUMERICAL CHARACTERS IN QUANTITY TEXT FIELD
  $(document).on("keydown", ".quantity",function (e) {
      // Allow: backspace, delete, tab, escape, enter and .
      if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
           // Allow: Ctrl+A
          (e.keyCode == 65 && e.ctrlKey === true) ||
           // Allow: Ctrl+C
          (e.keyCode == 67 && e.ctrlKey === true) ||
           // Allow: Ctrl+X
          (e.keyCode == 88 && e.ctrlKey === true) ||
           // Allow: home, end, left, right
          (e.keyCode >= 35 && e.keyCode <= 39)) {
               // let it happen, don't do anything
               return;
      }
      // Ensure that it is a number and stop the keypress
      if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
          e.preventDefault();
      }
  });

  //LIST REGIONS
  $(document).on("change", "#area_no", function(){
      $.post(location.origin+"/mod02/index.php/account/listRegions?area_no="+$(this).val(), function(data) {
          $("select#region_id").html("<option value=''>Select Region.. </option>" + data);
      });
  });

  //LIST CHAPTERS
  $(document).on("change", "#region_id", function(){
      $.post(location.origin+"/mod02/index.php/account/listChapters?region="+$(this).val(), function(data) {
          $("select#chapter_id").html("<option value=''>Select Chapter.. </option>" + data);
      });
  });

/* 
  //SHOW INPUT OPTIONS FOR SEARCH TYPES (PRESIDENT PAGE)
   $("#searchType").change(function(){
    var type = $(this).val();
    
    function removeInputPres(){
        $("#defaultSearch").css("display","none");
        $("#ageType").css("display","none");
        $("#genderPres").css("display","none");
        $("#titlePres").css("display","none");
        $("#positionPres").css("display","none");
    }

    if(type == 1)
      {
        removeInputPres();
        $("#ageType").fadeIn(500);
      }
    else if(type == 2)
      {
        removeInputPres();
        $("#positionPres").fadeIn(500);
      }
    else if(type == 3)
      {
        removeInputPres();
        $("#genderPres").fadeIn(500);
      }
    else if(type == 4)
      {
        removeInputPres();
        $("#titlePres").fadeIn(500);
      }
    else
      {
        removeInputPres();
        $("#defaultSearch").fadeIn(500);
      } 
    });
*/
});