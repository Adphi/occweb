(function (OC, window, $, undefined) {
  'use strict';
  $(function() {
    function scrollToBottom(){
      var html = $('html');
      html.scrollTop(html.prop('scrollHeight'));
    }
    var baseUrl = OC.generateUrl('/apps/testnextcloudapp');
    $.get(baseUrl + '/cmd', function(response){
      $('#app-content').terminal(function(command, term) {
        var occCommand = {
          command: command
        };
        term.pause();
        $.ajax({
          url: baseUrl + '/cmd',
          type: 'POST',
          contentType: 'application/json',
          data: JSON.stringify(occCommand)
        }).done(function (response) {
          term.echo('\n'+ response).resume();
        }).fail(function (response, code) {
          term.echo('\n' + response).resume();
        });
      }, {
        greetings: '[[;green;]' + new Date().toString().slice(0, 24) + "]\n\nPress Enter for more information on occ commands.\n",
        name: 'occ',
        prompt: 'occ $ ',
        completion: response,
        onResize: function(){
          scrollToBottom()
        }
      });
    });
  });
})(OC, window, jQuery);
