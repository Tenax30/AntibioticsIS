jQuery(document).ready(function($) {
    var $form_modal = $(".main-form"),
    $form_main = $("#main-form"),
    $form_login = $form_modal.find('#sign-in'),
    $form_signup = $form_modal.find('#sign-up'),
    $form_modal_tab = $('.switcher'),
    $tab_login = $form_modal_tab.children('li').eq(0).add($form_modal_tab.children('li').eq(0).children('a')),
    $tab_signup = $form_modal_tab.children('li').eq(1).add($form_modal_tab.children('li').eq(1).children('a')),

    $enter_btn = $form_login.find('#enter-btn'),
    $field_login_signin = $form_login.find('#login-field-sign-in'),
    $field_pass_signin = $form_login.find('#pass-field-sign-in'),
    $create_acc_btn = $form_signup.find('#create-acc-btn'),
    $field_login_signup = $form_signup.find('#login-field-sign-up'),
    $field_email_signup = $form_signup.find('#email-field'),
    $field_pass_signup = $form_signup.find('#pass-field-sign-up');


    login_selected();


    $form_main.submit(function(event) {
        event.preventDefault();

        //sendForm("main-form", "/register");
        return false;
    });

    $form_modal_tab.on('click', function(event) {
        event.preventDefault();
        ( $(event.target).is( $tab_login ) ) ? login_selected() : signup_selected();
    });

    function login_selected() {
        $form_login.addClass('is-selected');
        $form_signup.removeClass('is-selected');
        // $form_forgot_password.removeClass('is-selected');
        $form_modal_tab.children('li').eq(0).addClass('selected');
        $form_modal_tab.children('li').eq(1).removeClass('selected');

        //Для отправки только определенных значений формы
        $field_login_signin.removeAttr('disabled');
        $field_pass_signin.removeAttr('disabled');
        $field_login_signup.attr('disabled', 'disabled');
        $field_pass_signup.attr('disabled', 'disabled');
        $field_email_signup.attr('disabled', 'disabled');
    }

    function signup_selected() {
        $form_login.removeClass('is-selected');
        $form_signup.addClass('is-selected');
        // $form_forgot_password.removeClass('is-selected');
        $form_modal_tab.children('li').eq(0).removeClass('selected');
        $form_modal_tab.children('li').eq(1).addClass('selected');

        // Для отправки только определенных значений формы
        $field_login_signin.attr('disabled', 'disabled');
        $field_pass_signin.attr('disabled', 'disabled');
        $field_login_signup.removeAttr('disabled');
        $field_pass_signup.removeAttr('disabled');
        $field_email_signup.removeAttr('disabled');
    }

    // function sendForm(reqForm, url) {
    //     $.ajax({
    //         url: url,
    //         type: "POST",
    //         dataType: "html",
    //         data: $("#" + reqForm).serialize(),
    //         success: function(response) {
    //             alert(response);
    //         },
    //         error: function(response) {
    //             alert("Ошибка. Данные не отправлены.");
    //         }
    //     });
    // }
});