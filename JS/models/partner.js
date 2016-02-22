var mongoose = require("mongoose"), schema = mongoose.Schema;

var PartnerSchema = schema({
	clientID : {type : String, required : true},
	clientSecret : String,
	joindate : {type : Date, default : Date.now}

});

module.exports = mongoose.model("Partner", PartnerSchema);
