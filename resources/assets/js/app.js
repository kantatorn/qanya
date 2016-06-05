angular.module('App')

    .controller('AppCtrl', function ($scope, $timeout, $mdSidenav, $log, $translate) {

        $scope.toggleLeft = buildToggler('left');
        $scope.isOpenRight = function () {
            return $mdSidenav('left').isOpen();
        };

        function buildToggler(navID) {
            return function() {
                // Component lookup should always be available since we are not using `ng-if`
                $mdSidenav(navID)
                    .toggle()
                    .then(function () {
                        $log.debug("toggle " + navID + " is done");
                    });
            }
        }
    })


    //User Controller
    .controller('UserCtrl',function($http, $log, $window, $translate) {
        var userCtrl = this;

        userCtrl.expertiseArray = [];
        userCtrl.expertiseList = function(uuid){
            $http.post('/listExpertise',{ uuid: uuid})
            .then(function(response){
                userCtrl.expertiseArray = response;
            })
        }

        /**
         *
         */
        userCtrl.addExpertise = function()
        {
            $http.post('/addExpertise',{
                    expertise:      userCtrl.expertise,
                    expertise_body: userCtrl.expertise_body
            })
            .then(function(response){
                console.log(response);
                userCtrl.expertiseList.push("test")
            })
        }

    })


    //Question Controller
    .controller('QuestionCtrl',function($http, $log, $window, $translate) {

        var questionCtrl = this;

        // Any key code can be used to create a custom separator
        questionCtrl.keys = [188]; //Comma
        questionCtrl.tags = [];


        //Submit question
        questionCtrl.q_submit = function()
        {

            $http.post('/question', {
                                        topic:  questionCtrl.question_topic,
                                        channel:questionCtrl.question_channel,
                                        anon:   questionCtrl.question_anon,
                                        tags: questionCtrl.tags,
            })
            .then(function(response){
                console.log(response);
                /*if(response.status == 200){
                    $window.location.href = '/';
                }*/
                console.log(response.status)
            })
        }


        //Submit answer
        questionCtrl.answer_submit = function(topic_uuid)
        {
            $http.post('/answer', {
                                    topic: topic_uuid,
                                    text:   questionCtrl.answer_text
            })
            .then(function(response){
                questionCtrl.answer_text        =   null;
                questionCtrl.answerBtnStatus    =   false;
                console.log(response);
            })
        }


        //Save user expertise
        questionCtrl.userExpertiseSave = function()
        {
            console.log(questionCtrl.userExpertTopic + questionCtrl.userExpertTopicText);
        }


        //User follow question
        questionCtrl.followQuestion = function(topic_uuid)
        {
            $http.post('/followQuestion',{
                                            topic: topic_uuid
            })
            .then(function(response){

                console.log(response.data.follow_count);

                if(response.data == 0){
                    $translate('KEY_FOLLOW').then(function (translate) {
                        questionCtrl.followStatus = translate
                    });
                }else{
                    questionCtrl.followStatus = $translate('KEY_FOLLOWING');
                }
            })
        }

        //Upvote question
        questionCtrl.questionUpvote = function()
        {
            $http.post('/upvoteQuestion',{
                    topic: topic_uuid
            })
            .then(function(response){

            })
        }


        //Comment on answer
        questionCtrl.commentAnswer = function(topic_answers_uuid)
        {
            $http.post('/commentAnswer',{
                    topic: topic_answers_uuid,
                    body:   questionCtrl.answer_comment
            })
            .then(function(response){
                console.log(response);
            })
        }

    })


