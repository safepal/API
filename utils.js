var utils = module.exports;

/*
environment vars
*/
utils.port = process.env.PORT || 8000;
utils.database = 'mongodb://localhost/safepal';
utils.secret = 'wearesafepal';

/*
Assorted methods
*/
//method to handle json response messages
utils.resultHandler = function msgHandler(success_state, result, error){
   var msg = {
        "success" : success_state,
        "result" : result,
        "error" : error
         };

         return msg;
}

/*
Assorted messages and strings
*/
utils.pagenotfound = "Are you sure you got the proper address? This page doesn't seem to exist";
utils.reportsnotfound = "No reports found";
utils.reportcreated = "Report submitted successfully";
utils.duplicatereport = "Report already exists";
utils.reportcreationfailed = "Failed to submit your report. Try again later";
