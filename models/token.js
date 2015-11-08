var mongoose = require("mongoose"), schema = mongoose.Schema;

var token = schema({
	token : String,
	dateCreated : Date,
	expiryDate : Date,
	joinDate : String
});

module.exports = mongoose.model("token", token);