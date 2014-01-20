"use strict";

process.title = 'node-openxum';

var webSocketServer = require('websocket').server;
var http = require('http');
var mysql = require('mysql');

var OpenxumServer = function(p) {

// private methods
    var onConnect = function(connection, msg) {
        console.log('connect ' + msg.user_id);

        clients[msg.user_id] = connection;
        sendConnectedClients();
    };

    var onDisconnect = function (port) {
        var index;
        var found = false;

        for (index in clients) {
            if (clients[index].socket._peername.port == port) {
                found = true;
            }
        }
        if (found) {
            console.log('disconnect ' + index);

            clients[index] = undefined;
            sendConnectedClients();
        }
    };

    var onConfirm = function (msg) {
        databaseConnection.query("UPDATE openxum.games SET status='run', opponent_id=" + msg.opponent_id +
            " WHERE games.id=" + msg.game_id + ";", function(err, rows, fields) {
            if (err) throw err;
            databaseConnection.query("SELECT color FROM openxum.games WHERE games.id=" + msg.game_id + ";",
                function(err, rows, fields) {
                    if (err) throw err;
                    var c_opponent = clients[msg.opponent_id];
                    var c_owner = clients[msg.owner_id];
                    var response = {
                        type: 'confirm',
                        game_id: msg.game_id,
                        owner_id: msg.owner_id,
                        opponent_id: msg.opponent_id,
                        color: rows[0].color
                    };

                    console.log('confirm ' + msg.game_id + ' by ' + msg.opponent_id + ' against ' + msg.owner_id);
                    c_owner.send(JSON.stringify(response));
                    if (c_opponent != undefined) {
                        c_opponent.send(JSON.stringify(response));
                    }
                });
        });
    };

    var onJoin = function (msg) {
        databaseConnection.query("SELECT owner_id, users.username FROM openxum.games, openxum.users WHERE games.id=" +
            msg.game_id + " AND users.id="+msg.opponent_id+";",
            function(err, rows, fields) {
                if (err) throw err;
                var owner_id = rows[0].owner_id;
                var c_opponent = clients[msg.opponent_id];
                var c_owner = clients[owner_id];
                var response = {
                    type: 'join',
                    game_id: msg.game_id,
                    owner_id: owner_id,
                    opponent_id: msg.opponent_id,
                    opponent_name: rows[0].username
                };

                console.log('join ' + msg.game_id + ' by ' + msg.opponent_id + ' against ' + owner_id);
                c_opponent.send(JSON.stringify(response));
                if (c_owner != undefined) {
                    c_owner.send(JSON.stringify(response));
                }
            }
        );
    };

    var onMessage = function(connection, message) {
        var msg = JSON.parse(message.utf8Data);

        if (msg.type === 'connect') {
            onConnect(connection, msg);
        } else if (msg.type === 'join') {
            onJoin(msg);
        } else if (msg.type === 'confirm') {
            onConfirm(msg);
        } else if (msg.type === 'play') {
            onPlay(connection, msg);
        } else if (msg.type === 'turn') {
            onTurn(msg);
        }
    };

    var onPlay = function(connection, msg) {
        console.log('play: ' + msg.game_id + ' by ' + msg.user_id + ' against ' + msg.opponent_id);
        clients[msg.user_id] = connection;
        currentGames[msg.user_id] = {
            game_id: msg.game_id,
            opponent_id: msg.opponent_id
        };
    };

    var onTurn = function(msg) {
        var c_opponent = clients[currentGames[msg.user_id].opponent_id];
        var response;

        if (msg.move == 'put_ring' || msg.move == 'put_marker' || msg.move == 'remove_ring' ||
            msg.move == 'remove_row')  {
            console.log('turn: ' + msg.move + ' ' + msg.coordinates.letter + msg.coordinates.number
                + ' by ' + msg.color + ' / ' + msg.user_id);

            response = {
                type: 'turn',
                move: msg.move,
                coordinates: {
                    letter: msg.coordinates.letter,
                    number: msg.coordinates.number
                },
                color: msg.color
            };
        } else if (msg.move == 'move_ring') {
            console.log('turn: ' + msg.move + ' ' + msg.coordinates.letter + msg.coordinates.number
                + ' to ' + msg.ring.letter + msg.ring.number + ' / ' + msg.user_id);

            response = {
                type: 'turn',
                move: msg.move,
                ring: {
                    letter: msg.ring.letter,
                    number: msg.ring.number
                },
                coordinates: {
                    letter: msg.coordinates.letter,
                    number: msg.coordinates.number
                }
            };
        }
        if (c_opponent != undefined) {
            c_opponent.send(JSON.stringify(response));
        }
    };

    var processRequest = function(request) {
        var connection = request.accept(null, request.origin);

        connection.on('message', function (message) {
            onMessage(connection, message);
        });

        connection.on('close', function (connection) {
            onDisconnect(request.socket._peername.port);
        });
    };

    var sendConnectedClients = function() {
        if (clients[1] != undefined) {
            var user_ids =  [ ];

            for (var id in clients) {
                if (clients[id] != undefined) {
                    user_ids.push(id);
                }
            }

            var response = {
                type: 'connected',
                user_ids: user_ids
            };

            clients[1].send(JSON.stringify(response));
        }
    }

    var init = function(p)
    {
        port = p;
        databaseConnection = mysql.createConnection({
            host: 'localhost',
            user: 'root',
            password: 'toto'
        });
        server = http.createServer();
        server.listen(port, function () {
            databaseConnection.connect();
        });
        wsServer = new webSocketServer({
            httpServer: server
        });
        clients = { };
        currentGames = { };

        wsServer.on('request', function (request) {
            processRequest(request);
        });
    };

// private attributes
    var port;
    var server;
    var databaseConnection;
    var wsServer;
    var clients;
    var currentGames;

    init(p);
};

var server = new OpenxumServer(1337);