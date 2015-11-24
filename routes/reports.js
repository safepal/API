var Report  = require('../models/report');
var token   = require('../models/token');
var jwt = require('jsonwebtoken');
var utils = require('../utils');

//super secret for creating tokens
var superSecret = utils.secret;
module.exports = function(app, express){

//grab router instance
var reportRouter = express.Router();


/*
route for getting all reports
*/
reportRouter.post('/reports', function(req, res){
    //get all reports
    Report.find().select('formId assaulttype school incidentDate details helpReceived visitedClinic assualter age location status submissionDate').exec(function(err, reports){
        if(err) throw error;
        console.log(err);
        //if no reports found
        if(!reports){
            res.json(utils.resultHandler(false, "", utils.reportsnotfound));
        }

        else if(reports){
            //return all reports
            res.json(utils.resultHandler(true, reports, ""));
        }
    });
});

/*
route for getting report with particular id
*/
reportRouter.post('/reports/:formId') 
    .post(function(req, res){
    //find the report
    Report.findById(req.body.formId, function(err, report){
        if(err) res.send(err);
        console.log(err);
        if (!report) {
            res.json(utils.resultHandler(false, "", utils.reportsnotfound));
        }

        else{
            res.json(utils.resultHandler(true, report, ""));
        }
    });
});


/*
route for creating new reports
*/
reportRouter.route('/reports/new')
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
            location:         req.body.location,
            lat:              req.body.lat,
            lng:              req.body.lng,
            status:           req.body.status
        });

        report.save(function(err){
            //duplicate entry
            if(err){
            if(err.code == 11000)
                return res.json(utils.resultHandler(false, "", utils.duplicatereport));
            else
                return res.send(err);
        }
            res.json(utils.resultHandler(true, utils.reportcreated, ""));
        });
    });


/*
route for deleting reports
*/

/*
route for updating reports
*/


    return reportRouter
};
