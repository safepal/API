var User = require('../models/user');
var token   = require('../models/token');
var jwt = require('jsonwebtoken');
var config = require('../config');

//super secret for creating tokens
var superSecret = config.secret;

var usersExport = module.exports = function(app, express){
   var usersRouter = express.Router();


//route for authenticating users
usersRouter.post('/login', function(req, res){
    //find the user
    //select the name username and password explicitly
    User.findOne({
        email: req.body.email
    }).select('phone password').exec(function(err, user){
        if(err) throw error;

        //no user with that username was found
        if(!user){
            res.json({
                success: false,
                message: 'Authentication failed. User not found.'
            });
        }else if(user){
            //check if password matches
            user.comparePassword(req.body.password, function(err, isMatch){

            if(err) throw err;

            if(!isMatch){
                res.json({
                    success: false,
                    message: 'Authentication failed. Wrong password.'
                });
            }else {
                //if user is found and password is right
                //create a token
                var token = jwt.sign({
                    name: user.name,
                    email: user.phone
                }, superSecret, {expiresInMinutes: 1440 });

                //return the information including token as JSON
                res.json({
                    success: true,
                    message: 'Enjoy your token!',
                    token: token
                });
                }
            });
        }
    });
});

/*
route for creating new users
*/
usersRouter.route('/users')
    //create a user (accessed at POST http://localhost:8000/api/users)
    .post(function(req, res){
        //create a new instance of the User model
        var user = new User({
            userid:     req.body.userid,
            location:   req.body.location,
            phone:      req.body.phone,
            password:   req.body.password,
            emcontact:  req.body.emcontact,
            emcontact2: req.body.emcontact2,
            joindate:   req.body.joindate,
            age:        req.body.age,
            school:     req.body.school,
            lastseen:   req.body.lastseen
        });

        //set the users information (comes from the request)

        //save the user and check for errors
        user.save(function(err){
            //duplicate entry
            if(err){
            if(err.code == 11000)
                return res.json({ success: false, message: 'A user with that phone number already exists. '});
            else
                return res.send(err);
        }
            res.json({ message: 'User created'});
        });
    })
    .get(function(req, res){
        User.find(function(err, users){
            if(err) throw(err);
            res.json(users);
        });
    });

//middleware to use for all requests
// usersRouter.use(function(req, res, next){

//     //this is where we will authenticate users
//     //check header or url parameters or post parameters for token
//     var token = req.body.token || req.param('token') || req.headers['x-access-token'];
//     //decode token
//     if(token){

//         //verifies secret and checks exp
//         jwt.verify(token, superSecret, function(err, decoded){
//             if(err){
//                 return res.status(403).send({
//                     success:false,
//                     message: 'Failed to authenticate token.'
//                 });
//             }else {
//                 //if everything is good, save to request for use in other routes
//                 req.decoded = decoded;
//                 next();
//             }
//         });
//     } else{

//         //if there is no token
//         //return an HTTP response of 403 (access forbidden) and an error message
//         return res.status(403).send({
//             success: false,
//             message: 'No token provided.'
//         });
//     }
//     next(); //make shure we go to the next routes and do not stop here
// });
//test route to make sure everything is working
//accessed at GET http://localhost:8000/api

usersRouter.get('/', function(req, res){
    res.json({ message: 'hooray! welcome to our api!'});
});


//more routes for our API will happen here

usersRouter.route('/users/:user_id')
    //get the user with that id
    .post(function(req, res){
        User.findById(req.params.user_id, function(err, user){
            if(err) res.send(err);

            //return that user
            res.json(user);
        });
    })/*
    .get(function(req, res){
        User.findById(req.params.user_id, function(err, user){
            if(err) res.send(err);

            //return that user
            res.json(user);
        });
    })
    .put(function(req, res){
        //use our user model to find the user we want
        User.findById(req.params.user_id, function(err, user){
            if(err) res.send(err);

            //update the users info only if its new
            if(req.body.name) user.name = req.body.name;
            if(req.body.username) user.username = req.body.username;
            if(req.body.email) user.email = req.body.email;
            if(req.body.password) user.password = req.body.password;

            //save the user
            user.save(function(err){
                //return a message
                res.json({ message: 'User updated!'});
            });
        });
    })
    .delete(function(req, res){
        User.remove({
            _id: req.params.user_id
        }, function(err, user){
            if(err) return res.send(err);
            res.json({ message: 'Successfully deleted'});
        });
    }); */

    return usersRouter
};
