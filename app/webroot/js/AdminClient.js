AdminClient = function (u) {

    this.start = function () {

        window.onbeforeunload = function () {
            if (connection.readyState == 1) {
                connection.close();
            }
        };

        $(document).ready(function () {
            "use strict";

            window.WebSocket = window.WebSocket || window.MozWebSocket;
            if (!window.WebSocket) {
                return;
            }

            connection = new WebSocket('ws://127.0.0.1:1337');

            connection.onopen = function () {
                console.log('open');
            };

            connection.onerror = function (error) {
                console.log('error');
            };

            connection.onmessage = function (message) {
                var msg = JSON.parse(message.data);

                if (msg.type == 'connected') {
                    for (var i = 0; i < msg.user_ids.length; i++) {
                        $('td#td_user_' + msg.user_ids[i]).html('connected');
                    }
                }
            };

            var loop = setInterval(function () {
                if (connection.readyState !== 1) {
                    console.log('error connection');
                } else {
                    console.log('connecting ...');

                    var msg = {
                        type: 'connect',
                        user_id: 1
                    };

                    connection.send(JSON.stringify(msg));
                    clearInterval(loop);
                }
            }, 1000);
        });
    };

    var init = function (u) {
        uid = u;
    };

    var connection;
    var uid;

    init(u);
}