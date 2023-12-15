<div class="left_menu ">
   <div class="scroll">
   <div class="ver_scroll">
      <div class="top_sec">
         <div class="toggle d-flex">
            <span class="toggle_nav">
               <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15">
                  <path id="Icon_ionic-ios-arrow-dropright-circle" data-name="Icon ionic-ios-arrow-dropright-circle" d="M3.375,10.875a7.5,7.5,0,1,0,7.5-7.5A7.5,7.5,0,0,0,3.375,10.875Zm8.816,0L9.238,7.951a.7.7,0,1,1,.984-.984l3.44,3.451a.7.7,0,0,1,.022.959l-3.389,3.4A.695.695,0,1,1,9.31,13.8Z" transform="translate(18.375 18.375) rotate(180)" fill="#fff"/>
               </svg>
            </span>
         </div>
         <div class="logo">
            <a href="{{url('/dashboard')}}"><img src="{{ asset('admin/images/sidebar_logo.png') }}" alt=""></a>
         </div>
      </div>
      <ul class="nav_menu">
         <li class="menu_parent <?php if($data['main_menu']=='Dashboard'){echo "open_menu_a"; } ?>">
            <a href="{{url('/dashboard')}}" class="menu_items">
            <span class="menu_icons">
            <img src="{{ asset('admin/images/dashboard.png') }}" alt="">
            </span>
            <span class="text_menu">Dashboard</span>
            </a>
         </li>
         <li class="menu_parent <?php if($data['main_menu']=='Products'){echo "open_menu_a"; } ?>">
            <a href="{{url('/products')}}" class="menu_items">
            <span class="menu_icons">
            <img src="{{ asset('admin/images/product (1).png') }}" alt="">
            </span>
            <span class="text_menu">Products</span>
            </a>
         </li>

         <!-- Inventry -->
         <?php if ($data['user_details']['user_role']!='1') { ?>
         <li class="menu_parent <?php if($data['main_menu']=='Inventry'){echo "open_menu_a"; } ?>">
            <a href="{{url('/inventries')}}" class="menu_items">
            <span class="menu_icons">
            <img src="{{ asset('admin/images/inventory.png') }}" alt="">
            </span>
            <span class="text_menu">Inventry</span>
            </a>
         </li>
         <?php } ?>
         <!-- Product Type -->
         <li class="menu_parent <?php if($data['main_menu']=='Product type'){echo "open_menu_a"; } ?>">
            <a href="javascript:void(0);" class="menu_items">
               <span class="menu_icons">
               <img src="{{ asset('admin/images/product type.png') }}" alt="">
               </span>
               <span class="text_menu">Product</span>
               <span class="togg_icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="8" viewBox="0 0 16 8">
                     <path id="fi-rr-angle-small-down" d="M20.665,8.241a1.163,1.163,0,0,0-1.616,0l-5.241,5.116a1.188,1.188,0,0,1-1.616,0L6.951,8.241a1.163,1.163,0,0,0-1.616,0,1.1,1.1,0,0,0,0,1.578l5.24,5.115a3.488,3.488,0,0,0,4.849,0l5.241-5.116a1.1,1.1,0,0,0,0-1.577Z" transform="translate(-5 -7.914)" fill="#ffffff"/>
                  </svg>
               </span>
            </a>
            <ul class="inner_item">
               <li>
                  <a href="{{url('/Product_type')}}">
                  <span class="menu_icons">
                  <img src="{{ asset('admin/images/product type.png') }}" alt="">
                  </span>
                  <span class="text_menu">Product type</span>
                  </a>
               </li>
               <li class="">
                  <a href="{{url('/productcategorie')}}">
                  <span class="menu_icons">                       
                  <img src="{{ asset('admin/images/sv2.svg') }}" alt="">    
                  </span>
                  <span class="text_menu">Product Categories</span>
                  </a>
               </li>
              
               <li>
                  <a href="{{url('/vendors')}}">
                  <span class="menu_icons">                
                  <img src="{{ asset('admin/images/vendor.png') }}" alt="">   
                  </span>
                  <span class="text_menu">Vendors</span>
                  </a>
               </li>

            </ul>
         </li>
         
         <?php if ($data['user_details']['user_role']!='1') { ?>
         <!-- Ordering -->
         <li class="menu_parent <?php if($data['main_menu']=='Ordering'){echo "open_menu_a"; } ?>">
            <a href="javascript:void(0);" class="menu_items">
               <span class="menu_icons">
               <img src="{{ asset('admin/images/ordering.png') }}" alt="">
               </span>
               <span class="text_menu">Ordering</span>
               <span class="togg_icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="8" viewBox="0 0 16 8">
                     <path id="fi-rr-angle-small-down" d="M20.665,8.241a1.163,1.163,0,0,0-1.616,0l-5.241,5.116a1.188,1.188,0,0,1-1.616,0L6.951,8.241a1.163,1.163,0,0,0-1.616,0,1.1,1.1,0,0,0,0,1.578l5.24,5.115a3.488,3.488,0,0,0,4.849,0l5.241-5.116a1.1,1.1,0,0,0,0-1.577Z" transform="translate(-5 -7.914)" fill="#ffffff"/>
                  </svg>
               </span>
            </a>
            <ul class="inner_item">
               <li>
                  <a href="{{url('/purchase_order')}}">
                  <span class="menu_icons">
                  <img src="{{ asset('admin/images/purchase-order.png') }}" alt="">
                  </span>
                  <span class="text_menu">Purchase order</span>
                  </a>
               </li>
               <li class="">
                  <a href="{{url('/receive_products')}}">
                  <span class="menu_icons">                       
                  <img src="{{ asset('admin/images/receive product.png') }}" alt="">    
                  </span>
                  <span class="text_menu">Recieve products</span>
                  </a>
               </li>
               <li class="">
                  <a href="{{url('/invoice')}}">
                  <span class="menu_icons">                       
                  <img src="{{ asset('admin/images/invoice.png') }}" alt="">    
                  </span>
                  <span class="text_menu">Invoices</span>
                  </a>
               </li>
            </ul>
         </li>
         <?php } ?>

         <!-- Setting -->
         <li class="menu_parent <?php if($data['main_menu']=='Setting'){echo "open_menu_a"; } ?>">
            <a href="javascript:void(0);" class=" menu_items">
               <span class="menu_icons">
               <img src="{{ asset('admin/images/settings.png') }}" alt="">
               </span>
               <span class="text_menu">Setting</span>
               <span class="togg_icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="8" viewBox="0 0 16 8">
                     <path id="fi-rr-angle-small-down" d="M20.665,8.241a1.163,1.163,0,0,0-1.616,0l-5.241,5.116a1.188,1.188,0,0,1-1.616,0L6.951,8.241a1.163,1.163,0,0,0-1.616,0,1.1,1.1,0,0,0,0,1.578l5.24,5.115a3.488,3.488,0,0,0,4.849,0l5.241-5.116a1.1,1.1,0,0,0,0-1.577Z" transform="translate(-5 -7.914)" fill="#ffffff"/>
                  </svg>
               </span>
            </a>
            <ul class="inner_item">
               <li>
                  <a href="{{url('/icons')}}">
                  <span class="menu_icons">                    
                  <img src="{{ asset('admin/images/icon.png') }}" alt="">
                  </span>
                  <span class="text_menu">Icons</span>
                  </a>
               </li>
               <li>
                  <a href="{{url('/locations')}}">
                  <span class="menu_icons">                    
                  <img src="{{ asset('admin/images/location.png') }}" alt="">
                  </span>
                  <span class="text_menu">Location</span>
                  </a>
               </li>
            </ul>
         </li>

         <!-- Users -->
         <?php if ($data['user_details']['user_role']=='1') { ?>
         <li class="menu_parent <?php if($data['main_menu']=='Users'){echo "open_menu_a"; } ?>">
            <a href="{{url('/users')}}" class="menu_items">
            <span class="menu_icons">
            <img src="{{ asset('admin/images/dinner-white.svg') }}" alt="">
            </span>
            <span class="text_menu">Restaurants</span>
            </a>
         </li>
         <?php } ?>
      </ul>
      <div class="text-center mb_60">
         <a href="{{url('logout')}}" class="logout_btn">
            Logout 
            <span class="ml_15">
               <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                  <path id="logout" d="M4.5,6.5a2.006,2.006,0,0,1,2-2h8v2h-8v14h8v2h-8a2.006,2.006,0,0,1-2-2Zm14.173,6L16.137,9.964,17.551,8.55,22.5,13.5l-4.949,4.95-1.414-1.414L18.673,14.5H12.088v-2Z" transform="translate(-4.5 -4.5)" fill="#fff" fill-rule="evenodd"/>
               </svg>
            </span>
         </a>
      </div>
   </div>


</div>
</div>