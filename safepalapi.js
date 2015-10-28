
/*
functions
*/
function msgHandler(success_state, result, error = ""){
   var msg = {
        "success" : success_state,
        "result" : result,
        "error" : error
         };

         return msg;
}

//some GLOBALS
var wrongpagemessage = "Are you sure you got the proper address? This page doesn't seem to exist";
var invalidendpoint = "Invalid/Unauthorized endpoint";


//first things first
var express = require("express");
var mongoose = require("mongoose");
var http = require("http");
var bodyParser = require('body-parser');
var multer = require('multer'); // v1.0.5
var upload = multer(); // for parsing multipart/form-data

//start api app with express
var api = express();

api.use(bodyParser.json()); // for parsing application/json
api.use(bodyParser.urlencoded({ extended: true })); // for parsing application/x-www-form-urlencoded

//handle get requests to /api and /api/v1 with routing
api.get("/safepal/web/api", function(req, res){
                res.json(msgHandler(false, invalidendpoint, wrongpagemessage));
        });

api.get("/safepal/web/api/v1", function(req, res){
                res.json(msgHandler(false, invalidendpoint, wrongpagemessage));
        });

/*
//kill all other requests same as above
api.get("*", function(req, res){
                res.json(wrongpagemessage);
        });*/


//handle post requests to /api and /api/v1 end points
api.post("/safepal/web/api", function(req, res){
                res.json(msgHandler(false, invalidendpoint, wrongpagemessage));
});


/** Handle all incoming traffic requests tp /api/v1/
*** from here. Pick JSON values from json requests
*** Restrict values picked from only request that have 
json 'Accept' headers
*/
api.post("/safepal/web/api/v1", function(req, res, next){
        if(req.accepts("application/json")){

                console.log(req.body);

                //check function requested to determine what to do with request
                var func = req.body.function;
                if (func) {

                         /***************************************************************
                         Get new Token for requests
                         *****************************************************************/       
                        if (func == "gettoken") { //generate new token and return to user
                           res.json(msgHandler(true, "new generated token"));
                        };

                        /***************************************************************
                         LOGIN
                         *****************************************************************/  

                        else if (func == "login") {
                           if (req.body.phone && req.body.password) {
                                //login the user

                           }; 

                           else{ //handle errors more specifically

                                if (!req.body.phone) {
                                   res.json(msgHandler(false, "Failed to log in user", "Missing phone number"));
                                };

                                else{
                                   res.json(msgHandler(false, "Failed to log in user", "Missing password"));                                        
                                }
                           }
                        };

                        /***************************************************************
                         SIGN UP
                        *****************************************************************/  

                        else if (func == "signup") {

                                if (!req.body.phone) {
                                   res.json(msgHandler(false, "Failed to sign up user", "Missing phone number"));
                                };

                                else if(!req.body.password){
                                   res.json(msgHandler(false, "Failed to sign up user", "Missing password"));
                                }

                                else{
                                   //pick rest of the data to signup in user
                                }

                        };


                        /***************************************************************
                         REPORT
                        *****************************************************************/
                        else if(func == "report"){

                                if (!req.body.formid) {
                                   res.json(msgHandler(false, "Report submission failed", "Invalid/Missing form ID")); 
                                };

                                else if(!req.body.dob){
                                   res.json(msgHandler(false, "Report submission failed", "Invalid/Missing date of birth")); 
                                }

                                else{
                                   ///pick values from JSON to store   

                                  ///db connection
                                  ///shema stored in separate file
                                   mongoose.connect("mongodb://localhost/test");
                                   var spdb = mongoose.connection;
                                   db.on('error', console.error.bind(console, 'connection error:'));
                                   db.once('open', function (callback) {

                                    console.log("success");
                                  });

                                }
                        }

                        /***************************************************************
                         DATA/ANALYTICS API REQUESTS
                        *****************************************************************/
                        else if(func == "data"){
                          //check headers for clientID & token
                                if (!req.header("clientID")) {
                                   res.json(msgHandler(false, "", "Missing/Invalid clientID")); 
                                };

                                else if(!req.header("token")){
                                   res.json(msgHandler(false, "", "Unknown/Invalid token")); 
                                }

                                else{
                                  ///query db for data and return any specific errors if any occur

                                }

                        }

                        /***************************************************************
                         Default state
                        *****************************************************************/

                        else{

                           res.json(msgHandler(false, "", "Unknown/Invalid function/method"));      
                        }

                };

        }

        else{
           res.json(msgHandler(false, "Invalid request", "Request must be sent with 'Accept' = 'application/json'"));    
        }
});

//create our server and listen on unique port
http.createServer(api).listen(2317);
