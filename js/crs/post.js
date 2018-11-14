const post = {};

post.post = function() {
  $('.now_loading').show();
  fetch(apiUrl('note/post'), {
    headers: { 'content-type': 'application/x-www-form-urlencoded' },
    method: 'POST',
    credentials: 'include',
    body: buildQuery({
      csrf_token: API['csrf'],
      title: elemId('title').value,
      //tags: elemId('tags').value.split(','),
      body: post.get_value(),
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

post.get_value = function() {
  const parser = document.createElement('div');
  parser.innerHTML = editor.getValue().replace(/<[^>]*>/g, '');
  return parser.textContent;
};

post.image_upload = function() {
  const files = elemId('upload_image').files;
  let i = 0;
  const images = [];
  while (files[i]) {
    const reader = new FileReader();
    reader.onload = async fileData => {
      images.push(fileData.target.result.split(',')[1]);
      if (files.length === images.length) {
        elemId('upload_image').value = '';
        i = 0;
        while (images[i]) {
          let image_url = await post.upload_to_imgur(images[i]);
          editor.setValue(post.get_value() + `\n![image](${image_url})`, true);
          i++;
        }
      }
    };
    reader.readAsDataURL(files[i]);
    i++;
  }
};

post.upload_to_imgur = base64 =>
  new Promise((resolve, reject) => {
    $('.now_loading').show();

    const binary = atob(base64);
    const array = [];
    for (let i = 0; i < binary.length; i++) {
      array.push(binary.charCodeAt(i));
    }
    const blob = new Blob([new Uint8Array(array)], { type: 'image/png' });

    const formData = new FormData();
    formData.append('image', blob);

    fetch('https://api.imgur.com/3/image', {
      headers: { Authorization: 'Client-ID ' + API.imgur_client_id },
      method: 'POST',
      body: formData
    })
      .then(function(response) {
        if (response.ok) {
          return response.json();
        } else {
          throw response;
        }
      })
      .then(function(json) {
        $('.now_loading').hide();
        if (json['success']) {
          resolve(json['data']['link']);
        } else {
          toastr.error('Imgurでアップロードに失敗しました。', 'エラー');
        }
      })
      .catch(function(error) {
        toastr.error('Imgurとの通信中にエラーが発生しました。', 'エラー');
        $('.now_loading').hide();
        reject();
      });
  });
