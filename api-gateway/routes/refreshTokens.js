const express = require('express');
const router = express.Router();

const handlermedia = require('./handler/refresh-tokens');
/* GET users listing. */
router.post('/', handlermedia.refreshtoken);

module.exports = router;
