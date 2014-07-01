<div class="panel panel-info">
	<div class="panel-heading" style="margin-bottom: 30px">Log In</div>
	<div class="row">
		<div class="col-xs-12 text-center">
			{{error}}
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6 col-xs-offset-3">
			<div class="input-group">
				<span class="input-group-addon">Email Address</span>
				<input class="form-control" type="email" placeholder="email" ng-model="email">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6 col-xs-offset-3">
			<div class="input-group">
				<span class="input-group-addon">Password</span>
				<input class="form-control" type="password" placeholder="password" ng-model="password">
			</div>
		</div>
	</div>
	<div class="row" style="margin-bottom: 30px">
		<div class="col-xs-2 col-xs-offset-5">
			<button class="btn btn-primary btn-block" ng-click="login()">Log In</button>
		</div>
	</div>
</div>