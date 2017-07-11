function handler(req, res) {
    res.writeHead(200);
    res.end('');
}

var app = require('express')();
var server = require('http').createServer(app);
// var server = require('http').createServer(handler);
var io = require('socket.io')(server);
var redis = require('redis');

// var Redis = require('ioredis');
// var redis = new Redis(process.env.REDIS_PORT || 7777, process.env.REDIS_HOST || '127.0.0.1');

io.on('connection', function (client) {
    console.log("client connected command");

    var redisClient = redis.createClient(process.env.REDIS_PORT || 7777, process.env.REDIS_HOST || '127.0.0.1');
    // var redisClient = redis.createClient();

    redisClient.subscribe('message');

    redisClient.subscribe('*', function (err, count) {
        console.log("error event - " + redisClient.options.host + ":" + redisClient.options.port + " - " + err);
    });

    redisClient.on('message', function(channel, data) {
        console.log("data "+ data + " channel " + channel);
        client.emit(channel, data);
    });

    client.on('disconnect', function() {
        redisClient.quit();
    });

});

/***  subscribe ***/
/*
io.on('connection', function(socket) {
    socket.emit('msg', {message: "1xxxx", user: "11xxxxxxxxx"});
    console.log('client connected')
});


redis.subscribe('message');

redis.subscribe('*', function(err, count) {
    console.log("error event - " + redis.options.host + ":" + redis.options.port + " - " + err);
});

redis.on('message', function (channel, message) {
    console.log(channel, message);
    const event = JSON.parse(message);
    io.emit(event.event, channel, event.data);
});
*/

var listen = server.listen(8080, function () {
    console.log('listening on:' + listen.address().port);
});
