var misc = module.exports;

console.log("misc file");

var mongoose = require("mongoose"), schema = mongoose.Schema;

var userschema = schema({
	user : String,
	pass : String
});

//stored dbuser credentials in seperate collection
//get user cred from that collection and use it to access main collection
var usercred = mongoose.model("dbuser", userschema);
mongoose.createConnection("mongodb://127.0.0.1:27017/spsu");
var db = mongoose.connection;
db.on('error', console.error.bind(console, 'connection error:'));
db.once('open', function () {
	console.log("connected to spsu db");
  //get credentials
  var query = usercred.find({}, 'username pass', function (err, usercred){
  	if(err){
  		console.log(err);
  	}

  	else{
  		console.log(usercred);
  		misc.dbUser = usercred.username;
  		misc.dbP = usercred.pass;
  	}
  });

});


//strings that we may use often
misc.baseURL = "/safepal/web/api/";
misc.wrongpagemessage = "Are you sure you got the proper address? This page doesn't seem to exist";
misc.invalidendpoint = "Invalid/Unauthorized endpoint";
misc.reportsavefailed = "Failed to save report. Please try again in a few moments";

//some methods
var msghandler = function msgHandler(success_state, result, error){
   var msg = {
        "success" : success_state,
        "result" : result,
        "error" : error
         };

         return msg;
}

misc.resultMsgHandler = msghandler;
