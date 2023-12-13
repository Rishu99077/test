<!doctype html>
<html lang="en">
   <head>
<link rel="stylesheet" href="{{ asset('assets/css/pdf/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/pdf/newstyle.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}">
<link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
<!-- Latest compiled and minified JavaScript -->


<style>
 
 @page { margin: 0px; }
body { margin: 0px;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; }   
</style>
</head>
<body>
<section class='transfer_head_first trnsfer_order'>
    <div class='transfer_header_table'>
        <!-- <header>
            <div class='transfer_bar_img'>
                <img src="{{ asset('assets/img/tourlogo.png') }}" alt="" />
            </div>
        </header> -->
        <div class="container1">
            <!-- <div class="scan_bar mt-8" >
                <img style="width:150px" src="{{ asset('assets/img/tourlogo.png') }}" alt="" />
            </div> -->
             <main>
                <div class="orderDetails">
                    <table style="width:100%; background-image: url('{{asset('assets/img/header-slide.png')}}');background-repeat: no-repeat;background-size:cover;background-position: right;width: 100%;">
                        <tbody class="table_left">
                            <tr>
                                <td colspan="2" style="padding:10px ;"></td>
                            </tr>
                            <tr>
                                <td style="width:35%;padding: 0 0px 0 15px;">
                                    <img style="width: 150px;" src="{{ asset('assets/img/tourlogo.png') }}" alt="" />
                                </td>
                                <td style="width:65%; text-align: right;" >
                                   <img style="width: 35%;float: right;margin: 0px 20px;" src="{{ asset('assets/img/tourlogo.png') }}" alt="" /> 
                                </td>
                            </tr>
                             <tr>
                                <td colspan="2" style="padding:30px ;"></td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0px 5px 15px; width:35%;font-size: 14px;color:#828282; font-weight: 400;">Booking reference:</td>
                                <td style="padding-right: 15px;width:65%; padding-bottom: 5px; color: #232a35;font-size: 14px;font-weight: 500;">IGLU-H295d7bFA</td>
                            </tr>
                            <tr>
                                <td style="width:35%;font-size: 14px;color:#828282; font-weight: 400;padding: 0 0px 0 15px;">Supplier reference:</td>
                                <td style="padding-right: 15px;width:65%; color: #232a35;font-size: 14px;font-weight: 500;">IGLU-16133411</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:5px ;"></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding: 0 0px 0 15px;font-size: 14px;">
                                   <b>Please Read the</b> <a href="#"> Frequently asked Question</a> and the <a href="#">Terms & Condition</a> before you travel.
                                </td>
                            </tr>
                            <tr>
                              <td colspan="2" style="padding: 0 0px 10px 15px;font-size: 14px;">his voucher is to be presented to your suppliers representative fe EC</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:10px;"></td>
                            </tr>
                        </tbody>
                    </table>

                    <table style="width:100%;">
                        <thead>
                            <tr>
                                <th colspan="2"  style="background-color: #000000; color: #fff; padding: 10px; font-size: 14px;font-weight: 500;padding: 10px 10px 10px 15px;">General Details</th>
                            </tr>
                        </thead>
                        <tbody class="table_left">
                            <tr>
                                <td colspan="2" style="padding:10px ;"></td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#828282; font-weight: 400;">Supplier:</td>
                                <td style="padding-right: 15px;width:65%; color: #232a35;font-size: 14px;font-weight: 400;">Desert Gata Tourism -UAE</td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#828282; font-weight: 400;">From</td>
                                <td style="padding-right: 15px;width:65%; color: #232a35;font-size: 14px;font-weight: 400;">Dubai City Center</td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#828282; font-weight: 400;">To</td>
                                <td style="padding-right: 15px;width:65%; color: #232a35;font-size: 14px;font-weight: 400;">Dubai Port</td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#828282; font-weight: 400;">Number of Pax</td>
                                <td style="padding-right: 15px;width:65%; color: #232a35;font-size: 14px;font-weight: 400;">Adults:2</td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#828282; font-weight: 400;">Customer Name:</td>
                                <td style="padding-right: 15px;width:65%; color: #232a35;font-size: 14px;font-weight: 400;">MR Jonathan Hart</td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#828282; font-weight: 400;">Mobile No:</td>
                                <td style="padding-right: 15px;width:65%; color: #232a35;font-size: 14px;font-weight: 400;">+4407700110445</td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#828282; font-weight: 400;">Transfer Type:</td>
                                <td style="padding-right: 15px;width:65%; color: #232a35;font-size: 14px;font-weight: 400;">One Way Or Return Transfer</td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#828282; font-weight: 400;">To:</td>
                                <td style="padding-right: 15px;width:65%; color: #232a35;font-size: 14px;font-weight: 400;">Dubai Port</td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#828282; font-weight: 400;">Vehicle Type:</td>
                                <td style="padding-right: 15px;width:65%; color: #232a35;font-size: 14px;font-weight: 400;">1XPrivate Standard SUV (1-4)</td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#828282; font-weight: 400;">Travel Agent:</td>
                                <td style="padding-right: 15px;width:65%; color: #232a35;font-size: 14px;font-weight: 400;">lglu.com</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:10px;"></td>
                            </tr>
                        </tbody>
                    </table>

                    <table style="width:100%;">

                        <thead>
                            <tr>
                                <th colspan="2" style="background-color: #000000; color: #fff; padding: 10px 10px 10px 15px; font-size: 14px;font-weight: 500;">Arrival Details</th>
                            </tr>
                        </thead>
                        <tbody class="table_left">
                            <tr>
                                <td colspan="2" style="padding:10px ;"></td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#828282; font-weight: 400;">Arriving On:</td>
                                <td style="padding-right: 15px;width:65%; color: #232a35;font-size: 14px;font-weight: 400;">Friday 2 December 2022 at 15:00</td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#828282; font-weight: 400;">Arriving At/Aiport:</td>
                                <td style="padding-right: 15px;width:65%; color: #232a35;font-size: 14px;font-weight: 400;">Dubai Airport, (DXB), United Arab Emirates to Dukes</td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#828282; font-weight: 400;">Airline:</td>
                                <td style="padding-right: 15px;width:65%; color: #232a35;font-size: 14px;font-weight: 400;">Dubai Airline</td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#828282; font-weight: 400;">Flight Number:</td>
                                <td style="padding-right: 15px;width:65%; color: #232a35;font-size: 14px;font-weight: 400;">AF125349</td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#828282; font-weight: 400;">Added Services:</td>
                                <td style="padding-right: 15px;width:65%; color: #232a35;font-size: 14px;font-weight: 400;">Hotel Drop</td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#828282; font-weight: 400;">Drop Off Location:</td>
                                <td style="padding-right: 15px;width:65%; color: #232a35;font-size: 14px;font-weight: 400;">Royal Hideaway,Hotel PO Box 120015;Palm Jumeirah;Dubai,Dubai,United Arab Emirates </td>
                            </tr>
                             <tr>
                                <td colspan="2" style="padding:10px ;"></td>
                            </tr>
                        </tbody>
                    </table>

                    <table style="width:100%;">
                        <thead>
                             <tr>
                                <th colspan="2" style="background-color: #000000; color: #fff; padding: 10px 10px 10px 15px; font-size: 16px;font-weight: 500;">Departure Details</th>
                            </tr>
                        </thead>
                        <tbody class="table_left">
                            <tr>
                                <td colspan="2" style="padding:10px ;"></td>
                            </tr>
                           
                            <tr>
                                <td style="padding: 0 0px 5px 15px;width:35%;font-size: 16px;color:#828282; font-weight: 400;">Departing On:</td>
                                <td style="padding-right: 15px;width:65%; color: #232a35;font-size: 16px;font-weight: 400;">Friday 2 December 2022 at 15:00</td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#828282; font-weight: 400;">Departure from/Aiport:</td>
                                <td style="padding-right: 15px;width:65%; color: #232a35;font-size: 14px;font-weight: 400;">Dubai Airport, (DXB), United Arab Emirates to Dukes</td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#828282; font-weight: 400;">Airline:</td>
                                <td style="padding-right: 15px;width:65%; color: #232a35;font-size: 14px;font-weight: 400;">Dubai Airline</td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#828282; font-weight: 400;">Flight Number:</td>
                                <td style="padding-right: 15px;width:65%; color: #232a35;font-size: 14px;font-weight: 400;">AF125349</td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#828282; font-weight: 400;">Added Services:</td>
                                <td style="padding-right: 15px;width:65%; color: #232a35;font-size: 14px;font-weight: 400;">Hotel Drop</td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#828282; font-weight: 400;">Drop Off Location:</td>
                                <td style="padding-right: 15px;width:65%; color: #232a35;font-size: 14px;font-weight: 400;">Royal Hideaway,Hotel PO Box 120015;Palm Jumeirah;Dubai,Dubai,United Arab Emirates </td>
                            </tr>
                             <tr>
                                <td colspan="2" style="padding:10px ;"></td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="width:100%;">
                        <thead>
                             <tr>
                                <th colspan="2" style="background-color: #000000; color: #fff; padding: 10px 10px 10px 15px; font-size: 16px;font-weight: 500;">Arrival / Departure Instructions</th>
                            </tr>
                        </thead>
                       <!--  <tbody class="table_left">
                            <tr>
                                <td colspan="2" style="padding:10px ;"></td>
                            </tr>
                           
                            <tr>
                                <td style="padding: 0 0px 5px 15px;width:35%;font-size: 16px;color:#828282; font-weight: 400;">Departing On:</td>
                                <td style="width:65%; color: #232a35;font-size: 16px;font-weight: 400;">Friday 2 December 2022 at 15:00</td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#828282; font-weight: 400;">Departure from/Aiport:</td>
                                <td style="width:65%; color: #232a35;font-size: 14px;font-weight: 400;">Dubai Airport, (DXB), United Arab Emirates to Dukes</td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#828282; font-weight: 400;">Airline:</td>
                                <td style="width:65%; color: #232a35;font-size: 14px;font-weight: 400;">Dubai Airline</td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#828282; font-weight: 400;">Flight Number:</td>
                                <td style="width:65%; color: #232a35;font-size: 14px;font-weight: 400;">AF125349</td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#828282; font-weight: 400;">Added Services:</td>
                                <td style="width:65%; color: #232a35;font-size: 14px;font-weight: 400;">Hotel Drop</td>
                            </tr>
                            <tr>
                                <td style="padding: 0 0px 5px 15px;width:35%;font-size: 14px;color:#828282; font-weight: 400;">Drop Off Location:</td>
                                <td style="width:65%; color: #232a35;font-size: 14px;font-weight: 400;">Royal Hideaway,Hotel PO Box 120015;Palm Jumeirah;Dubai,Dubai,United Arab Emirates </td>
                            </tr>
                        </tbody> -->
                    </table>
                </div>
            </main>
        </div>
   </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
</body>
</html>
