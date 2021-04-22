const express = require("express");
const router = express.Router();
const Userhandler = require("./handler/users");
/* GET users listing. */
router.get("/", function (req, res, next) {
  res.send("respond with a resource");
});

router.post("/register", Userhandler.register);
router.post("/login", Userhandler.login);
router.put("/:id", Userhandler.update);
router.get("/:id", Userhandler.getuser);

module.exports = router;
