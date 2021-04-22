const express = require("express");
const router = express.Router();
const Refreshtokenshandler = require("./handler/refresh-tokens");

router.post('/',Refreshtokenshandler.createrefreshtokens);
router.get('/',Refreshtokenshandler.getrefreshtokens);

module.exports = router;
