const express = require('express');
const router = express.Router();

const handlermedia = require('./handler/my-courses');
/* GET users listing. */
router.get('/', handlermedia.get);
router.post('/', handlermedia.create);

module.exports = router;
