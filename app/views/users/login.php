<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            /* --app-gradient-background: linear-gradient(180deg, rgba(81, 255, 21, 1) 0%, rgba(24, 255, 82, 1) 73%, rgba(255, 255, 255, 1) 100%);
            --app-base-color: #51ff15; */
            --app-gradient-background: #f0f0f0;
        }

        .content-container {
            background: var(--app-gradient-background);
            border-radius: 0px 100px 100px 0px;
            box-shadow: 0px 2px 5px #aea4a4;
        }

        .form-area {
            border-radius: 100px 0px 0px 100px;
            box-shadow: 0px 2px 5px #aea4a4;
        }

        .submit-btn {
            background: green;
            border-radius: 20px;
            color: white;
        }

        .form-container {
            width: 50%;
            /* height: 55%; */
            background-color: #fff;
            /* border: 2px solid black; */
            padding: 40px 55px;
            border-radius: 40px;
            box-shadow: 0px 2px 16px 12px #f0f0f0;
        }

        .title {
            color: var(--app-base-color);
        }

        .form-container {
            transition: transform 0.5s;
            transform-style: preserve-3d;
        }

        .form-container.rotated {
            transform: rotateY(360deg);
        }

        .error-text {
            color: red;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div ng-app="app" ng-controller="controller" class="d-flex vh-100">
        <div class="container w-50 bg-secondary h-100 content-container">

        </div>
        <div class="d-flex align-items-center justify-content-center  w-50 h-100 form-area">
            <div class="d-flex flex-column form-container" ng-class="{'rotated': !isLogin}">
                <h1 class="my-4 title">{{page}}</h1>
                <form name="userForm" action="{{formAction}}" method="POST" ng-submit="submitUserForm()" novalidate>
                    <div class="mb-3">
                        <input type="text" id="uname" name="uname" ng-model="uname" class="form-control" ng-class="{'is-invalid':!isLogin&&invalidName || !isLogin&&uNameExists}" ng-keyup="!isLogin && validateName()" placeholder="Enter your username" required>
                        <div class="invalid-feedback error-text" ng-show="userForm.uname.$touched && userForm.uname.$invalid">
                            Username is required.
                        </div>
                        <span ng-if="invalidName" class="error-text">User name must contains atleast 3 letters</span>
                        <span ng-if="uNameExists" class="error-text">User name already taken</span>
                    </div>
                    <div class="mb-3">
                        <input type="password" id="password" ng-model="password" name="password" class="form-control" placeholder="Enter your password" required>
                    </div>
                    <div class="mb-3" ng-show="!isLogin">
                        <input type="password" id="rePassword" ng-model="rePassword" ng-keyup="validatePassword()" name="rePassword" class="form-control" ng-class="{'is-invalid': !passwordsMatch}" placeholder="Re-enter your password" required>
                        <span ng-if="!passwordsMatch" class="error-text">Passwords do not match</span>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" ng-disabled="(isLogin && (!uname || !password)) ||(!isLogin&&(!passwordsMatch || uNameExists || invalidName || userForm.$invalid))  ">{{ isLogin ? 'Submit' : 'Create an account' }}
                        </button>
                    </div>
                </form>
                <div ng-show="isLogin" class="mt-4">
                    <p class="fw-light">Not have an account? <a href="" ng-click="signUp()">Sign up</a></p>
                </div>
                <div ng-show="!isLogin" class="mt-4">
                    <p class="fw-light">Already have an account? <a href="" ng-click="login()">Sign in</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var app = angular.module('app', []);

        app.controller('controller', function($scope, $http) {
            $scope.page = 'LOGIN';
            $scope.isLogin = true;
            $scope.passwordsMatch = true;
            $scope.availableUsers;
            $scope.uNameExists = false;
            $scope.invalidName = false;
            $scope.formAction = "../../../index.php?login";

            $scope.setFormAction = function(isLogin) {
                $scope.formAction = isLogin ? "../../../index.php?login" : "../../../index.php?signUp";
            };

            $scope.signUp = function() {
                $scope.uname = "";
                $scope.password = "";
                $scope.page = "SIGN UP";
                $scope.isLogin = false;
                $scope.getUserNames();
                $scope.setFormAction();
            }

            $scope.login = function() {
                $scope.page = "LOGIN";
                $scope.isLogin = true;
                $scope.setFormAction();
            }

            $scope.validatePassword = function() {
                $scope.passwordsMatch = $scope.password === $scope.rePassword;
                console.log($scope.passwordsMatch);
                console.log($scope.rePassword);

            };

            $scope.getUserNames = function() {
                $http({
                    method: "GET",
                    url: "http://localhost/projects/chatApp/index.php?getUserNames"
                }).then(function(response) {
                    $scope.availableUsers = response.data;
                    console.log($scope.availableUsers);
                });
            };

            $scope.validateName = function() {
                // console.log($scope.uname);
                if ($scope.uname.length < 3) {
                    $scope.invalidName = true;
                    $scope.uNameExists = false;
                } else if ($scope.availableUsers.includes($scope.uname)) {
                    $scope.uNameExists = true;
                    $scope.invalidName = false;
                } else {
                    $scope.invalidName = false;
                    $scope.uNameExists = false;
                }
            }

            $scope.submitUserForm = function() {
                if (isLogin) {
                    window.location.href = "http://localhost/projects/chatApp/index.php?login"
                } else {
                    window.location.href = 'http://localhost/projects/chatApp/index.php?signUp';
                }
            }


        });
    </script>
</body>

</html>