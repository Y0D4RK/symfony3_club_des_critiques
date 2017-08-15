
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

    var id = 1;
    console.log('Nouveau user in the chat '+id);


    for(var u in users){
        id = id++;
        socket.emit('newuser', users[u]);
    }
    for(var m in messages){
        socket.emit('newmsg', messages[m]);
    }

    socket.on('login', function(user){
        me = user;

        me.id = user.mail.replace('@', '-').replace('.', '-');
        me.mail = user.mail;
        me.username = user.username;
        me.avatar = 'https://gravatar.com/avatar/'+md5(user.mail)+ '?s=100';

        socket.emit('logged');

        users[me.id] = me;

        // console.log( getUserInfos(me.email).then(
        //     (user) => {
        //         socket.user=user;
        //     }
        // ));

        io.sockets.emit('newuser', me)
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

// function getUserInfos(email){
//     return new Promise(function (resolve, reject){
//         var sql = `SELECT u.id, u.username, u.avatarName, u.email_canonical
//                     FROM user u
//                     WHERE u.email_canonical = ${db.escape(email)}`;
//
//             db.query(sql,(err, rows, fields) => {
//
//             if (!err){
//                 return resolve(rows[0]);
//             }else{
//                 reject(err);
//                 console.log('Erreur a la recup du user');
//             }
//         });
//     })
// }


server.listen(4200);
