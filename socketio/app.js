
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

io.on('connection', function(socket) {

    var me = false;

    var getLastMessages = function(){
        var querySelect = db.query(''+
            'SELECT user.id as user_id, user.username, user.email, message.message, UNIX_TIMESTAMP(message.created_at) as created_at '+
            'FROM message '+
            'LEFT JOIN user ON user.id = message.user_id '+
            'LIMIT 10', function(err, rows){
                if(err){
                    socket.emit('error', err);
                }

                if (rows.length === 1) {
                    rows.reverse();

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
                        }
                    }
                    socket.emit('newmsg', message);
                }
            });
        console.log(querySelect.sql);
    };

    console.log('*********************************\n' +
        ' Nouveau utilisateur dans ce tchat\n' +
        '***********************************');


    for(var u in users){
        socket.emit('newuser', users[u]);
    }

    socket.on('login', function(user) {

        db.query('SELECT * FROM user WHERE id = ?', [user.id], function (err, rows, fields) {
            if (err) {
                console.log(err.code);
                return false;
            }
            if (rows.length === 1) {
                me = {
                    username: rows[0].username,
                    id: rows[0].id,
                    avatar: 'https://gravatar.com/avatar/' + md5(rows[0].email) + '?s=100',
                };
                socket.emit('logged');

                users[me.id] = me;
                io.sockets.emit('newuser', me);

                getLastMessages();
            } else {
                io.sockets.emit('error', 'Aucun utilisateur trouvé !');
            }
        });
    });

    /* On recoit un nouveau msg */
    socket.on('newmsg', function(message){

        if(message.message === ''){
            return false;
        }
        console.log(message);

        message.user = me;
        message.created_at = Date.now();
        message.room_id = 1;

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

        console.log(query.sql)


    });


    socket.on('disconnect', function(){
        if(!me){
            return false;
        }
        delete users[me.id];
        io.sockets.emit('disuser', me);
    });

});
/*
function getUserInfos(){
        var sql = `SELECT u.id, u.username, u.avatarName, u.email_canonical
                    FROM user u
                    WHERE u.username_canonical = ${db.escape(email)}`;

            db.query(sql,(err, rows, fields) => {

            if (!err){
                return resolve(rows[0]);
            }else{
                reject(err);
                console.log('Erreur a la recup du user');
            }
        });
    })
}*/


server.listen(4200);
