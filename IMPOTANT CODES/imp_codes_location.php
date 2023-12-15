

Generate Dom PDF (Workjackpot [WorkmangmentController])
TCPDF (Seeds live)
CI PAypal (SPORTS)

Excel Asropoli CRM Members export {Codeignitor}

Excel export Locker [Transction history] LARAVEL
-------------------------------------
Nav-tabs next click switch (tours [Desert gate]) 
---------------------------------------------------------
Search on keyup jquery (PROJECts BackUP)
----------------------------------------------------------
Horizontal dynamic table (SamelJobs (landing_page_new))
-----------------------------------------------------------
LOCKER WALE me select pe change value staff module 17 feb 23
------------------------
Zip (Workjackpot [ReportController])
-------------------------------------------
<script type="text/javascript">
	$('body').on("change",'.rec_location', function(){
      var Rec_loc_id = $(this).find(":selected").val();

      var append_div_closest = $(this).closest(".append_div");
      append_div_closest.find(".rec_loc").val(Rec_loc_id);

      $.ajax({
          url:"<?php echo base_url('admin/get_receivers_location'); ?>",
          type: 'post',
          data: {'receiver_location_id': Rec_loc_id},
           success: function(response) {
              append_div_closest.find('.Province_Res').html(response);
              // console.log(response); 
              // $("#get_ajx_province").val(response.get_ajx_province);
              // $("#get_ajx_mobile1").val(response.get_ajx_mobile1);
           }
        });
        return false;
    });
</script>

-------------------------------------------------------------
Upload multiple images 

foreach ($DateSowing as $key => $value) {

  $datathirditems =array();
  $datathirditems['third_stage_id']       = $Third_id;
  $datathirditems['proposal_id']        = $ProposalID[$key];
  $datathirditems['variety_name']       = $VarietyName[$key];
  // $datathirditems['date_of_transplanting']   = $DateTransplanting[$key];
  $datathirditems['date_of_sowing']       = $DateSowing[$key];
  $datathirditems['number_of_transplating']   = $NumberTransplanting[$key];
  $datathirditems['internal_code']      = $InternalCode[$key];
  $datathirditems['rec_location']       = $Locations[$key];


      if(@$_FILES["map_of_swing"]["name"] != ''){
              $targetDir = "uploads/";
              $allowTypes = array('jpg','png','jpeg','gif','mp4','mov');
              $images_arr = array();
              $date = date('d_m_Y');
              foreach($_FILES['map_of_swing']['name'] as $key2=>$val){
                
                  $image_name = time()."_".$key2."_".$date."_".$_FILES['map_of_swing']['name'][$key2];
                  $tmp_name   = $_FILES['map_of_swing']['tmp_name'][$key2];
                  $size       = $_FILES['map_of_swing']['size'][$key2];
                  $type       = $_FILES['map_of_swing']['type'][$key2];
                  $error      = $_FILES['map_of_swing']['error'][$key2];
                  // File upload path
                  $fileName = basename($image_name);
                  $file_Name = str_replace(' ', '_', $fileName);
                  $targetFilePath = $targetDir . $file_Name;
                  // Check whether file type is valid
                  $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
                  
                      if(move_uploaded_file($_FILES['map_of_swing']['tmp_name'][$key2],$targetFilePath)){
                          $images_arr[] = $targetFilePath;

                      
                        $upload_filename[] = $file_Name;
                      }
                  
              }
          }

        $datathirditems['map_of_swing'] = $upload_filename[$key];
      
  $this->Reportsadmin->insert_thirdstage_items($datathirditems);
} 

----------------------------------------------------------------------
<!-- datepicker -->
<link href="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/semantic.min.css" rel="stylesheet" type="text/css" />
<div class="ui calendar date_picker7">
  <div class="ui input left icon">
    <i class="time icon"></i>
    <input type="text" class="form-control" placeholder="Time" name="college_end_date[]" value="<?php echo $value['college_end_date']; ?>">
  </div>
</div>

<script src="https://code.jquery.com/jquery-2.1.4.js"></script>
<script src="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/semantic.min.js"></script>
<script type="text/javascript">
  $('.date_picker7').calendar({
    type: 'month'
  });
