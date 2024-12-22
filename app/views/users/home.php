<?php
session_start();
$data = $_SESSION;
// print_r($data);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>

    <style>
        .header {
            background-color: #C65BCF;
            position: sticky;
            z-index: 2;
            top: 0;
        }

        .main-container {
            height: 90%;
        }

        .search-div {
            height: 15%;
            top: 0;
            position: sticky;
            z-index: 1;
        }

        .message-header {
            top: 0;
            position: sticky;
            z-index: 1;
        }

        .friends-list {
            scrollbar-width: 20px;
            height: 85%;
        }

        .friends-list li {

            cursor: pointer;
        }

        .friends-list li:hover {
            background-color: #C65BCF;
        }

        .friends-list::-webkit-scrollbar {
            width: 8px;
            /* Width of the scrollbar */
        }

        .friends-list::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #28a745, #3ccf4e);
            border-radius: 10px;
        }

        .friends-list::-webkit-scrollbar-thumb:hover {
            background: #218838;
        }

        .friends-list::-webkit-scrollbar-track {
            background: #f0f0f0;
            border-radius: 5px;
        }


        div[style*="overflow-y: auto;"]::-webkit-scrollbar {
            width: 8px;
        }

        div[style*="overflow-y: auto;"]::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #28a745, #3ccf4e);
            border-radius: 10px;
        }

        div[style*="overflow-y: auto;"]::-webkit-scrollbar-thumb:hover {
            background: #218838;
        }

        div[style*="overflow-y: auto;"]::-webkit-scrollbar-track {
            background: #f0f0f0;
            border-radius: 10px;
        }


        .message-bubble {
            border-radius: 20px;
            padding: 4px 10px;
            max-width: 60%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .message-bubble:hover {
            transform: scale(1);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }


        .message-bubble.sender {
            background: linear-gradient(135deg, #28a745, #3ccf4e);
            color: #fff;
            align-self: flex-end;
        }

        .message-bubble.receiver {
            background: #e9ecef;
            color: #333;
            align-self: flex-start;
        }

        .message-text {
            font-size: 16px;
            line-height: 1.5;
        }

        .message-meta {
            color: #747d86;
            margin-top: 4px;
            font-size: 12px;
        }
    </style>
</head>

<body ng-app="app" ng-controller="controller" class="bg-light vh-100">
    <!-- Header -->
    <div class="container-fluid header text-white py-2 bg-dark h-20">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="ms-3">{{page}}</h3>
            <div class="me-3 btn-group" role="group">
                <button type="button" class="btn btn-light btn-sm">
                    <i class="bi bi-bell"></i>
                </button>
                <button type="button" class="btn btn-light btn-sm">
                    <i class="bi bi-person-circle"></i>
                </button>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-gear"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li class="dropdown-item p-0">
                            <button type="button" class="w-100 btn btn-light border-0" ng-click="logout()">Logout</button>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <div class="d-flex main-container">
        <!-- Friend List -->
        <div class="friend-list-area px-3 bg-white" style="width: 30%; height:100%; border-right: 1px solid #ccc;">
            <div class="bg-white search-div pb-2">
                <div>
                    <h3>Friends</h3>
                </div>
                <input type="text" class="form-control" placeholder="Search friends...">
            </div>
            <ul class="list-group friends-list" style="overflow-y: auto;">
                <li ng-repeat="friend in friends" class="list-group-item friend-item me-2"  ng-click="changeMessageArea(friend)">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="fw-bold">{{friend.name}}</div>
                        <span class="badge bg-primary rounded-pill">14</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-start mt-1">
                        <div class="me-2 text-truncate">Lorem ipsum dolor sit, amet consectetur adipisicing elit.</div>
                        <div class="fw-light text-nowrap">10:20 AM</div>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Messages Section -->
        <div ng-show="!messageArea" ng-class="d-flex justify-content-center text-center w-100">
            <h5 class="text-muted">Select a friend to view messages</h5>
        </div>


        <div ng-show="messageArea" class="messages bg-white p-3 d-flex flex-column flex-grow-1" style="height: 100%;">

            <div class="message-header">
                <h5 class="fw-bold">{{selectedFriend.name}}</h5>
            </div>

            <div class="message-container" style="overflow-y: auto;">
                <div ng-repeat="message in messages" class=" flex-grow-1 overflow-auto">
                    <div class="d-flex flex-column m-3">
                        <div class="message-bubble"
                            ng-class="{'sender': message.isSender, 'receiver': !message.isSender}">
                            <div class="message-text">
                                {{message.messageText}}
                            </div>
                        </div>
                        <div class="message-meta" ng-class="{'ms-auto':message.isSender,'me-auto':!message.isSender}">
                            {{message.time}} | {{message.date}}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Message Input Box -->
            <div class="input-group mt-auto ps-10">
                <input type="text" class="form-control" ng-model="message" id="message-input" placeholder="Type a message..." />
                <button class="btn btn-primary" id="send-button" ng-click="sendMessage()">
                    <i class="bi bi-send"></i>
                </button>
            </div>
        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">

    <script>
        // Handle friend item click
        // document.querySelectorAll('.friend-item').forEach(item => {            
        //     item.addEventListener('click', function () {
        //     // console.log('sesd');

        //     });
        // });

        var app = angular.module('app', []);

        app.controller('controller', function($scope, $http, $httpParamSerializerJQLike) {
            $scope.page = 'Messages';

            $scope.messageArea = '';
            $scope.friends = '';
            $scope.message = '';

            $scope.getFriends = function() {
                $http.get('http://localhost/projects/chatApp/index.php?getFriends')
                    .then(function(response) {
                        console.log(response.data);

                        $scope.friends = response.data;
                        console.log("Friends data retrieved successfully:", response.data);
                    })
                    .catch(function(error) {
                        console.error("Error retrieving friends data:", error);
                    });
            };

            $scope.getFriends();


            $scope.changeMessageArea = function(friend) {
                $scope.messageArea = true;
                $scope.selectedFriend = friend;

                $scope.messages = $scope.getMessages($scope.selectedFriend);
                console.log('List item clicked!', friend);
            };

            $scope.getMessages = function(friend) {
                console.log('getmessages');

                $http({
                    method: "GET",
                    url: "http://localhost/projects/chatApp/index.php?getMessages",
                    params: {
                        'friendId': friend.id
                    }
                }).then(function(response) {
                    $scope.messages = response.data;
                }).catch(function(error) {

                });
            }

            $scope.sendMessage = function() {
                console.log($scope.message);
                console.log($scope.selectedFriend.id);

                // if(message.sizeof)
                console.log($scope.message.length);
                if ($scope.message.length > 0) {
                    $http({
                        method: 'POST',
                        url: 'http://localhost/projects/chatApp/index.php?insertMessage',
                        data: $httpParamSerializerJQLike({
                            'message': $scope.message,
                            'recepientId': $scope.selectedFriend.id
                        }),
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        }
                    }).then(function(response) {
                        $scope.message = '';
                        console.log("Message sent successfully:", response.data);
                        $scope.messages = $scope.getMessages($scope.selectedFriend);
                    }).catch(function(error) {
                        console.error("Error sending message:", error);
                    });
                }
            }


            $scope.logout = function() {
                // $http({
                //     method:'GET',
                //     url: 'http://localhost/projects/chatApp/index.php?logout'
                // });
                window.location.href = 'http://localhost/projects/chatApp/index.php?logout';
            }
        });
    </script>
</body>

</html>