
//first things first
var express = require("express");
var mongoose = require("mongoose");
require("./models/user");
require("./models/report");
require("./models/partner");
require("./models/token");
var miscStuff = require("./misc.js");
/*mongoose.createConnection("mongodb://" + miscStuff.dbUser + ":" + miscStuff.dbP + "@localhost:987/safepaldb");
var x = mongoose.connection;
x.on('error', console.error.bind(console, 'connection error:'));
x.once('open', function (callback) {
  console.log("connected successfully to db");
  });*/

var http = require("http");
var bodyParser = require('body-parser');
var multer = require('multer'); // v1.0.5
var upload = multer(); // for parsing multipart/form-data

//start api app with express
var api = express();

api.use(bodyParser.json()); // for parsing application/json
api.use(bodyParser.urlencoded({ extended: true })); // for parsing application/x-www-form-urlencoded

var routes = require("./routes")(api);

//create our server and listen on unique port
http.createServer(api).listen(4757);