</script>

--------------------------------------------------------------------------
Comma seprated value insert in laravel


<select class="form-select single-select country_{{$data}}_{{$EXO['id']}}  {{ $errors->has('country') ? 'is-invalid' : '' }}"
    name="country[{{ $data }}][]" id="country{{$data}}_{{$EXO['id']}}" onchange="getStateCity('country','','{{$data}}')" multiple>
    <option value="">{{ translate('Select Country') }}</option>
    @foreach ($country as $C)
        <option value="{{ $C['id'] }}"
            {{ getSelectedInArray($C['id'], $EXO['country']) }}>{{ $C['name'] }}
        </option>
    @endforeach
</select>
<!-- Controller -->
<?php 
$OverRideBanner['country'] = isset($request->country[$key]) ? implode(',', $request->country[$key]) : '';
$OverRideBanner->save();
?>
<!-- database -->
filed with text or varchar 255

----------------------------------------------------------------------------

Get city,country,state,pincode from google map 

<script src="https://maps.google.com/maps/api/js?key=AIzaSyCpqoRKJ3CM7GGiFWTEY0qCKYYRh00ULF0&libraries=places&callback=initAutocomplete" type="text/javascript"></script>
<script type="text/javascript">
   google.maps.event.addDomListener(window, 'load', initialize);
   
   function initialize() {
       var input = document.getElementById('input_store_address_id');
       var autocomplete = new google.maps.places.Autocomplete(input);
       autocomplete.addListener('place_changed', function() {
           var place = autocomplete.getPlace();

           $('#address_latitude').val(place.geometry['location'].lat());
           $('#address_longitude').val(place.geometry['location'].lng());

           var whole_address = place.address_components;   
           // console.log(whole_address);            
           $('#address_city').val('');
           $('#address_state').val('');
           $('#address_country').val('');
           $('#address_pincode').val('');
           $.each(whole_address, function(key1, value1) 
           {
               
               if((value1.types[0]) == 'locality')
               {                
                   var prev_long_name_city = value1.long_name;  
                   $('#address_city').val(prev_long_name_city);
               }

               if((value1.types[0]) == 'administrative_area_level_1')
               {
                   var prev_long_name_state = value1.long_name;  
                   $('#address_state').val(prev_long_name_state);
               }

               if((value1.types[0]) == 'country')
               {
                   var prev_long_name_country = value1.long_name;  
                   $('#address_country').val(prev_long_name_country);
               }

               if((value1.types[0]) == 'postal_code')
               {
                   var prev_long_name_pincode = value1.long_name;  
                   $('#address_pincode').val(prev_long_name_pincode);        
               }
           }); 


       });
   }
</script>

----------------------------------------------------------------------------
Full time diffrence b/w two dates

<?php 
 
$datetime1 = date_create($request->drop_date);
$datetime2 = date_create($request->pickup_date);

// Calculates the difference between DateTime objects
$interval = date_diff($datetime1, $datetime2);

// Printing result in years & months format
$time_diff  = $interval->format('%y Yearly %m Montly %d Daily %H Hourly %i Hourly');

// echo $time_diff  = $this->newtimeago($request->drop_date,$request->pickup_date);
$month_type = explode('', $time_diff);

?>
---------------------------------------------------------------------------
Multiple data add with Ajax and Append (Hotel booking[Locations(bulk add)])
--------------------------------------------------------------------------
Multiplle table data in Single LIST Without Join With Pagination


$get_list_arr = array_merge($get_list_product_arr, $get_list_tranfer_arr);

       
$get_list_arr = $this->paginate($get_list_arr,10);
$get_list_arr->path('');

 public function paginate($items, $perPage = 10, $page = null)
{
    $page        = $page ?: (Paginator::resolveCurrentPage() ?: 1);
    $total       = count($items);
    $currentpage = $page;
    $offset = ($currentpage * $perPage) - $perPage ;
    $itemstoshow = array_slice($items , $offset , $perPage);
    return new LengthAwarePaginator($itemstoshow ,$total ,$perPage);
}

