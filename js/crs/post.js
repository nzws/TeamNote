const post = {};

post.post = function(text) {
  const parser = document.createElement('div');
  parser.innerHTML = text.replace(/<[^>]*>/g, '');
  text = parser.textContent;

  $('.now_loading').show();
  fetch(apiUrl('note/post'), {
    headers: { 'content-type': 'application/x-www-form-urlencoded' },
    method: 'POST',
    credentials: 'include',
    body: buildQuery({
      csrf_token: API['csrf'],
      title: elemId('title').value,
      //tags: elemId('tags').value.split(','),
      body: text,
      is_admin: elemId('only_admin').checked ? 1 : 0,
      edit_id: elemId('edit_id').value,
      pin: elemId('pin').value
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
        location.href = 'note' + API['suffix'] + '?id=' + json['id'];
      }
      $('.now_loading').hide();
    })
    .catch(function(error) {
      toastr.error('サーバとの通信中にエラーが発生しました。', 'エラー');
      $('.now_loading').hide();
    });
};
