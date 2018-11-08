//ライブラリとかを読み込むだけ
window.$ = require('jquery');
require('bootstrap');
window.toastr = require('toastr');
window.handlebars = require('handlebars');
window.SimpleMDE = require('simplemde');
window.marked = require('marked');

window.toastr.options = {
  closeButton: true,
  positionClass: 'toast-bottom-left'
};
