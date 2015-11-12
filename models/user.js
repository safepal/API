//grab the packages that we need for th user model
var mongoose = require('mongoose');
var Schema = mongoose.Schema;
var bcrypt = require('bcryptjs');


var UserSchema = Schema({
	userid : {type : Number, default : 0, required : true, unique:true},
	location : String,
	phone : {type:String, required:true, unique:true},
    password: {type:String, required:true},
	emcontact : String,
	emcontact2 : String,
	joindate : {type:Date, default:Date.now},
	age : Number,
	school : String,
	lastseen : {type:Date, default:Date.now},
});


//hash the password before the user is saved
UserSchema.pre('save', function(next) {
    var user = this;
    if (!user.isModified('password')) return next();
    bcrypt.genSalt(10, function(err, salt) {
        if (err) return next(err);
        bcrypt.hash(user.password, salt, function(err, hash) {
            if (err) return next(err);
            user.password = hash;
            next();
        });
    });
});


UserSchema.methods.comparePassword = function(candidatePassword, cb) {
    bcrypt.compare(candidatePassword, this.password, function(err, isMatch) {
        if (err) return cb(err);
        cb(null, isMatch);
    });
};

module.exports = mongoose.model("User", UserSchema);
