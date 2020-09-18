require('./bootstrap');

require('./users')

require('./jquery.jTinder');

require('./jquery.transform2d');

require('./jTinder');

require('./chat');

$.ajax({
  type: "GET",
  url: "request.php",
  data: { 'データ': data },
  dataType: "json",
  scriptCharset: 'utf-8',
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
})
  .then(
      function (param) {
          //　通信後の処理
      },
      function (XMLHttpRequest, textStatus, errorThrown) {
          //　トークンエラー処理
          if (XMLHttpRequest.status == '419') {
              //　リロード
              location.reload();
          }
      });