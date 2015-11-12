var mongoose = require("mongoose"), schema = mongoose.Schema;

var TokenSchema = schema({
	token : String,
	dateCreated : Date,
	expiryDate : Date,
	joinDate : String
});

module.exports = mongoose.model("Token", TokenSchema);
