
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
var messages = [];
var history = 2;

io.on('connection', function(socket) {

    var me = false;

    console.log('Nouveau utilisateur dans ce tchat');


    for(var u in users){
        socket.emit('newuser', users[u]);
    }
    for(var m in messages){
        socket.emit('newmsg', messages[m]);
    }

    socket.on('login', function(user) {

        db.query('SELECT * FROM user WHERE id = ?', [user.id], function (err, rows, fields) {
            if (err) {
                io.sockets.emit('error', err.code);
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
            } else {
                io.sockets.emit('error', 'Aucun utilisateur trouvé !');
            }
        });
    });

    /* On recoit un nouveau msg */
    socket.on('newmsg', function(message){
        message.me = me;
        var date = new Date();
        message.h = date.getHours();
        message.min = date.getMinutes();
        messages.push(message);
        if(messages.length > history){
            messages.shift();
        }
        io.sockets.emit('newmsg', message);
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
