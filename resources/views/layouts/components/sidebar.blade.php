<aside class="main-sidebar  sidebar-dark-primary elevation-4" style="z-index: 10">
	<a href="#" class="brand-link">
	<img src="image/rooster.png" alt="AdminLTE Logo" class="brand-image "
		style="opacity: .8">
	<span class="brand-text font-weight-light">Finance SOA</span>
	</a>
	<div class="sidebar">
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
			<img  src="{{Auth::user()->photo == null ? 'image/profile.png' : 'image/profile/'. Auth::user()->photo}}" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
			<a href="#" class="d-block">{{Auth::user()->email}}</a>
		
			</div>
		</div>


		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
			
		

			<li class="nav-item">
				<router-link to="/profile" class="nav-link ">
					<i class="nav-icon fas fa-user "></i>
					<p>Profile</p>
				</router-link>
			</li>

            <li class="nav-item">
				<router-link to="/soa" class="nav-link ">
					<i class="nav-icon fas fa-file "></i>
					<p>Accounts &nbsp; </p>
				
					<span class="badge badge-danger right">	{{$importCount}}</span>
				</router-link>
			</li>

            <li class="nav-item">
				<router-link to="/arena" class="nav-link ">
					<i class="nav-icon fab fa-angular"></i>
					<p>Arena</p>

					<span class="badge badge-danger right">{{$arenaCount}}</span>
				</router-link>
			</li>

			<li class="nav-item">
				<router-link to="/summary" class="nav-link ">
					<i class="nav-icon fas fa-book-reader"></i>
					<p>Summary Report</p>
				</router-link>
			</li>

			
			

			@if(Auth::user()->type === 'tech' || Auth::user()->type === 'admin')
                <li class="nav-item has-treeview menu-close">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-cog"></i>
                    <p>
                        Management
                        <i class="right fas fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <router-link to="/users" class="nav-link">
                                <i class="fa fa-users-cog "></i>
                                <p>User</p>
                            </router-link>
                        </li>
						

						<li class="nav-item">
							<router-link to="/teams" class="nav-link ">
								<i class="fa fa-users"></i>
								<p>Teams</p>
							</router-link>
						</li>
					
						<li class="nav-item">
							<router-link to="/detailsconfig" class="nav-link ">
								<i class="fa fa-cogs"></i>
								<p>Configuration</p>
							</router-link>
						</li>
					
						
						
                    </ul>
                </li>
            @endif
			@if(Auth::user()->type === 'tech')
				<li class="nav-item">
					<router-link to="/activitylogs" class="nav-link ">
						<i class="nav-icon  fas fa-cogs"></i>
						<p>Activity logs</p>
					</router-link>
				</li>
			@endif

			</ul>
		</nav>
	</div>
</aside>
