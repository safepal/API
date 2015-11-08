var mongoose = require("mongoose"), schema = mongoose.Schema;

var partner = schema({
	clientID : {type : String, required : true},
	clientSecret : String,
	joindate : {type : Date, default : Date.now}

});

module.exports = mongoose.model("partner", partner);