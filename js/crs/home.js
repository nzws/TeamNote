const home = {};

home.list = function(mode, max_id = 0, load_mode_button) {
  home.show(mode);
  if (load_mode_button) load_mode_button.className = 'invisible';
  $('.now_loading').show();

  fetch(apiUrl('note/home') + '?mode=' + mode + '&max_id=' + max_id, {
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
        const tmpl = handlebars.compile(elemId('card_tmpl').innerHTML);
        let i = 0,
          reshtml = '';
        if (max_id !== 0) reshtml = elemId(mode + '_posts').innerHTML;
        if (json[0]) {
          while (json[i]) {
            if (json[i]['edited_by'] && json[i]['edited_by']['id'] !== json[i]['created_by']['id'])
              json[i]['edited_by_others'] = true;
            reshtml += tmpl(json[i]);
            i++;
          }
          reshtml += `<button class="btn btn-outline-primary btn-block" onclick="home.list('${mode}', ${
            json[0]['id']
          }, this)">もっと見る</button>`;
        }
        elemId(mode + '_posts').innerHTML = reshtml;
      }
      $('.now_loading').hide();
    })
    .catch(function(error) {
      console.error(error);

      toastr.error('サーバとの通信中にエラーが発生しました。', 'エラー');
      $('.now_loading').hide();
    });
};

home.search = function(page = 0, load_mode_button) {
  if (load_mode_button) load_mode_button.className = 'invisible';
  $('.now_loading').show();
  if (!page) {
    home.show('search');
    elemId('search_posts_content').innerHTML = '';
  }

  fetch(
    apiUrl('note/search') +
      '?page=' +
      page +
      '&word=' +
      encodeURIComponent(elemId('search_text').value),
    {
      headers: { 'content-type': 'application/x-www-form-urlencoded' },
      method: 'GET',
      credentials: 'include'
    }
  )
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
        const tmpl = handlebars.compile(elemId('card_tmpl').innerHTML);
        let i = 0,
          reshtml = '';
        if (page !== 0) reshtml = elemId('search_posts_content').innerHTML;
        page++;
        if (json[0]) {
          while (json[i]) {
            if (json[i]['edited_by'] && json[i]['edited_by']['id'] !== json[i]['created_by']['id'])
              json[i]['edited_by_others'] = true;
            reshtml += tmpl(json[i]);
            i++;
          }
          reshtml += `<button class="btn btn-outline-primary btn-block" onclick="home.search(${page}, this)">もっと見る</button>`;
        }
        elemId('search_posts_content').innerHTML = reshtml;
      }
      $('.now_loading').hide();
    })
    .catch(function(error) {
      console.error(error);

      toastr.error('サーバとの通信中にエラーが発生しました。', 'エラー');
      $('.now_loading').hide();
    });
};

home.show = function(mode) {
  if (elemId(mode + '_posts').style.display !== 'none') return;
  $('#home_posts').slideUp();
  $('#search_posts').slideUp();
  $('#admin_posts').slideUp();
  $('#archive_posts').slideUp();
  $('#' + mode + '_posts').slideDown();
};
