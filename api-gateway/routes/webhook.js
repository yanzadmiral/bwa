const express = require('express');
const router = express.Router();
const handlermedia = require('./handler/webhook');
/* GET users listing. */

router.post('/', handlermedia.webhook);

module.exports = router;
