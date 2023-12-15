 <!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
   <!-- Brand Logo -->
   <a href="{{route('admin.dashboard')}}" class="brand-link" style="text-align: center;">
      <img src="{{url('adminassets/img/logo.png')}}" alt="" >
   </a>
   <div class="sidebar"  style="clear: both;">
      <!-- Sidebar -->
      <nav class="mt-2">
         <!-- Sidebar Menu -->
         <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
            <li class="nav-item">
               <a href="{{route('admin.users')}}" class="nav-link @if($common['title']=='Users') active @endif">
                  <p>Users</p>
               </a>
            </li>
            <li class="nav-item">
               <a href="{{route('admin.slider')}}" class="nav-link @if($common['title']=='Slider') active @endif">
                  <p>Slider</p>
               </a>
            </li>
            <li class="nav-item">
               <a href="{{route('admin.plans')}}" class="nav-link @if($common['title']=='Plans') active @endif">
                  <p>Plans</p>
               </a>
            </li>
         </ul>
      </nav>
      <!-- /.sidebar-menu -->
   </div>
   <!-- /.sidebar -->
</aside>