const express = require("express");
const router = express.Router();
const Userhandler = require("./handler/users");
/* GET users listing. */
router.post("/register", Userhandler.register);
router.post("/login", Userhandler.login);
router.put("/:id", Userhandler.update);
router.get("/:id", Userhandler.getuser);
router.get("/", Userhandler.getusers);

module.exports = router;
