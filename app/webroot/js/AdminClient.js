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
                        var found = false;
                        var j = 0;

                        $('td#td_user_' + msg.user_ids[i]).html('connected');
                        while (j < clients.length && !found) {
                            if (clients[j] == msg.user_ids[i]) {
                                found = true;
                            } else {
                                j++;
                            }
                        }
                        if (!found) {
                            clients.push(msg.user_ids[i]);
                        }
                    }

                    var j = 0;

                    while (j < clients.length) {
                        var found = false;
                        var i = 0;

                        while (i < msg.user_ids.length && !found) {
                            if (clients[j] == msg.user_ids[i]) {
                                found = true;
                            } else {
                                i++;
                            }
                        }
                        if (!found) {
                            $('td#td_user_' + clients[j]).html('');
                            clients.splice(j, 1);
                        } else {
                            j++;
                        }
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
        clients = [ ];
    };

    var connection;
    var uid;
    var clients;

    init(u);
};