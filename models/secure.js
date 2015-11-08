var misc = module.exports;

//strings that we may use often
misc.baseURL = "/safepal/web/api/";
misc.wrongpagemessage = "Are you sure you got the proper address? This page doesn't seem to exist";
misc.invalidendpoint = "Invalid/Unauthorized endpoint";
misc.reportsavefailed = "Failed to save report. Please try again in a few moments";

//some methods
misc.resultMsgHandler = function msgHandler(success_state, result, error = ""){
   var msg = {
        "success" : success_state,
        "result" : result,
        "error" : error
         };

         return msg;
}

misc.securevalue = function encrypt(text){
  var cipher = crypto.createCipher('aes-256-cbc', process.env.SERVER_SECRET);
  var crypted = cipher.update(text,'utf8','hex');
  crypted += cipher.final('hex');
  return crypted;
} 

misc.unwrapvalue = function decrypt(text){
  if (text === null || typeof text === 'undefined') {return text;};
  var decipher = crypto.createDecipher('aes-256-cbc', process.env.SERVER_SECRET);
  var dec = decipher.update(text,'hex','utf8');
  dec += decipher.final('utf8');
  return dec;
}
