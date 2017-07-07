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
var server = require('http').createServer(app);
var io = require('socket.io')(server);
// var redis = require('redis');

var Redis = require('ioredis');
var redis = new Redis(process.env.REDIS_PORT, process.env.REDIS_HOST);

var listen = server.listen(8080, function () {
    console.log('listening on:' + listen.address().port);
});

function handler(req, res) {
    res.writeHead(200);
    res.end('');
}

// io.on('connection', function (socket) {
//     console.log("client connected command");
//     var redisClient = redis.createClient(7777, '127.0.0.1');
//     // var redisClient = redis.createClient();
//     redisClient.subscribe('msg');
//
//     redisClient.on("msg", function(channel, data) {
//         console.log("mew message add in queue "+ data['message'] + " channel");
//         socket.emit(channel, data);
//     });
//
//     socket.on('disconnect', function() {
//         redisClient.quit();
//     });
//
// });

// io.on('connection', function(socket) {
//     socket.emit('msg', {message: "1xxxx", user: "11xxxxxxxxx"});
//     console.log('client connected')
// });

redis.on('msg', function(subscribed, channel, message) {
    message = JSON.parse(message);
    console.log(message);
    io.emit(channel + ':' + message.event, message.data);
});

redis.on('msg', function (channel, message) {
    const event = JSON.parse(message);
    io.emit(event.event, channel, event.data);
});

redis.subscribe('*', function(err, count) {
    console.log('error', err, count);
});