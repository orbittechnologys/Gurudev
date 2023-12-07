/* animations are from:
 * https://daneden.github.io/animate.css/
 */
var __fade_in = ' animated fadeInRight';

var __fade_out = ' animated fadeOutRight';

var __fadeL_in = ' animated fadeInLeft';

var __fadeL_out = ' animated fadeOutLeft';


var Stepzation = function(elem) {
    var _this = this;
    window.btn = "next"

    checkCounter(0, '.nav-item .current_step.active');

    var total_question = $("#total_question_count").text();
    var persentage = (1 / total_question) * 100;
    $("#process_quiz").css("width", persentage + "%");


    _this.db = {};

    _this.elem = elem;
    _this.steps = elem.querySelectorAll('.step-by-step-step');

    /**
     * Initializer
     *
     * Runs at instantiation.
     */
    _this.init = function() {
        for (var i = 0; i < _this.steps.length; i++) {

            var step = _this.steps[i];

            var step_prev_btn1 = step.querySelector('[data-type="prev1"]');
            var step_next_btn1 = step.querySelector('[data-type="next1"]');


            if (step_prev_btn1 != null) {

                step_prev_btn1.addEventListener('click', function(e) {
                    _this.previous_step();
                });
            }

            if (step_next_btn1 != null) {

                step_next_btn1.addEventListener('click', function(e) {
                    _this.next_step();
                });
            }



            step.setAttribute('data-active', '0');
            step.setAttribute('data-step-id', i);


        }
    };



    /*** Will start the setup.  */
    _this.start = function() {
        _this.activate_step(_this.steps[0]);
        updateCurrentTabCounts();
    };

    /*** Get the ID of the current step. **  @return Int | null  */
    _this.get_current_step_id = function() {
        for (var i = 0; i < _this.steps.length; i++) {
            var step = _this.steps[i];

            if (step.getAttribute('data-active') == '1')
                return parseInt(step.getAttribute('data-step-id'));
        }

        return null;
    };

    /***  Make the setup go to the next step. */
    _this.next_step = function() {
        window.btn = "next"

        var current_id = _this.get_current_step_id();

        checkCounter(current_id + 1, this);

        var persentage = ((current_id + 2) / total_question) * 100;
        $("#process_quiz").css("width", persentage + "%");

        //alert($('.question_counter').html())
        $('.question_counter').html(current_id + 2)
        if (current_id == null)
            return;

        var errors = [];

        if (typeof _this.next_step_action != 'undefined') {
            if (_this.next_step_action != null && _this.next_step_action) {
                errors = _this.next_step_action(_this.steps[current_id]);
            }
        }

        if (typeof errors == 'undefined')
            errors = [];

        if (errors.length > 0) {
            for (var i = 0; i < errors.length; i++) {
                /* Making the error handler none-proprietary by
                 * making it possible for other developers to create a custom
                 * error handler.
                 */
                if (typeof _this.handle_error != 'undefined') {
                    if (_this.handle_error != null && _this.handle_error) {
                        _this.handle_error(errors[i]);
                    }
                }
            }

            return;
        }

        var next_id = current_id + 1;

        if (next_id >= _this.steps.length) {
            /* Making the finish action none-proprietary by
             * making it possible for other developers to create custom
             * finish actions.
             */
            if (typeof _this.handle_finish != 'undefined') {
                if (_this.handle_finish != null && _this.handle_finish) {
                    _this.handle_finish(_this.steps[current_id]);
                }
            }
            //_this.deactivate_step(_this.steps[current_id]);
        } else {
            _this.activate_step(_this.steps[next_id]);
        }
        updateCurrentTabCounts();
    };

    /*** Make the setup go to the previous step. */
    _this.previous_step = function() {
        window.btn = "prev"
        updateCurrentTabCounts();
        var current_id = _this.get_current_step_id();
        $('.question_counter').html(current_id)

        checkCounter(current_id - 1, this);

        if (current_id == null)
            return;

        var prev_id = current_id - 1;

        var persentage = (current_id / total_question) * 100;

        $("#process_quiz").css("width", persentage + "%");

        _this.activate_step(_this.steps[prev_id]);
    };



    /*-------------------------- Save Next and Mark for Review  Start --------------------------*/
    $('#saveNext').click(function() {
        $('.step-by-step-step[data-active=1] div.data_set').attr('data-mark-review', 0);
        ajaxSubmission('next');
        var nextQuIndex = parseInt($('.step-by-step-step[data-active=1]').attr('data-step-id')) + 2;
        if (nextQuIndex != 2 && $('.nav-link[data-tab-start=' + nextQuIndex + ']').length > 0) {
            afterCategoryActive($('.nav-link[data-tab-start=' + nextQuIndex + ']'))
        }

    });

    $('#markForReview').click(function() {
        $('.step-by-step-step[data-active=1] div.data_set').attr('data-mark-review', 1);
        ajaxSubmission('next');
        var nextQuIndex = parseInt($('.step-by-step-step[data-active=1]').attr('data-step-id')) + 2;
        if (nextQuIndex != 2 && $('.nav-link[data-tab-start=' + nextQuIndex + ']').length > 0) {
            afterCategoryActive($('.nav-link[data-tab-start=' + nextQuIndex + ']'))
        }
    });


    $('.finalSubmitMain').click(function() {
        clearInterval(time_update_interval);
        clearInterval(window.catTimer);
        ajaxSubmission('final_submit');

    });

    $('.finalSubmit').click(function() {
        if ($(this).hasClass('markForReview')) {
            $('.step-by-step-step[data-active=1] div.data_set').attr('data-mark-review', 1);
        } else {
            $('.step-by-step-step[data-active=1] div.data_set').attr('data-mark-review', 0);
        }
        swal({
                title: "Are you sure?",
                text: "Want to submit ..!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                cancelButtonColor: "#4da3d",
                confirmButtonText: "Yes, Submit it!",
                closeOnConfirm: false
            },
            function() {

                ajaxSubmission('final_submit');
                $('.cancel').click();
            });

    });
    /*-------------------------- Save Next and Mark for Review  End --------------------------*/


    /*----this will resume the test from last question attended from user Current Step visible Start --------------------------*/

    $('.current_step, .hidden-resume-click').click(function() {
        $('.nav-link.active').prop('disabled', true);
        activeIndex = $('.nav-link.active').attr('data-index')
        clickedIndex = $(this).attr('data-index')
        if (activeIndex > clickedIndex) return false;
        if ($(this).hasClass('hidden-resume-click')) {
            particularStep(this);
        } else {
            $('.nav-link.current_step').removeClass('active')
            ajaxSubmission("particularStep", this);
        }
    });

    /*-------------------------- Current Step visible End --------------------------*/

    /*-------------------------- Ajax Submission Start --------------------------*/
    function ajaxSubmission(slide_type, event = null) {

        $('.loading').show();
        var activeCatSpendTime = $('.nav-link[data-subject=' + subject_id + ']').attr('data-category-spend-time')
            //   console.log('catActive', catActive)
        var data_set = $('.step-by-step-step[data-active=1] div.data_set');
        var umqd_id = data_set.attr('data-user-mock-question-detail-id');
        var user_mock_detail_id = data_set.attr('data-user-mock-detail-id');
        var subject_id = data_set.attr('data-subject-id');
        var question_id = data_set.attr('data-question-id');
        var given_answer = data_set.attr('data-given-answer').trim();
        var data_marks = data_set.attr('data-marks').trim();
        var data_negetive_marks = data_set.attr('data-negetive-marks').trim();
        var correct_answer = data_set.attr('data-correct-answer').trim();
        var mark_review = parseInt(data_set.attr('data-mark-review'));
        var mark_review = (isNaN(mark_review)) ? 0 : mark_review;
        var mock_test_id = $('#mock_test_id').val();
        var marks = 0;
        var negetivemarks = 0;
        if (given_answer == correct_answer) {
            marks = data_marks;
        } else if (given_answer != '') {
            negetivemarks = data_negetive_marks;
        }
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: 'POST',
            data: {
                'id': umqd_id,
                'user_mock_detail_id': user_mock_detail_id,
                'subject_id': subject_id,
                'question_id': question_id,
                'given_answer': given_answer,
                'mark_review': mark_review,
                'mock_test_id': mock_test_id,
                'marks': marks,
                'activeCatSpendTime': activeCatSpendTime,
                'neg_marks': negetivemarks

            },
            url: data_set.attr('data-save-url'),
            dataType: 'json',
            success: function(data) {
                //console.log(data)
                $('.loading').hide();
                if (data['noSession']) {
                    return sessionCheckout();
                }

                $('.step-by-step-step[data-active=1] div.data_set').attr('data-user-mock-question-detail-id', data['second_table_id']);
                var current_id = $('.step-by-step-step[data-active=1]').attr('data-step-id');
                current_id = parseInt(current_id);

                /*------------------- Counter Updates Start  --------------------*/
                $('.answered_count').filter('[data-subject="' + subject_id + '"]').html(data['subject_qu_counter']['answered'])
                $('.not_answered_count').filter('[data-subject="' + subject_id + '"]').html(data['subject_qu_counter']['not_answered'])
                $('.not_visited_count').filter('[data-subject="' + subject_id + '"]').html(data['subject_qu_counter']['not_visited'])
                $('.marked_review_count').filter('[data-subject="' + subject_id + '"]').html(data['subject_qu_counter']['marked_review'])
                $('.answered_mark_review_count').filter('[data-subject="' + subject_id + '"]').html(data['subject_qu_counter']['answered_marked_review'])

                updateCurrentTabCounts();
                /*------------------- Counter Updates End  --------------------*/

                $($('.question_counter_div')[current_id]).removeClass('answered_mark_review_count');
                $($('.question_counter_div')[current_id]).removeClass('answered_count');
                $($('.question_counter_div')[current_id]).removeClass('not_answered_count');
                $($('.question_counter_div')[current_id]).removeClass('marked_review_count');

                if (given_answer && mark_review) {
                    $($('.question_counter_div')[current_id]).addClass('answered_mark_review_count');

                } else if (given_answer && !mark_review) {
                    $($('.question_counter_div')[current_id]).addClass('answered_count');

                } else if (!given_answer && !mark_review) {
                    $($('.question_counter_div')[current_id]).addClass('not_answered_count');

                } else if (!given_answer && mark_review) {
                    $($('.question_counter_div')[current_id]).addClass('marked_review_count');

                } else {


                }


                //console.log(umqd_id);
                //console.log($($('.question_counter_div')[current_id]).addClass('answered_count'));

                if (slide_type == 'next') {
                    _this.next_step();
                } else if (slide_type == 'particularStep') {

                    particularStep(event);
                } else if (slide_type == 'final_submit') {
                    ajaxFinalSubmission('final_submit', 1);
                }

            },
            error: function(data) {

                return closeAndReturnToMain();
                // console.log(data)
            }
        });
    }
    /*-------------------------- Ajax Submission End --------------------------*/


    function sessionCheckout() {
        swal({
                title: "Error",
                type: "error",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                cancelButtonColor: "#4da3d",
                confirmButtonText: "Restart",
                closeOnConfirm: false
            },
            function() {
                $('.cancel').click();
            });
        setTimeout(function() {
            closeAndReturnToMain();
        }, 5000);
    }

    var time_update_interval = window.setInterval(function() {
        ajaxFinalSubmission('time_interval');
    }, 10000);


    function ajaxFinalSubmission(submit_type, status = 0) {
        if (status == 1) {
            $('.loading').show();
        }
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: 'POST',
            data: {
                'id': $('#spend_time').attr('data-user-mock-detail-id'),
                'question_allocation_id': $('#spend_time').attr('data-question-allocation-id'),
                'spend_time': $('#spend_time').attr('data-mock-spend-time'),
                'activeCatSpendTime': $('.nav-link.active ').attr('data-category-spend-time'),
                'activeCat': $('.nav-link.active ').attr('data-subject'),
                'status': status,
            },
            url: $('#spend_time').attr('data-mock-update-url'),
            dataType: 'json',
            success: function(data) {
                //console.log(data);

                if (status == 1) {
                    $('.loading').hide();
                    clearInterval(time_update_interval);
                    clearInterval(window.catTimer);
                    $(".time_taken").text(data.qu_counter['totalTimeTaken']);
                    var dataRes = data.qu_counter
                    $(".result_counter.answered_count").text(data.qu_counter['answered']);
                    $(".result_counter.not_answered_count").text(data.qu_counter['not_answered']);
                    $(".result_counter.marked_review_count").text(data.qu_counter['marked_review']);
                    $(".result_counter.answered_mark_review_count").text(data.qu_counter['answered_marked_review']);
                    $(".result_counter.not_visited_count").text(data.qu_counter['not_visited']);
                    $(".total_questions").text(dataRes['total_qu_count']);
                    $(".attended_questions").text(dataRes['attended_question']);
                    $(".correct_questions").text(dataRes['right_answer']);
                    $(".negative_questions").text(dataRes['negetive_count']);
                    $(".wrong_questions").text(dataRes['wrong_answer']);
                    $(".total_marks").text(dataRes['total_marks']);
                    $(".final_marks").text(dataRes['final_marks']);
                    $(".obt_marks").text(dataRes['obtained_marks']);
                    $(".negative_marks").text(dataRes['negative_marks']);

                    var persentage = parseInt(dataRes['final_marks'] / dataRes['total_marks'] * 100);
                    persentage = (persentage > 0) ? persentage : 0;

                    chartDisplay(persentage);

                    $('#ResultModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $("#ResultModal").modal().show();

                    setTimeout(function() {
                        closeAndReturnToMain();
                    }, 30000);

                }

            },
            error: function(data) {

                return sessionCheckout();
                // console.log(data)
            }
        });
    }

    $('#closeAndReturnToMain').click(function() {
        closeAndReturnToMain();
    });

    function closeAndReturnToMain() {

        self.close();
    }


    function particularStep(event) {

        $('.nav-link.current_step').removeClass('active')
        $(event).addClass('active')
        window.btn = "next"
        var current_id = parseInt($(event).attr('data-tab-start')) - 2;
        var activeCat = $('.nav-link[data-subject=' + $(event).attr("data-subject") + ']')
        $('.current_step').attr('data-tab-start')
        checkCounter(current_id + 1, event);
        if ($(event).hasClass('question_counter_div')) {
            activeCat = $('.nav-link.active')
        }
        afterCategoryActive(activeCat);

        $('.question_counter').html(current_id + 2)
        if (current_id == null)
            return;

        var errors = [];

        if (typeof _this.next_step_action != 'undefined') {
            if (_this.next_step_action != null && _this.next_step_action) {
                errors = _this.next_step_action(_this.steps[current_id]);
            }
        }

        if (typeof errors == 'undefined')
            errors = [];

        if (errors.length > 0) {
            for (var i = 0; i < errors.length; i++) {
                if (typeof _this.handle_error != 'undefined') {
                    if (_this.handle_error != null && _this.handle_error) {
                        // console.log('error',errors[i])
                        _this.handle_error(errors[i]);
                    }
                }
            }
            return;
        }

        var next_id = current_id + 1;

        if (next_id >= _this.steps.length) {
            /* Making the finish action none-proprietary by
             * making it possible for other developers to create custom
             * finish actions.
             */
            if (typeof _this.handle_finish != 'undefined') {
                if (_this.handle_finish != null && _this.handle_finish) {
                    _this.handle_finish(_this.steps[current_id]);
                }
            }
            //_this.deactivate_step(_this.steps[current_id]);
        } else {
            _this.activate_step(_this.steps[next_id]);
        }
        updateCurrentTabCounts();
    }

    function checkCounter(current_id, event) {

        $('.question_counter_div').removeClass('activeQuestion');
        $($('.question_counter_div')[current_id]).addClass('activeQuestion');


        if ((current_id + 1) == $('.question_counter_div').length) {
            $('.finalSubmit').removeClass('hidden');
            $('#markForReview, #saveNext').addClass('hidden');
        } else {
            $('.finalSubmit').addClass('hidden');
            $('#markForReview, #saveNext').removeClass('hidden');
        }

        var active_tab_array = [];
        for (i = 0; i < $('.nav-link.current_step').length; i++) {
            active_tab_array[i] = $($('.nav-link.current_step')[i]).attr('data-tab-start');
        }


        var question_length = $('.question_counter_div').length;
        var start_hide = '';
        var end_hide = '';
        if ($(event).parent('.nav-item').length) {
            console.log('active_tab_array first if');
            start_hide = $(event).parent().next('.nav-item').children('a').attr('data-tab-start');
            end_hide = $(event).attr('data-tab-start');

            start_hide = start_hide - 1;
            end_hide = end_hide - 2;

            currentSubjectQuestions(event, question_length, start_hide, end_hide);

        } else {
            var total_tab_length = $('.nav-link.current_step').length;

            for (i = 0; i < active_tab_array.length; i++) {
                if (active_tab_array[i] <= current_id + 1 && active_tab_array[i + 1] > current_id + 1) {
                    console.log('active_tab_array');
                    end_hide = active_tab_array[i];
                    start_hide = active_tab_array[i + 1];

                    end_hide = end_hide - 2;
                    start_hide = start_hide - 1;

                    $('.nav-link.current_step').removeClass('active');
                    $('.nav-link.current_step[data-tab-start=' + active_tab_array[i] + ']').addClass('active');

                    currentSubjectQuestions(event, question_length, start_hide, end_hide);
                } else if (active_tab_array[i] <= current_id + 1 && i == (total_tab_length - 1)) {
                    end_hide = active_tab_array[i];
                    console.log('active_tab_array else ');
                    end_hide = end_hide - 2;
                    start_hide = question_length;
                    $('.nav-link.current_step').removeClass('active');
                    $('.nav-link.current_step[data-tab-start=' + active_tab_array[i] + ']').addClass('active');

                    currentSubjectQuestions(event, question_length, start_hide, end_hide);
                    //  alert();
                }
                //console.log($('.nav-link.current_step[data-tab-start=' + active_tab_array[i] + ']'));
            }
        }


    }

    function currentSubjectQuestions(event, question_length, start_hide, end_hide) {

        for (i = 0; i < question_length; i++) {
            if (start_hide <= i || end_hide >= i) {
                $($('.question_counter_div')[i]).addClass('hidden');
            } else {
                $($('.question_counter_div')[i]).removeClass('hidden');
            }
        }
    }


    function updateCurrentTabCounts() {
        subject = $('.current_step[class*="active"]').attr("data-subject");



        $('.final_answered_count').html($('.answered_count').filter('[data-subject="' + subject + '"]').html());
        $('.final_not_answered_count').html($('.not_answered_count').filter('[data-subject="' + subject + '"]').html());
        $('.final_not_visited_count').html($('.not_visited_count').filter('[data-subject="' + subject + '"]').html());
        $('.final_marked_review_count').html($('.marked_review_count').filter('[data-subject="' + subject + '"]').html());
        $('.final_answered_mark_review_count').html($('.answered_mark_review_count').filter('[data-subject="' + subject + '"]').html());
        // console.log(subject);
    }



    /**
     * Activate a single step,
     * will deactivate all other steps.
     */
    _this.activate_step = function(step) {
        //console.log('active step',step)

        for (var i = 0; i < _this.steps.length; i++) {
            var _step = _this.steps[i];
            //  console.log('active  loop step',_step)
            if (_step == step) {
                continue;
            }


            _this.deactivate_step(_step);
        }
        step.className = step.className.replace(__fadeL_out, '');
        step.className = step.className.replace(__fade_out, '');
        if (window.btn == "next") {
            step.className += __fade_in;
        } else {
            step.className += __fadeL_in;
        }
        $(step).removeClass('fadeOutRight')
        $(step).removeClass('fadeOutRight')
        step.setAttribute('data-active', '1');
    };

    /**
     * Deactivate a single step.
     */
    _this.deactivate_step = function(step) {
        if (step.className.indexOf(__fade_in) > -1) {
            step.className = step.className.replace(__fade_in, '');
            step.className = step.className.replace(__fadeL_in, '');
            if (window.btn == "next") {
                step.className += __fade_out;
            } else {
                step.className += __fadeL_out;
            }

        }
        if (step.className.indexOf(__fadeL_in) > -1) {
            step.className = step.className.replace(__fade_in, '');
            step.className = step.className.replace(__fadeL_in, '');
            if (window.btn == "next") {
                step.className += __fade_out;
            } else {
                step.className += __fadeL_out;
            }

        }
        step.setAttribute('data-active', '0');
    }



    _this.init();
};
