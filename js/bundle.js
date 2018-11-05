//ライブラリとかを読み込むだけ
window.$ = require('jquery');
require('bootstrap');
window.toastr = require('toastr');
window.mustache = require('mustache');
require('turbolinks').start();

window.toastr.options = {
  "closeButton": true,
  "positionClass": "toast-bottom-left",
};