----------------------------------------------------------------------------
Multiple images not deleted 

<input type="hidden" name="research_data_image[]" value="{{ $HRD['research_image'] }}">
<?php 

if ($request->research_title) {
    ReasonDescription::where(['reason_id' => $reason_id])->delete();
    foreach ($request->research_title as $key => $value) {
        $ReasonDescription = new ReasonDescription();
        $ReasonDescription->reason_id    = $reason_id;
        $ReasonDescription->research_title       = $value;
        $ReasonDescription->research_description = $request->research_description[$key];
        
        if (isset($request->research_image[$key])) {
            if (isset($request->research_image[$key]) && $request->research_image[$key] != '') {
                $files = $request->file('research_image')[$key];

                $random_no = uniqid();
                $img = $files;
                $ext = $files->getClientOriginalExtension();
                $new_name = $random_no . time() . '.' . $ext;
                $destinationPath = public_path('assets/uploads/reason/');
                $img->move($destinationPath, $new_name);
                $ReasonDescription['research_image'] = $new_name;
            }
        }elseif (isset($request->research_data_image[$key])) {
            $ReasonDescription->research_image = $request->research_data_image[$key];
        }

        $ReasonDescription->save();
    }
}

?>
==================================================
Graph monthly or date wise [Desert gate][19 MAY 23]  Location

<!-- Query to fetch Monthly data  -->
$get_charts_items = ProductCheckout::select(
                            ProductCheckout::raw("(COUNT(*)) as count"),
                            ProductCheckout::raw("DATE(created_at) as month_name"),
                            <!-- ProductCheckout::raw("MONTHNAME(created_at) as month_name"), -->
                            ProductCheckout::raw("sum(total) as totale")
                        )
                        ->whereYear('created_at', date('Y'))
                        ->groupBy('month_name')
                        ->orderby('id','asc')
                        ->get();

 <!-- view                        -->
 <div class="col-xxl-9">
    <div id="chartContainer" style="height: 310px; width: 100%;"></div>
  </div>

<?php
if ($get_charts_items!='') {
    $dataPoints = [];
    foreach ($get_charts_items as $key => $value) {
        $my_arr = [];
        $my_arr['y'] = $value['totale'];
        $my_arr['label'] = $value['month_name'];
        $dataPoints[] = $my_arr;
    }
}
?>    
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
    title: {
        text: "Orders"
    },
    axisY: {
        title: "Sales"
    },
    data: [{
        type: "line",
        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
    }]
});
chart.render();
 
}
</script>  
================================================================================
QR Code generate in laravel AND mobile view on change like flutter [24JE card][27 MAY 23 BACKUP]  Location

for QR code library
composer require simplesoftwareio/simple-qrcode

for card library
composer require jeroendesloovere/vcard-bundle

for Image library
composer require intervention/image

===============================================================================
Dynamic Pagination in laravel

