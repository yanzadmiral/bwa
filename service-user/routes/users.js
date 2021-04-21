const express = require("express");
const router = express.Router();
const Userhandler = require("./handler/users");
/* GET users listing. */
router.get("/", function (req, res, next) {
  res.send("respond with a resource");
});

router.post("/register", Userhandler.register);

module.exports = router;
