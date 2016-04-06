<ul class="nav navbar-nav">
	<li>
		<a href="{!! url('logout') !!}">Logout</a>
	</li>
	<li>
		<a href="#">Profile</a>
	</li>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown<strong class="caret"></strong></a>
		<ul class="dropdown-menu">
			<li>
				<a href="#">Action</a>
			</li>
			<li>
				<a href="#">Another action</a>
			</li>
			<li>
				<a href="#">Something else here</a>
			</li>
			<li class="divider">
			</li>
			<li>
				<a href="#">Separated link</a>
			</li>
			<li class="divider">
			</li>
			<li>
				<a href="#">One more separated link</a>
			</li>
		</ul>
	</li>
</ul>
<form class="navbar-form navbar-left" role="search">
	<div class="form-group">
		<input type="text" class="form-control">
	</div> 
	<button type="submit" class="btn btn-default">
		Submit
	</button>
</form>