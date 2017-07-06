// var app = require('express')();
// var http = require('http').Server(app);
// var io = require('socket.io')(http);
// var path = require('path');
//
// // Initialize appication with route / (that means root of the application)
// app.get('/', function(req, res){
//     console.log(__dirname);
//   var express=require('express');
//   app.use(express.static(path.join(__dirname)));
//   res.sendFile(path.join(__dirname, '/public', 'index.php'));
// });
//
// // Register events on socket connection
// io.on('connection', function(socket){
//   socket.on('chatMessage', function(from, msg){
//     io.emit('chatMessage', from, msg);
//   });
//
//   socket.on('notifyUser', function(user){
//     io.emit('notifyUser', user);
//   });
// });
//
// // Listen application request on port 3000
// http.listen(8080, function(){
//   console.log('listening on *:8080');
// });

var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var redis = require('redis');

var listen = server.listen(7777, function () {
    console.log('listening on:' + listen.address().port);
});

io.on('connection', function (socket) {

    console.log("client connected");
    var redisClient = redis.createClient();
    redisClient.subscribe('message');

    redisClient.on("message", function(channel, data) {
        console.log("mew message add in queue "+ data['message'] + " channel");
        socket.emit(channel, data);
    });

    socket.on('disconnect', function() {
        redisClient.quit();
    });

});