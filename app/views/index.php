<!DOCTYPE html>
<html ng-app="produceMinder">
<head>
	<title>Produce Minder</title>
	<script type="text/javascript" src="/js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="/js/angular.min.js"></script>
	<script type="text/javascript" src="/js/angular-route.min.js"></script>
	<script type="text/javascript" src="/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body>
	<header>
		<h1>Produce Minder v0.1.0</h1>
	</header>
	<main class="container">
		<div class="row" id="page-wrap">
			<nav id="accordion" class="col-xs-12 col-sm-2">
				<ul>
					<li><h3><span class="glyphicon glyphicon-dashboard"></span>Dashboard</h3></li>
					<li>
						<h3><span class="glyphicon glyphicon-stats"></span>Stats</h3>
						<ul>
							<li><a href="#">Weekly</a></li>
							<li><a href="#">Monthly</a></li>
							<li><a href="#">Daily</a></li>
							<li><a href="#">Yearly</a></li>
						</ul>
					</li>
					<!-- we will keep this LI open by default -->
					<li>
						<h3><span class="glyphicon glyphicon-list-alt"></span>Inventory</h3>
						<ul>
							<li><a href="#">Fridge</a></li>
							<li><a href="#">Freezer</a></li>
							<li><a href="#">Shelf</a></li>
						</ul>
					</li>
					<li>
						<h3><span class="glyphicon glyphicon-book"></span>Recipes</h3>
					</li>
				</ul>
			</nav>
			<section id="content" class="col-xs-12 col-sm-10">
				<ng-view></ng-view>
			</section>
		</div>
		<footer></footer>
	</main>
	<style type="text/css">
		body, html, ul {
			margin: 0;
			padding: 0;
		}
		body > * {
			width: 100%;
		} 
		.container {
			margin: 0;
			width: 100%;
		}
		#accordion {
			background: #004050;
			color: white;
			padding: 0;
			height: calc(100vh - 50px);
			/*Some cool shadow and glow effect*/
			box-shadow: 
				0 5px 15px 1px rgba(0, 0, 0, 0.6), 
				0 0 200px 1px rgba(255, 255, 255, 0.5);

		}
		 body > header h1 {
		 	background: #004050;
			color: white;
			padding: 5px;
			margin: 0;
		 }
		/*heading styles*/
		#accordion h3 {
			font-size: 12px;
			margin: 0;
			line-height: 34px;
			padding: 0 10px;
			cursor: pointer;
			/*fallback for browsers not supporting gradients*/
			background: #003040; 
			background: linear-gradient(#003040, #002535);
		}
		/*heading hover effect*/
		#accordion h3:hover {
			text-shadow: 0 0 1px rgba(255, 255, 255, 0.7);
		}
		/*iconfont styles*/
		#accordion h3 span {
			font-size: 16px;
			margin-right: 10px;
		}
		/*list items*/
		#accordion li {
			list-style-type: none;
		}
		/*links*/
		#accordion ul ul li a {
			color: white;
			text-decoration: none;
			font-size: 11px;
			line-height: 27px;
			display: block;
			padding: 0 15px;
			/*transition for smooth hover animation*/
			transition: all 0.15s;
		}
		/*hover effect on links*/
		#accordion ul ul li a:hover {
			background: #003545;
			border-left: 5px solid lightgreen;
		}
		/*Lets hide the non active LIs by default*/
		#accordion ul ul {
			display: none;
		}
		#accordion li.active ul {
			display: block;
		}
	</style>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#accordion h3").click(function(){
			if ($(this).siblings('ul').length > 0) {
				$("#accordion ul ul").slideUp();
				//slide down the link list below the h3 clicked - only if its closed
				if(!$(this).next().is(":visible"))
				{
					$(this).next().slideDown();
				}
			}
			
		})
	});
	angular.module('produceMinder', ['ngRoute'])
		.service('apiToken', function apiTokenService() {
			this.getToken = function() {
				return window.localStorage.getItem('apiToken');
			};
			this.setToken = function(token) {
				window.localStorage.setItem('apiToken', token);
			};
		})
		.factory('authRequest', function($q,  apiToken){
			var noAuth = [
				'/login'
			];
			var noKeyReturned = [
				'/logout'
			];
			return {
				request: function(config) {
					for (var i = 0; i < noAuth.length; i++) {
						if (config.url.indexOf(noAuth[i]) !== -1) {
							return config;
						}
					}
					
					if (config.method === 'GET') {
						config.params = config.params || {};
						config.params.apiToken = apiToken.getToken();
					} else {
						config.data = config.data || {};
						config.data.apiToken = apiToken.getToken();
					}
					return config;
				}, response: function(resp) {
					for (var i = 0; i < noKeyReturned.length; i++) {
						if (resp.config.url.indexOf(noKeyReturned[i])) {
							return resp;
						}
					}
					console.log(resp);
					if (!resp.data.apiToken) {
						return $q.reject(resp);
					}
					apiToken.setToken(resp.data.apiToken);
					resp.data = resp.data.data;
					return resp;
				}
			};
		})
		.factory('user', function userFactory($http, apiToken){

			return function() {

			};
		})
		.config(function($routeProvider, $httpProvider){
			console.log('sdfsdf');
			$routeProvider
				.when('/product/:productId', {
					templateUrl: '/view/product.php',
					controller: 'ProductController'
				})
				.when('/recipe/:recipeId', {
					templateUrl: '/view/recipe.php',
					controller: 'RecipeController'
				})
				.when('/graph/:graphType', {
					templateUrl: '/view/graph.php',
					controller: 'GraphController'
				})
				.when('/cookbook', {
					templateUrl: '/view/cookbook.php',
					controller: 'CookbookController'
				})
				.when('/inventory/:location', {
					templateUrl: '/view/inventory.php',
					controller: 'InventoryController'
				})
				.when('/dashboard', {
					templateUrl: '/view/dashboard.php',
					controller: 'DashboardController'
				})
				.when('/login', {
					templateUrl: '/view/login',
					controller: 'LoginController'
				});
				$httpProvider.interceptors.push('authRequest');
		})
		.run(function run($http, $location, $rootScope){
			console.log($location.path());

			$http.get('/user')
				.success(function(){
					if (!location.path()) $location.path('dashboard');
				})
				.error(function(){
					$location.path('login');
				});
		})
		.controller('LoginController', function LoginController($scope, $http){

			$scope.email = 'danielbweiner@gmail.com';
			$scope.password = 'password123';
			$scope.register = function(){

			};
			$scope.login= function(){

				$http.post('/login', {email: $scope.email, password: $scope.password})
					.success(function(data){

					}).error(function(){
						$scope.error = "Incorrect email/password combination.";
					});
			};
		})
		.controller('DashboardController', function DashboardController($scope, $routeParams, $rootScope){
			
		})
		.controller('InventoryController', function InventoryController($scope, $routeParams, $rootScope){

		})
		.controller('CookbookController', function CookbookController($scope, $routeParams, $rootScope){

		})
		.controller('GraphController', function GraphController($scope, $routeParams, $rootScope){

		})
		.controller('RecipeController', function RecipeController($scope, $routeParams, $rootScope){

		})
		.controller('ProductController', function ProductController($scope, $routeParams, $rootScope){
			
		});
	</script>

</body>
</html>