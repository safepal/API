module.exports = function (api) {


    //import stuff
    var mongoose = require("mongoose");
    //var exp = require("express");
    var miscStuff = require("../misc.js");
    //mongoose.createConnection("mongodb://" + miscStuff.dbUser + ":" + miscStuff.dbP + "@localhost:23013/safepaldb");
    mongoose.createConnection("mongodb://46.101.226.248:27017/safepaldb");

    console.log(miscStuff.dbUser + " pass is " + miscStuff.dbP);

    var user = require("../models/user");
    var Report = require("../models/report");
    var partner = require("../models/partner");
    var token = require("../models/token");

    /********************************
    handle reports
    ********************************/
    api.get(miscStuff.baseURL + "reports", function (req, res, next) {

    });


    api.post(miscStuff.baseURL + "reports", function (req, res, next) {

        if (req.accepts("application/json")) {
            var jsondata = req.body;

            console.log(jsondata);

            var action = jsondata.action;

            console.log("action = " + action);

            if (action) {

                console.log("action is " + action);

                var db = mongoose.connection;
                console.log(db);
                console.log("misc stuff" + miscStuff.resultMsgHandler(false, miscStuff.reportsavefailed, ""));
                db.on('error', console.error.bind(console, 'connection error:'));
                db.once('open', function () {

                    console.log("connected to db");

                    if (action == "createreport") {

                        if (req.body.reportid) {

                            var newreport = new Report();
                            newreport.formId = jsondata.reportid;
                            newreport.incidentDate = jsondata.incidentDate;
                            newreport.helpReceived = jsondata.helpReceived;
                            newreport.visitedClinic = jsondata.visitedClinic;
                            newreport.assualter = jsondata.assualter;
                            newreport.assaulttype = jsondata.assaulttype;
                            newreport.age = jsondata.age;
                            newreport.school = jsondata.school;

                            console.log("new report is " + newreport);

                            newreport.save(function (err, next) {
                                if (err) {
                                    res.json(miscStuff.resultMsgHandler(false, miscStuff.reportsavefailed, err));
                                }

                                else {
                                    res.json(miscStuff.resultMsgHandler(true, miscStuff.reportsavesuccessful, ""));
                                    res.send("successful insert");
                                }
                            });
                        }
                    }

                    else if (action == "getreports") {
                        var allreports = report.find({}, function (err, next) {
                            if (err) {
                                console.log(err);
                                next();
                            }

                            else {
                                res.json(allreports); //return all reports as json string
                                console.log(allreports);
                            }
                        });
                    }

                    else if (action == "updatereport") {

                    }

                    else if (action == "deletereport") {

                    }
                });
            }
        }
    });

}

