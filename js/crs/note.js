const note = {};

note.get_note = async id =>
  new Promise((resolve, reject) => {
    $('.now_loading').show();
    fetch('viewmd' + API['suffix'] + '?id=' + id, {
      headers: { 'content-type': 'application/x-www-form-urlencoded' },
      method: 'GET',
      credentials: 'include'
    })
      .then(function(response) {
        if (response.ok) {
          return response.text();
        } else {
          throw response;
        }
      })
      .then(function(text) {
        $('.now_loading').hide();
        resolve(text);
      })
      .catch(function(error) {
        console.error(error);
        toastr.error('サーバとの通信中にエラーが発生しました。', 'エラー');
        $('.now_loading').hide();
        reject();
      });
  });

note.view_note = function(id) {
  note.get_note(id).then(text => {
    elemId('note').innerHTML = markdown(text);
  });
};

note.view_comment = function(id, max_id = 0, load_mode_button) {
  if (load_mode_button) load_mode_button.className = 'invisible';
  $('.now_loading').show();
  fetch(apiUrl('comment/view') + '?id=' + id + '&max_id=' + max_id, {
    headers: { 'content-type': 'application/x-www-form-urlencoded' },
    method: 'GET',
    credentials: 'include'
  })
    .then(function(response) {
      if (response.ok) {
        return response.json();
      } else {
        throw response;
      }
    })
    .then(function(json) {
      if (json['error']) {
        toastr.warning(json['error'], 'エラー');
      } else {
        const tmpl = handlebars.compile(elemId('com_tmpl').innerHTML);
        let i = 0,
          reshtml = '';
        if (max_id !== 0) reshtml = elemId('comments').innerHTML;
        if (json[0]) {
          while (json[i]) {
            json[i]['body'] = markdown(json[i]['body']);
            reshtml += tmpl(json[i]);
            i++;
          }
          reshtml += `<button class="btn btn-outline-primary btn-block" onclick="note.view_comment(${id}, ${
            json[0]['id']
          }, this)">もっと見る</button>`;
        }
        elemId('comments').innerHTML = reshtml;
      }
      $('.now_loading').hide();
    })
    .catch(function(error) {
      console.error(error);
      toastr.error('サーバとの通信中にエラーが発生しました。', 'エラー');
      $('.now_loading').hide();
    });
};

note.post_comment = function(id) {
  const t = elemId('com_textarea');
  if (!t.value) {
    toastr.error('コメントを入力してください。', 'エラー');
    return;
  }
  $('.now_loading').show();
  fetch(apiUrl('comment/post'), {
    headers: { 'content-type': 'application/x-www-form-urlencoded' },
    method: 'POST',
    credentials: 'include',
    body: buildQuery({
      csrf_token: API['csrf'],
      body: t.value,
      note_id: id
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
      if (json['error']) {
        toastr.warning(json['error'], 'エラー');
      } else {
        toastr.success('投稿しました。', '投稿');
        note.view_comment(id);
        t.value = '';
      }
      $('.now_loading').hide();
    })
    .catch(function(error) {
      toastr.error('サーバとの通信中にエラーが発生しました。', 'エラー');
      $('.now_loading').hide();
    });
};

note.delete = function(id, mode) {
  const text = mode === 1 ? 'アーカイブ' : mode === 0 ? '回復' : '削除';
  if (window.confirm(text + 'します。よろしいですか？')) {
    $('.now_loading').show();
    fetch(apiUrl('note/delete'), {
      headers: { 'content-type': 'application/x-www-form-urlencoded' },
      method: 'POST',
      credentials: 'include',
      body: buildQuery({
        csrf_token: API['csrf'],
        id: id,
        mode: mode
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
        if (json['error']) {
          toastr.warning(json['error'], 'エラー');
        } else {
          toastr.success(text + 'しました。', text);
          if (mode !== 2) location.reload();
          else location.href = 'index' + API['suffix'];
        }
        $('.now_loading').hide();
      })
      .catch(function(error) {
        toastr.error('サーバとの通信中にエラーが発生しました。', 'エラー');
        $('.now_loading').hide();
      });
  }
};
