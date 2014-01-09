"use strict";

process.title = 'node-openxum';

var port = 1337;

var webSocketServer = require('websocket').server;
var http = require('http');
var mysql = require('mysql');

var server = http.createServer();
server.listen(port, function () {
    console.log((new Date()) + " Server is listening on port " + port);

    database_connection.connect();
});

var database_connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: 'toto'
});

var wsServer = new webSocketServer({
    httpServer: server
});

var clients = [ ];
var current_games = [ ];

wsServer.on('request', function (request) {
    var connection = request.accept(null, request.origin);

    connection.on('message', function (message) {
        var msg = JSON.parse(message.utf8Data);

        if (msg.type === 'connect') {
            console.log('connect ' + msg.user_id);
            clients[msg.user_id] = connection;
        } else if (msg.type === 'join') {
            database_connection.query("SELECT owner_id, users.username FROM openxum.games, openxum.users WHERE games.id=" +
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
        } else if (msg.type === 'confirm') {
            database_connection.query("UPDATE openxum.games SET status='run', opponent_id=" + msg.opponent_id +
                " WHERE games.id=" + msg.game_id + ";", function(err, rows, fields) {
                if (err) throw err;
                database_connection.query("SELECT color FROM openxum.games WHERE games.id=" + msg.game_id + ";",
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
        } else if (msg.type === 'play') {
            console.log('play: ' + msg.game_id + ' by ' + msg.user_id);
            clients[msg.user_id] = connection;
            current_games[msg.user_id] = {
                game_id: msg.game_id,
                opponent_id: msg.opponent_id
            };
        } else if (msg.type === 'turn') {
            var c_opponent = clients[current_games[msg.user_id].opponent_id];
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
        } else if (msg.type === 'close') {
            console.log('close');
        }
    });

    // player disconnected
    connection.on('close', function (connection) {
        console.log('close connection');
    });

});