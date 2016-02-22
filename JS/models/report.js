var mongoose = require("mongoose"), schema = mongoose.Schema;

var ReportSchema = schema({
	formId : {type : Number, required : true},
	userid : Number, 
	assaulttype : String,
	school : String,
	incidentDate : Date,
	details : String,
	helpReceived : String,
	visitedClinic : String,
	assualter : String,
	age : String,
	details : String,
	location : String,
	lat : String,
	lng : String,
	submissionDate : {type : Date, default : Date.now},
	status : String
});

//export 
module.exports = mongoose.model("Report", ReportSchema);