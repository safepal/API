var mongoose = require("mongoose"), schema = mongoose.Schema;

var user = schema({
	userid : {type : Number, default : 0, required : true},
	location : String,
	phone : String,
	emcontact : String,
	emcontact2 : String,
	joindate : {type : Date, default : Date.now},
	age : Number,
	school : String,
	lastseen : Date
});

module.exports = mongoose.model("user", user);