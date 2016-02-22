var mongoose = require("mongoose"), schema = mongoose.Schema;
var crypto = require('crypto');

function encrypt(text){
  var cipher = crypto.createCipher('aes-256-cbc', process.env.SERVER_SECRET);
  var crypted = cipher.update(text,'utf8','hex');
  crypted += cipher.final('hex');
  return crypted;
} 

function decrypt(text){
  if (text === null || typeof text === 'undefined') {return text;};
  var decipher = crypto.createDecipher('aes-256-cbc', process.env.SERVER_SECRET);
  var dec = decipher.update(text,'hex','utf8');
  dec += decipher.final('utf8');
  return dec;
}

var sec = schema({
	value : {type : String, get : decrypt, set : encrypt}
});

module.exports = mongoose.model("secval", sec);