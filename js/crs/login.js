const login = {};

login.login = function() {
  $(".now_loading").show();
  fetch(apiUrl('auth/login'), {
    headers: {'content-type': 'application/x-www-form-urlencoded'},
    method: 'POST',
    credentials: 'include',
    body: buildQuery({
      csrf_token: API["csrf"],
      username: elemId("login_username").value,
      password: elemId("login_password").value,
    })
  })
  .then(function(response) {
    if (response.ok) {
      return response.json();
    } else {
      throw response;
    }
  })
  .then(function(json) {
    if (json["error"]) {
      toastr.warning(json["error"], 'エラー');
    } else {
      toastr.success('ログインしました。', 'ログイン');
      location.href = "home" + API["suffix"];
    }
    $(".now_loading").hide();
  })
  .catch(function(error) {
    toastr.error('サーバとの通信中にエラーが発生しました。', 'エラー');
    $(".now_loading").hide();
  });
};

login.register = function() {
  const pass = elemId("reg_password").value;
  if (pass !== elemId("reg_password_2").value) {
    toastr.error('2度目に入力したパスワードと一致しません。', 'エラー');
    return;
  }

  $(".now_loading").show();
  fetch(apiUrl('auth/register'), {
    headers: {'content-type': 'application/x-www-form-urlencoded'},
    method: 'POST',
    credentials: 'include',
    body: buildQuery({
      csrf_token: API["csrf"],
      username: elemId("reg_username").value,
      password: elemId("reg_password").value,
      display_name: elemId("reg_display_name").value,
      invite_code: elemId("reg_invite_code").value,
    })
  })
  .then(function(response) {
    if (response.ok) {
      return response.json();
    } else {
      throw response;
    }
  })
  .then(function(json) {
    if (json["error"]) {
      toastr.warning(json["error"], 'エラー');
    } else {
      toastr.success('登録完了しました。ログインしてください。', '登録完了');
      elemId("reg_invite_code").value = "";
      login.show('login');
    }
    $(".now_loading").hide();
  })
  .catch(function(error) {
    toastr.error('サーバとの通信中にエラーが発生しました。', 'エラー');
    $(".now_loading").hide();
  });
};

login.verifyInviteCode = function () {
  $(".now_loading").show();
  fetch(apiUrl('auth/verify_invite'), {
    headers: {'content-type': 'application/x-www-form-urlencoded'},
    method: 'POST',
    credentials: 'include',
    body: buildQuery({
      csrf_token: API["csrf"],
      invite_code: elemId("reg_invite_code").value,
    })
  })
  .then(function(response) {
    if (response.ok) {
      return response.json();
    } else {
      throw response;
    }
  })
  .then(function(json) {
    if (json["error"]) {
      toastr.warning(json["error"], 'エラー');
    } else {
      login.show('register');
    }
    $(".now_loading").hide();
  })
  .catch(function(error) {
    toastr.error('サーバとの通信中にエラーが発生しました。', 'エラー');
    $(".now_loading").hide();
  });
};

login.show = function (mode) {
  $("#login_form").slideUp();
  $("#register_form").slideUp();
  $("#" + mode + "_form").slideDown();
};
