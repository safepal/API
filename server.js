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
var utils = require('./utils');

//run configs
var port = utils.port;
var superSecret = utils.secret;
mongoose.connect(utils.database);

//log all requests to the console
app.use(morgan('dev'));

//Application configuration
app.use(bodyParser.urlencoded({ extended: true}));
app.use(bodyParser.json());
app.use(serveStatic(path.resolve(__dirname, 'public/src')));

//configure our app to handle CORS requests
app.use(function(req, res, next){
    res.setHeader('Access-Control-Allow-Origin', '*');
    res.setHeader('Access-Control-Allow-Methods','GET, POST');
    res.setHeader('Access-Control-Allow_Headers', 'X-Requested-With, content-type, Authorization');
    next();
});


//configure routing
var reportsRouter = require('./routes/reports')(app, express);
var usersRouter = require('./routes/users')(app, express);

//apply routes
app.use('/api', reportsRouter);
app.use('/api', usersRouter);

//start server
app.listen(port);
console.log('Magic happening on port '+port);
