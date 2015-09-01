var app = angular.module('HermesBundleApp', ['ngMaterial', 'ngRoute'], '');

app.config(['$routeProvider', '$interpolateProvider',
    function($routeProvider, $interpolateProvider) {
        $routeProvider.
            when('/start', {
                templateUrl: 'views/start.html'
            }).
            when('/email/:emailId', {
                templateUrl: 'views/emailDetails.html',
                controller: 'EmailDetailsCtrl'
            }).
            otherwise({
                redirectTo: '/start'
            });

        $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
    }]);

app.controller('AppCtrl', ['$scope', '$mdSidenav', function($scope, $mdSidenav){
    $scope.toggleSidenav = function(menuId) {
        $mdSidenav(menuId).toggle();
    };
}])

    .controller('InboxListCtrl', ['$scope', 'MessageRepository', function($scope, MessageRepository) {
        MessageRepository.promise.success(function () {
            $scope.emails = MessageRepository.getMessages();
        });
    }])

    .controller('EmailDetailsCtrl', function($scope, $routeParams, $location, MessageRepository){
        $scope.email_id = $routeParams.emailId;
        emailData = MessageRepository.getMessages().filter(function(email) {
            return email._id === $scope.email_id;
        });
        if (emailData.length !== 1) {
            $location.path('/start');
        }

        $scope.emailData = emailData[0];
    })

    .directive("htmlViewer", function() {
        return {
            restrict: "A",
            link: function (scope,element) {
                iframe = element[0];

                function refreshIframe() {
                    iframe.contentWindow.document.open();
                    if (scope.visor === 'text') {
                        iframe.contentWindow.document.write(scope.emailData.content.text);
                    } else {
                        iframe.contentWindow.document.write(scope.emailData.content.html);
                    }
                    iframe.contentWindow.document.close();
                }

                scope.$watch('visor', refreshIframe);

                iframe.onload = function () {
                    iframe.style.height = '0px';
                    iframe.style.height = iframe.contentWindow.document.body.scrollHeight + 'px';
                };
            }
        }
    })

    .service('MessageRepository', ['$http', 'MessageParser', function($http, MessageParser) {
        var messages = [];

        var promise = $http.get('messages').success(function (data) {
            var len = data.length;
            for (var i = 0; i < len; i++) {
                messages.push(MessageParser.parseMessage(data[i]));
            }
        });

        return {
            promise: promise,
            getMessages: function () {
                return messages;
            }
        };
    }])

    .service('MessageParser', function () {
        return {
            'parseMessage': function (message) {
                var email = {
                    '_id': message.id,
                    'content': {}
                };
                var mp = new MimeParser();

                mp.onheader = function (node) {
                    email.dateReceived = 1433688138;
                    email.subject = node.headers['subject'][0].value;
                    email.fromEmail = node.headers['from'][0].value[0].address;
                    email.fromName = node.headers['from'][0].value[0].name;
                };

                mp.onbody = function (node, chunk) {
                    email.content.text = String.fromCharCode.apply(null, chunk);
                    email.content.html = String.fromCharCode.apply(null, chunk);
                };

                mp.end(message.message);

                return email;
            }
        };
    });
