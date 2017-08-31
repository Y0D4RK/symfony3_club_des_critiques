
'use strict';

var md5 = require('md5');
var express = require('express');
var app = express();
var server = require('http').createServer(app);
var io = require('socket.io')(server);

var mysql   = require('mysql');
var request   = require('request');

var db = mysql.createConnection({
    host: 'localhost',
    port: '3306',
    user: 'root',
    password: 'root',
    database: 'club',
});
db.connect(function(error){
    if(error){
        console.error("Impossible de se connecter", error);
    }else{
        console.log("SQL connection : OK !")
    }
});

app.use(express.static(__dirname + '/bower_components'));
app.use(express.static(__dirname + '/public'));

/*app.get('/', function(req, res, next) {
    res.sendFile(__dirname + '/index.html');
});*/

var users = {};
var rooms = {};

io.on('connection', function(socket) {


    console.log('' +
        '/------------------------------------\n' +
        '| Nouveau utilisateur dans ce tchat |\n' +
        '------------------------------------/\n');

    var me = false;
    var salon = false;

    for(var u in users){
        socket.emit('newuser', users[u]);
    }

    socket.on('login', function(data) {
        getUserById(data.user_id);
        getRoomById(data.room_id);
        getLastMessagesRooms(data.room_id);
    });

    /* On recoit un nouveau msg */
    socket.on('newmsg', function(message){

        if(message.message === ''){
            return false;
        }

        message.user = me;
        message.created_at = Date.now();
        saveMessage(message);
    });


    socket.on('disconnect', function(){
        if(!me){
            return false;
        }
        delete users[me.id];
        io.sockets.emit('disuser', me);
    });

    var saveMessage = function(message){
        var query = db.query('INSERT INTO message SET user_id=?, room_id=?, message=?, created_at=?', [
            message.user.id,
            message.room_id,
            message.message,
            new Date(message.created_at)
        ], function(err){
            if(err){
                console.log(err);
            }
            io.sockets.emit('newmsg', message);
        });
        console.log(query.sql);
    };

    var getUserById = function(userId){
        var queryUserById = db.query('SELECT * FROM user WHERE id = ?',

            [userId],

            function (err, rows, fields) {
                if (err) {
                    console.log(err.code);
                    return false;
                }
                if (rows.length === 1) {
                    console.log(rows);
                    me = {
                        username: rows[0].username,
                        id: rows[0].id,
                        avatar: 'https://gravatar.com/avatar/' + md5(rows[0].email) + '?s=100',
                        //avatar: '/web/upload/avatar/' + rows[0].avatarName
                    };
                    console.log(me);
                    socket.emit('logged');

                    users[me.id] = me;
                    io.sockets.emit('newuser', me);
                } else {
                    io.sockets.emit('error', 'Aucun utilisateur trouvé !');
                }
            });
        // console.log(queryUserById.sql);
    };

    var getRoomById = function(roomId){
        console.log(roomId);
        var queryRoomById = db.query('SELECT * FROM room WHERE id = ?',

            [roomId],

            function (err, rows, fields) {
                if (err) {
                    console.log(err.code);
                    return false;
                }
                // console.log(rows);
                if (rows.length === 1) {
                    salon = {
                        id: rows[0].id,
                        name: rows[0].name
                    };

                    rooms[salon.id] = salon;

                    socket.join(salon.name);
                } else {
                    io.sockets.emit('error', 'Aucun salon trouvé !');
                }
            });
        // console.log(queryRoomById.sql);
    }

    var getLastMessagesRooms = function(roomId){
        var queryLastMsgRooms = db.query(''+
            'SELECT message.message, user.username, user.email, UNIX_TIMESTAMP(message.created_at) as created_at '+
            'FROM message '+
            'LEFT JOIN user ON user.id = message.user_id '+
            'WHERE message.room_id = '+roomId+
            ' GROUP BY message.id', function(err, rows){
            if(err){
                socket.emit('error', err.code);
                return true;
            }

            for (var k in rows) {

                var row = rows[k];

                var message = {
                    message: row.message,
                    created_at: row.created_at * 1000,
                    user: {
                        id: row.user_id,
                        username: row.username,
                        avatar: 'https://gravatar.com/avatar/' + md5(row.email) + '?s=100',
                    }
                };
                socket.emit('newmsg', message);
            }
        });
        console.log(queryLastMsgRooms.sql);
    };
});

server.listen(4200);
