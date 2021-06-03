const express = require('express');
const router = express.Router();
const handlermedia = require('./handler/order-payment');
/* GET users listing. */

router.get('/', handlermedia.getOrder);

module.exports = router;
