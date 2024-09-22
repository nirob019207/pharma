<nav id="sidebar">
    <!-- Sidebar Header-->
    <div class="sidebar-header d-flex align-items-center">
        <div class="avatar"><img src="img/avatar-6.jpg" alt="..." class="img-fluid rounded-circle"></div>
        <div class="title">
            <h1 class="h5">CBST Pharma</h1>
            
        </div>
    </div>
    <!-- Sidebar Navigation Menus--><span class="heading">Main</span>
    <ul class="list-unstyled">
      
        
        @role('admin')
        <li class="active"><a href="{{ route('dashboard') }}"> <i class="icon-home"></i>Home </a></li>
        <li><a href="{{ route('users.index') }}"> <i class="icon-contract"></i>Users</a></li>
        <li><a href="{{ route('permissions.index') }}"> <i class="icon-contract"></i>Permissions</a></li>
        <li><a href="{{ route('roles.index') }}"> <i class="icon-contract"></i>Roles</a></li>
        <li><a href="{{ route('pharmacies.index') }}"> <i class="icon-contract"></i>Pharmacies</a></li>
        <li><a href="{{ route('companies.index') }}"> <i class="icon-contract"></i>Company</a></li>

<li><a href="{{ route('generics.index') }}"> <i class="icon-contract"></i>Generic</a></li>
        <li><a href="{{ route('medicines.index') }}"> <i class="icon-contract"></i>Medicines</a></li>
        <li><a href="{{ route('stocks.index') }}"> <i class="icon-contract"></i>Stocks</a></li>
        <li><a href="{{ route('sales.index') }}"> <i class="icon-contract"></i>Sales</a></li>

       

        @endrole

        @role('branch')
        <li><a href="{{ route('brachStock.index') }}"> <i class="icon-contract"></i>Branch Stock</a></li>
        <li><a href="{{ route('sales.index') }}"> <i class="icon-contract"></i>Sales</a></li>
        @endrole
        
       
    </ul>
</nav>
