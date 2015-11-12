var User = require('../models/user');
var Partner = require('../models/partner');
var Report  = require('../models/report');
var token   = require('../models/token');
var jwt = require('jsonwebtoken');
var config = require('../config');
//super secret for creating tokens
var superSecret = config.secret;
module.exports = function(app, express){
   var reportRouter = express.Router();



//route for authenticating users
reportRouter.post('/reports', function(req, res){
    //find the user
    //select the name username and password explicitly
    Report.find({},function(err, reports){
        if(err) throw error;

        //no user with that username was found
        if(!reports){
            res.json({
                success: false,
                message: 'Error fetching Reports.'
            });
        }else if(reports){
            //check if password matches
            res.json(reports);
        }
});
});


reportRouter.route('/report')
    .post(function(req, res){
        //create a new instance of the report model
        var report = new Report({
            formId:           req.body.formId,
            userid:           req.body.userid,
            assaulttype:      req.body.assaulttype,
            school:           req.body.school,
            incidentDate:     req.body.incidentDate,
            details:          req.body.details,
            helpReceived:     req.body.helpReceived,
            visitedClinic:    req.body.visitedClinic,
            assualter:        req.body.assualter,
            age:              req.body.age,
            details:          req.body.details,
            location:         req.body.location,
            lat:              req.body.lat,
            lng:              req.body.lng,
            status:           req.body.status
        });
        report.save(function(err){
            //duplicate entry
            if(err){
            if(err.code == 11000)
                return res.json({ success: false, message: 'Report already exists. '});
            else
                return res.send(err);
        }
            res.json({ message: 'Report created'});
        });
    })
    .get(function(req, res){
        User.find(function(err, users){
            if(err) throw(err);
            res.json(users);
        });
    });

    return reportRouter
};
