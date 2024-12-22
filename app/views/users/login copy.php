<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-primary bg-gradient d-flex justify-content-center align-items-center vh-100">
    <div ng-app="app" ng-controller="controller" class="bg-white p-4 rounded shadow-lg" style="width: 100%; max-width: 400px;">
        <h1 class="text-center mb-4 text-primary">LOGIN</h1>
        <form action="../../../index.php?login" method="POST">
            <div class="mb-3">
                <label for="uname" class="form-label">Enter Username</label>
                <input type="text" id="uname" name="uname" ng-model="uname" class="form-control" placeholder="Enter your username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Enter Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
        <!-- <h2 class="text-center mt-4 text-secondary">{{uname}}</h2> -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>

        var app = angular.module('app',[]);

        app.controller('controller',function($scope){
            // $scope.page = 'L'
        });
    </script>
</body>
</html>