$setLimit     = 10;
$offset       = $request->offset;
$limit        = $offset * $setLimit;

        $orders_count =  UserBookingLodge::where(['customer_id' => $request->customer_id ])->count();
        $output['orders_count'] = $orders_count;

        if($orders_count > 0 ){
            $output['page_count'] = ceil($orders_count / $setLimit);            
            $UserBookingLodge = UserBookingLodge::where(['customer_id' => $request->customer_id ])
                        ->offset($limit)
                        ->limit($setLimit)
                        ->get();
===============================================================================
Onclick status change ajax with msg

View---------
<script type="text/javascript">
    $('body').on("change",'.switch_button', function(){
        
        var data_id =jQuery(this).attr('data-id');
        if (this.checked) {
            var status = "Active";
        } else {
            var status = "Deactive";
        }

      $.ajax({
          url:"{{route('admin.reviews_status_change')}}",
          type: 'post',
          data: {'data_id': data_id,'status': status,"_token": "{{ csrf_token() }}"},
           success: function(response) {
               success_msg("Status update successfully");
               setTimeout(function(){ 
                  window.location.reload();     
               }, 1500);
           }
        });
    });
</script>

Controller---------------------
<?php 
public function reviews_status_change(Request $request){
       
    if ($request->status) {
        $updatedata = array();
        $updatedata['status'] = $request->status;

        UserReview::where('id',$request->data_id)->update($updatedata);

        $message      = "Status update Successfully";
        $status       = "success";

    }     

} ?>


@if ($errors->has('success'))
    <script>
        success_msg("{{ $errors->first('success') }}")
    </script>
@endif
@if ($errors->has('error'))
    <script>
        danger_msg("{{ $errors->first('error') }}");
    </script>
@endif

=========================================================================
From date to date code in laravel +1 day
<script>
    $(document).ready(function() {
      let arrival = $('.datetimepickerdate_new');
      let departure = $('.datetimepickerdate_to_date');

      arrival.flatpickr({
        dateFormat: "Y-m-d",
        disableMobile: true,
        //locale: "de",
        minDate: "today",
        onChange: function(selectedDates, dateStr, instance) {
          //departure.set('maxDate', new Date(dateStr).fp_incr(5));
          departure.flatpickr({
            dateFormat: "Y-m-d",
            enableTime: false,
            minDate: new Date(selectedDates).fp_incr(1), // add 1 day
            //new Date(dateStr).fp_incr(1)
          });
          departure.removeAttr('readonly');
          arrival.removeAttr('readonly');
        }
      });

      departure.flatpickr({});
    });

</script>
=======================================================================
PDF row divided in particular format [row break when multiple images]

<?php 
    // $items = array("Volvo", "BMW", "Toyota","Volvo2", "BMW2", "Toyota2","Volvo3", "BMW3", "Toyota3");
   
    $numOfCols = 3;
    $rowCount = 0;
    $bootstrapColWidth = 12 / $numOfCols;
?>
<table>
    <tr>
        <?php foreach ($slider_heading as $key => $row){ ?>  
                <td><img src="<?php echo asset('uploads/excursion/pdf/'.$row['slider_images']) ?>" class="row_img"></td>
        <?php 
            $rowCount++;
            if($rowCount % $numOfCols == 0) echo '<tr>';
        } ?>
    </tr>
</table>    
====================================================================
To change class or key Onchange / Delete [Multiple]

<script type="text/javascript">
    deleteMsg('Are you sure you want to delete ?').then((result) => {
                if (result.isConfirmed) {
                     $(this).parent().closest('div').remove();
                     var AddOnCount = $(this).attr('data-count');
                     var numItems = $('.general_box').length;
                     var addKey1 = numItems;

                     $(".preview_general_img").each(function(key, value) {
                         var newKey = parseInt(key) ;
                         $(this).attr("id",  "preview_general_img_" + newKey );
                     });
                     $(".general_test").each(function(key, value) {
                         var newKey = parseInt(key) ;
                         $(this).attr("name",  "page_content_multi[general_heading]["+newKey+"][general_title]");
                     });
                     $(".anchor_tag").each(function(key, value) {
                         var newKey = parseInt(key) ;
                         $(this).attr("onclick",  "loadFileeditn(\'gen_img_"+newKey+"\')");
                     });
                     $(".general_imag").each(function(key, value) {
                         var newKey = parseInt(key) ;
                         $(this).attr("name",  "page_content_multi[general_heading]["+newKey+"][general_images]");
                         $(this).attr("id",  "gen_img_"+newKey+"");
                         $(this).attr("onchange",  "loadFile(event,\'preview_general_img_"+newKey+"\')");

                     });
                     $(".general_imag_hidden").each(function(key, value) {
                         var newKey = parseInt(key) ;
                         $(this).attr("name",  "hidden_file_page_content_multi[general_heading]["+newKey+"][general_images]");
                 
                     });
                     $(".delete_btn_general").each(function(key, value) {
                         var newKey = parseInt(key) ;
                         $(this).attr("data-count",  newKey);
                 
                     });
                     $(".add_btn_general").attr("onclick",  "addgeneral('general_heading','"+addKey1+"')");
               
                     
                   
                    // $(".add_btn_general").attr("onclick","addgeneral('"+id+"','"+count+"')");
                    e.preventDefault();
                }
            });
</script>