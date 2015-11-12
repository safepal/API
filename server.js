//Call to the packages

var express = require('express');
var app = express();
var bodyParser = require('body-parser');
var morgan = require('morgan');
var mongoose = require('mongoose');
var path = require('path');
var serveStatic = require('serve-static');
var jwt =require('jsonwebtoken');
var config = require('./config');
var User = require('./models/user');
var port = config.port;
var superSecret = config.secret;
mongoose.connect(config.database);
//Application configuration
app.use(bodyParser.urlencoded({ extended: true}));
app.use(bodyParser.json());

//configure our app to handle CORS requests

app.use(function(req, res, next){
    res.setHeader('Access-Control-Allow-Origin', '*');
    res.setHeader('Access-Control-Allow-Methods','GET, POST');
    res.setHeader('Access-Control-Allow_Headers', 'X-Requested-With, content-type, Authorization');
    next();
});

//log all requests to the console
app.use(morgan('dev'));
app.use(serveStatic(path.resolve(__dirname, 'public/src')));
var apiRouter = require('./routes/api')(app, express);
var reportRouter = require('./routes/reports')(app, express);
app.use('/api', reportRouter);
app.use('/api', apiRouter);
app.listen(port);
console.log('Magic happens on port '+port);
